<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlumniJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumni_id',
        'title',
        'company',
        'location',
        'job_type',
        'description',
        'requirements',
        'benefits',
        'contact_email',
        'application_link',
        'deadline',
        'is_active',
        'views'
    ];

    protected $casts = [
        'deadline' => 'date',
        'is_active' => 'boolean'
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('deadline', '>=', now());
    }

    public function incrementViews()
    {
        $this->increment('views');
    }
}