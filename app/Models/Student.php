<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'students';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'name',
        'email',
        'year',
        'section',
        'batch',
        'department',
        'profile_image',
        'phone',
        'address',
        'bio',
        'achievements',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     * This prevents sensitive data from being exposed in API responses
     * and public views when using toArray() or toJson().
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'student_id',   // HIDE student_id from public
        'email',        // HIDE email from public
        'phone',        // HIDE phone from public
        'address',      // HIDE address from public
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'year' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'display_name',
        'profile_image_url',
        'initials'
    ];

    /**
     * Get the user account associated with the student.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    /**
     * Get the courses this student is enrolled in.
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id')
                    ->withPivot('academic_year', 'status', 'enrollment_date')
                    ->withTimestamps();
    }

    /**
     * Get courses where this student is currently enrolled (active status).
     */
    public function enrolledCourses()
    {
        return $this->courses()->wherePivot('status', 'enrolled');
    }

    /**
     * Get courses this student has completed.
     */
    public function completedCourses()
    {
        return $this->courses()->wherePivot('status', 'completed');
    }

    /**
     * Get courses this student dropped.
     */
    public function droppedCourses()
    {
        return $this->courses()->wherePivot('status', 'dropped');
    }

    /**
     * Get courses by academic year.
     */
    public function coursesByAcademicYear($academicYear)
    {
        return $this->courses()->wherePivot('academic_year', $academicYear);
    }

    /**
     * Get the grades for this student.
     */
    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id', 'student_id');
    }

    /**
     * Get the assignment submissions for this student.
     */
    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class, 'student_id', 'student_id');
    }

    /**
     * Get the current GPA (Grade Point Average) for this student.
     */
    public function getGpaAttribute()
    {
        $grades = $this->grades;
        if ($grades->isEmpty()) {
            return 0;
        }
        
        $totalPoints = 0;
        $totalCredits = 0;
        
        foreach ($grades as $grade) {
            if ($grade->course && $grade->percentage) {
                $totalPoints += $this->percentageToGradePoint($grade->percentage) * $grade->course->credit_hours;
                $totalCredits += $grade->course->credit_hours;
            }
        }
        
        return $totalCredits > 0 ? round($totalPoints / $totalCredits, 2) : 0;
    }

    /**
     * Convert percentage to grade point (4.0 scale).
     */
    private function percentageToGradePoint($percentage)
    {
        return match(true) {
            $percentage >= 90 => 4.0,
            $percentage >= 85 => 3.7,
            $percentage >= 80 => 3.3,
            $percentage >= 75 => 3.0,
            $percentage >= 70 => 2.7,
            $percentage >= 65 => 2.3,
            $percentage >= 60 => 2.0,
            $percentage >= 50 => 1.7,
            $percentage >= 45 => 1.3,
            $percentage >= 40 => 1.0,
            default => 0.0
        };
    }

    /**
     * Check if student is enrolled in a specific course.
     */
    public function isEnrolledIn(Course $course)
    {
        return $this->enrolledCourses()
                    ->where('course_id', $course->id)
                    ->exists();
    }

    /**
     * Check if student has completed a specific course.
     */
    public function hasCompleted(Course $course)
    {
        return $this->completedCourses()
                    ->where('course_id', $course->id)
                    ->exists();
    }

    /**
     * Get enrollment date for a specific course.
     */
    public function getEnrollmentDateForCourse(Course $course)
    {
        $enrollment = $this->courses()
                          ->where('course_id', $course->id)
                          ->first();
        
        return $enrollment ? $enrollment->pivot->enrollment_date : null;
    }

    /**
     * Get the student's full name with ID (for admin/staff only).
     * This will automatically hide student_id from public when used in views
     * that don't check permissions.
     */
    public function getDisplayNameAttribute()
    {
        // If user is authenticated and is admin/staff, show with ID
        if (auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isStaff())) {
            return $this->name . ' (' . $this->student_id . ')';
        }
        
        // For public, show name only
        return $this->name;
    }

    /**
     * Get the student's profile image URL.
     */
    public function getProfileImageUrlAttribute()
    {
        return $this->profile_image 
            ? asset('storage/' . $this->profile_image) 
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=0a2342&background=FFD700';
    }

    /**
     * Get the student's initials for avatar.
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
     * Get total credits taken.
     */
    public function getTotalCreditsAttribute()
    {
        return $this->enrolledCourses->sum('credit_hours');
    }

    /**
     * Get completion rate percentage.
     */
    public function getCompletionRateAttribute()
    {
        $total = $this->courses()->count();
        if ($total === 0) return 0;
        
        $completed = $this->completedCourses()->count();
        return round(($completed / $total) * 100, 2);
    }

    /**
     * Custom toArray method to conditionally expose sensitive data.
     * This allows admin/staff to see student_id while keeping it hidden from public.
     */
    public function toArray()
    {
        // Get the default array with hidden attributes removed
        $array = parent::toArray();
        
        // Check if the current user is authenticated and is admin or staff
        if (auth()->check()) {
            $user = auth()->user();
            
            // If user is admin or staff, include the sensitive data
            if ($user && ($user->isAdmin() || $user->isStaff())) {
                $array['student_id'] = $this->student_id;
                $array['email'] = $this->email;
                $array['phone'] = $this->phone;
                $array['address'] = $this->address;
            }
        }
        
        return $array;
    }

    /**
     * Scope a query to only include active students.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by year.
     */
    public function scopeOfYear($query, $year)
    {
        return $query->where('year', $year);
    }

    /**
     * Scope a query to filter by batch.
     */
    public function scopeOfBatch($query, $batch)
    {
        return $query->where('batch', $batch);
    }

    /**
     * Scope a query to filter by section.
     */
    public function scopeOfSection($query, $section)
    {
        return $query->where('section', $section);
    }

    /**
     * Scope a query to order by year and name.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('year')->orderBy('name');
    }

    /**
     * Scope a query to search by name or student ID (for admin/staff only).
     * Student ID search is automatically restricted by the hidden attribute,
     * but this scope can still be used internally.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('student_id', 'LIKE', "%{$search}%") // Works internally even though hidden
              ->orWhere('email', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Get public student data - explicitly excludes sensitive fields.
     * Use this method when you want to ensure only public data is returned.
     */
    public function getPublicData()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'year' => $this->year,
            'section' => $this->section,
            'batch' => $this->batch,
            'profile_image' => $this->profile_image_url,
            'initials' => $this->initials,
            'bio' => $this->bio,
            'achievements' => $this->achievements
        ];
    }
}