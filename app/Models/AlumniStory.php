<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlumniStory extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumni_id',
        'title',
        'story',
        'image',
        'is_featured',
        'is_published',
        'views'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean'
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}