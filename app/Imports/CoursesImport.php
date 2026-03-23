<?php

namespace App\Imports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;

class CoursesImport implements ToModel, WithHeadingRow, WithValidation
{
    private $successCount = 0;
    private $failedCount = 0;
    
    public function model(array $row)
    {
        // Check if course already exists
        $existing = Course::where('course_code', $row['course_code'])->first();
        
        if ($existing) {
            $this->failedCount++;
            return null;
        }
        
        $this->successCount++;
        
        return new Course([
            'course_code' => $row['course_code'],
            'course_name' => $row['course_name'],
            'slug' => Str::slug($row['course_code'] . '-' . $row['course_name']),
            'credit_hours' => $row['credit_hours'],
            'year_level' => $row['year_level'],
            'semester' => $row['semester'],
            'description' => $row['description'],
            'instructor' => $row['instructor'] ?? null,
            'capacity' => $row['capacity'] ?? 60,
            'status' => 'active',
            'is_elective' => false,
        ]);
    }
    
    public function rules(): array
    {
        return [
            'course_code' => 'required|unique:courses,course_code',
            'course_name' => 'required',
            'credit_hours' => 'required|integer|min:1|max:6',
            'year_level' => 'required|integer|min:1|max:4',
            'semester' => 'required|in:1,2',
            'description' => 'required',
        ];
    }
    
    public function getSuccessCount()
    {
        return $this->successCount;
    }
    
    public function getFailedCount()
    {
        return $this->failedCount;
    }
}