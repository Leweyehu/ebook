<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory;
    
    protected $table = 'staff';
    
    protected $fillable = [
        'staff_id',
        'name',
        'email',
        'position',
        'qualification',  // Added qualification field
        'staff_type',     // Added staff_type field
        'department',
        'phone',
        'profile_image',
        'bio',
        'order',          // Added order field for sorting
        'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];
}