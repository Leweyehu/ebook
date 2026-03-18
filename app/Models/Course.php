<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'course_name',
        'description',
        'credit_hours',
        'ects',
        'semester',
        'year',
        'status',
        'created_by'
    ];

    protected $casts = [
        'credit_hours' => 'integer',
        'ects' => 'integer',
        'year' => 'integer'
    ];

    /**
     * Get the staff members teaching this course
     */
    public function instructors()
    {
        return $this->belongsToMany(Staff::class, 'course_staff', 'course_id', 'staff_id')
                    ->withPivot('role', 'academic_year')
                    ->withTimestamps();
    }

    /**
     * Get the primary instructor for this course
     */
    public function primaryInstructor()
    {
        return $this->belongsToMany(Staff::class, 'course_staff', 'course_id', 'staff_id')
                    ->wherePivot('role', 'primary')
                    ->withPivot('role', 'academic_year')
                    ->withTimestamps();
    }

    /**
     * Get the students enrolled in this course
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student', 'course_id', 'student_id')
                    ->withPivot('academic_year', 'status', 'enrollment_date')
                    ->withTimestamps();
    }

    /**
     * Get students by year
     */
    public function studentsByYear($year)
    {
        return $this->students()->where('year', $year);
    }

    /**
     * Get the user who created this course
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope a query to only include active courses
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to filter by year
     */
    public function scopeYear($query, $year)
    {
        return $query->where('year', $year);
    }

    /**
     * Get the full course name with code
     */
    public function getFullNameAttribute()
    {
        return $this->course_code . ' - ' . $this->course_name;
    }
}