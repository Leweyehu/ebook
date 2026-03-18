<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        $stats = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'staff' => User::where('role', 'staff')->count(),
            'student' => User::where('role', 'student')->count(),
            'active' => User::where('is_active', true)->count(),
        ];
        
        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Show form to create a new user (admin/staff/student)
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,staff,student',
            'student_id' => 'nullable|string|unique:users,student_id',
            'department' => 'nullable|string|max:100',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'student_id' => $request->student_id,
            'department' => $request->department,
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "✅ User '{$user->name}' created successfully!");
    }

    /**
     * Show form to create staff user from existing staff record
     */
    public function createFromStaff()
    {
        // Get staff members who don't have a user account yet
        // Assuming you have a staff table with email field
        $staff = Staff::whereDoesntHave('user')->get();
        return view('admin.users.create-from-staff', compact('staff'));
    }

    /**
     * Store staff user from existing staff record
     */
    public function storeFromStaff(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $staff = Staff::findOrFail($request->staff_id);

        $user = User::create([
            'name' => $staff->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff',
            'student_id' => 'STF' . str_pad($staff->id, 5, '0', STR_PAD_LEFT),
            'department' => $staff->department ?? 'Computer Science',
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "✅ User account created for staff: {$staff->name}");
    }

    /**
     * Show form to create student user from existing student record
     */
    public function createFromStudent()
    {
        // Get students who don't have a user account yet
        $students = Student::whereDoesntHave('user')->get();
        return view('admin.users.create-from-student', compact('students'));
    }

    /**
     * Store student user from existing student record
     */
    public function storeFromStudent(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $student = Student::findOrFail($request->student_id);

        $user = User::create([
            'name' => $student->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
            'student_id' => $student->student_id,
            'department' => $student->department ?? 'Computer Science',
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "✅ User account created for student: {$student->name}");
    }

    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,staff,student',
            'student_id' => 'nullable|string|unique:users,student_id,' . $user->id,
            'department' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'student_id' => $request->student_id,
            'department' => $request->department,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', "✅ User '{$user->name}' updated successfully!");
    }

    /**
     * Remove the specified user
     */
    /**
 * Remove the specified user from storage.
 */
public function destroy(User $user)
{
    // Don't allow deleting your own account
    if ($user->id === Auth::id()) {
        return redirect()->route('admin.users.index')
            ->with('error', '❌ You cannot delete your own account!');
    }

    $userName = $user->name;
    $user->delete();

    return redirect()->route('admin.users.index')
        ->with('success', "✅ User '{$userName}' deleted successfully!");
}

    /**
     * Toggle user active status
     */
    public function toggleStatus(User $user)
    {
        // Don't allow disabling your own account
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', "❌ You cannot disable your own account!");
        }

        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.users.index')
            ->with('success', "✅ User '{$user->name}' {$status} successfully!");
    }

    /**
     * Bulk create accounts for all staff without users
     */
    public function bulkCreateStaff()
    {
        $staffWithoutAccounts = Staff::whereDoesntHave('user')->get();
        $created = 0;

        foreach ($staffWithoutAccounts as $staff) {
            // Generate email from name
            $email = strtolower(str_replace(' ', '.', $staff->name)) . '@staff.mkau.edu.et';
            
            // Check if email already exists
            if (User::where('email', $email)->exists()) {
                $email = strtolower(str_replace(' ', '.', $staff->name)) . '.' . uniqid() . '@staff.mkau.edu.et';
            }

            User::create([
                'name' => $staff->name,
                'email' => $email,
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'student_id' => 'STF' . str_pad($staff->id, 5, '0', STR_PAD_LEFT),
                'department' => $staff->department ?? 'Computer Science',
                'is_active' => true,
            ]);
            $created++;
        }

        return redirect()->route('admin.users.index')
            ->with('success', "✅ {$created} staff accounts created successfully! Default password: password123");
    }

    /**
     * Bulk create accounts for all students without users
     */
    public function bulkCreateStudents()
    {
        $studentsWithoutAccounts = Student::whereDoesntHave('user')->get();
        $created = 0;

        foreach ($studentsWithoutAccounts as $student) {
            // Use student's email if available, otherwise generate
            $email = $student->email ?? strtolower(str_replace(' ', '.', $student->name)) . '@student.mkau.edu.et';
            
            // Check if email already exists
            if (User::where('email', $email)->exists()) {
                $email = strtolower(str_replace(' ', '.', $student->name)) . '.' . uniqid() . '@student.mkau.edu.et';
            }

            User::create([
                'name' => $student->name,
                'email' => $email,
                'password' => Hash::make('password123'),
                'role' => 'student',
                'student_id' => $student->student_id,
                'department' => $student->department ?? 'Computer Science',
                'is_active' => true,
            ]);
            $created++;
        }

        return redirect()->route('admin.users.index')
            ->with('success', "✅ {$created} student accounts created successfully! Default password: password123");
    }
}