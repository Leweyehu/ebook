@extends('layouts.staff')

@section('title', 'My Courses')
@section('page-title', 'My Assigned Courses')

@section('content')
@php
    $currentAcademicYear = date('Y') . '/' . (date('Y')+1);
@endphp

@forelse($courses as $academicYear => $yearCourses)
    <div style="margin-bottom: 3rem;">
        <!-- Academic Year Header -->
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
            <h2 style="color: #1a2b3c; font-size: 1.8rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-calendar-alt" style="color: #667eea;"></i>
                Academic Year: {{ $academicYear }}
            </h2>
            @if($academicYear === $currentAcademicYear)
                <span style="background: #28a745; color: white; padding: 0.3rem 1rem; border-radius: 20px; font-size: 0.9rem; font-weight: 600;">
                    <i class="fas fa-check-circle"></i> Current
                </span>
            @endif
        </div>

        <!-- Courses Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 2rem;">
            @foreach($yearCourses as $course)
            <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s, box-shadow 0.3s;">
                <!-- Course Header -->
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 1.5rem; color: white;">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <h3 style="margin-bottom: 0.5rem; font-size: 1.3rem;">{{ $course->course_code }}</h3>
                            <p style="opacity: 0.9; font-size: 0.95rem;">{{ $course->course_name }}</p>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem; align-items: flex-end;">
                            <span style="background: #ffc107; color: #1a2b3c; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                Year {{ $course->year }}
                            </span>
                            <span style="background: rgba(255,255,255,0.2); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                <i class="fas fa-tag"></i> {{ ucfirst($course->pivot->role) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Course Body -->
                <div style="padding: 1.5rem;">
                    <!-- Course Stats -->
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1rem;">
                        <div style="background: #f8f9fa; padding: 0.8rem; border-radius: 8px; text-align: center;">
                            <i class="fas fa-users" style="color: #667eea; font-size: 1.2rem;"></i>
                            <div style="font-weight: 700; font-size: 1.3rem; margin-top: 0.3rem;">{{ $course->students_count }}</div>
                            <div style="color: #666; font-size: 0.8rem;">Enrolled Students</div>
                        </div>
                        <div style="background: #f8f9fa; padding: 0.8rem; border-radius: 8px; text-align: center;">
                            <i class="fas fa-clock" style="color: #ffc107; font-size: 1.2rem;"></i>
                            <div style="font-weight: 700; font-size: 1.3rem; margin-top: 0.3rem;">{{ $course->credit_hours }}</div>
                            <div style="color: #666; font-size: 0.8rem;">Credit Hours</div>
                        </div>
                    </div>

                    <!-- Course Details -->
                    <div style="margin-bottom: 1rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; color: #666;">
                            <i class="fas fa-calendar-alt" style="color: #667eea; width: 20px;"></i>
                            <span><strong>Semester:</strong> {{ $course->semester }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; color: #666;">
                            <i class="fas fa-layer-group" style="color: #4facfe; width: 20px;"></i>
                            <span><strong>Academic Year:</strong> {{ $academicYear }}</span>
                        </div>
                    </div>

                    <!-- Course Description -->
                    <p style="color: #666; margin-bottom: 1.5rem; line-height: 1.6;">
                        {{ Str::limit($course->description ?? 'No description available.', 100) }}
                    </p>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 1rem;">
                        <a href="{{ route('staff.courses.show', $course) }}" 
                           style="flex: 1; background: #667eea; color: white; padding: 0.8rem; text-align: center; border-radius: 5px; text-decoration: none; font-weight: 500; transition: all 0.3s;"
                           onmouseover="this.style.background='#5a67d8'; this.style.transform='translateY(-2px)';"
                           onmouseout="this.style.background='#667eea'; this.style.transform='translateY(0)';">
                            <i class="fas fa-eye"></i> View Course
                        </a>
                        <a href="{{ route('staff.courses.students', $course) }}" 
                           style="flex: 1; background: #ffc107; color: #1a2b3c; padding: 0.8rem; text-align: center; border-radius: 5px; text-decoration: none; font-weight: 500; transition: all 0.3s;"
                           onmouseover="this.style.background='#ffca2c'; this.style.transform='translateY(-2px)';"
                           onmouseout="this.style.background='#ffc107'; this.style.transform='translateY(0)';">
                            <i class="fas fa-users"></i> My Students
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@empty
    <!-- Empty State -->
    <div style="text-align: center; padding: 4rem; background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div style="font-size: 5rem; color: #e9ecef; margin-bottom: 1rem;">
            <i class="fas fa-book-open"></i>
        </div>
        <h3 style="color: #1a2b3c; font-size: 1.8rem; margin-bottom: 1rem;">No Courses Assigned</h3>
        <p style="color: #6c757d; font-size: 1.1rem; max-width: 500px; margin: 0 auto 2rem;">
            You haven't been assigned any courses yet. Once the administrator assigns courses to you, they will appear here grouped by academic year.
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <a href="{{ route('staff.dashboard') }}" style="background: #667eea; color: white; padding: 0.75rem 2rem; border-radius: 5px; text-decoration: none; font-weight: 500;">
                <i class="fas fa-tachometer-alt"></i> Go to Dashboard
            </a>
            <a href="{{ route('staff.profile.edit') }}" style="background: #ffc107; color: #1a2b3c; padding: 0.75rem 2rem; border-radius: 5px; text-decoration: none; font-weight: 500;">
                <i class="fas fa-user-edit"></i> Edit Profile
            </a>
        </div>
    </div>
@endforelse

<style>
    /* Hover effect for course cards */
    [style*="border-radius: 15px"]:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        [style*="grid-template-columns: repeat(auto-fill, minmax(380px, 1fr))"] {
            grid-template-columns: 1fr !important;
        }
        
        h2 {
            font-size: 1.5rem !important;
        }
    }
</style>
@endsection