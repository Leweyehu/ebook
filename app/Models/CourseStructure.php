<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseStructure extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'semester',
        'course_code',
        'course_name',
        'ects',
        'credit_hours',
        'description',
        'is_elective',
        'status',
        'order'
    ];

    protected $casts = [
        'is_elective' => 'boolean',
        'ects' => 'integer',
        'credit_hours' => 'integer',
        'year' => 'integer',
        'semester' => 'integer'
    ];

    // Get course type badge
    public function getTypeBadgeAttribute()
    {
        if ($this->is_elective) {
            return '<span style="background: #ffc107; color: #1a2b3c; padding: 0.2rem 0.5rem; border-radius: 20px; font-size: 0.7rem;">Elective</span>';
        }
        return '<span style="background: #28a745; color: white; padding: 0.2rem 0.5rem; border-radius: 20px; font-size: 0.7rem;">Core</span>';
    }
}