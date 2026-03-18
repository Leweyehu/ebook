<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'qualification',
        'phone',
        'email',
        'specialization',
        'image',
        'bio',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Get the user account associated with the staff member.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    /**
     * Get the courses taught by this staff member.
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_staff', 'staff_id', 'course_id')
                    ->withPivot('role', 'academic_year')
                    ->withTimestamps();
    }

    /**
     * Get courses where this staff is the primary instructor.
     */
    public function primaryCourses()
    {
        return $this->belongsToMany(Course::class, 'course_staff', 'staff_id', 'course_id')
                    ->wherePivot('role', 'primary')
                    ->withPivot('role', 'academic_year')
                    ->withTimestamps();
    }

    /**
     * Get courses taught by this staff in a specific academic year.
     */
    public function coursesByAcademicYear($academicYear)
    {
        return $this->belongsToMany(Course::class, 'course_staff', 'staff_id', 'course_id')
                    ->wherePivot('academic_year', $academicYear)
                    ->withPivot('role', 'academic_year')
                    ->withTimestamps();
    }

    /**
     * Check if staff is assigned to a specific course.
     */
    public function isAssignedToCourse($courseId)
    {
        return $this->courses()->where('course_id', $courseId)->exists();
    }

    /**
     * Get the total number of students across all courses taught by this staff.
     */
    public function getTotalStudentsAttribute()
    {
        $total = 0;
        foreach ($this->courses as $course) {
            $total += $course->students()->count();
        }
        return $total;
    }

    /**
     * Get the staff's full name with position.
     */
    public function getDisplayNameAttribute()
    {
        return $this->name . ($this->position ? ' (' . $this->position . ')' : '');
    }

    /**
     * Get the staff's profile image URL.
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-avatar.jpg');
    }

    /**
     * Scope a query to only include active staff.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order by sort_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Scope a query to filter by position.
     */
    public function scopePosition($query, $position)
    {
        return $query->where('position', 'LIKE', "%{$position}%");
    }

    /**
     * Scope a query to filter by specialization.
     */
    public function scopeSpecialization($query, $specialization)
    {
        return $query->where('specialization', 'LIKE', "%{$specialization}%");
    }
}