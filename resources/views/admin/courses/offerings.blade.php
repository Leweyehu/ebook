@extends('layouts.admin')

@section('title', 'Course Offerings')
@section('page-title', 'Course Offerings Management')

@section('content')
<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-book" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['total_courses'] }}</h3>
        <p>Registered Courses</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #28a745 0%, #218838 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-users" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['total_students'] }}</h3>
        <p>Total Students</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: #1a2b3c; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-chalkboard-teacher" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['total_staff'] }}</h3>
        <p>Available Instructors</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-calendar-alt" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ date('Y') }}</h3>
        <p>Academic Year</p>
    </div>
</div>

<!-- Students by Year Summary -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    @foreach([1,2,3,4] as $year)
    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; text-align: center; border-left: 4px solid {{ 
        $year == 1 ? '#667eea' : 
        ($year == 2 ? '#f093fb' : 
        ($year == 3 ? '#4facfe' : '#43e97b')) 
    }};">
        <h3 style="color: #1a2b3c; margin-bottom: 0.5rem;">Year {{ $year }} Students</h3>
        <p style="font-size: 2rem; font-weight: 700; color: {{ 
            $year == 1 ? '#667eea' : 
            ($year == 2 ? '#f093fb' : 
            ($year == 3 ? '#4facfe' : '#43e97b')) 
        }};">{{ count($studentsByYear[$year]) }}</p>
        <p style="color: #666;">Available for enrollment</p>
    </div>
    @endforeach
</div>

<!-- Course Offering Form -->
<div style="background: white; border-radius: 10px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <h3 style="margin-bottom: 1.5rem; color: #1a2b3c;">Offer Course to Students</h3>
    
    <form action="{{ route('admin.courses.offer') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <!-- Left Column - Course Selection -->
            <div>
                <h4 style="margin-bottom: 1rem; color: #667eea;">1. Select Course</h4>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Year</label>
                    <select id="courseYearSelect" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">Select Year</option>
                        <option value="1">Year 1</option>
                        <option value="2">Year 2</option>
                        <option value="3">Year 3</option>
                        <option value="4">Year 4</option>
                    </select>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Semester</label>
                    <select id="semesterSelect" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">Select Semester</option>
                        <option value="Semester 1">Semester 1</option>
                        <option value="Semester 2">Semester 2</option>
                    </select>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Course</label>
                    <select name="course_id" id="courseSelect" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">First select year and semester</option>
                        @php
                            $allCourses = \App\Models\Course::all();
                        @endphp
                        @foreach($allCourses as $course)
                            <option value="{{ $course->id }}" data-year="{{ $course->year }}" data-semester="{{ $course->semester }}" style="display: none;">
                                {{ $course->course_code }} - {{ $course->course_name }} ({{ $course->credit_hours }} cr)
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <!-- Right Column - Target Students -->
            <div>
                <h4 style="margin-bottom: 1rem; color: #28a745;">2. Select Target Students</h4>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Target Student Year</label>
                    <select name="target_year" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">Select Year</option>
                        <option value="1">Year 1 Students ({{ count($studentsByYear[1]) }} available)</option>
                        <option value="2">Year 2 Students ({{ count($studentsByYear[2]) }} available)</option>
                        <option value="3">Year 3 Students ({{ count($studentsByYear[3]) }} available)</option>
                        <option value="4">Year 4 Students ({{ count($studentsByYear[4]) }} available)</option>
                    </select>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Academic Year</label>
                    <input type="text" name="academic_year" value="{{ date('Y') . '/' . (date('Y')+1) }}" required 
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                </div>
            </div>
        </div>
        
        <!-- Instructor Assignment -->
        <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e9ecef;">
            <h4 style="margin-bottom: 1rem; color: #ffc107;">3. Assign Instructors</h4>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Select Instructors</label>
                    <select name="instructors[]" multiple required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; min-height: 150px;">
                        @foreach($staff as $member)
                            <option value="{{ $member->id }}">{{ $member->name }} - {{ $member->position }}</option>
                        @endforeach
                    </select>
                    <p style="color: #666; font-size: 0.85rem; margin-top: 0.3rem;">Hold Ctrl/Cmd to select multiple</p>
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Primary Instructor</label>
                    <select name="primary_instructor" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">Select Primary Instructor</option>
                        @foreach($staff as $member)
                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Submit Button -->
        <div style="margin-top: 2rem; text-align: right;">
            <button type="submit" style="background: #28a745; color: white; padding: 0.75rem 2rem; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
                <i class="fas fa-graduation-cap"></i> Offer Course to Students
            </button>
        </div>
    </form>
</div>

<!-- Available Courses by Year and Semester -->
<h3 style="margin-bottom: 1.5rem; color: #1a2b3c;">Available Courses by Year & Semester</h3>

@foreach([1,2,3,4] as $year)
    <div style="margin-bottom: 3rem;">
        <h4 style="color: #1a2b3c; margin-bottom: 1rem; border-bottom: 2px solid #e9ecef; padding-bottom: 0.5rem;">
            Year {{ $year }} Courses
        </h4>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            @foreach(['Semester 1', 'Semester 2'] as $semester)
                <div>
                    <h5 style="color: #667eea; margin-bottom: 1rem;">{{ $semester }}</h5>
                    
                    @if(isset($coursesByYear[$year][$semester]) && count($coursesByYear[$year][$semester]) > 0)
                        <div style="background: #f8f9fa; border-radius: 8px; padding: 1rem;">
                            @foreach($coursesByYear[$year][$semester] as $course)
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem; border-bottom: 1px solid #e9ecef;">
                                    <div>
                                        <strong>{{ $course->course_code }}</strong>
                                        <p style="color: #666; font-size: 0.9rem;">{{ $course->course_name }}</p>
                                    </div>
                                    <span style="background: #28a745; color: white; padding: 0.2rem 0.5rem; border-radius: 3px; font-size: 0.8rem;">
                                        {{ $course->credit_hours }} cr
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p style="color: #999; text-align: center; padding: 2rem; background: #f8f9fa; border-radius: 8px;">
                            No courses registered for {{ $semester }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endforeach

<!-- Quick Guide -->
<div style="margin-top: 2rem; background: #f8f9fa; border-radius: 10px; padding: 1.5rem;">
    <h4 style="color: #1a2b3c; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
        <i class="fas fa-info-circle" style="color: #17a2b8;"></i>
        How to Offer Courses
    </h4>
    
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;">
        <div>
            <strong style="color: #667eea;">Step 1:</strong>
            <p style="color: #666; font-size: 0.9rem;">Select a course by year and semester</p>
        </div>
        <div>
            <strong style="color: #28a745;">Step 2:</strong>
            <p style="color: #666; font-size: 0.9rem;">Choose target student year (all students from that year will be enrolled)</p>
        </div>
        <div>
            <strong style="color: #ffc107;">Step 3:</strong>
            <p style="color: #666; font-size: 0.9rem;">Assign instructors (primary and assistants)</p>
        </div>
        <div>
            <strong style="color: #dc3545;">Step 4:</strong>
            <p style="color: #666; font-size: 0.9rem;">Click "Offer Course" to complete</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const yearSelect = document.getElementById('courseYearSelect');
    const semesterSelect = document.getElementById('semesterSelect');
    const courseSelect = document.getElementById('courseSelect');
    const allOptions = Array.from(courseSelect.options).slice(1); // Skip the first option
    
    function filterCourses() {
        const selectedYear = yearSelect.value;
        const selectedSemester = semesterSelect.value;
        
        // Hide all options first
        allOptions.forEach(option => {
            option.style.display = 'none';
        });
        
        if (selectedYear && selectedSemester) {
            // Show matching options
            const matchingOptions = allOptions.filter(option => 
                option.dataset.year === selectedYear && 
                option.dataset.semester === selectedSemester
            );
            
            matchingOptions.forEach(option => {
                option.style.display = 'block';
            });
            
            if (matchingOptions.length > 0) {
                courseSelect.value = matchingOptions[0].value;
                courseSelect.disabled = false;
            } else {
                courseSelect.value = '';
                courseSelect.disabled = true;
            }
        } else {
            courseSelect.value = '';
            courseSelect.disabled = true;
        }
    }
    
    yearSelect.addEventListener('change', filterCourses);
    semesterSelect.addEventListener('change', filterCourses);
    
    // Initial filter
    filterCourses();
});
</script>

<style>
    /* Hover effects */
    [style*="border-radius: 5px"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        transition: all 0.2s ease;
    }
    
    @media (max-width: 768px) {
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        [style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection