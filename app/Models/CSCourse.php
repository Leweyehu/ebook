<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CSCourse extends Model
{
    use HasFactory;

    protected $table = 'cs_courses';

    protected $fillable = [
        'course_code',
        'course_title',
        'ects',
        'credit_hours',
        'lecture_hours',
        'lab_hours',
        'tutorial_hours',
        'category',
        'year',
        'semester',
        'description',
        'instructor',
        'syllabus_path',
        'image_path',
        'thumbnail_path',
        'additional_files',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'additional_files' => 'array',
        'ects' => 'integer',
        'credit_hours' => 'float',
        'lecture_hours' => 'integer',
        'lab_hours' => 'integer',
        'tutorial_hours' => 'integer',
        'year' => 'integer',
        'semester' => 'integer',
        'is_active' => 'boolean'
    ];

    public function materials()
    {
        return $this->hasMany(CourseMaterial::class, 'cs_course_id');
    }

    public function getCategoryNameAttribute()
    {
        $categories = [
            'compulsory' => 'Compulsory',
            'elective' => 'Elective',
            'supportive' => 'Supportive',
            'common' => 'Common Course'
        ];
        return $categories[$this->category] ?? $this->category;
    }

    public function getFullDisplayNameAttribute()
    {
        return "{$this->course_code} - {$this->course_title}";
    }

    public function getTotalHoursAttribute()
    {
        return $this->lecture_hours + $this->lab_hours + $this->tutorial_hours;
    }
}