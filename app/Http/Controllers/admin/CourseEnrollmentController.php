<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseEnrollmentController extends Controller
{
    /**
     * Show form to manage students in a course
     */
    public function manageStudents(Course $course)
    {
        // Get all students
        $allStudents = Student::orderBy('name')->get();
        
        // Get IDs of students already enrolled in this course
        $enrolledStudentIds = $course->students()->pluck('students.id')->toArray();
        
        // Get enrolled students with pivot data
        $enrolledStudents = $course->students()->get();
        
        return view('admin.courses.manage-students', compact('course', 'allStudents', 'enrolledStudentIds', 'enrolledStudents'));
    }

    /**
     * Enroll students in a course
     */
    public function enrollStudents(Request $request, Course $course)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
            'academic_year' => 'required|string|max:20',
        ]);

        $enrolledCount = 0;
        $skippedCount = 0;

        foreach ($request->student_ids as $studentId) {
            // Check if already enrolled
            $exists = $course->students()->where('student_id', $studentId)->exists();
            
            if (!$exists) {
                $course->students()->attach($studentId, [
                    'academic_year' => $request->academic_year,
                    'status' => 'enrolled',
                    'enrollment_date' => now(),
                ]);
                $enrolledCount++;
            } else {
                $skippedCount++;
            }
        }

        $message = "✅ {$enrolledCount} students enrolled successfully.";
        if ($skippedCount > 0) {
            $message .= " {$skippedCount} students were already enrolled.";
        }

        return redirect()->route('admin.courses.manage-students', $course)
            ->with('success', $message);
    }

    /**
     * Remove a student from a course
     */
    public function removeStudent(Course $course, Student $student)
    {
        $course->students()->detach($student->id);

        return redirect()->route('admin.courses.manage-students', $course)
            ->with('success', "✅ Student {$student->name} removed from course successfully.");
    }

    /**
     * Update student enrollment status
     */
    public function updateStatus(Request $request, Course $course, Student $student)
    {
        $request->validate([
            'status' => 'required|in:enrolled,completed,dropped',
        ]);

        $course->students()->updateExistingPivot($student->id, [
            'status' => $request->status
        ]);

        return redirect()->route('admin.courses.manage-students', $course)
            ->with('success', "✅ Student status updated successfully.");
    }

    /**
     * Bulk enroll students from a specific year/section
     */
    public function bulkEnroll(Request $request, Course $course)
    {
        $request->validate([
            'year' => 'required|integer|in:1,2,3,4',
            'section' => 'nullable|string|max:10',
            'academic_year' => 'required|string|max:20',
        ]);

        $query = Student::where('year', $request->year);
        
        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }

        $students = $query->get();
        $enrolledCount = 0;

        foreach ($students as $student) {
            $exists = $course->students()->where('student_id', $student->id)->exists();
            
            if (!$exists) {
                $course->students()->attach($student->id, [
                    'academic_year' => $request->academic_year,
                    'status' => 'enrolled',
                    'enrollment_date' => now(),
                ]);
                $enrolledCount++;
            }
        }

        return redirect()->route('admin.courses.manage-students', $course)
            ->with('success', "✅ {$enrolledCount} students from Year {$request->year} enrolled successfully.");
    }
}