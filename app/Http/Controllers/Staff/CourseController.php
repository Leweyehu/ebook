<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Student;
use App\Models\Staff;
use App\Models\CourseMaterial;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\CourseNotice;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    /**
     * Display list of courses taught by staff (grouped by academic year)
     */
    public function index()
    {
        $user = Auth::user();
        
        // Find staff record by email
        $staff = Staff::where('email', $user->email)->first();
        
        if (!$staff) {
            return redirect()->route('staff.dashboard')
                ->with('error', 'Staff record not found. Please contact administrator.');
        }
        
        // Get courses taught by this staff member with pivot data and student counts
        $courses = $staff->courses()
                        ->withPivot('role', 'academic_year')
                        ->withCount('students')
                        ->orderBy('pivot_academic_year', 'desc')
                        ->orderBy('year')
                        ->orderBy('semester')
                        ->get()
                        ->groupBy('pivot.academic_year');
        
        return view('staff.courses.index', compact('courses'));
    }

    /**
     * Show single course details with ONLY enrolled students
     */
    public function show(Course $course)
    {
        $user = Auth::user();
        $staff = Staff::where('email', $user->email)->first();
        
        // Check if staff is authorized to view this course
        if (!$staff || !$staff->courses()->where('course_id', $course->id)->exists()) {
            abort(403, 'You are not authorized to view this course.');
        }
        
        // Get the pivot data for this staff and course
        $pivot = $staff->courses()
                      ->where('course_id', $course->id)
                      ->first()
                      ->pivot;
        
        // Get ONLY enrolled students (status = 'enrolled') for this specific course
        $students = $course->students()
                          ->wherePivot('status', 'enrolled')
                          ->orderBy('year')
                          ->orderBy('name')
                          ->get();
        
        // Get course materials
        $materials = $course->materials()->latest()->get();
        
        // Get assignments for this course
        $assignments = $course->assignments()
                             ->withCount('submissions')
                             ->latest()
                             ->get();
        
        // Get notices for this course
        $notices = $course->notices()
                         ->where('is_active', true)
                         ->latest()
                         ->get();
        
        // Get student statistics for this course
        $studentStats = [
            'total' => $students->count(),
            'by_year' => [
                'year1' => $course->students()->wherePivot('status', 'enrolled')->where('year', 1)->count(),
                'year2' => $course->students()->wherePivot('status', 'enrolled')->where('year', 2)->count(),
                'year3' => $course->students()->wherePivot('status', 'enrolled')->where('year', 3)->count(),
                'year4' => $course->students()->wherePivot('status', 'enrolled')->where('year', 4)->count(),
            ]
        ];
        
        // Get statistics for this course
        $stats = [
            'total_students' => $students->count(),
            'total_materials' => $materials->count(),
            'total_assignments' => $assignments->count(),
            'total_notices' => $notices->count(),
            'pending_grading' => AssignmentSubmission::whereIn(
                'assignment_id',
                $course->assignments()->pluck('id')
            )->whereNull('score')->count(),
            'academic_year' => $pivot->academic_year ?? date('Y') . '/' . (date('Y')+1),
            'role' => $pivot->role ?? 'assistant',
        ];
        
        return view('staff.courses.show', compact(
            'course', 
            'students', 
            'materials', 
            'assignments', 
            'notices', 
            'stats',
            'studentStats'
        ));
    }

    /**
     * Show enrolled students in course (ONLY enrolled students)
     */
    public function students(Course $course)
    {
        $user = Auth::user();
        $staff = Staff::where('email', $user->email)->first();
        
        // Check if staff is authorized to view this course
        if (!$staff || !$staff->courses()->where('course_id', $course->id)->exists()) {
            abort(403, 'You are not authorized to view students in this course.');
        }
        
        // Get ONLY enrolled students with pagination
        $students = $course->students()
                          ->wherePivot('status', 'enrolled')
                          ->orderBy('year')
                          ->orderBy('name')
                          ->paginate(20);
        
        // Get student statistics for this course
        $stats = [
            'total' => $course->students()->wherePivot('status', 'enrolled')->count(),
            'by_year' => [
                'year1' => $course->students()->wherePivot('status', 'enrolled')->where('year', 1)->count(),
                'year2' => $course->students()->wherePivot('status', 'enrolled')->where('year', 2)->count(),
                'year3' => $course->students()->wherePivot('status', 'enrolled')->where('year', 3)->count(),
                'year4' => $course->students()->wherePivot('status', 'enrolled')->where('year', 4)->count(),
            ]
        ];
        
        return view('staff.courses.students', compact('course', 'students', 'stats'));
    }

    /**
     * Get course statistics (can be used for AJAX)
     */
    public function statistics(Course $course)
    {
        $user = Auth::user();
        $staff = Staff::where('email', $user->email)->first();
        
        if (!$staff || !$staff->courses()->where('course_id', $course->id)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $stats = [
            'students_count' => $course->students()->wherePivot('status', 'enrolled')->count(),
            'materials_count' => $course->materials()->count(),
            'assignments_count' => $course->assignments()->count(),
            'notices_count' => $course->notices()->where('is_active', true)->count(),
            'pending_grading' => AssignmentSubmission::whereIn(
                'assignment_id',
                $course->assignments()->pluck('id')
            )->whereNull('score')->count(),
        ];
        
        return response()->json($stats);
    }

    /**
     * Search enrolled students in course
     */
    public function searchStudents(Request $request, Course $course)
    {
        $user = Auth::user();
        $staff = Staff::where('email', $user->email)->first();
        
        if (!$staff || !$staff->courses()->where('course_id', $course->id)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $search = $request->get('q');
        
        $students = $course->students()
            ->wherePivot('status', 'enrolled')
            ->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('student_id', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->take(20)
            ->get();
        
        return response()->json($students);
    }

    /**
     * Get student list for a specific course (API endpoint)
     */
    public function getStudents(Course $course)
    {
        $user = Auth::user();
        $staff = Staff::where('email', $user->email)->first();
        
        if (!$staff || !$staff->courses()->where('course_id', $course->id)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $students = $course->students()
                          ->wherePivot('status', 'enrolled')
                          ->orderBy('name')
                          ->get(['id', 'student_id', 'name', 'email', 'year', 'section']);
        
        return response()->json([
            'total' => $students->count(),
            'students' => $students
        ]);
    }

    /**
     * Get students by year for this course
     */
    public function getStudentsByYear(Course $course, $year)
    {
        $user = Auth::user();
        $staff = Staff::where('email', $user->email)->first();
        
        if (!$staff || !$staff->courses()->where('course_id', $course->id)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $students = $course->students()
                          ->wherePivot('status', 'enrolled')
                          ->where('year', $year)
                          ->orderBy('name')
                          ->get(['id', 'student_id', 'name', 'email', 'section']);
        
        return response()->json([
            'year' => $year,
            'total' => $students->count(),
            'students' => $students
        ]);
    }
}