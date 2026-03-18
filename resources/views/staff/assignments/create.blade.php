@extends('layouts.staff')

@section('title', 'Create Assignment')
@section('page-title', 'Create Assignment for ' . $course->course_code)

@section('content')
<div style="background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <form action="{{ route('staff.assignments.store', $course) }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Assignment Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required 
                   style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
            @error('title')
                <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Assignment Type</label>
            <select name="assignment_type" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                <option value="">Select Type</option>
                <option value="homework" {{ old('assignment_type') == 'homework' ? 'selected' : '' }}>Homework</option>
                <option value="quiz" {{ old('assignment_type') == 'quiz' ? 'selected' : '' }}>Quiz</option>
                <option value="project" {{ old('assignment_type') == 'project' ? 'selected' : '' }}>Project</option>
                <option value="lab" {{ old('assignment_type') == 'lab' ? 'selected' : '' }}>Lab Work</option>
                <option value="midterm" {{ old('assignment_type') == 'midterm' ? 'selected' : '' }}>Midterm Exam</option>
                <option value="final" {{ old('assignment_type') == 'final' ? 'selected' : '' }}>Final Exam</option>
            </select>
            @error('assignment_type')
                <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Due Date</label>
                <input type="date" name="due_date" value="{{ old('due_date') }}" required 
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                @error('due_date')
                    <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Total Points</label>
                <input type="number" name="total_points" value="{{ old('total_points', 100) }}" required min="1" max="100"
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                @error('total_points')
                    <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Description</label>
            <textarea name="description" rows="6" required 
                      style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">{{ old('description') }}</textarea>
            @error('description')
                <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Attachment (Optional)</label>
            <input type="file" name="file" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 5px;">
            <p style="color: #666; font-size: 0.85rem; margin-top: 0.3rem;">Max file size: 10MB</p>
            @error('file')
                <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" style="background: #28a745; color: white; padding: 0.75rem 2rem; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
                <i class="fas fa-save"></i> Create Assignment
            </button>
            <a href="{{ route('staff.courses.show', $course) }}" style="background: #6c757d; color: white; padding: 0.75rem 2rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection