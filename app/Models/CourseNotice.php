<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseNotice extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'posted_by',
        'title',
        'content',
        'attachment_path',
        'attachment_name',
        'priority',
        'is_active',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    /**
     * Get the course that owns this notice
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the user who posted this notice
     */
    public function poster()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    /**
     * Get the staff who posted this notice
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'posted_by', 'user_id');
    }

    /**
     * Scope a query to only include active notices
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where(function($q) {
                         $q->whereNull('expires_at')
                           ->orWhere('expires_at', '>', now());
                     });
    }

    /**
     * Scope a query to filter by priority
     */
    public function scopePriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Get priority badge color
     */
    public function getPriorityBadgeAttribute()
    {
        return match($this->priority) {
            'urgent' => '#dc3545',
            'high' => '#fd7e14',
            'normal' => '#ffc107',
            'low' => '#6c757d',
            default => '#6c757d'
        };
    }
}