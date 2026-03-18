<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'created_by',
        'last_message_at'
    ];

    protected $casts = [
        'last_message_at' => 'datetime'
    ];

    /**
     * Get the users in this conversation
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'conversation_user')
                    ->withPivot('last_read_at', 'is_muted')
                    ->withTimestamps();
    }

    /**
     * Get the messages in this conversation
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the latest message in this conversation
     */
    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    /**
     * Get the creator of this conversation
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the other user in a private conversation
     */
    public function getOtherUserAttribute()
    {
        if ($this->type === 'private') {
            return $this->users->where('id', '!=', auth()->id())->first();
        }
        return null;
    }

    /**
     * Scope a query to only include conversations for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('users', function($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    /**
     * Scope a query to only include private conversations
     */
    public function scopePrivate($query)
    {
        return $query->where('type', 'private');
    }

    /**
     * Scope a query to only include group conversations
     */
    public function scopeGroup($query)
    {
        return $query->where('type', 'group');
    }

    /**
     * Get unread messages count for a user
     */
    public function unreadCountForUser($userId)
    {
        $lastRead = $this->users()
                        ->where('user_id', $userId)
                        ->first()
                        ?->pivot
                        ?->last_read_at;

        return $this->messages()
                    ->where('user_id', '!=', $userId)
                    ->when($lastRead, function($query) use ($lastRead) {
                        return $query->where('created_at', '>', $lastRead);
                    })
                    ->count();
    }

    /**
     * Mark conversation as read for a user
     */
    public function markAsReadForUser($userId)
    {
        $this->users()->updateExistingPivot($userId, [
            'last_read_at' => now()
        ]);
    }
}