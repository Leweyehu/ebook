<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\MessageParticipant;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    /**
     * Show all conversations for the current user
     */
    public function index()
    {
        $user = Auth::user();
        
        $conversations = Conversation::forUser($user->id)
            ->with(['latestMessage', 'participants.user'])
            ->orderBy('last_message_at', 'desc')
            ->get();
        
        $unreadCount = $conversations->sum(function($conv) use ($user) {
            return $conv->getUnreadCountForUser($user->id);
        });
        
        return view('messages.index', compact('conversations', 'unreadCount'));
    }

    /**
     * Show a specific conversation
     */
    public function show(Conversation $conversation)
    {
        $user = Auth::user();
        
        // Check if user is participant
        $participant = $conversation->participants()->where('user_id', $user->id)->first();
        
        if (!$participant) {
            abort(403, 'You are not part of this conversation.');
        }
        
        // Mark messages as read
        $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        
        $participant->markAsRead();
        
        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->get();
        
        return view('messages.show', compact('conversation', 'messages'));
    }

    /**
     * Start a new conversation with a user
     */
    public function create(User $user)
    {
        $currentUser = Auth::user();
        
        // Check if conversation already exists between these users
        $existingConversation = Conversation::whereHas('participants', function($q) use ($currentUser) {
            $q->where('user_id', $currentUser->id);
        })->whereHas('participants', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where('type', 'direct')->first();
        
        if ($existingConversation) {
            return redirect()->route('messages.show', $existingConversation);
        }
        
        return view('messages.create', compact('user'));
    }

    /**
     * Store a new conversation
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'attachment' => 'nullable|file|max:10240'
        ]);

        $currentUser = Auth::user();
        
        // Create conversation
        $conversation = Conversation::create([
            'subject' => $request->subject,
            'type' => 'direct',
            'created_by' => $currentUser->id,
            'last_message_at' => now()
        ]);
        
        // Add participants
        MessageParticipant::create([
            'conversation_id' => $conversation->id,
            'user_id' => $currentUser->id
        ]);
        
        MessageParticipant::create([
            'conversation_id' => $conversation->id,
            'user_id' => $request->recipient_id
        ]);
        
        // Create message
        $this->sendMessage($request, $conversation);
        
        return redirect()->route('messages.show', $conversation)
            ->with('success', 'Message sent successfully!');
    }

    /**
     * Send a message in a conversation
     */
    public function sendMessage(Request $request, Conversation $conversation)
    {
        $request->validate([
            'content' => 'required_without:attachment|string',
            'attachment' => 'nullable|file|max:10240'
        ]);

        $user = Auth::user();
        
        // Check if user is participant
        if (!$conversation->participants()->where('user_id', $user->id)->exists()) {
            abort(403);
        }
        
        $data = [
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'content' => $request->content ?? ''
        ];
        
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('message-attachments', $fileName, 'public');
            
            $data['attachment_path'] = $filePath;
            $data['attachment_name'] = $file->getClientOriginalName();
        }
        
        $message = Message::create($data);
        
        $conversation->update(['last_message_at' => now()]);
        
        // Mark as unread for other participants
        $conversation->participants()
            ->where('user_id', '!=', $user->id)
            ->update(['last_read_at' => null]);
        
        return response()->json([
            'success' => true,
            'message' => $message->load('sender')
        ]);
    }

    /**
     * Get unread message count for the current user
     */
    public function unreadCount()
    {
        $user = Auth::user();
        
        $conversations = Conversation::forUser($user->id)->get();
        
        $unreadCount = $conversations->sum(function($conv) use ($user) {
            return $conv->getUnreadCountForUser($user->id);
        });
        
        return response()->json(['count' => $unreadCount]);
    }

    /**
     * Course discussion forum
     */
    public function courseForum(Course $course)
    {
        $user = Auth::user();
        
        // Check if user is enrolled (for students) or teaching (for staff)
        if ($user->role === 'student') {
            $student = $user->student;
            if (!$student || !$student->courses()->where('course_id', $course->id)->exists()) {
                abort(403, 'You are not enrolled in this course.');
            }
        }
        
        // Get or create course conversation
        $conversation = Conversation::firstOrCreate(
            [
                'course_id' => $course->id,
                'type' => 'course'
            ],
            [
                'subject' => $course->course_name . ' Discussion',
                'created_by' => $user->id,
                'last_message_at' => now()
            ]
        );
        
        // Ensure all course participants are added
        $this->syncCourseParticipants($conversation, $course);
        
        return redirect()->route('messages.show', $conversation);
    }

    /**
     * Sync course participants to conversation
     */
    private function syncCourseParticipants(Conversation $conversation, Course $course)
    {
        $students = $course->students()->with('user')->get();
        $staff = $course->instructors()->with('user')->get();
        
        $userIds = [];
        
        foreach ($students as $student) {
            if ($student->user) {
                $userIds[] = $student->user->id;
            }
        }
        
        foreach ($staff as $instructor) {
            if ($instructor->user) {
                $userIds[] = $instructor->user->id;
            }
        }
        
        $userIds = array_unique($userIds);
        
        foreach ($userIds as $userId) {
            MessageParticipant::firstOrCreate([
                'conversation_id' => $conversation->id,
                'user_id' => $userId
            ]);
        }
    }
}