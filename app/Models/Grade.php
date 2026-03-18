<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'assignment_id',
        'score',
        'percentage',
        'letter_grade',
        'remarks',
        'grade_type',
        'graded_by'
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'percentage' => 'decimal:2'
    ];

    /**
     * Get the student that owns this grade
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the course that owns this grade
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the assignment that owns this grade (if applicable)
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * Get the user who graded this
     */
    public function grader()
    {
        return $this->belongsTo(User::class, 'graded_by');
    }

    /**
     * Calculate letter grade based on percentage
     */
    public static function calculateLetterGrade($percentage)
    {
        if ($percentage >= 90) return 'A+';
        if ($percentage >= 85) return 'A';
        if ($percentage >= 80) return 'A-';
        if ($percentage >= 75) return 'B+';
        if ($percentage >= 70) return 'B';
        if ($percentage >= 65) return 'B-';
        if ($percentage >= 60) return 'C+';
        if ($percentage >= 50) return 'C';
        if ($percentage >= 45) return 'C-';
        if ($percentage >= 40) return 'D';
        return 'F';
    }
}