<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@mau.edu.et',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create Staff
        User::create([
            'name' => 'Staff Member',
            'email' => 'staff@mau.edu.et',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
            'department' => 'Computer Science',
            'is_active' => true,
        ]);

        // Create Student
        User::create([
            'name' => 'Student User',
            'email' => 'student@mau.edu.et',
            'password' => Hash::make('student123'),
            'role' => 'student',
            'student_id' => 'CS2023001',
            'department' => 'Computer Science',
            'is_active' => true,
        ]);
    }
}