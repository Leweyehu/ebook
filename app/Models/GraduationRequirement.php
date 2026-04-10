<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GraduationRequirement extends Model
{
    use HasFactory;

    protected $fillable = ['requirement', 'order_position', 'is_active'];
}