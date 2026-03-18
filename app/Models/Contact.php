<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'admin_reply',
        'status',
        'ip_address',
        'user_agent',
        'replied_at',
        'replied_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'replied_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the user who replied to this message.
     */
    public function replier()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    /**
     * Scope a query to only include unread messages.
     */
    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }

    /**
     * Scope a query to only include read messages.
     */
    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    /**
     * Scope a query to only include replied messages.
     */
    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    /**
     * Check if message is read.
     */
    public function isRead()
    {
        return $this->status === 'read' || $this->status === 'replied';
    }

    /**
     * Check if message is replied.
     */
    public function isReplied()
    {
        return $this->status === 'replied';
    }

    /**
     * Mark the message as read.
     */
    public function markAsRead()
    {
        if ($this->status === 'unread') {
            $this->update(['status' => 'read']);
        }
        return $this;
    }

    /**
     * Get the truncated message for lists.
     */
    public function getExcerptAttribute($length = 100)
    {
        return strlen($this->message) > $length 
            ? substr($this->message, 0, $length) . '...' 
            : $this->message;
    }
}