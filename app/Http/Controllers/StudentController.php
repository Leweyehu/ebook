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
     * Display public student statistics
     */
    public function index()
    {
        $year1 = Student::where('year', 1)->count();
        $year2 = Student::where('year', 2)->count();
        $year3 = Student::where('year', 3)->count();
        $year4 = Student::where('year', 4)->count();
        $total = Student::count();
        
        $studentsByYear = [
            'Year 1' => $year1,
            'Year 2' => $year2,
            'Year 3' => $year3,
            'Year 4' => $year4,
        ];
        
        // Get ALL students with pagination
        $allStudents = Student::orderBy('year')->orderBy('name')->paginate(20);
        
        return view('students.index', compact('year1', 'year2', 'year3', 'year4', 'total', 'studentsByYear', 'allStudents'));
    }

    /**
     * Admin: Show student management page
     */
    public function admin()
    {
        $students = Student::orderBy('year')->orderBy('name')->get();
        $stats = [
            'total' => Student::count(),
            'year1' => Student::where('year', 1)->count(),
            'year2' => Student::where('year', 2)->count(),
            'year3' => Student::where('year', 3)->count(),
            'year4' => Student::where('year', 4)->count(),
        ];
        
        return view('admin.students.index', compact('students', 'stats'));
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
            // Get file and verify it's readable
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
            
            // Clean headers - remove any remaining BOM or invisible characters
            $headers = [];
            foreach ($rawHeaders as $header) {
                // Remove any non-printable characters and trim
                $cleanHeader = preg_replace('/[^\x20-\x7E]/', '', $header);
                $cleanHeader = trim(strtolower($cleanHeader));
                if (!empty($cleanHeader)) {
                    $headers[] = $cleanHeader;
                }
            }
            
            // Debug info
            $debug = "Raw headers: " . implode(', ', array_map('trim', $rawHeaders)) . "\n";
            $debug .= "Cleaned headers: " . implode(', ', $headers) . "\n";
            $debug .= "First row: " . implode(', ', $firstRow) . "\n\n";
            
            // Define expected headers
            $expectedHeaders = ['student_id', 'name', 'email', 'year', 'section', 'batch'];
            
            // Create a mapping of found headers to expected headers
            $headerMap = [];
            foreach ($headers as $index => $header) {
                // Direct match
                if (in_array($header, $expectedHeaders)) {
                    $headerMap[$header] = $index;
                }
                // Handle common variations
                elseif (strpos($header, 'student') !== false && strpos($header, 'id') !== false) {
                    $headerMap['student_id'] = $index;
                }
                elseif ($header == 'full name' || $header == 'student name' || $header == 'name') {
                    $headerMap['name'] = $index;
                }
                elseif ($header == 'e-mail' || $header == 'mail' || $header == 'email') {
                    $headerMap['email'] = $index;
                }
                elseif ($header == 'yr' || $header == 'study year' || $header == 'year') {
                    $headerMap['year'] = $index;
                }
                elseif ($header == 'sec' || $header == 'class' || $header == 'section') {
                    $headerMap['section'] = $index;
                }
                elseif ($header == 'bach' || $header == 'bat ch' || $header == 'year of entry' || $header == 'batch') {
                    $headerMap['batch'] = $index;
                }
            }
            
            $debug .= "Header map: " . json_encode($headerMap) . "\n\n";
            
            // Check if we have the required headers
            $requiredHeaders = ['student_id', 'name', 'email', 'year'];
            $missingHeaders = [];
            
            foreach ($requiredHeaders as $required) {
                if (!isset($headerMap[$required])) {
                    $missingHeaders[] = $required;
                }
            }
            
            if (!empty($missingHeaders)) {
                $debug .= "Missing headers: " . implode(', ', $missingHeaders);
                
                return redirect()->back()->with('error', 
                    '❌ CSV missing required headers.<br><pre>' . nl2br($debug) . '</pre>');
            }
            
            // Create a new temporary file with corrected headers
            $outputPath = tempnam(sys_get_temp_dir(), 'csv_fixed_');
            $outputHandle = fopen($outputPath, 'w');
            
            // Write corrected headers
            fputcsv($outputHandle, $expectedHeaders);
            
            // Process first row
            $mappedRow = [];
            foreach ($expectedHeaders as $expected) {
                if (isset($headerMap[$expected])) {
                    $value = isset($firstRow[$headerMap[$expected]]) ? trim($firstRow[$headerMap[$expected]]) : '';
                    $mappedRow[] = $value;
                } else {
                    $mappedRow[] = '';
                }
            }
            fputcsv($outputHandle, $mappedRow);
            
            // Read and write the rest of the rows
            $handle = fopen($tempPath, 'r');
            fgetcsv($handle); // Skip original headers
            fgetcsv($handle); // Skip first row (already written)
            
            $rowNumber = 2;
            while (($row = fgetcsv($handle)) !== false) {
                $mappedRow = [];
                foreach ($expectedHeaders as $expected) {
                    if (isset($headerMap[$expected])) {
                        $value = isset($row[$headerMap[$expected]]) ? trim($row[$headerMap[$expected]]) : '';
                        $mappedRow[] = $value;
                    } else {
                        $mappedRow[] = '';
                    }
                }
                fputcsv($outputHandle, $mappedRow);
                $rowNumber++;
            }
            
            fclose($handle);
            fclose($outputHandle);
            
            $debug .= "Created temp file with {$rowNumber} rows\n";
            
            // Use the fixed file for import
            $import = new StudentsImport();
            Excel::import($import, $outputPath);
            
            // Clean up temp files
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }
            if (file_exists($outputPath)) {
                unlink($outputPath);
            }
            
            $successful = $import->getSuccessfulCount();
            $failed = $import->getFailedCount();
            $total = $import->getRowCount();
            $importDebug = $import->getDebug();
            
            // Get final count from database
            $finalCount = Student::count();
            
            if ($successful > 0) {
                $message = "✅ Import completed!\n";
                $message .= "📊 Total rows processed: {$total}\n";
                $message .= "✅ Successfully imported: {$successful} students\n";
                
                if ($failed > 0) {
                    $message .= "❌ Failed/skipped: {$failed} rows\n";
                    $message .= "\n📋 Import debug info:\n";
                    foreach ($importDebug as $item) {
                        $message .= "• {$item}\n";
                    }
                }
                
                $message .= "\n📊 Total students in database now: {$finalCount}";
                
                return redirect()->route('admin.students.index')->with('success', nl2br($message));
            } else {
                $errorMsg = "❌ No students were imported.\n\n";
                $errorMsg .= "CSV Debug Info:\n" . $debug . "\n";
                $errorMsg .= "Import Debug Info:\n";
                foreach ($importDebug as $item) {
                    $errorMsg .= "• {$item}\n";
                }
                
                if (empty($importDebug)) {
                    $errorMsg .= "• No import debug info available. Check storage/logs/laravel.log for details.\n";
                }
                
                return redirect()->back()->with('error', nl2br($errorMsg));
            }
            
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            
            foreach ($failures as $failure) {
                $errorMessages[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
            }
            
            // Clean up temp files if they exist
            if (isset($tempPath) && file_exists($tempPath)) {
                unlink($tempPath);
            }
            if (isset($outputPath) && file_exists($outputPath)) {
                unlink($outputPath);
            }
            
            // Limit error messages
            if (count($errorMessages) > 10) {
                $errorMessages = array_slice($errorMessages, 0, 10);
                $errorMessages[] = "... and " . (count($failures) - 10) . " more errors";
            }
            
            return redirect()->back()->with('error', '❌ Validation failed:<br>' . implode('<br>', $errorMessages));
            
        } catch (\Maatwebsite\Excel\Exceptions\NoTypeDetectedException $e) {
            // Clean up temp files if they exist
            if (isset($tempPath) && file_exists($tempPath)) {
                unlink($tempPath);
            }
            if (isset($outputPath) && file_exists($outputPath)) {
                unlink($outputPath);
            }
            return redirect()->back()->with('error', '❌ Could not detect file type. Please ensure it is a valid Excel or CSV file.');
            
        } catch (\Exception $e) {
            // Clean up temp files if they exist
            if (isset($tempPath) && file_exists($tempPath)) {
                unlink($tempPath);
            }
            if (isset($outputPath) && file_exists($outputPath)) {
                unlink($outputPath);
            }
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
        $headers = [
            'student_id', 'name', 'email', 'year', 'section', 'batch'
        ];
        
        $filename = "student_upload_template.csv";
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        $handle = fopen('php://output', 'w');
        
        // Add UTF-8 BOM for Excel compatibility
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($handle, $headers);
        
        // Add sample data with proper email format
        fputcsv($handle, ['CS2025001', 'Abel Shewangizaw', 'abel.shewangizaw@mkau.edu.et', '1', 'A', '2025']);
        fputcsv($handle, ['CS2025002', 'Abyu Eshetie', 'abyu.eshetie@mkau.edu.et', '1', 'A', '2025']);
        fputcsv($handle, ['CS2025003', 'Akililu Ayka', 'akililu.ayka@mkau.edu.et', '1', 'A', '2025']);
        
        // Add instructions
        fputcsv($handle, ['# INSTRUCTIONS: Replace sample data with your students']);
        fputcsv($handle, ['# student_id: Unique identifier (required)']);
        fputcsv($handle, ['# name: Full name (required)']);
        fputcsv($handle, ['# email: Valid email (required, must be unique)']);
        fputcsv($handle, ['# year: 1, 2, 3, or 4 (required)']);
        fputcsv($handle, ['# section: A, B, C, etc. (optional)']);
        fputcsv($handle, ['# batch: Admission year (optional)']);
        
        fclose($handle);
        exit;
    }

    /**
     * Staff: View students (read-only)
     */
    public function staffIndex()
    {
        $students = Student::orderBy('year')->orderBy('name')->paginate(15);
        $stats = [
            'total' => Student::count(),
            'year1' => Student::where('year', 1)->count(),
            'year2' => Student::where('year', 2)->count(),
            'year3' => Student::where('year', 3)->count(),
            'year4' => Student::where('year', 4)->count(),
        ];
        
        return view('staff.students.index', compact('students', 'stats'));
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
        
        // Check if user has isStudent method
        if (method_exists($user, 'isStudent') && !$user->isStudent()) {
            abort(403, 'Unauthorized access.');
        }
        
        // Get the student record associated with this user
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
    
    // Get student record
    $student = Student::where('email', $user->email)->first();
    
    if (!$student) {
        // If no student record exists, create a placeholder
        $student = (object) [
            'student_id' => 'N/A',
            'name' => $user->name,
            'email' => $user->email,
            'year' => 1,
            'section' => 'A',
        ];
    }
    
    // Get courses (if relationship exists)
    $courses = collect([]);
    if ($student && isset($student->courses)) {
        $courses = $student->courses;
    }
    
    // Stats array
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
            // Delete old image
            if ($student->profile_image && file_exists(public_path($student->profile_image))) {
                unlink(public_path($student->profile_image));
            }
            
            $image = $request->file('profile_image');
            $imageName = 'student_' . $student->student_id . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/students'), $imageName);
            $data['profile_image'] = 'uploads/students/' . $imageName;
        }

        $student->update($data);
        
        // Update user email as well
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
        
        // Check if student is enrolled in this course
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
        
        // Check if student is enrolled in the course
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
        
        // Check if student is enrolled in the course
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
        
        // Check if student is enrolled in the course
        if (!$student->courses()->where('course_id', $assignment->course_id)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }
        
        // Check if already submitted
        $existingSubmission = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('student_id', $student->id)
            ->first();
            
        if ($existingSubmission) {
            return redirect()->back()->with('error', 'You have already submitted this assignment.');
        }
        
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'comments' => 'nullable|string|max:1000',
        ]);

        $file = $request->file('file');
        $fileName = $student->student_id . '_' . time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('submissions/' . $assignment->id, $fileName, 'public');

        $submission = AssignmentSubmission::create([
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