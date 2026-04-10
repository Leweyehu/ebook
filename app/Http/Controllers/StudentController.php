<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;

class StudentController extends Controller
{
    /**
     * Display public student listing
     */
    public function index(Request $request)
    {
        $batch = $request->get('batch');
        $search = $request->get('search');
        
        $students = Student::where('is_active', true)
            ->when($batch, function($query, $batch) {
                return $query->where('batch', $batch);
            })
            ->when($search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('student_id', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('year')
            ->orderBy('name')
            ->paginate(20);
        
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
        
        return view('students.index', compact('students', 'batches', 'stats', 'batch', 'search'));
    }

    /**
     * Display single student profile (public)
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
                        return $query->where(function($q) use ($search) {
                            $q->where('name', 'LIKE', "%{$search}%")
                              ->orWhere('student_id', 'LIKE', "%{$search}%")
                              ->orWhere('email', 'LIKE', "%{$search}%");
                        });
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
     * Admin: Store individual student
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|unique:students,student_id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'year' => 'required|in:1,2,3,4',
            'section' => 'nullable|string|max:10',
            'batch' => 'nullable|string|max:50',
        ]);

        try {
            DB::beginTransaction();

            $student = Student::create([
                'student_id' => $request->student_id,
                'name' => $request->name,
                'email' => $request->email,
                'year' => $request->year,
                'section' => $request->section,
                'batch' => $request->batch,
                'is_active' => true
            ]);

            User::updateOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'password' => Hash::make($request->student_id),
                    'role' => 'student'
                ]
            );

            DB::commit();
            return redirect()->back()->with('success', "✅ Student '{$request->name}' added successfully!");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', '❌ Error adding student: ' . $e->getMessage());
        }
    }

    /**
     * Admin: Download template for bulk upload
     */
    public function downloadTemplate()
    {
        $filename = "student_upload_template.csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ];
        
        $callback = function() {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            fputcsv($file, ['student_id', 'name', 'email', 'year', 'section', 'batch']);
            fputcsv($file, ['MAU2024001', 'John Doe', 'john.doe@university.edu', '1', 'A', '2024']);
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Admin: Bulk upload students from CSV
     */
    public function upload(Request $request)
    {
        // FIX: Using 'student_file' to match your Blade input name
        $request->validate([
            'student_file' => 'required|mimes:csv,txt|max:5120'
        ]);

        try {
            $file = $request->file('student_file');
            $handle = fopen($file->getPathname(), 'r');
            
            $rawHeaders = fgetcsv($handle);
            $headers = [];
            foreach ($rawHeaders as $header) {
                $cleanHeader = trim(strtolower(preg_replace('/^\xEF\xBB\xBF/', '', $header)));
                $headers[] = $cleanHeader;
            }
            
            $expectedHeaders = ['student_id', 'name', 'email', 'year', 'section', 'batch'];
            $headerMap = [];
            foreach ($headers as $index => $header) {
                if (in_array($header, $expectedHeaders)) {
                    $headerMap[$header] = $index;
                }
            }
            
            $requiredHeaders = ['student_id', 'name', 'email', 'year'];
            foreach ($requiredHeaders as $req) {
                if (!isset($headerMap[$req])) {
                    fclose($handle);
                    return redirect()->back()->with('error', "❌ CSV missing column: $req");
                }
            }
            
            $successCount = 0;
            $errorCount = 0;
            $errors = [];
            $rowNumber = 1;

            DB::beginTransaction();

            while (($row = fgetcsv($handle)) !== false) {
                $rowNumber++;
                if (empty(array_filter($row)) || strpos($row[0], '#') === 0) continue;

                $data = [
                    'student_id' => trim($row[$headerMap['student_id']] ?? ''),
                    'name'       => trim($row[$headerMap['name']] ?? ''),
                    'email'      => trim($row[$headerMap['email']] ?? ''),
                    'year'       => trim($row[$headerMap['year']] ?? ''),
                    'section'    => isset($headerMap['section']) ? trim($row[$headerMap['section']] ?? '') : null,
                    'batch'      => isset($headerMap['batch']) ? trim($row[$headerMap['batch']] ?? '') : null,
                    'is_active'  => true
                ];

                // Check for duplicates
                if (Student::where('student_id', $data['student_id'])->orWhere('email', $data['email'])->exists()) {
                    $errors[] = "Row $rowNumber: ID or Email already exists.";
                    $errorCount++;
                    continue;
                }

                // FIX: Create Student AND User record
                Student::create($data);
                User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['student_id']),
                    'role' => 'student'
                ]);
                
                $successCount++;
            }

            DB::commit();
            fclose($handle);
            
            return redirect()->route('admin.students.index')->with('success', "✅ Successfully imported $successCount students.");
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', '❌ Error: ' . $e->getMessage());
        }
    }

    /**
     * Admin: Delete student
     */
    public function destroy(Student $student)
    {
        $email = $student->email;
        DB::transaction(function() use ($student, $email) {
            $student->delete();
            User::where('email', $email)->delete(); // Clean up user account too
        });
        
        return redirect()->route('admin.students.index')->with('success', "✅ Student deleted successfully!");
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
                        return $query->where(function($q) use ($search) {
                            $q->where('name', 'LIKE', "%{$search}%")
                              ->orWhere('student_id', 'LIKE', "%{$search}%");
                        });
                    })
                    ->orderBy('year')
                    ->orderBy('name')
                    ->paginate(20);
        
        $batches = Student::where('is_active', true)->whereNotNull('batch')->distinct()->pluck('batch')->sort()->values();
        
        $stats = [
            'total' => Student::where('is_active', true)->count(),
            'year1' => Student::where('is_active', true)->where('year', 1)->count(),
            'year2' => Student::where('is_active', true)->where('year', 2)->count(),
            'year3' => Student::where('is_active', true)->where('year', 3)->count(),
            'year4' => Student::where('is_active', true)->where('year', 4)->count(),
        ];
        
        return view('staff.students.index', compact('students', 'stats', 'batches', 'batch', 'search'));
    }
    
    public function staffShow(Student $student)
    {
        return view('staff.students.show', compact('student'));
    }

    /**
     * Student Dashboard
     */
    public function dashboard()
    {
        $user = auth()->user();
        $student = Student::where('email', $user->email)->first();
        
        if (!$student) {
            $student = (object) [
                'student_id' => 'N/A',
                'name' => $user->name,
                'email' => $user->email,
                'year' => 1,
                'section' => 'N/A',
            ];
        }
        
        return view('student.dashboard', compact('student'));
    }

    public function profile()
    {
        $student = Student::where('email', auth()->user()->email)->firstOrFail();
        return view('student.profile', compact('student'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $student = Student::where('email', $user->email)->firstOrFail();
        
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
        $user->update(['email' => $request->email, 'name' => $request->name]);

        return redirect()->route('student.profile')->with('success', 'Profile updated successfully!');
    }

    public function showChangePasswordForm()
    {
        return view('student.profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password changed successfully!');
    }

    public function courses()
    {
        $student = Student::where('email', auth()->user()->email)->firstOrFail();
        $courses = $student->courses()->get();
        return view('student.courses', compact('student', 'courses'));
    }

    public function grades()
    {
        $student = Student::where('email', auth()->user()->email)->firstOrFail();
        return view('student.grades', compact('student'));
    }

    public function notices()
    {
        $student = Student::where('email', auth()->user()->email)->firstOrFail();
        return view('student.notices', compact('student'));
    }

    public function myComplaints()
    {
        $user = auth()->user();
        $student = Student::where('email', $user->email)->first();
        
        $complaints = \App\Models\Complaint::where('email', $user->email)
            ->orWhere('student_id', $student->student_id ?? null)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('student.complaints', compact('complaints'));
    }

    public function allAssignments()
    {
        $student = Student::where('email', auth()->user()->email)->firstOrFail();
        return view('student.assignments.all', compact('student'));
    }
}