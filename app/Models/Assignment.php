<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'created_by',
        'title',
        'description',
        'file_path',
        'file_name',
        'due_date',
        'total_points',
        'assignment_type',
        'is_active'
    ];

    protected $casts = [
        'due_date' => 'date',
        'is_active' => 'boolean',
        'total_points' => 'integer'
    ];

    /**
     * Get the course that owns this assignment
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the user who created this assignment
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the submissions for this assignment
     */
    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    /**
     * Get students who have submitted
     */
    public function submittedStudents()
    {
        return $this->belongsToMany(Student::class, 'assignment_submissions', 'assignment_id', 'student_id')
                    ->withPivot('submitted_at', 'score', 'feedback')
                    ->withTimestamps();
    }

    /**
     * Check if assignment is past due date
     */
    public function isPastDue()
    {
        return now()->gt($this->due_date);
    }

    /**
     * Get submission count
     */
    public function getSubmissionCountAttribute()
    {
        return $this->submissions()->count();
    }

    /**
     * Get pending submissions (students enrolled but not submitted)
     */
    public function getPendingSubmissionsAttribute()
    {
        $enrolledCount = $this->course->students()->count();
        return $enrolledCount - $this->submissions()->count();
    }
}