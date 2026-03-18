<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Events\MessageSent;
use App\Events\UserTyping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    /**
     * Display the chat interface
     */
    public function index()
    {
        $users = $this->getChattableUsers();
        return view('chat.index', compact('users'));
    }

    /**
     * Get all users that the current user can chat with
     */
    public function getChattableUsers()
    {
        $currentUser = Auth::user();
        
        if ($currentUser->isAdmin()) {
            // Admins can chat with everyone
            $users = User::where('id', '!=', $currentUser->id)
                ->where('is_active', true)
                ->select('id', 'name', 'email', 'role')
                ->get();
        } elseif ($currentUser->isStaff()) {
            // Staff can chat with students
            $users = User::where('role', 'student')
                ->where('is_active', true)
                ->where('id', '!=', $currentUser->id)
                ->select('id', 'name', 'email', 'role')
                ->get();
        } elseif ($currentUser->isStudent()) {
            // Students can chat with staff
            $users = User::where('role', 'staff')
                ->where('is_active', true)
                ->where('id', '!=', $currentUser->id)
                ->select('id', 'name', 'email', 'role')
                ->get();
        } else {
            $users = collect([]);
        }

        // Add online status and unread count for each user
        foreach ($users as $user) {
            $user->is_online = $user->isOnline();
            $user->last_seen = $user->last_seen;
            $user->unread_count = Message::where('sender_id', $user->id)
                ->where('receiver_id', $currentUser->id)
                ->where('is_read', false)
                ->count();
            
            // Get latest message for preview
            $latestMessage = Message::where(function($query) use ($user, $currentUser) {
                    $query->where('sender_id', $currentUser->id)
                        ->where('receiver_id', $user->id);
                })->orWhere(function($query) use ($user, $currentUser) {
                    $query->where('sender_id', $user->id)
                        ->where('receiver_id', $currentUser->id);
                })
                ->latest()
                ->first();
            
            $user->latest_message = $latestMessage ? [
                'content' => $latestMessage->message,
                'time' => $latestMessage->created_at->diffForHumans(),
                'is_from_me' => $latestMessage->sender_id === $currentUser->id
            ] : null;
        }

        return $users;
    }

    /**
     * API: Get online users
     */
    public function onlineUsers()
    {
        try {
            $users = User::where('id', '!=', Auth::id())
                ->where('is_active', true)
                ->select('id', 'name', 'role')
                ->get()
                ->map(function($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'role' => $user->role,
                        'is_online' => $user->isOnline(),
                        'last_seen' => $user->last_seen,
                        'initials' => $user->initials,
                        'avatar' => $user->profile_photo_url
                    ];
                });
            
            return response()->json([
                'success' => true,
                'data' => $users
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error fetching online users: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch online users'
            ], 500);
        }
    }
    
    /**
     * API: Get messages with a specific user
     */
    public function messages($userId)
    {
        try {
            $messages = Message::where(function($query) use ($userId) {
                    $query->where('sender_id', Auth::id())
                        ->where('receiver_id', $userId);
                })->orWhere(function($query) use ($userId) {
                    $query->where('sender_id', $userId)
                        ->where('receiver_id', Auth::id());
                })
                ->with('sender:id,name,role')
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function($message) {
                    return [
                        'id' => $message->id,
                        'message' => $message->message,
                        'sender_id' => $message->sender_id,
                        'receiver_id' => $message->receiver_id,
                        'sender_name' => $message->sender->name,
                        'sender_role' => $message->sender->role,
                        'is_read' => $message->is_read,
                        'read_at' => $message->read_at,
                        'created_at' => $message->created_at->format('Y-m-d H:i:s'),
                        'time_ago' => $message->created_at->diffForHumans()
                    ];
                });
            
            // Mark messages as read
            Message::where('sender_id', $userId)
                ->where('receiver_id', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);
            
            return response()->json([
                'success' => true,
                'data' => $messages
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error fetching messages: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch messages'
            ], 500);
        }
    }
    
    /**
     * API: Send a message
     */
    public function sendMessage(Request $request)
    {
        try {
            $request->validate([
                'receiver_id' => 'required|exists:users,id',
                'message' => 'required|string|max:5000'
            ]);

            // Check if user can message this recipient
            $currentUser = Auth::user();
            $recipient = User::find($request->receiver_id);
            
            if (!$currentUser->canMessage($recipient)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to message this user'
                ], 403);
            }
            
            $message = Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
                'is_read' => false
            ]);
            
            // Load sender relationship
            $message->load('sender:id,name,role');
            
            // Broadcast the message
            broadcast(new MessageSent($message))->toOthers();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $message->id,
                    'message' => $message->message,
                    'sender_id' => $message->sender_id,
                    'receiver_id' => $message->receiver_id,
                    'sender_name' => $message->sender->name,
                    'sender_role' => $message->sender->role,
                    'created_at' => $message->created_at->format('Y-m-d H:i:s'),
                    'time_ago' => $message->created_at->diffForHumans()
                ]
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error sending message: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message'
            ], 500);
        }
    }
    
    /**
     * API: User is typing
     */
    public function typing(Request $request)
    {
        try {
            $request->validate([
                'receiver_id' => 'required|exists:users,id'
            ]);
            
            broadcast(new UserTyping(
                Auth::user(),
                $request->receiver_id
            ))->toOthers();
            
            return response()->json([
                'success' => true,
                'status' => 'typing indicator sent'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error sending typing indicator: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send typing indicator'
            ], 500);
        }
    }
    
    /**
     * API: Get unread messages count
     */
    public function getUnreadCount()
    {
        try {
            $count = Message::where('receiver_id', Auth::id())
                ->where('is_read', false)
                ->count();
            
            return response()->json([
                'success' => true,
                'count' => $count
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error fetching unread count: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch unread count'
            ], 500);
        }
    }
    
    /**
     * API: Mark messages as read
     */
    public function markAsRead(Request $request)
    {
        try {
            $request->validate([
                'sender_id' => 'required|exists:users,id'
            ]);
            
            Message::where('sender_id', $request->sender_id)
                ->where('receiver_id', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);
            
            return response()->json([
                'success' => true,
                'message' => 'Messages marked as read'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error marking messages as read: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark messages as read'
            ], 500);
        }
    }

    /**
     * API: Get conversation list
     */
    public function getConversations()
    {
        try {
            $currentUser = Auth::user();
            
            // Get all users that have exchanged messages with current user
            $userIds = Message::where('sender_id', $currentUser->id)
                ->orWhere('receiver_id', $currentUser->id)
                ->get()
                ->map(function($message) use ($currentUser) {
                    return $message->sender_id == $currentUser->id 
                        ? $message->receiver_id 
                        : $message->sender_id;
                })
                ->unique()
                ->values();
            
            $conversations = User::whereIn('id', $userIds)
                ->where('id', '!=', $currentUser->id)
                ->select('id', 'name', 'role')
                ->get()
                ->map(function($user) use ($currentUser) {
                    $lastMessage = Message::where(function($query) use ($user, $currentUser) {
                            $query->where('sender_id', $currentUser->id)
                                ->where('receiver_id', $user->id);
                        })->orWhere(function($query) use ($user, $currentUser) {
                            $query->where('sender_id', $user->id)
                                ->where('receiver_id', $currentUser->id);
                        })
                        ->latest()
                        ->first();
                    
                    $unreadCount = Message::where('sender_id', $user->id)
                        ->where('receiver_id', $currentUser->id)
                        ->where('is_read', false)
                        ->count();
                    
                    return [
                        'user' => [
                            'id' => $user->id,
                            'name' => $user->name,
                            'role' => $user->role,
                            'is_online' => $user->isOnline(),
                            'last_seen' => $user->last_seen,
                            'initials' => $user->initials,
                            'avatar' => $user->profile_photo_url
                        ],
                        'last_message' => $lastMessage ? [
                            'content' => $lastMessage->message,
                            'time' => $lastMessage->created_at->diffForHumans(),
                            'is_from_me' => $lastMessage->sender_id === $currentUser->id
                        ] : null,
                        'unread_count' => $unreadCount
                    ];
                })
                ->sortByDesc(function($conversation) {
                    return $conversation['last_message']['time'] ?? '';
                })
                ->values();
            
            return response()->json([
                'success' => true,
                'data' => $conversations
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error fetching conversations: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch conversations'
            ], 500);
        }
    }
}