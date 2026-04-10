@extends('layouts.admin')

@section('title', 'Add Course')
@section('page-title', 'Add New Course')

@section('content')
<div style="margin-bottom: 1rem;">
    <a href="{{ route('admin.course-structure.index') }}" style="background: #6c757d; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Back to Course Structure
    </a>
</div>

<div style="background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <form action="{{ route('admin.course-structure.store') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Year *</label>
                <select name="year" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                    <option value="">Select Year</option>
                    <option value="1">Year 1</option>
                    <option value="2">Year 2</option>
                    <option value="3">Year 3</option>
                    <option value="4">Year 4</option>
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Semester *</label>
                <select name="semester" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                    <option value="">Select Semester</option>
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                </select>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Course Code *</label>
                <input type="text" name="course_code" required placeholder="e.g., MATH1011" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Course Name *</label>
                <input type="text" name="course_name" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">ECTS Credits *</label>
                <input type="number" name="ects" required min="1" max="10" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Credit Hours *</label>
                <input type="number" name="credit_hours" required min="1" max="6" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
            </div>
        </div>
        
        <div style="margin-top: 1rem;">
            <label style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="checkbox" name="is_elective" value="1">
                <span>This is an Elective Course</span>
            </label>
        </div>
        
        <div style="margin-top: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Description (Optional)</label>
            <textarea name="description" rows="3" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;"></textarea>
        </div>
        
        <div style="margin-top: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Display Order</label>
            <input type="number" name="order" value="0" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
            <small style="color: #6c757d;">Lower numbers appear first</small>
        </div>
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" style="background: #28a745; color: white; padding: 0.8rem 2rem; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;">
                <i class="fas fa-save"></i> Save Course
            </button>
            <a href="{{ route('admin.course-structure.index') }}" style="background: #6c757d; color: white; padding: 0.8rem 2rem; border-radius: 5px; text-decoration: none;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection