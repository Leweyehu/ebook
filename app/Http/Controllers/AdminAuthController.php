<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Hardcoded credentials (you can move these to .env file)
        $validUsername = env('ADMIN_USERNAME', 'admin');
        $validPassword = env('ADMIN_PASSWORD', 'admin123');

        if ($request->username === $validUsername && $request->password === $validPassword) {
            // Regenerate session ID for security
            $request->session()->regenerate();
            
            // Store admin session data
            Session::put('admin_logged_in', true);
            Session::put('admin_username', $request->username);
            Session::put('admin_login_time', now()->toDateTimeString());
            
            // Redirect to intended page or staff admin
            return redirect()->intended(route('admin.staff.index'))->with('success', 'Welcome to Admin Panel!');
        }

        return back()
            ->withInput($request->only('username'))
            ->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ]);
    }

    public function logout(Request $request)
    {
        // Clear all admin session data
        Session::forget(['admin_logged_in', 'admin_username', 'admin_login_time']);
        
        // Invalidate the session
        $request->session()->invalidate();
        
        // Regenerate CSRF token
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login.form')->with('success', 'You have been logged out successfully!');
    }
}