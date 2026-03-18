<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'student_id',
        'department',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the staff record associated with the user.
     * Staff are linked by email only - the role is determined by the user's role
     */
    public function staff()
    {
        return $this->hasOne(Staff::class, 'email', 'email');
    }

    /**
     * Get the student record associated with the user.
     * Students are linked by email only - the role is determined by the user's role
     */
    public function student()
    {
        return $this->hasOne(Student::class, 'email', 'email');
    }

    /**
     * Get the related model (Staff or Student) based on role
     */
    public function related()
    {
        if ($this->isStaff()) {
            return $this->staff();
        } elseif ($this->isStudent()) {
            return $this->student();
        }
        return null;
    }

    // ========== CHAT SYSTEM RELATIONSHIPS ==========

    /**
     * Get the conversations this user is part of.
     */
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_user')
                    ->withPivot('last_read_at', 'is_muted')
                    ->withTimestamps()
                    ->orderBy('updated_at', 'desc');
    }

    /**
     * Get the messages sent by this user.
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get the messages received by this user.
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Get the user's online status.
     */
    public function status()
    {
        return $this->hasOne(UserStatus::class);
    }

    /**
     * Get the user's unread messages count.
     */
    public function getUnreadMessagesCountAttribute()
    {
        return Message::where('receiver_id', $this->id)
                      ->where('is_read', false)
                      ->count();
    }

    /**
     * Get unread messages per conversation.
     */
    public function getUnreadMessagesPerConversationAttribute()
    {
        $unreadCounts = [];
        
        foreach ($this->conversations as $conversation) {
            $lastRead = $conversation->pivot->last_read_at;
            
            $count = Message::where('conversation_id', $conversation->id)
                            ->where('sender_id', '!=', $this->id)
                            ->when($lastRead, function($query) use ($lastRead) {
                                return $query->where('created_at', '>', $lastRead);
                            })
                            ->count();
            
            if ($count > 0) {
                $unreadCounts[$conversation->id] = $count;
            }
        }
        
        return $unreadCounts;
    }

    /**
     * Check if user is online.
     */
    public function isOnline()
    {
        return $this->status && 
               $this->status->status === 'online' && 
               $this->status->last_seen_at >= now()->subMinutes(5);
    }

    /**
     * Get user's online status text.
     */
    public function getOnlineStatusAttribute()
    {
        if (!$this->status) {
            return 'offline';
        }
        
        if ($this->status->status === 'online' && $this->status->last_seen_at >= now()->subMinutes(5)) {
            return 'online';
        } elseif ($this->status->last_seen_at >= now()->subMinutes(15)) {
            return 'away';
        } else {
            return 'offline';
        }
    }

    /**
     * Get user's last seen time in human readable format.
     */
    public function getLastSeenAttribute()
    {
        return $this->status?->last_seen_at?->diffForHumans() ?? 'Never';
    }

    /**
     * Get user's initials for avatar.
     */
    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        return substr($initials, 0, 2);
    }

    /**
     * Get user's profile photo URL.
     */
    public function getProfilePhotoUrlAttribute()
    {
        // You can customize this based on your user's profile image logic
        if ($this->role === 'staff' && $this->staff && $this->staff->image) {
            return asset($this->staff->image);
        } elseif ($this->role === 'student' && $this->student && $this->student->profile_image) {
            return asset($this->student->profile_image);
        }
        
        // Default avatar using UI Avatars service
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get all users that this user can chat with (staff can chat with students, students with staff)
     */
    public function getChattableUsersAttribute()
    {
        if ($this->isStaff()) {
            // Staff can chat with students
            return User::where('role', 'student')->active()->get();
        } elseif ($this->isStudent()) {
            // Students can chat with staff
            return User::where('role', 'staff')->active()->get();
        } elseif ($this->isAdmin()) {
            // Admins can chat with everyone
            return User::whereIn('role', ['staff', 'student'])->active()->get();
        }
        
        return collect([]);
    }

    /**
     * Get the latest message with a specific user.
     */
    public function latestMessageWith($userId)
    {
        return Message::where(function($query) use ($userId) {
                $query->where('sender_id', $this->id)
                      ->where('receiver_id', $userId);
            })->orWhere(function($query) use ($userId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', $this->id);
            })
            ->latest()
            ->first();
    }

    /**
     * Get all messages exchanged with a specific user.
     */
    public function messagesWith($userId)
    {
        return Message::where(function($query) use ($userId) {
                $query->where('sender_id', $this->id)
                      ->where('receiver_id', $userId);
            })->orWhere(function($query) use ($userId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', $this->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Mark all messages from a specific sender as read.
     */
    public function markMessagesAsRead($senderId)
    {
        return Message::where('sender_id', $senderId)
                      ->where('receiver_id', $this->id)
                      ->where('is_read', false)
                      ->update(['is_read' => true, 'read_at' => now()]);
    }

    // Check user roles
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    /**
     * Check if user account is active
     */
    public function isActive()
    {
        return $this->is_active === true;
    }

    /**
     * Get the display name with role badge
     */
    public function getDisplayNameAttribute()
    {
        $roleBadge = '';
        switch ($this->role) {
            case 'admin':
                $roleBadge = ' [Admin]';
                break;
            case 'staff':
                $roleBadge = ' [Staff]';
                break;
            case 'student':
                $roleBadge = ' [Student]';
                break;
        }
        return $this->name . $roleBadge;
    }

    /**
     * Get the profile URL based on role
     */
    public function getDashboardRouteAttribute()
    {
        switch ($this->role) {
            case 'admin':
                return route('admin.dashboard');
            case 'staff':
                return route('staff.dashboard');
            case 'student':
                return route('student.dashboard');
            default:
                return route('home');
        }
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include users by role.
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope a query to only include admins.
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope a query to only include staff.
     */
    public function scopeStaff($query)
    {
        return $query->where('role', 'staff');
    }

    /**
     * Scope a query to only include students.
     */
    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    /**
     * Scope a query to only include users that can chat with the current user.
     */
    public function scopeChattable($query, $user)
    {
        if ($user->isStaff()) {
            return $query->where('role', 'student');
        } elseif ($user->isStudent()) {
            return $query->where('role', 'staff');
        } elseif ($user->isAdmin()) {
            return $query->whereIn('role', ['staff', 'student']);
        }
        
        return $query->whereRaw('1 = 0'); // Return empty collection
    }

    /**
     * Scope a query to only include online users.
     */
    public function scopeOnline($query)
    {
        return $query->whereHas('status', function($q) {
            $q->where('status', 'online')
              ->where('last_seen_at', '>=', now()->subMinutes(5));
        });
    }

    /**
     * Get the user's full name with title.
     */
    public function getFullNameAttribute()
    {
        $title = '';
        if ($this->isStaff()) {
            $title = 'Mr./Ms. ';
        } elseif ($this->isStudent()) {
            $title = 'Student ';
        }
        
        return $title . $this->name;
    }

    /**
     * Check if user can message another user.
     */
    public function canMessage(User $otherUser)
    {
        if (!$this->isActive() || !$otherUser->isActive()) {
            return false;
        }
        
        if ($this->isAdmin()) {
            return true;
        }
        
        if ($this->isStaff() && $otherUser->isStudent()) {
            return true;
        }
        
        if ($this->isStudent() && $otherUser->isStaff()) {
            return true;
        }
        
        return false;
    }

    /**
     * Get conversation with a specific user.
     */
    public function getConversationWith($userId)
    {
        return $this->conversations()
                    ->whereHas('users', function($query) use ($userId) {
                        $query->where('user_id', $userId);
                    })
                    ->first();
    }
}