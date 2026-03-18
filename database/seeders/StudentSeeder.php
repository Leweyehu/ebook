<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'student_id' => 'STU001',
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'year' => 1,
            'section' => 'A',
            'batch' => '2024',
            'department' => 'Computer Science',
            'phone' => '1234567890',
            'address' => '123 Main St',
            'is_active' => true
        ]);

        // Create multiple students using factory if you have one
        // Student::factory()->count(50)->create();
    }
}