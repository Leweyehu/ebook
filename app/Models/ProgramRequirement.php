<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramRequirement extends Model
{
    use HasFactory;

    protected $table = 'program_requirements';

    protected $fillable = [
        'category_name', 'number_of_courses', 'credit_hours', 'ects', 'order_position'
    ];
}