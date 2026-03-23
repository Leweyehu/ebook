<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';
    
    protected $fillable = [
    'student_id',
    'name',
    'email',
    'graduation_year',
    'degree',
    'employment_status',
    'employment_type',
    'employment_start_month',
    'employment_start_year',
    'employment_end_month',
    'employment_end_year',
    'current_job_title',
    'current_company',
    'industry_sector',
    'work_mode',
    'location',
    'salary_range',
    'professional_certifications',
    'linkedin_url',
    'github_url',
    'website_url',
    'bio',
    'achievements',
    'profile_image',
    'show_in_directory',
    'is_verified',
    'status'
];

    protected $casts = [
        'show_in_directory' => 'boolean',
        'is_verified' => 'boolean',
        'graduation_year' => 'integer'
    ];

    public function jobs()
    {
        return $this->hasMany(AlumniJob::class);
    }

    public function stories()
    {
        return $this->hasMany(AlumniStory::class);
    }

    public function getProfileImageUrlAttribute()
    {
        return $this->profile_image 
            ? asset($this->profile_image) 
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=ffc107&color=003E72';
    }

    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        return substr($initials, 0, 2);
    }
}