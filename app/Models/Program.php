<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'type', 'icon', 'description', 'career_opportunities',
        'specializations', 'duration_years', 'duration_text', 'mode_of_delivery',
        'teaching_method', 'credit_hours', 'ects', 'semesters', 'order_position', 'is_active'
    ];

    protected $casts = [
        'career_opportunities' => 'array',
        'specializations' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($program) {
            $program->slug = Str::slug($program->title);
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}