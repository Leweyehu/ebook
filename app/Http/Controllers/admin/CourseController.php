<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of courses
     */
    public function index()
    {
        // Get courses with instructors and student counts
        $courses = Course::with(['instructors'])
                        ->withCount('students')
                        ->orderBy('year')
                        ->orderBy('semester')
                        ->orderBy('course_code')
                        ->paginate(15);
        
        // Calculate stats using is_active
        $totalCourses = Course::count();
        $activeCourses = Course::where('is_active', true)->count();
        $inactiveCourses = Course::where('is_active', false)->count();
        
        // Calculate courses by year
        $byYear = [
            'year1' => Course::where('year', 1)->count(),
            'year2' => Course::where('year', 2)->count(),
            'year3' => Course::where('year', 3)->count(),
            'year4' => Course::where('year', 4)->count(),
        ];
        
        $stats = [
            'total' => $totalCourses,
            'active' => $activeCourses,
            'inactive' => $inactiveCourses,
            'by_year' => $byYear,
        ];
        
        return view('admin.courses.index', compact('courses', 'stats'));
    }

    /**
     * Show form to create a new course
     */
    public function create()
    {
        $staff = Staff::where('is_active', true)->orderBy('name')->get();
        return view('admin.courses.create', compact('staff'));
    }

    /**
     * Store a newly created course
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_code' => 'required|string|max:20|unique:courses',
            'course_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credit_hours' => 'required|integer|min:1|max:10',
            'ects' => 'nullable|integer|min:1|max:30',
            'semester' => 'required|string|max:50',
            'year' => 'required|integer|in:1,2,3,4',
            'is_active' => 'sometimes|boolean',
            'instructors' => 'required|array|min:1',
            'instructors.*' => 'exists:staff,id',
            'primary_instructor' => 'required|exists:staff,id'
        ]);

        // Create the course
        $course = Course::create([
            'course_code' => $validated['course_code'],
            'course_name' => $validated['course_name'],
            'description' => $validated['description'] ?? null,
            'credit_hours' => $validated['credit_hours'],
            'ects' => $validated['ects'] ?? null,
            'semester' => $validated['semester'],
            'year' => $validated['year'],
            'is_active' => $request->has('is_active') ? true : true,
            'created_by' => Auth::id()
        ]);

        // Attach instructors with roles
        $instructorData = [];
        foreach ($validated['instructors'] as $instructorId) {
            $role = ($instructorId == $validated['primary_instructor']) ? 'primary' : 'assistant';
            $instructorData[$instructorId] = ['role' => $role];
        }
        
        $course->instructors()->attach($instructorData);

        return redirect()->route('admin.courses.index')
            ->with('success', "✅ Course '{$course->course_name}' created successfully!");
    }

    /**
     * Display the specified course
     */
    public function show(Course $course)
    {
        $course->load(['instructors', 'students']);
        
        // Get statistics for this course
        $stats = [
            'total_students' => $course->students()->count(),
            'total_instructors' => $course->instructors()->count(),
            'enrollment_rate' => $course->students()->count() > 0 ? 100 : 0,
        ];
        
        return view('admin.courses.show', compact('course', 'stats'));
    }

    /**
     * Show form to edit a course
     */
    public function edit(Course $course)
    {
        $staff = Staff::where('is_active', true)->orderBy('name')->get();
        $assignedInstructors = $course->instructors->pluck('id')->toArray();
        $primaryInstructor = $course->instructors()
            ->wherePivot('role', 'primary')
            ->first();
        
        return view('admin.courses.edit', compact('course', 'staff', 'assignedInstructors', 'primaryInstructor'));
    }

    /**
     * Update the specified course
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'course_code' => 'required|string|max:20|unique:courses,course_code,' . $course->id,
            'course_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credit_hours' => 'required|integer|min:1|max:10',
            'ects' => 'nullable|integer|min:1|max:30',
            'semester' => 'required|string|max:50',
            'year' => 'required|integer|in:1,2,3,4',
            'is_active' => 'sometimes|boolean',
            'instructors' => 'required|array|min:1',
            'instructors.*' => 'exists:staff,id',
            'primary_instructor' => 'required|exists:staff,id'
        ]);

        // Update course details
        $course->update([
            'course_code' => $validated['course_code'],
            'course_name' => $validated['course_name'],
            'description' => $validated['description'],
            'credit_hours' => $validated['credit_hours'],
            'ects' => $validated['ects'],
            'semester' => $validated['semester'],
            'year' => $validated['year'],
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        // Sync instructors with roles
        $instructorData = [];
        foreach ($validated['instructors'] as $instructorId) {
            $role = ($instructorId == $validated['primary_instructor']) ? 'primary' : 'assistant';
            $instructorData[$instructorId] = ['role' => $role];
        }
        
        $course->instructors()->sync($instructorData);

        return redirect()->route('admin.courses.index')
            ->with('success', "✅ Course '{$course->course_name}' updated successfully!");
    }

    /**
     * Remove the specified course
     */
    public function destroy(Course $course)
    {
        $courseName = $course->course_name;
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', "✅ Course '{$courseName}' deleted successfully!");
    }

    /**
     * Toggle course active status
     */
    public function toggleStatus(Course $course)
    {
        $course->update([
            'is_active' => !$course->is_active
        ]);

        $status = $course->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.courses.index')
            ->with('success', "✅ Course '{$course->course_name}' {$status} successfully!");
    }

    /**
     * Show form to assign instructors and students to course
     */
    public function assignForm(Course $course)
    {
        $staff = Staff::where('is_active', true)->orderBy('name')->get();
        $assignedInstructors = $course->instructors->pluck('id')->toArray();
        
        // Get students by year
        $studentsByYear = [
            1 => Student::where('year', 1)->orderBy('name')->get(),
            2 => Student::where('year', 2)->orderBy('name')->get(),
            3 => Student::where('year', 3)->orderBy('name')->get(),
            4 => Student::where('year', 4)->orderBy('name')->get(),
        ];
        
        $enrolledStudents = $course->students()->pluck('students.id')->toArray();
        
        return view('admin.courses.assign', compact('course', 'staff', 'assignedInstructors', 'studentsByYear', 'enrolledStudents'));
    }

    /**
     * Update instructor and student assignments
     */
    public function assign(Request $request, Course $course)
    {
        $request->validate([
            'instructors' => 'required|array|min:1',
            'instructors.*' => 'exists:staff,id',
            'primary_instructor' => 'required|exists:staff,id',
            'student_years' => 'nullable|array',
            'student_years.*' => 'in:1,2,3,4',
            'academic_year' => 'required|string|max:20',
        ]);

        DB::transaction(function () use ($request, $course) {
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

            // 2. Enroll students from selected years
            if ($request->has('student_years')) {
                $studentIds = [];
                foreach ($request->student_years as $year) {
                    $students = Student::where('year', $year)->get();
                    foreach ($students as $student) {
                        if (!$course->students()->where('student_id', $student->id)->exists()) {
                            $studentIds[$student->id] = [
                                'academic_year' => $request->academic_year,
                                'status' => 'enrolled',
                                'enrollment_date' => now()
                            ];
                        }
                    }
                }
                
                if (!empty($studentIds)) {
                    $course->students()->syncWithoutDetaching($studentIds);
                }
            }
        });

        return redirect()->route('admin.courses.index')
            ->with('success', "✅ Course '{$course->course_name}' assigned successfully!");
    }

    /**
     * Show form to assign instructors (legacy method - kept for backward compatibility)
     */
    public function assignInstructors(Course $course)
    {
        $staff = Staff::where('is_active', true)->orderBy('name')->get();
        $assignedInstructors = $course->instructors->pluck('id')->toArray();
        
        return view('admin.courses.assign-instructors', compact('course', 'staff', 'assignedInstructors'));
    }

    /**
     * Update instructor assignments (legacy method - kept for backward compatibility)
     */
    public function updateInstructors(Request $request, Course $course)
    {
        $request->validate([
            'instructors' => 'required|array|min:1',
            'instructors.*' => 'exists:staff,id',
            'primary_instructor' => 'required|exists:staff,id'
        ]);

        $instructorData = [];
        foreach ($request->instructors as $instructorId) {
            $role = ($instructorId == $request->primary_instructor) ? 'primary' : 'assistant';
            $instructorData[$instructorId] = ['role' => $role];
        }
        
        $course->instructors()->sync($instructorData);

        return redirect()->route('admin.courses.show', $course)
            ->with('success', "✅ Instructors assigned successfully!");
    }

    /**
     * Get courses by year (API endpoint)
     */
    public function getByYear($year)
    {
        $courses = Course::where('year', $year)
                        ->where('is_active', true)
                        ->orderBy('course_code')
                        ->get(['id', 'course_code', 'course_name', 'credit_hours']);
        
        return response()->json($courses);
    }

    /**
     * Get student enrollment statistics
     */
    public function enrollmentStats(Course $course)
    {
        $stats = [
            'total' => $course->students()->count(),
            'by_year' => [
                'year1' => $course->students()->where('year', 1)->count(),
                'year2' => $course->students()->where('year', 2)->count(),
                'year3' => $course->students()->where('year', 3)->count(),
                'year4' => $course->students()->where('year', 4)->count(),
            ],
            'by_status' => [
                'enrolled' => $course->students()->wherePivot('status', 'enrolled')->count(),
                'completed' => $course->students()->wherePivot('status', 'completed')->count(),
                'dropped' => $course->students()->wherePivot('status', 'dropped')->count(),
            ]
        ];
        
        return response()->json($stats);
    }
}