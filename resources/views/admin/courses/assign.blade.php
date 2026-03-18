@extends('layouts.admin')

@section('title', 'Assign Course')
@section('page-title', 'Assign: ' . $course->course_code . ' - ' . $course->course_name)

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('admin.courses.index') }}" style="background: #6c757d; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Back to Courses
    </a>
</div>

<div style="background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <h3 style="margin-bottom: 2rem; color: #1a2b3c;">Assign Instructors & Students to Course</h3>
    
    <form action="{{ route('admin.courses.assign.store', $course) }}" method="POST">
        @csrf
        
        <!-- Course Info -->
        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
            <h4 style="margin-bottom: 1rem; color: #1a2b3c;">Course Information</h4>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;">
                <div>
                    <strong>Course Code:</strong>
                    <p>{{ $course->course_code }}</p>
                </div>
                <div>
                    <strong>Course Name:</strong>
                    <p>{{ $course->course_name }}</p>
                </div>
                <div>
                    <strong>Year:</strong>
                    <p>{{ $course->year }}</p>
                </div>
                <div>
                    <strong>Semester:</strong>
                    <p>{{ $course->semester }}</p>
                </div>
            </div>
        </div>
        
        <!-- Academic Year -->
        <div style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Academic Year</label>
            <input type="text" name="academic_year" value="{{ date('Y') . '/' . (date('Y')+1) }}" required 
                   style="width: 300px; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
            <p style="color: #666; font-size: 0.85rem; margin-top: 0.3rem;">Format: YYYY/YYYY (e.g., 2025/2026)</p>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <!-- Left Column - Instructors -->
            <div style="border-right: 1px solid #e9ecef; padding-right: 2rem;">
                <h4 style="margin-bottom: 1.5rem; color: #1a2b3c;">1. Select Instructors</h4>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Primary Instructor</label>
                    <select name="primary_instructor" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">Select Primary Instructor</option>
                        @foreach($staff as $member)
                            <option value="{{ $member->id }}" {{ in_array($member->id, $assignedInstructors) ? 'selected' : '' }}>
                                {{ $member->name }} - {{ $member->position }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Additional Instructors (Assistant/Guest)</label>
                    <select name="instructors[]" multiple style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; min-height: 200px;">
                        @foreach($staff as $member)
                            <option value="{{ $member->id }}" {{ in_array($member->id, $assignedInstructors) ? 'selected' : '' }}>
                                {{ $member->name }} - {{ $member->position }}
                            </option>
                        @endforeach
                    </select>
                    <p style="color: #666; font-size: 0.85rem; margin-top: 0.3rem;">Hold Ctrl/Cmd to select multiple instructors</p>
                </div>
            </div>
            
            <!-- Right Column - Students by Year (From Bulk Upload) -->
            <div>
                <h4 style="margin-bottom: 1.5rem; color: #1a2b3c;">2. Select Students by Year</h4>
                <p style="margin-bottom: 1rem; color: #666;">Students uploaded via bulk upload are shown below by their year:</p>
                
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 2rem;">
                    @php
                        $year1Students = \App\Models\Student::where('year', 1)->count();
                        $year2Students = \App\Models\Student::where('year', 2)->count();
                        $year3Students = \App\Models\Student::where('year', 3)->count();
                        $year4Students = \App\Models\Student::where('year', 4)->count();
                    @endphp
                    
                    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; border-left: 4px solid #667eea;">
                        <label style="display: flex; align-items: center; gap: 0.5rem;">
                            <input type="checkbox" name="student_years[]" value="1" {{ $course->year == 1 ? 'checked' : '' }}>
                            <span><strong>Year 1 Students</strong></span>
                        </label>
                        <div style="display: flex; justify-content: space-between; margin-top: 0.5rem;">
                            <span style="color: #666;">{{ $year1Students }} students</span>
                            @if($year1Students > 0)
                                <span style="color: #28a745; font-size: 0.8rem;">
                                    <i class="fas fa-check-circle"></i> Available
                                </span>
                            @else
                                <span style="color: #dc3545; font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle"></i> No students
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; border-left: 4px solid #f093fb;">
                        <label style="display: flex; align-items: center; gap: 0.5rem;">
                            <input type="checkbox" name="student_years[]" value="2" {{ $course->year == 2 ? 'checked' : '' }}>
                            <span><strong>Year 2 Students</strong></span>
                        </label>
                        <div style="display: flex; justify-content: space-between; margin-top: 0.5rem;">
                            <span style="color: #666;">{{ $year2Students }} students</span>
                            @if($year2Students > 0)
                                <span style="color: #28a745; font-size: 0.8rem;">
                                    <i class="fas fa-check-circle"></i> Available
                                </span>
                            @else
                                <span style="color: #dc3545; font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle"></i> No students
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; border-left: 4px solid #4facfe;">
                        <label style="display: flex; align-items: center; gap: 0.5rem;">
                            <input type="checkbox" name="student_years[]" value="3" {{ $course->year == 3 ? 'checked' : '' }}>
                            <span><strong>Year 3 Students</strong></span>
                        </label>
                        <div style="display: flex; justify-content: space-between; margin-top: 0.5rem;">
                            <span style="color: #666;">{{ $year3Students }} students</span>
                            @if($year3Students > 0)
                                <span style="color: #28a745; font-size: 0.8rem;">
                                    <i class="fas fa-check-circle"></i> Available
                                </span>
                            @else
                                <span style="color: #dc3545; font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle"></i> No students
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; border-left: 4px solid #43e97b;">
                        <label style="display: flex; align-items: center; gap: 0.5rem;">
                            <input type="checkbox" name="student_years[]" value="4" {{ $course->year == 4 ? 'checked' : '' }}>
                            <span><strong>Year 4 Students</strong></span>
                        </label>
                        <div style="display: flex; justify-content: space-between; margin-top: 0.5rem;">
                            <span style="color: #666;">{{ $year4Students }} students</span>
                            @if($year4Students > 0)
                                <span style="color: #28a745; font-size: 0.8rem;">
                                    <i class="fas fa-check-circle"></i> Available
                                </span>
                            @else
                                <span style="color: #dc3545; font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle"></i> No students
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Summary of Selected Years -->
                <div style="background: #e3f2fd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                    <h5 style="margin-bottom: 0.5rem; color: #1a2b3c;">Enrollment Summary</h5>
                    <p style="color: #666; font-size: 0.9rem;">
                        <i class="fas fa-info-circle" style="color: #17a2b8;"></i>
                        When you select a year, <strong>ALL students</strong> from that year will be automatically enrolled in this course.
                    </p>
                    <p style="color: #666; font-size: 0.9rem;">
                        Total students available across all years: 
                        <strong>{{ $year1Students + $year2Students + $year3Students + $year4Students }}</strong>
                    </p>
                </div>
            </div>
        </div>
        
        <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e9ecef; display: flex; gap: 1rem;">
            <button type="submit" style="background: #28a745; color: white; padding: 0.75rem 2rem; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
                <i class="fas fa-save"></i> Save Assignments
            </button>
            <a href="{{ route('admin.courses.index') }}" style="background: #6c757d; color: white; padding: 0.75rem 2rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection