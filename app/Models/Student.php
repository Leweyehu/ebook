<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    
    protected $primaryKey = 'id';
    
    public $incrementing = true;
    
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
    
    protected $casts = [
        'year' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
    /**
     * Scope for filtering by batch
     */
    public function scopeByBatch($query, $batch)
    {
        if ($batch) {
            return $query->where('batch', $batch);
        }
        return $query;
    }
    
    /**
     * Scope for searching students
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('student_id', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('batch', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }
        return $query;
    }
    
    /**
     * Scope for active students only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Get all unique batches for filtering
     */
    public static function getBatches()
    {
        return self::where('is_active', true)
                   ->whereNotNull('batch')
                   ->distinct()
                   ->pluck('batch')
                   ->filter()
                   ->sort()
                   ->values();
    }
    
    /**
     * Get all unique years for filtering
     */
    public static function getYears()
    {
        return self::where('is_active', true)
                   ->distinct()
                   ->pluck('year')
                   ->filter()
                   ->sort()
                   ->values();
    }
    
    /**
     * Get students by batch
     */
    public static function getByBatch($batch)
    {
        return self::where('batch', $batch)
                   ->where('is_active', true)
                   ->orderBy('name')
                   ->get();
    }
    
    /**
     * Get student display name with ID
     */
    public function getDisplayNameAttribute()
    {
        return $this->name . ' (' . $this->student_id . ')';
    }
    
    /**
     * Get student avatar URL
     */
    public function getAvatarAttribute()
    {
        if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=667eea&color=fff';
    }
    
    /**
     * Get student initials
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
     * Relationship with courses (if needed)
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id')
                    ->withTimestamps();
    }
    
    /**
     * Get enrolled courses
     */
    public function enrolledCourses()
    {
        return $this->courses()->wherePivot('status', 'enrolled');
    }
    
    /**
     * Check if student is active
     */
    public function isActive()
    {
        return $this->is_active;
    }
}