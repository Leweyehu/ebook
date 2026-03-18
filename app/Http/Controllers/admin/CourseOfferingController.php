<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CourseOfferingController extends Controller
{
    /**
     * Show course offering interface
     */
    public function index()
    {
        // Get all courses
        $allCourses = Course::orderBy('year')->orderBy('semester')->orderBy('course_code')->get();
        
        // Get courses grouped by year and semester
        $coursesByYear = [
            1 => [
                'Semester 1' => Course::where('year', 1)->where('semester', 'Semester 1')->orderBy('course_code')->get(),
                'Semester 2' => Course::where('year', 1)->where('semester', 'Semester 2')->orderBy('course_code')->get(),
            ],
            2 => [
                'Semester 1' => Course::where('year', 2)->where('semester', 'Semester 1')->orderBy('course_code')->get(),
                'Semester 2' => Course::where('year', 2)->where('semester', 'Semester 2')->orderBy('course_code')->get(),
            ],
            3 => [
                'Semester 1' => Course::where('year', 3)->where('semester', 'Semester 1')->orderBy('course_code')->get(),
                'Semester 2' => Course::where('year', 3)->where('semester', 'Semester 2')->orderBy('course_code')->get(),
            ],
            4 => [
                'Semester 1' => Course::where('year', 4)->where('semester', 'Semester 1')->orderBy('course_code')->get(),
                'Semester 2' => Course::where('year', 4)->where('semester', 'Semester 2')->orderBy('course_code')->get(),
            ],
        ];

        // Get students grouped by year
        $studentsByYear = [
            1 => Student::where('year', 1)->orderBy('name')->get(),
            2 => Student::where('year', 2)->orderBy('name')->get(),
            3 => Student::where('year', 3)->orderBy('name')->get(),
            4 => Student::where('year', 4)->orderBy('name')->get(),
        ];

        // Get all active staff for instructor assignment
        $staff = Staff::where('is_active', true)->orderBy('name')->get();

        $stats = [
            'total_courses' => Course::count(),
            'total_students' => Student::count(),
            'total_staff' => Staff::count(),
        ];

        return view('admin.courses.offerings', compact('coursesByYear', 'studentsByYear', 'staff', 'stats'));
    }

    /**
     * Offer a course to specific year students
     */
    public function offerCourse(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'target_year' => 'required|integer|in:1,2,3,4',
            'academic_year' => 'required|string|max:20',
            'instructors' => 'required|array|min:1',
            'instructors.*' => 'exists:staff,id',
            'primary_instructor' => 'required|exists:staff,id',
        ]);

        DB::transaction(function () use ($request) {
            $course = Course::findOrFail($request->course_id);

            // 1. Assign instructors
            $instructorData = [];
            foreach ($request->instructors as $instructorId) {
                $role = ($instructorId == $request->primary_instructor) ? 'primary' : 'assistant';
                $instructorData[$instructorId] = [
                    'role' => $role,
                    'academic_year' => $request->academic_year
                ];
            }
            $course->instructors()->sync($instructorData);

            // 2. Enroll all students from the target year
            $students = Student::where('year', $request->target_year)->get();
            $enrolledCount = 0;
            $skippedCount = 0;

            foreach ($students as $student) {
                // Check if already enrolled using explicit table names to avoid ambiguity
                $exists = DB::table('course_student')
                    ->where('course_id', $course->id)
                    ->where('student_id', $student->id)
                    ->exists();
                
                if (!$exists) {
                    DB::table('course_student')->insert([
                        'course_id' => $course->id,
                        'student_id' => $student->id,
                        'academic_year' => $request->academic_year,
                        'status' => 'enrolled',
                        'enrollment_date' => now(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    $enrolledCount++;
                } else {
                    $skippedCount++;
                }
            }

            // Log the offering
            \Log::info("Course {$course->course_code} offered to Year {$request->target_year} students. {$enrolledCount} enrolled, {$skippedCount} already enrolled.");
        });

        $message = "✅ Course offered successfully to Year {$request->target_year} students!";
        
        return redirect()->route('admin.courses.offerings')->with('success', $message);
    }

    /**
     * Offer multiple courses at once
     */
    public function offerMultipleCourses(Request $request)
    {
        $request->validate([
            'course_ids' => 'required|array|min:1',
            'course_ids.*' => 'exists:courses,id',
            'target_year' => 'required|integer|in:1,2,3,4',
            'academic_year' => 'required|string|max:20',
            'instructor_assignments' => 'required|array',
            'primary_instructors' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {
            $students = Student::where('year', $request->target_year)->get();
            $enrolledCount = 0;
            $courseCount = 0;

            foreach ($request->course_ids as $courseId) {
                $course = Course::findOrFail($courseId);
                $courseCount++;

                // Assign instructors for this course
                if (isset($request->instructor_assignments[$courseId])) {
                    $instructorIds = $request->instructor_assignments[$courseId];
                    $primaryInstructorId = $request->primary_instructors[$courseId] ?? null;

                    $instructorData = [];
                    foreach ($instructorIds as $instructorId) {
                        $role = ($instructorId == $primaryInstructorId) ? 'primary' : 'assistant';
                        $instructorData[$instructorId] = [
                            'role' => $role,
                            'academic_year' => $request->academic_year
                        ];
                    }
                    $course->instructors()->sync($instructorData);
                }

                // Enroll students
                foreach ($students as $student) {
                    $exists = DB::table('course_student')
                        ->where('course_id', $course->id)
                        ->where('student_id', $student->id)
                        ->exists();
                    
                    if (!$exists) {
                        DB::table('course_student')->insert([
                            'course_id' => $course->id,
                            'student_id' => $student->id,
                            'academic_year' => $request->academic_year,
                            'status' => 'enrolled',
                            'enrollment_date' => now(),
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                        $enrolledCount++;
                    }
                }
            }
        });

        return redirect()->route('admin.courses.offerings')
            ->with('success', "✅ " . count($request->course_ids) . " courses offered to Year {$request->target_year} students successfully!");
    }

    /**
     * Get courses by year and semester (AJAX)
     */
    public function getCoursesByYearAndSemester(Request $request)
    {
        $year = $request->get('year');
        $semester = $request->get('semester');

        $courses = Course::where('year', $year)
                        ->where('semester', $semester)
                        ->where('is_active', true)
                        ->orderBy('course_code')
                        ->get(['id', 'course_code', 'course_name', 'credit_hours']);

        return response()->json($courses);
    }

    /**
     * Get students by year (AJAX)
     */
    public function getStudentsByYear(Request $request)
    {
        $year = $request->get('year');
        $students = Student::where('year', $year)
                          ->orderBy('name')
                          ->get(['id', 'student_id', 'name', 'email', 'section']);

        return response()->json([
            'year' => $year,
            'total' => $students->count(),
            'students' => $students
        ]);
    }

    /**
     * Get course offering summary
     */
    public function getOfferingSummary()
    {
        $summary = [
            'total_courses' => Course::count(),
            'courses_by_year' => [
                1 => Course::where('year', 1)->count(),
                2 => Course::where('year', 2)->count(),
                3 => Course::where('year', 3)->count(),
                4 => Course::where('year', 4)->count(),
            ],
            'students_by_year' => [
                1 => Student::where('year', 1)->count(),
                2 => Student::where('year', 2)->count(),
                3 => Student::where('year', 3)->count(),
                4 => Student::where('year', 4)->count(),
            ],
            'active_offerings' => DB::table('course_student')
                                   ->where('status', 'enrolled')
                                   ->distinct('course_id')
                                   ->count('course_id')
        ];

        return response()->json($summary);
    }
}