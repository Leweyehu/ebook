@extends('layouts.staff')

@section('title', 'Staff Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Card -->
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem; border-radius: 15px; margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
        @php
            $staff = \App\Models\Staff::where('email', Auth::user()->email)->first();
            $currentAcademicYear = date('Y') . '/' . (date('Y')+1);
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

<!-- Statistics Cards - Personalized for this staff -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-book" style="font-size: 2.5rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['total_courses'] ?? 0 }}</h3>
        <p>My Assigned Courses</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-users" style="font-size: 2.5rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['total_students'] ?? 0 }}</h3>
        <p>My Students</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-clock" style="font-size: 2.5rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['pending_grading'] ?? 0 }}</h3>
        <p>Pending Grading</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-bullhorn" style="font-size: 2.5rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['active_notices'] ?? 0 }}</h3>
        <p>Active Notices</p>
    </div>
</div>

<!-- Quick Actions Section -->
<h2 style="color: #1a2b3c; margin-bottom: 1.5rem;">Quick Actions</h2>
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
    <a href="{{ route('staff.courses.index') }}" class="action-card" style="background: white; padding: 2rem; border-radius: 10px; text-decoration: none; color: #1a2b3c; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s; text-align: center;">
        <i class="fas fa-book" style="font-size: 2.5rem; color: #667eea; margin-bottom: 1rem;"></i>
        <h3 style="margin-bottom: 0.5rem;">My Courses</h3>
        <p style="color: #666;">View and manage your assigned courses</p>
    </a>
    
    <a href="{{ route('staff.news.index') }}" class="action-card" style="background: white; padding: 2rem; border-radius: 10px; text-decoration: none; color: #1a2b3c; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s; text-align: center;">
        <i class="fas fa-newspaper" style="font-size: 2.5rem; color: #ffc107; margin-bottom: 1rem;"></i>
        <h3 style="margin-bottom: 0.5rem;">News</h3>
        <p style="color: #666;">View department news</p>
    </a>
    
    <a href="{{ route('staff.students.index') }}" class="action-card" style="background: white; padding: 2rem; border-radius: 10px; text-decoration: none; color: #1a2b3c; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s; text-align: center;">
        <i class="fas fa-users" style="font-size: 2.5rem; color: #28a745; margin-bottom: 1rem;"></i>
        <h3 style="margin-bottom: 0.5rem;">Students</h3>
        <p style="color: #666;">View all students</p>
    </a>
    
    <a href="{{ route('staff.profile.edit') }}" class="action-card" style="background: white; padding: 2rem; border-radius: 10px; text-decoration: none; color: #1a2b3c; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s; text-align: center;">
        <i class="fas fa-user-cog" style="font-size: 2.5rem; color: #17a2b8; margin-bottom: 1rem;"></i>
        <h3 style="margin-bottom: 0.5rem;">Profile</h3>
        <p style="color: #666;">Update your profile</p>
    </a>
</div>

<!-- My Assigned Courses by Academic Year -->
<h2 style="color: #1a2b3c; margin-bottom: 1.5rem;">My Assigned Courses</h2>

@forelse($coursesByYear as $academicYear => $courses)
    <div style="margin-bottom: 3rem;">
        <!-- Academic Year Header -->
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
            <h3 style="color: #667eea; font-size: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-calendar-alt"></i>
                Academic Year: {{ $academicYear }}
            </h3>
            @if($academicYear === $currentAcademicYear)
                <span style="background: #28a745; color: white; padding: 0.3rem 1rem; border-radius: 20px; font-size: 0.9rem;">
                    Current
                </span>
            @endif
        </div>

        <!-- Courses Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem;">
            @foreach($courses as $course)
            <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 1.5rem; color: white;">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <h3 style="margin-bottom: 0.5rem;">{{ $course->course_code }}</h3>
                            <p style="opacity: 0.9;">{{ $course->course_name }}</p>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem; align-items: flex-end;">
                            <span style="background: #ffc107; color: #1a2b3c; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem;">
                                Year {{ $course->year }}
                            </span>
                            <span style="background: rgba(255,255,255,0.2); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;">
                                <i class="fas fa-tag"></i> {{ ucfirst($course->pivot->role) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div style="padding: 1.5rem;">
                    <!-- Course Stats -->
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1rem;">
                        <div style="background: #f8f9fa; padding: 0.8rem; border-radius: 8px; text-align: center;">
                            <i class="fas fa-users" style="color: #667eea;"></i>
                            <div style="font-weight: 700; font-size: 1.3rem;">{{ $course->students_count }}</div>
                            <div style="color: #666; font-size: 0.8rem;">Enrolled Students</div>
                        </div>
                        <div style="background: #f8f9fa; padding: 0.8rem; border-radius: 8px; text-align: center;">
                            <i class="fas fa-clock" style="color: #ffc107;"></i>
                            <div style="font-weight: 700; font-size: 1.3rem;">{{ $course->credit_hours }}</div>
                            <div style="color: #666; font-size: 0.8rem;">Credit Hours</div>
                        </div>
                    </div>

                    <!-- Course Details -->
                    <div style="margin-bottom: 1rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; color: #666;">
                            <i class="fas fa-calendar-alt" style="color: #667eea; width: 20px;"></i>
                            <span><strong>Semester:</strong> {{ $course->semester }}</span>
                        </div>
                    </div>

                    <!-- Course Description -->
                    <p style="color: #666; margin-bottom: 1.5rem; line-height: 1.6;">
                        {{ Str::limit($course->description ?? 'No description available.', 100) }}
                    </p>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 1rem;">
                        <a href="{{ route('staff.courses.show', $course) }}" style="flex: 1; background: #667eea; color: white; padding: 0.75rem; text-align: center; border-radius: 5px; text-decoration: none;">
                            <i class="fas fa-eye"></i> View Course
                        </a>
                        <a href="{{ route('staff.courses.students', $course) }}" style="flex: 1; background: #ffc107; color: #1a2b3c; padding: 0.75rem; text-align: center; border-radius: 5px; text-decoration: none;">
                            <i class="fas fa-users"></i> My Students
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@empty
    <div style="text-align: center; padding: 3rem; background: white; border-radius: 10px;">
        <i class="fas fa-book-open" style="font-size: 3rem; color: #6c757d; margin-bottom: 1rem;"></i>
        <p style="color: #6c757d; font-size: 1.2rem;">You haven't been assigned any courses yet.</p>
        <p style="color: #999; margin-top: 0.5rem;">Once admin assigns courses to you, they will appear here grouped by academic year.</p>
    </div>
@endforelse

<!-- Debug Section - Remove after fixing -->
@if(isset($coursesByYear) && count($coursesByYear) == 0 && isset($staff))
    <div style="background: #fff3cd; border: 1px solid #ffeeba; padding: 1.5rem; margin-top: 2rem; border-radius: 10px;">
        <h4 style="color: #856404; margin-bottom: 1rem;">Debug Information</h4>
        <p><strong>Staff Found:</strong> Yes (ID: {{ $staff->id }})</p>
        <p><strong>Email:</strong> {{ $staff->email }}</p>
        <p><strong>Courses in database:</strong> {{ \App\Models\Course::count() }}</p>
        <p><strong>Staff assignments in pivot table:</strong> 
            @php
                $pivotCount = DB::table('course_staff')->where('staff_id', $staff->id)->count();
                echo $pivotCount;
            @endphp
        </p>
        @if($pivotCount > 0)
            <p><strong>Pivot data:</strong></p>
            <ul>
                @foreach(DB::table('course_staff')->where('staff_id', $staff->id)->get() as $assignment)
                    <li>Course ID: {{ $assignment->course_id }}, Role: {{ $assignment->role }}, Academic Year: {{ $assignment->academic_year }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endif

<style>
    .action-card:hover {
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