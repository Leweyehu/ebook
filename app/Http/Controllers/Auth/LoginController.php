<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Check if user is active
            if (isset($user->is_active) && !$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account is deactivated. Please contact administrator.',
                ]);
            }
            
            // Store user info in session
            Session::put('user_role', $user->role);
            Session::put('user_name', $user->name);
            Session::put('user_id', $user->id);
            
            // Log successful login
            Log::info('User logged in successfully', ['user_id' => $user->id, 'role' => $user->role]);
            
            // Redirect based on role
            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    private function redirectBasedOnRole($user)
    {
        try {
            switch ($user->role) {
                case 'admin':
                    // Check if route exists
                    if (app('router')->has('admin.dashboard')) {
                        return redirect()->route('admin.dashboard')
                            ->with('success', 'Welcome to Admin Dashboard!');
                    } 
                    // Check if URL is accessible
                    else {
                        return redirect('/admin/dashboard')
                            ->with('success', 'Welcome to Admin Dashboard!');
                    }
                
                case 'staff':
                    if (app('router')->has('staff.dashboard')) {
                        return redirect()->route('staff.dashboard')
                            ->with('success', 'Welcome to Staff Dashboard!');
                    } else {
                        return redirect('/staff/dashboard')
                            ->with('success', 'Welcome to Staff Dashboard!');
                    }
                
                case 'student':
                    if (app('router')->has('student.dashboard')) {
                        return redirect()->route('student.dashboard')
                            ->with('success', 'Welcome to Student Portal!');
                    } else {
                        return redirect('/student/dashboard')
                            ->with('success', 'Welcome to Student Portal!');
                    }
                
                default:
                    // Make sure home route exists
                    if (app('router')->has('home')) {
                        return redirect()->route('home')
                            ->with('success', 'Welcome back!');
                    } else {
                        return redirect('/')
                            ->with('success', 'Welcome back!');
                    }
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error('Redirect error: ' . $e->getMessage());
            
            // Fallback to home page with URL
            return redirect('/')->with('warning', 'Welcome!');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Clear custom session data
        Session::forget(['user_role', 'user_name', 'user_id']);
        
        // Check if home route exists
        if (app('router')->has('home')) {
            return redirect()->route('home')->with('success', 'You have been logged out successfully!');
        }
        
        return redirect('/')->with('success', 'You have been logged out successfully!');
    }
}