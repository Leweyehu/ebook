<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionRequirement extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'order_position', 'is_active'];
}