<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'course_name',
        'slug',
        'credit_hours',
        'year_level',
        'semester',
        'description',
        'objectives',
        'syllabus',
        'featured_image',
        'instructor',
        'prerequisites',
        'capacity',
        'status',
        'is_elective',
        'order'
    ];

    protected $casts = [
        'credit_hours' => 'integer',
        'year_level' => 'integer',
        'capacity' => 'integer',
        'is_elective' => 'boolean',
        'order' => 'integer'
    ];

    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($course) {
            $course->slug = Str::slug($course->course_code . '-' . $course->course_name);
        });
        
        static::updating(function ($course) {
            if ($course->isDirty('course_code') || $course->isDirty('course_name')) {
                $course->slug = Str::slug($course->course_code . '-' . $course->course_name);
            }
        });
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByYear($query, $year)
    {
        return $query->where('year_level', $year);
    }

    public function scopeBySemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        return $this->featured_image 
            ? asset('storage/' . $this->featured_image) 
            : asset('images/course-placeholder.jpg');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'active' => ['bg' => '#28a745', 'text' => 'Active'],
            'inactive' => ['bg' => '#dc3545', 'text' => 'Inactive'],
            'archived' => ['bg' => '#6c757d', 'text' => 'Archived']
        ];
        
        $badge = $badges[$this->status] ?? $badges['active'];
        return "<span style='background: {$badge['bg']}; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;'>{$badge['text']}</span>";
    }
}