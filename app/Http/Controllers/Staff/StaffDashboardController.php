<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Staff;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\CourseNotice;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class StaffDashboardController extends Controller
{
    /**
     * Show staff dashboard with personalized course data
     */
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Find staff record by email
        $staff = Staff::where('email', $user->email)->first();
        
        // Initialize collections
        $coursesByYear = [];
        $recentSubmissions = collect([]);
        $recentNotices = collect([]);
        
        // Initialize stats with default values
        $stats = [
            'total_courses' => 0,
            'total_students' => 0,
            'pending_grading' => 0,
            'active_notices' => 0,
        ];
        
        // Current academic year (default)
        $currentAcademicYear = date('Y') . '/' . (date('Y')+1);
        
        // If staff found, load real data
        if ($staff) {
            // Debug: Check if staff has courses in the pivot table
            $pivotCount = DB::table('course_staff')->where('staff_id', $staff->id)->count();
            Log::info("Staff ID {$staff->id} has {$pivotCount} course assignments in pivot table");
            
            // Get courses taught by this staff member with pivot data
            $courses = $staff->courses()
                            ->withPivot('role', 'academic_year')
                            ->withCount('students')
                            ->orderBy('pivot_academic_year', 'desc')
                            ->orderBy('year')
                            ->orderBy('semester')
                            ->get();
            
            // Debug: Log the raw courses data
            Log::info('Raw courses data:', [
                'courses_count' => $courses->count(),
                'courses' => $courses->map(function($course) {
                    return [
                        'id' => $course->id,
                        'code' => $course->course_code,
                        'name' => $course->course_name,
                        'academic_year' => $course->pivot->academic_year ?? 'N/A',
                        'role' => $course->pivot->role ?? 'N/A',
                        'students_count' => $course->students_count ?? 0
                    ];
                })->toArray()
            ]);
            
            // Calculate statistics
            $stats['total_courses'] = $courses->count();
            $stats['total_students'] = $courses->sum('students_count');
            
            // Group courses by academic year
            if ($courses->count() > 0) {
                $coursesByYear = $courses->groupBy('pivot.academic_year');
                
                // Debug: Log grouped courses
                Log::info('Grouped courses by academic year:', [
                    'years' => $coursesByYear->keys()->toArray(),
                    'grouped_data' => $coursesByYear->map(function($yearCourses, $year) {
                        return [
                            'year' => $year,
                            'count' => $yearCourses->count(),
                            'courses' => $yearCourses->pluck('course_code')->toArray()
                        ];
                    })->toArray()
                ]);
            } else {
                Log::warning('No courses found for staff member', ['staff_id' => $staff->id]);
            }
            
            // Get course IDs for this staff
            $courseIds = $courses->pluck('id');
            
            if ($courseIds->isNotEmpty()) {
                // Count pending grading (submissions without scores)
                $stats['pending_grading'] = AssignmentSubmission::whereIn(
                    'assignment_id', 
                    Assignment::whereIn('course_id', $courseIds)->pluck('id')
                )->whereNull('score')->count();
                
                // Count active notices
                $stats['active_notices'] = CourseNotice::whereIn('course_id', $courseIds)
                    ->where('is_active', true)
                    ->count();
                
                // Get recent submissions (pending grading)
                $recentSubmissions = AssignmentSubmission::whereIn(
                    'assignment_id',
                    Assignment::whereIn('course_id', $courseIds)->pluck('id')
                )->whereNull('score')
                  ->with(['student', 'assignment.course'])
                  ->latest()
                  ->take(10)
                  ->get();
                
                // Get recent notices from assigned courses
                $recentNotices = CourseNotice::whereIn('course_id', $courseIds)
                    ->where('is_active', true)
                    ->with('course')
                    ->latest()
                    ->take(5)
                    ->get();
            }
        } else {
            Log::error('Staff record not found for user', ['user_email' => $user->email]);
        }
        
        // Log for debugging
        Log::info('Staff dashboard accessed', [
            'user' => $user->email,
            'staff_found' => $staff ? 'yes' : 'no',
            'staff_id' => $staff->id ?? null,
            'courses_count' => $stats['total_courses'],
            'academic_years' => is_array($coursesByYear) ? array_keys($coursesByYear) : $coursesByYear->keys()->toArray()
        ]);
        
        // Prepare data array
        $data = [
            'staff' => $staff,
            'coursesByYear' => $coursesByYear,
            'currentAcademicYear' => $currentAcademicYear,
            'stats' => $stats,
            'recentSubmissions' => $recentSubmissions,
            'recentNotices' => $recentNotices
        ];
        
        // Return view with data
        return view('staff.dashboard', $data);
    }

    /**
     * Show change password form
     */
    public function showChangePasswordForm()
    {
        return view('staff.profile.change-password');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password changed successfully!');
    }

    /**
     * Show profile edit form
     */
    public function editProfile()
    {
        $user = Auth::user();
        $staff = Staff::where('email', $user->email)->first();
        
        return view('staff.profile.edit', compact('staff'));
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $staff = Staff::where('email', $user->email)->first();
        
        if (!$staff) {
            return redirect()->back()->with('error', 'Staff record not found.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'phone' => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only(['name', 'email', 'phone', 'qualification', 'specialization', 'bio']);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($staff->image && file_exists(public_path($staff->image))) {
                unlink(public_path($staff->image));
            }
            
            $image = $request->file('image');
            $imageName = 'staff_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/staff'), $imageName);
            $data['image'] = 'uploads/staff/' . $imageName;
        }

        $staff->update($data);
        
        // Update user name as well
        $user->update(['name' => $request->name]);

        return redirect()->route('staff.dashboard')->with('success', 'Profile updated successfully!');
    }

    /**
     * Get staff's assigned courses for API
     */
    public function getAssignedCourses()
    {
        $user = Auth::user();
        $staff = Staff::where('email', $user->email)->first();
        
        if (!$staff) {
            return response()->json(['error' => 'Staff not found'], 404);
        }
        
        $courses = $staff->courses()
                        ->withPivot('role', 'academic_year')
                        ->withCount('students')
                        ->get()
                        ->groupBy('pivot.academic_year');
        
        return response()->json($courses);
    }

    /**
     * Get specific course details for staff
     */
    public function getCourseDetails(Course $course)
    {
        $user = Auth::user();
        $staff = Staff::where('email', $user->email)->first();
        
        if (!$staff || !$staff->courses()->where('course_id', $course->id)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $courseData = $course->load(['instructors' => function($q) use ($staff) {
            $q->where('staff_id', $staff->id);
        }])->loadCount('students');
        
        $students = $course->students()
                          ->wherePivot('status', 'enrolled')
                          ->orderBy('name')
                          ->get(['id', 'student_id', 'name', 'email', 'year', 'section']);
        
        return response()->json([
            'course' => $courseData,
            'students' => $students,
            'student_count' => $students->count()
        ]);
    }

    /**
     * Debug method to check course assignments
     */
    public function debugAssignments()
    {
        $user = Auth::user();
        $staff = Staff::where('email', $user->email)->first();
        
        if (!$staff) {
            return response()->json(['error' => 'Staff not found'], 404);
        }
        
        // Check course_staff table directly
        $assignments = DB::table('course_staff')
                        ->where('staff_id', $staff->id)
                        ->get();
        
        // Get courses with details
        $courses = $staff->courses()->get();
        
        return response()->json([
            'staff' => [
                'id' => $staff->id,
                'name' => $staff->name,
                'email' => $staff->email
            ],
            'pivot_assignments' => $assignments,
            'courses' => $courses->map(function($course) {
                return [
                    'id' => $course->id,
                    'code' => $course->course_code,
                    'name' => $course->course_name,
                    'pivot' => $course->pivot
                ];
            })
        ]);
    }
}