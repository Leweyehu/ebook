<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\AlumniJob;
use App\Models\AlumniStory;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year');
        $search = $request->get('search');
        
        $alumni = Alumni::where('status', 'approved')
            ->when($year, function($query, $year) {
                return $query->where('graduation_year', $year);
            })
            ->when($search, function($query, $search) {
                return $query->where('name', 'LIKE', "%{$search}%")
                             ->orWhere('current_company', 'LIKE', "%{$search}%")
                             ->orWhere('current_job_title', 'LIKE', "%{$search}%");
            })
            ->orderBy('graduation_year', 'desc')
            ->orderBy('name')
            ->paginate(20);
        
        $years = Alumni::where('status', 'approved')
            ->distinct()
            ->pluck('graduation_year')
            ->sort()
            ->reverse()
            ->values();
        
        $stats = [
            'total' => Alumni::where('status', 'approved')->count(),
            'companies' => Alumni::where('status', 'approved')->whereNotNull('current_company')->distinct('current_company')->count('current_company'),
            'years' => Alumni::where('status', 'approved')->distinct('graduation_year')->count('graduation_year')
        ];
        
        return view('alumni.index', compact('alumni', 'years', 'stats', 'year', 'search'));
    }

    public function show(Alumni $alumni)
    {
        if ($alumni->status !== 'approved') {
            abort(404);
        }
        
        return view('alumni.show', compact('alumni'));
    }

    public function registerForm()
    {
        return view('alumni.register');
    }

    public function register(Request $request)
{
    $validated = $request->validate([
        'student_id' => 'required|string|max:50|unique:alumni',
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:alumni',
        'phone' => 'nullable|string|max:20',
        'graduation_year' => 'required|integer|min:2000|max:' . date('Y'),
        'degree' => 'required|string|max:255',
        'employment_status' => 'nullable|string|max:50',
        'employment_type' => 'nullable|string|max:50',
        'employment_start_month' => 'nullable|integer|min:1|max:12',
        'employment_start_year' => 'nullable|integer|min:2000|max:' . date('Y'),
        'employment_end_month' => 'nullable|integer|min:1|max:12',
        'employment_end_year' => 'nullable|integer|min:2000|max:' . date('Y'),
        'current_job_title' => 'nullable|string|max:255',
        'current_company' => 'nullable|string|max:255',
        'industry_sector' => 'nullable|string|max:100',
        'work_mode' => 'nullable|string|max:50',
        'location' => 'nullable|string|max:255',
        'salary_range' => 'nullable|string|max:50',
        'professional_certifications' => 'nullable|string',
        'linkedin_url' => 'nullable|url|max:255',
        'github_url' => 'nullable|url|max:255',
        'website_url' => 'nullable|url|max:255',
        'bio' => 'nullable|string',
        'achievements' => 'nullable|string',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'show_in_directory' => 'boolean'
    ]);

    $data = $request->except('profile_image');
    
    if ($request->hasFile('profile_image')) {
        $image = $request->file('profile_image');
        $imageName = 'alumni_' . time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('uploads/alumni'), $imageName);
        $data['profile_image'] = 'uploads/alumni/' . $imageName;
    }

    $data['status'] = 'pending';
    $data['is_verified'] = false;
    $data['show_in_directory'] = $request->show_in_directory ?? true;

    Alumni::create($data);

    return redirect()->route('alumni.register')
        ->with('success', '✅ Registration submitted successfully! Your profile will be reviewed within 3-5 business days.');
    }
}