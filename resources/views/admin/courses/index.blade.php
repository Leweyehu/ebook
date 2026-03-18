@extends('layouts.admin')

@section('title', 'Course Management')
@section('page-title', 'Course Management')

@section('content')
<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-book" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['total'] ?? 0 }}</h3>
        <p>Total Courses</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #28a745 0%, #218838 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-check-circle" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['active'] ?? 0 }}</h3>
        <p>Active Courses</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: #1a2b3c; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-users" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">
            @php
                $totalStudents = \App\Models\Student::count();
            @endphp
            {{ $totalStudents }}
        </h3>
        <p>Total Students</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-calendar-alt" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ date('Y') }}</h3>
        <p>Academic Year</p>
    </div>
</div>

<!-- Students by Year Summary -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    @php
        $studentsByYear = [
            1 => \App\Models\Student::where('year', 1)->count(),
            2 => \App\Models\Student::where('year', 2)->count(),
            3 => \App\Models\Student::where('year', 3)->count(),
            4 => \App\Models\Student::where('year', 4)->count(),
        ];
    @endphp
    
    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; text-align: center; border-left: 4px solid #667eea;">
        <h3 style="color: #1a2b3c; margin-bottom: 0.5rem;">Year 1 Students</h3>
        <p style="font-size: 1.8rem; font-weight: 700; color: #667eea;">{{ $studentsByYear[1] }}</p>
        <p style="color: #666;">Available for enrollment</p>
    </div>
    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; text-align: center; border-left: 4px solid #f093fb;">
        <h3 style="color: #1a2b3c; margin-bottom: 0.5rem;">Year 2 Students</h3>
        <p style="font-size: 1.8rem; font-weight: 700; color: #f093fb;">{{ $studentsByYear[2] }}</p>
        <p style="color: #666;">Available for enrollment</p>
    </div>
    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; text-align: center; border-left: 4px solid #4facfe;">
        <h3 style="color: #1a2b3c; margin-bottom: 0.5rem;">Year 3 Students</h3>
        <p style="font-size: 1.8rem; font-weight: 700; color: #4facfe;">{{ $studentsByYear[3] }}</p>
        <p style="color: #666;">Available for enrollment</p>
    </div>
    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; text-align: center; border-left: 4px solid #43e97b;">
        <h3 style="color: #1a2b3c; margin-bottom: 0.5rem;">Year 4 Students</h3>
        <p style="font-size: 1.8rem; font-weight: 700; color: #43e97b;">{{ $studentsByYear[4] }}</p>
        <p style="color: #666;">Available for enrollment</p>
    </div>
</div>

<!-- Courses by Year Summary -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; text-align: center; border-left: 4px solid #667eea;">
        <h3 style="color: #1a2b3c; margin-bottom: 0.5rem;">Year 1 Courses</h3>
        <p style="font-size: 1.8rem; font-weight: 700; color: #667eea;">{{ $stats['by_year']['year1'] ?? 0 }}</p>
        <p style="color: #666;">Courses</p>
    </div>
    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; text-align: center; border-left: 4px solid #f093fb;">
        <h3 style="color: #1a2b3c; margin-bottom: 0.5rem;">Year 2 Courses</h3>
        <p style="font-size: 1.8rem; font-weight: 700; color: #f093fb;">{{ $stats['by_year']['year2'] ?? 0 }}</p>
        <p style="color: #666;">Courses</p>
    </div>
    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; text-align: center; border-left: 4px solid #4facfe;">
        <h3 style="color: #1a2b3c; margin-bottom: 0.5rem;">Year 3 Courses</h3>
        <p style="font-size: 1.8rem; font-weight: 700; color: #4facfe;">{{ $stats['by_year']['year3'] ?? 0 }}</p>
        <p style="color: #666;">Courses</p>
    </div>
    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; text-align: center; border-left: 4px solid #43e97b;">
        <h3 style="color: #1a2b3c; margin-bottom: 0.5rem;">Year 4 Courses</h3>
        <p style="font-size: 1.8rem; font-weight: 700; color: #43e97b;">{{ $stats['by_year']['year4'] ?? 0 }}</p>
        <p style="color: #666;">Courses</p>
    </div>
</div>

<!-- Page Header -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h2 style="color: #1a2b3c; margin-bottom: 0.5rem;">Course Management</h2>
        <p style="color: #666;">Register new courses, assign instructors, and enroll students by year</p>
    </div>
    
    <div style="display: flex; gap: 1rem;">
        <a href="{{ route('admin.courses.create') }}" style="background: #28a745; color: white; padding: 0.75rem 1.5rem; border-radius: 5px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-plus"></i> Register New Course
        </a>
    </div>
</div>

<!-- Courses Table -->
<div style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead style="background: #1a2b3c; color: white;">
            <tr>
                <th style="padding: 1rem; text-align: left;">Code</th>
                <th style="padding: 1rem; text-align: left;">Course Name</th>
                <th style="padding: 1rem; text-align: left;">Year</th>
                <th style="padding: 1rem; text-align: left;">Semester</th>
                <th style="padding: 1rem; text-align: left;">Credit Hrs</th>
                <th style="padding: 1rem; text-align: left;">Instructors</th>
                <th style="padding: 1rem; text-align: left;">Students</th>
                <th style="padding: 1rem; text-align: left;">Status</th>
                <th style="padding: 1rem; text-align: left;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses as $course)
            <tr style="border-bottom: 1px solid #e9ecef;">
                <td style="padding: 1rem; font-weight: 600;">{{ $course->course_code }}</td>
                <td style="padding: 1rem;">{{ $course->course_name }}</td>
                <td style="padding: 1rem;">Year {{ $course->year }}</td>
                <td style="padding: 1rem;">{{ $course->semester }}</td>
                <td style="padding: 1rem;">{{ $course->credit_hours }}</td>
                <td style="padding: 1rem;">
                    @forelse($course->instructors as $instructor)
                        <span style="background: #e9ecef; padding: 0.25rem 0.5rem; border-radius: 3px; font-size: 0.8rem; display: inline-block; margin: 0.2rem;">
                            {{ Str::limit($instructor->name, 15) }}
                            @if($instructor->pivot->role === 'primary')
                                <span style="color: #ffc107; font-weight: bold;">(P)</span>
                            @endif
                        </span>
                    @empty
                        <span style="color: #dc3545; font-size: 0.85rem;">No instructors</span>
                    @endforelse
                </td>
                <td style="padding: 1rem;">
                    <span style="background: #28a745; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                        {{ $course->students()->count() }} Enrolled
                    </span>
                </td>
                <td style="padding: 1rem;">
                    <span style="background: {{ $course->is_active ? '#28a745' : '#dc3545' }}; color: white; padding: 0.25rem 0.75rem; border-radius: 3px; font-size: 0.85rem;">
                        {{ $course->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td style="padding: 1rem;">
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <a href="{{ route('admin.courses.show', $course) }}" style="background: #17a2b8; color: white; padding: 0.4rem 0.8rem; border-radius: 5px; text-decoration: none; font-size: 0.8rem;" title="View Course Details">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.courses.edit', $course) }}" style="background: #ffc107; color: #1a2b3c; padding: 0.4rem 0.8rem; border-radius: 5px; text-decoration: none; font-size: 0.8rem;" title="Edit Course">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('admin.courses.assign', $course) }}" style="background: #28a745; color: white; padding: 0.4rem 0.8rem; border-radius: 5px; text-decoration: none; font-size: 0.8rem;" title="Assign Instructors & Students by Year">
                            <i class="fas fa-user-plus"></i>
                        </a>
                        <a href="{{ route('admin.courses.manage-students', $course) }}" style="background: #6610f2; color: white; padding: 0.4rem 0.8rem; border-radius: 5px; text-decoration: none; font-size: 0.8rem;" title="Manage Individual Students">
                            <i class="fas fa-users"></i>
                        </a>
                        <form action="{{ route('admin.courses.toggle-status', $course) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" style="background: {{ $course->is_active ? '#dc3545' : '#28a745' }}; color: white; border: none; padding: 0.4rem 0.8rem; border-radius: 5px; cursor: pointer; font-size: 0.8rem;" title="{{ $course->is_active ? 'Deactivate Course' : 'Activate Course' }}">
                                <i class="fas fa-{{ $course->is_active ? 'ban' : 'check' }}"></i>
                            </button>
                        </form>
                        
                        <!-- DELETE COURSE BUTTON -->
                        <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" style="display: inline;" onsubmit="return confirm('⚠️ Are you sure you want to delete this course? This action cannot be undone and will remove all associated data (enrollments, assignments, materials, etc.).');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: #dc3545; color: white; border: none; padding: 0.4rem 0.8rem; border-radius: 5px; cursor: pointer; font-size: 0.8rem;" title="Delete Course Permanently">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="padding: 3rem; text-align: center; color: #6c757d;">
                    <i class="fas fa-book" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                    <p style="font-size: 1.1rem;">No courses found. Register your first course!</p>
                    <a href="{{ route('admin.courses.create') }}" style="display: inline-block; margin-top: 1rem; background: #28a745; color: white; padding: 0.75rem 2rem; border-radius: 5px; text-decoration: none;">
                        <i class="fas fa-plus"></i> Register New Course
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div style="margin-top: 2rem;">
    {{ $courses->links() }}
</div>

<!-- Quick Guide Card -->
<div style="margin-top: 2rem; background: #f8f9fa; border-radius: 10px; padding: 1.5rem; border: 1px solid #e9ecef;">
    <h4 style="color: #1a2b3c; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
        <i class="fas fa-info-circle" style="color: #17a2b8;"></i>
        Quick Guide: Course Management
    </h4>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
        <div>
            <strong style="color: #28a745;">1. Register Course</strong>
            <p style="color: #666; font-size: 0.9rem; margin-top: 0.3rem;">Create a new course with code, name, credit hours, and specify which year it belongs to.</p>
        </div>
        <div>
            <strong style="color: #17a2b8;">2. Assign Instructors</strong>
            <p style="color: #666; font-size: 0.9rem; margin-top: 0.3rem;">Select primary and assistant instructors for the course.</p>
        </div>
        <div>
            <strong style="color: #ffc107;">3. Select Student Years</strong>
            <p style="color: #666; font-size: 0.9rem; margin-top: 0.3rem;">Choose which year(s) of students should be enrolled (automatically enrolls all students from selected years).</p>
        </div>
        <div>
            <strong style="color: #6610f2;">4. Manage Enrollments</strong>
            <p style="color: #666; font-size: 0.9rem; margin-top: 0.3rem;">Fine-tune student enrollments, remove or add individual students as needed.</p>
        </div>
    </div>
</div>

<style>
    /* Hover effects for action buttons */
    a[style*="border-radius: 5px"]:hover,
    button[style*="border-radius: 5px"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        transition: all 0.2s ease;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        table {
            font-size: 0.9rem;
        }
        
        td, th {
            padding: 0.75rem !important;
        }
    }
    
    @media (max-width: 480px) {
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection