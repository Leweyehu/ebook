<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseManagementController extends Controller
{
    /**
     * Display course management dashboard
     */
    public function index()
    {
        $courses = Course::with(['instructors', 'creator'])
                        ->orderBy('year')
                        ->orderBy('semester')
                        ->orderBy('course_code')
                        ->paginate(15);
        
        $stats = [
            'total' => Course::count(),
            'active' => Course::where('status', 'active')->count(),
            'by_year' => [
                'year1' => Course::where('year', 1)->count(),
                'year2' => Course::where('year', 2)->count(),
                'year3' => Course::where('year', 3)->count(),
                'year4' => Course::where('year', 4)->count(),
            ]
        ];
        
        return view('admin.courses.index', compact('courses', 'stats'));
    }

    /**
     * Show form to create a new course
     */
    public function create()
    {
        return view('admin.courses.create');
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
            'status' => 'required|in:active,inactive',
        ]);

        $validated['created_by'] = Auth::id();

        $course = Course::create($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', "✅ Course '{$course->course_name}' created successfully!");
    }

    /**
     * Show course assignment interface
     */
    public function assignForm(Course $course)
    {
        // Get all active staff
        $staff = Staff::where('is_active', true)->orderBy('name')->get();
        
        // Get students grouped by year
        $studentsByYear = [
            1 => Student::where('year', 1)->orderBy('name')->get(),
            2 => Student::where('year', 2)->orderBy('name')->get(),
            3 => Student::where('year', 3)->orderBy('name')->get(),
            4 => Student::where('year', 4)->orderBy('name')->get(),
        ];
        
        // Get currently assigned staff
        $assignedStaff = $course->instructors->pluck('id')->toArray();
        
        // Get currently enrolled students
        $enrolledStudents = $course->students->pluck('id')->toArray();
        
        return view('admin.courses.assign', compact('course', 'staff', 'studentsByYear', 'assignedStaff', 'enrolledStudents'));
    }

    /**
     * Assign instructors and students to course
     */
    public function assign(Request $request, Course $course)
    {
        $request->validate([
            'instructors' => 'required|array|min:1',
            'instructors.*' => 'exists:staff,id',
            'primary_instructor' => 'required|exists:staff,id',
            'student_years' => 'required|array|min:1',
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
            $studentIds = [];
            foreach ($request->student_years as $year) {
                $students = Student::where('year', $year)->get();
                foreach ($students as $student) {
                    // Check if already enrolled
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
        });

        return redirect()->route('admin.courses.index')
            ->with('success', "✅ Course '{$course->course_name}' assigned successfully!");
    }

    /**
     * Show form to manage course students
     */
    public function manageStudents(Course $course)
    {
        $students = Student::orderBy('year')->orderBy('name')->paginate(20);
        $enrolledStudents = $course->students()->pluck('students.id')->toArray();
        
        return view('admin.courses.manage-students', compact('course', 'students', 'enrolledStudents'));
    }

    /**
     * Enroll students in course
     */
    public function enrollStudents(Request $request, Course $course)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
            'academic_year' => 'required|string|max:20',
        ]);

        $enrolledCount = 0;
        foreach ($request->student_ids as $studentId) {
            if (!$course->students()->where('student_id', $studentId)->exists()) {
                $course->students()->attach($studentId, [
                    'academic_year' => $request->academic_year,
                    'status' => 'enrolled',
                    'enrollment_date' => now()
                ]);
                $enrolledCount++;
            }
        }

        return redirect()->route('admin.courses.manage-students', $course)
            ->with('success', "✅ {$enrolledCount} students enrolled successfully!");
    }

    /**
     * Remove student from course
     */
    public function removeStudent(Course $course, Student $student)
    {
        $course->students()->detach($student->id);

        return redirect()->route('admin.courses.manage-students', $course)
            ->with('success', "✅ Student removed from course successfully!");
    }

    /**
     * Show edit form for course
     */
    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update course
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
            'status' => 'required|in:active,inactive',
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', "✅ Course '{$course->course_name}' updated successfully!");
    }

    /**
     * Delete course
     */
    public function destroy(Course $course)
    {
        $courseName = $course->course_name;
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', "✅ Course '{$courseName}' deleted successfully!");
    }

    /**
     * Get students by year (AJAX endpoint)
     */
    public function getStudentsByYear(Request $request)
    {
        $year = $request->get('year');
        $students = Student::where('year', $year)->orderBy('name')->get();
        
        return response()->json($students);
    }
}