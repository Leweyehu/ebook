<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\CourseMaterial;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\CourseNotice;
use App\Models\Grade;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display public student listing with search and batch filter
     */
    public function index(Request $request)
    {
        $batch = $request->get('batch');
        $search = $request->get('search');
        
        // Get students with filters
        $allStudents = Student::where('is_active', true)
            ->when($batch, function($query, $batch) {
                return $query->where('batch', $batch);
            })
            ->when($search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('student_id', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('year')
            ->orderBy('name')
            ->paginate(20);
        
        // Get statistics for the dashboard
        $year1 = Student::where('is_active', true)->where('year', 1)->count();
        $year2 = Student::where('is_active', true)->where('year', 2)->count();
        $year3 = Student::where('is_active', true)->where('year', 3)->count();
        $year4 = Student::where('is_active', true)->where('year', 4)->count();
        $total = Student::where('is_active', true)->count();
        
        $studentsByYear = [
            'Year 1' => $year1,
            'Year 2' => $year2,
            'Year 3' => $year3,
            'Year 4' => $year4,
        ];
        
        // Get unique batches for filter dropdown
        $batches = Student::where('is_active', true)
            ->whereNotNull('batch')
            ->distinct()
            ->pluck('batch')
            ->filter()
            ->sort()
            ->values();
        
        return view('students.index', compact(
            'allStudents', 
            'year1', 'year2', 'year3', 'year4', 'total', 
            'studentsByYear', 'batches', 'batch', 'search'
        ));
    }

    /**
     * Display single student details (public)
     */
    public function show($id)
    {
        $student = Student::where('is_active', true)->findOrFail($id);
        return view('students.show', compact('student'));
    }

    /**
     * Admin: Show student management page
     */
    public function admin(Request $request)
    {
        $batch = $request->get('batch');
        $search = $request->get('search');
        
        $students = Student::when($batch, function($query, $batch) {
                        return $query->where('batch', $batch);
                    })
                    ->when($search, function($query, $search) {
                        return $query->where('name', 'LIKE', "%{$search}%")
                                     ->orWhere('student_id', 'LIKE', "%{$search}%")
                                     ->orWhere('email', 'LIKE', "%{$search}%");
                    })
                    ->orderBy('year')
                    ->orderBy('name')
                    ->paginate(20);
        
        $batches = Student::whereNotNull('batch')
                    ->distinct()
                    ->pluck('batch')
                    ->filter()
                    ->sort()
                    ->values();
        
        $stats = [
            'total' => Student::count(),
            'year1' => Student::where('year', 1)->count(),
            'year2' => Student::where('year', 2)->count(),
            'year3' => Student::where('year', 3)->count(),
            'year4' => Student::where('year', 4)->count(),
        ];
        
        return view('admin.students.index', compact('students', 'stats', 'batches', 'batch', 'search'));
    }

    /**
     * Admin: Bulk upload via Excel
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120' // 5MB max
        ]);

        try {
            $file = $request->file('file');
            
            if (!$file->isValid()) {
                return redirect()->back()->with('error', '❌ File upload failed. Please try again.');
            }
            
            // Read the entire file content and remove BOM
            $content = file_get_contents($file->getPathname());
            
            // Remove UTF-8 BOM if present
            if (substr($content, 0, 3) == "\xEF\xBB\xBF") {
                $content = substr($content, 3);
            }
            
            // Create a temporary file without BOM
            $tempPath = tempnam(sys_get_temp_dir(), 'csv_clean_');
            file_put_contents($tempPath, $content);
            
            // Read first few lines to verify format
            $handle = fopen($tempPath, 'r');
            $rawHeaders = fgetcsv($handle);
            $firstRow = fgetcsv($handle);
            fclose($handle);
            
            // Clean headers
            $headers = [];
            foreach ($rawHeaders as $header) {
                $cleanHeader = preg_replace('/[^\x20-\x7E]/', '', $header);
                $cleanHeader = trim(strtolower($cleanHeader));
                if (!empty($cleanHeader)) {
                    $headers[] = $cleanHeader;
                }
            }
            
            // Define expected headers
            $expectedHeaders = ['student_id', 'name', 'email', 'year', 'section', 'batch'];
            
            // Create mapping
            $headerMap = [];
            foreach ($headers as $index => $header) {
                if (in_array($header, $expectedHeaders)) {
                    $headerMap[$header] = $index;
                } elseif (strpos($header, 'student') !== false && strpos($header, 'id') !== false) {
                    $headerMap['student_id'] = $index;
                } elseif ($header == 'full name' || $header == 'student name' || $header == 'name') {
                    $headerMap['name'] = $index;
                } elseif ($header == 'e-mail' || $header == 'mail' || $header == 'email') {
                    $headerMap['email'] = $index;
                } elseif ($header == 'yr' || $header == 'study year' || $header == 'year') {
                    $headerMap['year'] = $index;
                } elseif ($header == 'sec' || $header == 'class' || $header == 'section') {
                    $headerMap['section'] = $index;
                } elseif ($header == 'bach' || $header == 'bat ch' || $header == 'year of entry' || $header == 'batch') {
                    $headerMap['batch'] = $index;
                }
            }
            
            // Check required headers
            $requiredHeaders = ['student_id', 'name', 'email', 'year'];
            $missingHeaders = [];
            
            foreach ($requiredHeaders as $required) {
                if (!isset($headerMap[$required])) {
                    $missingHeaders[] = $required;
                }
            }
            
            if (!empty($missingHeaders)) {
                return redirect()->back()->with('error', 
                    '❌ CSV missing required headers: ' . implode(', ', $missingHeaders) . 
                    '<br><br>Required headers: student_id, name, email, year<br>' .
                    'Found headers: ' . implode(', ', $headers));
            }
            
            // Create fixed file
            $outputPath = tempnam(sys_get_temp_dir(), 'csv_fixed_');
            $outputHandle = fopen($outputPath, 'w');
            fputcsv($outputHandle, $expectedHeaders);
            
            // Process rows
            $handle = fopen($tempPath, 'r');
            fgetcsv($handle); // Skip original headers
            
            $rowNumber = 1;
            while (($row = fgetcsv($handle)) !== false) {
                $rowNumber++;
                $mappedRow = [];
                foreach ($expectedHeaders as $expected) {
                    if (isset($headerMap[$expected]) && isset($row[$headerMap[$expected]])) {
                        $value = trim($row[$headerMap[$expected]]);
                        // Clean year field
                        if ($expected == 'year') {
                            $value = is_numeric($value) ? intval($value) : 1;
                            $value = max(1, min(4, $value)); // Ensure between 1-4
                        }
                        $mappedRow[] = $value;
                    } else {
                        $mappedRow[] = '';
                    }
                }
                fputcsv($outputHandle, $mappedRow);
            }
            
            fclose($handle);
            fclose($outputHandle);
            
            // Import
            $import = new StudentsImport();
            Excel::import($import, $outputPath);
            
            // Clean up
            if (file_exists($tempPath)) unlink($tempPath);
            if (file_exists($outputPath)) unlink($outputPath);
            
            $successful = $import->getSuccessfulCount();
            $failed = $import->getFailedCount();
            $importDebug = $import->getDebug();
            
            if ($successful > 0) {
                $message = "✅ Import completed!<br>";
                $message .= "📊 Successfully imported: {$successful} students<br>";
                if ($failed > 0) {
                    $message .= "⚠️ Skipped: {$failed} rows (duplicates or invalid data)<br>";
                }
                return redirect()->route('admin.students.index')->with('success', $message);
            } else {
                $errorMsg = "❌ No students were imported.<br><br>";
                foreach ($importDebug as $item) {
                    $errorMsg .= "• {$item}<br>";
                }
                return redirect()->back()->with('error', $errorMsg);
            }
            
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
            }
            if (isset($tempPath) && file_exists($tempPath)) unlink($tempPath);
            if (isset($outputPath) && file_exists($outputPath)) unlink($outputPath);
            
            return redirect()->back()->with('error', '❌ Validation failed:<br>' . implode('<br>', array_slice($errorMessages, 0, 20)));
            
        } catch (\Exception $e) {
            if (isset($tempPath) && file_exists($tempPath)) unlink($tempPath);
            if (isset($outputPath) && file_exists($outputPath)) unlink($outputPath);
            return redirect()->back()->with('error', '❌ Error uploading file: ' . $e->getMessage());
        }
    }

    /**
     * Admin: Delete student
     */
    public function destroy(Student $student)
    {
        try {
            $studentName = $student->name;
            $studentId = $student->student_id;
            $student->delete();
            
            return redirect()->route('admin.students.index')
                ->with('success', "✅ Student '{$studentName}' ({$studentId}) deleted successfully!");
                
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ Error deleting student: ' . $e->getMessage());
        }
    }

    /**
     * Admin: Download sample Excel template
     */
    public function downloadTemplate()
    {
        $headers = ['student_id', 'name', 'email', 'year', 'section', 'batch'];
        
        $filename = "student_upload_template.csv";
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        $handle = fopen('php://output', 'w');
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($handle, $headers);
        fputcsv($handle, ['STU2025001', 'Abel Shewangizaw', 'abel@mkau.edu.et', '1', 'A', '2025']);
        fputcsv($handle, ['STU2025002', 'Abyu Eshetie', 'abyu@mkau.edu.et', '1', 'A', '2025']);
        fputcsv($handle, ['STU2025003', 'Akililu Ayka', 'akililu@mkau.edu.et', '1', 'A', '2025']);
        
        fclose($handle);
        exit;
    }

    /**
     * Staff: View students (read-only)
     */
    public function staffIndex(Request $request)
    {
        $batch = $request->get('batch');
        $search = $request->get('search');
        
        $students = Student::where('is_active', true)
                    ->when($batch, function($query, $batch) {
                        return $query->where('batch', $batch);
                    })
                    ->when($search, function($query, $search) {
                        return $query->where('name', 'LIKE', "%{$search}%")
                                     ->orWhere('student_id', 'LIKE', "%{$search}%");
                    })
                    ->orderBy('year')
                    ->orderBy('name')
                    ->paginate(15);
        
        $batches = Student::where('is_active', true)
                    ->whereNotNull('batch')
                    ->distinct()
                    ->pluck('batch')
                    ->filter()
                    ->sort()
                    ->values();
        
        $stats = [
            'total' => Student::where('is_active', true)->count(),
            'year1' => Student::where('is_active', true)->where('year', 1)->count(),
            'year2' => Student::where('is_active', true)->where('year', 2)->count(),
            'year3' => Student::where('is_active', true)->where('year', 3)->count(),
            'year4' => Student::where('is_active', true)->where('year', 4)->count(),
        ];
        
        return view('staff.students.index', compact('students', 'stats', 'batches', 'batch', 'search'));
    }
    
    /**
     * Staff: View single student
     */
    public function staffShow(Student $student)
    {
        return view('staff.students.show', compact('student'));
    }

    /**
     * ===========================================================
     * STUDENT DASHBOARD METHODS (For logged-in students)
     * ===========================================================
     */

    /**
     * Get the authenticated student
     */
    private function getAuthenticatedStudent()
    {
        $user = Auth::user();
        
        if (!$user) {
            abort(403, 'Unauthorized access.');
        }
        
        $student = Student::where('email', $user->email)->first();
        
        if (!$student) {
            abort(404, 'Student record not found.');
        }
        
        return $student;
    }

    /**
     * Student Dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        $student = Student::where('email', $user->email)->first();
        
        if (!$student) {
            $student = (object) [
                'student_id' => 'N/A',
                'name' => $user->name,
                'email' => $user->email,
                'year' => 1,
                'section' => 'A',
            ];
        }
        
        $courses = collect([]);
        if ($student && isset($student->courses)) {
            $courses = $student->courses;
        }
        
        $stats = [
            'total_courses' => $courses->count(),
            'pending_assignments' => 0,
            'average_grade' => 0,
            'total_notices' => 0,
        ];
        
        $recentAssignments = collect([]);
        $recentNotices = collect([]);
        $grades = collect([]);
        
        return view('student.dashboard', compact('user', 'student', 'courses', 'recentAssignments', 'recentNotices', 'grades', 'stats'));
    }

    /**
     * Student Profile
     */
    public function profile()
    {
        $student = $this->getAuthenticatedStudent();
        return view('student.profile', compact('student'));
    }

    /**
     * Update Student Profile
     */
    public function updateProfile(Request $request)
    {
        $student = $this->getAuthenticatedStudent();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'address']);

        if ($request->hasFile('profile_image')) {
            if ($student->profile_image && file_exists(public_path($student->profile_image))) {
                unlink(public_path($student->profile_image));
            }
            
            $image = $request->file('profile_image');
            $imageName = 'student_' . $student->student_id . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/students'), $imageName);
            $data['profile_image'] = 'uploads/students/' . $imageName;
        }

        $student->update($data);
        Auth::user()->update(['email' => $request->email, 'name' => $request->name]);

        return redirect()->route('student.profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Student Courses
     */
    public function courses()
    {
        $student = $this->getAuthenticatedStudent();
        $courses = $student->courses()->withCount(['materials', 'assignments'])->get();
        
        return view('student.courses.index', compact('student', 'courses'));
    }

    /**
     * Course Details
     */
    public function courseDetail(Course $course)
    {
        $student = $this->getAuthenticatedStudent();
        
        if (!$student->courses()->where('course_id', $course->id)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }
        
        $materials = $course->materials()->latest()->get();
        $assignments = $course->assignments()->where('is_active', true)->get();
        $notices = $course->notices()->active()->latest()->get();
        
        return view('student.courses.show', compact('course', 'materials', 'assignments', 'notices'));
    }

    /**
     * Student Grades
     */
    public function grades()
    {
        $student = $this->getAuthenticatedStudent();
        
        $grades = Grade::where('student_id', $student->id)
            ->with(['course', 'assignment'])
            ->get()
            ->groupBy('course_id');
        
        $courseAverages = [];
        foreach ($grades as $courseId => $courseGrades) {
            $courseAverages[$courseId] = [
                'average' => $courseGrades->avg('percentage'),
                'total' => $courseGrades->sum('score'),
                'count' => $courseGrades->count(),
                'course' => $courseGrades->first()->course,
            ];
        }
        
        return view('student.grades', compact('student', 'grades', 'courseAverages'));
    }

    /**
     * Course Materials
     */
    public function materials(Course $course)
    {
        $student = $this->getAuthenticatedStudent();
        
        if (!$student->courses()->where('course_id', $course->id)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }
        
        $materials = $course->materials()->latest()->paginate(20);
        
        return view('student.materials.index', compact('course', 'materials'));
    }

    /**
     * Download Course Material
     */
    public function downloadMaterial(CourseMaterial $material)
    {
        $student = $this->getAuthenticatedStudent();
        
        if (!$student->courses()->where('course_id', $material->course_id)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }
        
        $material->incrementDownloadCount();
        
        return Storage::disk('public')->download($material->file_path, $material->file_name);
    }

    /**
     * Student Assignments List
     */
    public function assignments(Course $course)
    {
        $student = $this->getAuthenticatedStudent();
        
        if (!$student->courses()->where('course_id', $course->id)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }
        
        $assignments = $course->assignments()
            ->where('is_active', true)
            ->with(['submissions' => function($query) use ($student) {
                $query->where('student_id', $student->id);
            }])
            ->orderBy('due_date')
            ->paginate(20);
        
        return view('student.assignments.index', compact('course', 'assignments'));
    }

    /**
     * Assignment Detail
     */
    public function assignmentDetail(Assignment $assignment)
    {
        $student = $this->getAuthenticatedStudent();
        
        if (!$student->courses()->where('course_id', $assignment->course_id)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }
        
        $submission = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('student_id', $student->id)
            ->first();
        
        return view('student.assignments.show', compact('assignment', 'submission'));
    }

    /**
     * Submit Assignment
     */
    public function submitAssignment(Request $request, Assignment $assignment)
    {
        $student = $this->getAuthenticatedStudent();
        
        if (!$student->courses()->where('course_id', $assignment->course_id)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }
        
        $existingSubmission = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('student_id', $student->id)
            ->first();
            
        if ($existingSubmission) {
            return redirect()->back()->with('error', 'You have already submitted this assignment.');
        }
        
        $request->validate([
            'file' => 'required|file|max:10240',
            'comments' => 'nullable|string|max:1000',
        ]);

        $file = $request->file('file');
        $fileName = $student->student_id . '_' . time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('submissions/' . $assignment->id, $fileName, 'public');

        AssignmentSubmission::create([
            'assignment_id' => $assignment->id,
            'student_id' => $student->id,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'comments' => $request->comments,
            'submitted_at' => now(),
            'is_late' => now()->gt($assignment->due_date),
        ]);

        return redirect()->route('student.assignments.show', $assignment)
            ->with('success', 'Assignment submitted successfully!');
    }

    /**
     * Student Notices
     */
    public function notices()
    {
        $student = $this->getAuthenticatedStudent();
        
        $courses = $student->courses()->pluck('id');
        
        $notices = CourseNotice::whereIn('course_id', $courses)
            ->active()
            ->with('course')
            ->latest()
            ->paginate(20);
        
        return view('student.notices.index', compact('notices'));
    }

    /**
     * Change Password Form
     */
    public function showChangePasswordForm()
    {
        return view('student.profile.change-password');
    }
    
    /**
     * All Assignments for Student
     */
    public function allAssignments()
    {
        $student = $this->getAuthenticatedStudent();
        $courseIds = $student->courses()->pluck('courses.id');
        
        $assignments = Assignment::whereIn('course_id', $courseIds)
            ->where('is_active', true)
            ->with('course')
            ->with(['submissions' => function($query) use ($student) {
                $query->where('student_id', $student->id);
            }])
            ->orderBy('due_date')
            ->paginate(20);
        
        return view('student.assignments.all', compact('student', 'assignments'));
    }

    /**
     * Update Password
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
}