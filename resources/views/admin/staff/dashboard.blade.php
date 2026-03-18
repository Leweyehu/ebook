@extends('layouts.staff')

@section('title', 'Staff Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Card -->
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem; border-radius: 15px; margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
        @php
            $staff = \App\Models\Staff::where('email', Auth::user()->email)->first();
        @endphp
        
        @if($staff && $staff->image)
            <img src="{{ asset($staff->image) }}" alt="{{ $staff->name }}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #ffc107;">
        @else
            <div style="width: 80px; height: 80px; background: #ffc107; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <span style="font-size: 2rem; color: #1a2b3c; font-weight: bold;">{{ substr(Auth::user()->name, 0, 1) }}</span>
            </div>
        @endif
        <div>
            <h2 style="font-size: 2rem; margin-bottom: 0.5rem;">Welcome, {{ Auth::user()->name }}!</h2>
            <p style="opacity: 0.9; font-size: 1.1rem;">
                {{ $staff->position ?? 'Staff Member' }} • 
                {{ $staff->qualification ?? '' }}
            </p>
            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                <a href="{{ route('staff.profile.edit') }}" style="color: #ffc107; text-decoration: none;">
                    <i class="fas fa-user-edit"></i> Edit Profile
                </a>
                <a href="{{ route('staff.password.change') }}" style="color: #ffc107; text-decoration: none;">
                    <i class="fas fa-key"></i> Change Password
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    @php
        $totalCourses = 0;
        $totalStudents = 0;
        $pendingGrading = 0;
        $activeNotices = 0;
        
        try {
            $totalCourses = \App\Models\Course::count();
            $totalStudents = \App\Models\Student::count();
            $pendingGrading = \App\Models\AssignmentSubmission::whereNull('score')->count();
            $activeNotices = \App\Models\CourseNotice::where('is_active', true)->count();
        } catch (\Exception $e) {
            // Tables might not exist yet, use defaults
        }
    @endphp
    
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-book" style="font-size: 2.5rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $totalCourses }}</h3>
        <p>My Courses</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-users" style="font-size: 2.5rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $totalStudents }}</h3>
        <p>Total Students</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-clock" style="font-size: 2.5rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $pendingGrading }}</h3>
        <p>Pending Grading</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-bullhorn" style="font-size: 2.5rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $activeNotices }}</h3>
        <p>Active Notices</p>
    </div>
</div>

<!-- Quick Actions -->
<h2 style="color: #1a2b3c; margin-bottom: 1.5rem;">Quick Actions</h2>
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
    <a href="{{ route('staff.courses.index') }}" style="background: white; padding: 2rem; border-radius: 10px; text-decoration: none; color: #1a2b3c; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s;">
        <i class="fas fa-book" style="font-size: 2.5rem; color: #667eea; margin-bottom: 1rem;"></i>
        <h3 style="margin-bottom: 0.5rem;">My Courses</h3>
        <p style="color: #666;">View and manage your courses</p>
    </a>
    
    <a href="{{ route('staff.news.index') }}" style="background: white; padding: 2rem; border-radius: 10px; text-decoration: none; color: #1a2b3c; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s;">
        <i class="fas fa-newspaper" style="font-size: 2.5rem; color: #ffc107; margin-bottom: 1rem;"></i>
        <h3 style="margin-bottom: 0.5rem;">News</h3>
        <p style="color: #666;">View department news</p>
    </a>
    
    <a href="{{ route('staff.students.index') }}" style="background: white; padding: 2rem; border-radius: 10px; text-decoration: none; color: #1a2b3c; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s;">
        <i class="fas fa-users" style="font-size: 2.5rem; color: #28a745; margin-bottom: 1rem;"></i>
        <h3 style="margin-bottom: 0.5rem;">Students</h3>
        <p style="color: #666;">View student list</p>
    </a>
    
    <a href="{{ route('staff.profile.edit') }}" style="background: white; padding: 2rem; border-radius: 10px; text-decoration: none; color: #1a2b3c; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s;">
        <i class="fas fa-user-cog" style="font-size: 2.5rem; color: #17a2b8; margin-bottom: 1rem;"></i>
        <h3 style="margin-bottom: 0.5rem;">My Profile</h3>
        <p style="color: #666;">Update your profile</p>
    </a>
</div>

<!-- Recent Activity Section -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-bottom: 3rem;">
    <!-- Recent Submissions -->
    <div style="background: white; border-radius: 10px; padding: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <h3 style="color: #1a2b3c; margin-bottom: 1rem;">Recent Submissions</h3>
        @php
            $recentSubmissions = collect([]);
            try {
                $recentSubmissions = \App\Models\AssignmentSubmission::with(['student', 'assignment'])
                    ->latest()
                    ->take(5)
                    ->get();
            } catch (\Exception $e) {}
        @endphp
        
        @if($recentSubmissions->count() > 0)
            @foreach($recentSubmissions as $submission)
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 0; border-bottom: 1px solid #e9ecef;">
                <div>
                    <strong>{{ $submission->student->name ?? 'N/A' }}</strong>
                    <p style="color: #666; font-size: 0.9rem;">{{ $submission->assignment->title ?? 'N/A' }}</p>
                </div>
                <div style="text-align: right;">
                    <span style="color: #999; font-size: 0.85rem;">{{ $submission->submitted_at ? $submission->submitted_at->diffForHumans() : 'N/A' }}</span><br>
                    @if($submission->score)
                        <span style="background: #28a745; color: white; padding: 0.2rem 0.5rem; border-radius: 3px; font-size: 0.8rem;">Graded</span>
                    @else
                        <span style="background: #ffc107; color: #1a2b3c; padding: 0.2rem 0.5rem; border-radius: 3px; font-size: 0.8rem;">Pending</span>
                    @endif
                </div>
            </div>
            @endforeach
        @else
            <p style="color: #999; text-align: center; padding: 2rem;">No recent submissions</p>
        @endif
    </div>
    
    <!-- Upcoming Deadlines -->
    <div style="background: white; border-radius: 10px; padding: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <h3 style="color: #1a2b3c; margin-bottom: 1rem;">Upcoming Deadlines</h3>
        @php
            $upcoming = collect([]);
            try {
                $upcoming = \App\Models\Assignment::with('course')
                    ->where('due_date', '>', now())
                    ->orderBy('due_date')
                    ->take(5)
                    ->get();
            } catch (\Exception $e) {}
        @endphp
        
        @if($upcoming->count() > 0)
            @foreach($upcoming as $assignment)
            <div style="padding: 1rem 0; border-bottom: 1px solid #e9ecef;">
                <strong>{{ $assignment->title }}</strong>
                <p style="color: #666; font-size: 0.9rem;">{{ $assignment->course->course_code ?? 'N/A' }}</p>
                <p style="color: #dc3545; font-size: 0.85rem;">Due: {{ $assignment->due_date ? $assignment->due_date->format('M d, Y') : 'N/A' }}</p>
            </div>
            @endforeach
        @else
            <p style="color: #999; text-align: center; padding: 2rem;">No upcoming deadlines</p>
        @endif
    </div>
</div>

<!-- My Courses Section -->
<h2 style="color: #1a2b3c; margin-bottom: 1.5rem;">My Courses</h2>
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem;">
    @php
        $myCourses = collect([]);
        if ($staff) {
            try {
                $myCourses = $staff->courses;
            } catch (\Exception $e) {}
        }
    @endphp
    
    @forelse($myCourses as $course)
    <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 1.5rem; color: white;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h3 style="margin-bottom: 0.5rem;">{{ $course->course_code }}</h3>
                    <p style="opacity: 0.9;">{{ $course->course_name }}</p>
                </div>
                <span style="background: #ffc107; color: #1a2b3c; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem;">
                    Year {{ $course->year }}
                </span>
            </div>
        </div>
        <div style="padding: 1.5rem;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                <span><i class="fas fa-users" style="color: #667eea;"></i> {{ $course->students()->count() }} Students</span>
                <span><i class="fas fa-file-alt" style="color: #ffc107;"></i> {{ $course->materials()->count() }} Materials</span>
            </div>
            <p style="color: #666; margin-bottom: 1.5rem;">{{ Str::limit($course->description ?? '', 100) }}</p>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('staff.courses.show', $course) }}" style="flex: 1; background: #667eea; color: white; padding: 0.75rem; text-align: center; border-radius: 5px; text-decoration: none;">
                    <i class="fas fa-eye"></i> View
                </a>
                <a href="{{ route('staff.courses.students', $course) }}" style="flex: 1; background: #ffc107; color: #1a2b3c; padding: 0.75rem; text-align: center; border-radius: 5px; text-decoration: none;">
                    <i class="fas fa-users"></i> Students
                </a>
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column: 1/-1; text-align: center; padding: 3rem; background: white; border-radius: 10px;">
        <i class="fas fa-book-open" style="font-size: 3rem; color: #6c757d; margin-bottom: 1rem;"></i>
        <p style="color: #6c757d;">You haven't been assigned any courses yet.</p>
    </div>
    @endforelse
</div>

<style>
    a[style*="box-shadow"]:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important;
    }
    
    @media (max-width: 768px) {
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        [style*="grid-template-columns: 2fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
    
    @media (max-width: 480px) {
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection