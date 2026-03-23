@extends('layouts.admin')

@section('title', 'Add New Course')
@section('page-title', 'Add New Course')

@section('content')
<div style="margin-bottom: 1rem;">
    <a href="{{ route('admin.courses.index') }}" style="background: #6c757d; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Back to Courses
    </a>
</div>

<div style="background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <!-- Left Column -->
            <div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Course Code *</label>
                    <input type="text" name="course_code" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Course Name *</label>
                    <input type="text" name="course_name" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Credit Hours *</label>
                    <select name="credit_hours" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">Select Credit Hours</option>
                        <option value="1">1 Credit</option>
                        <option value="2">2 Credits</option>
                        <option value="3">3 Credits</option>
                        <option value="4">4 Credits</option>
                        <option value="5">5 Credits</option>
                        <option value="6">6 Credits</option>
                    </select>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Year Level *</label>
                    <select name="year_level" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">Select Year</option>
                        <option value="1">Year 1</option>
                        <option value="2">Year 2</option>
                        <option value="3">Year 3</option>
                        <option value="4">Year 4</option>
                    </select>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Semester *</label>
                    <select name="semester" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">Select Semester</option>
                        <option value="1">Semester 1</option>
                        <option value="2">Semester 2</option>
                    </select>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Instructor</label>
                    <input type="text" name="instructor" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                </div>
            </div>
            
            <!-- Right Column -->
            <div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Capacity</label>
                    <input type="number" name="capacity" value="60" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Status *</label>
                    <select name="status" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="checkbox" name="is_elective" value="1">
                        <span>This is an Elective Course</span>
                    </label>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Prerequisites</label>
                    <input type="text" name="prerequisites" placeholder="e.g., CS101" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Featured Image</label>
                    <input type="file" name="featured_image" accept="image/*" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                    <small style="color: #6c757d;">JPG, PNG (Max 2MB)</small>
                </div>
            </div>
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Description *</label>
            <textarea name="description" rows="4" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;"></textarea>
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Course Objectives</label>
            <textarea name="objectives" rows="3" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;"></textarea>
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Syllabus</label>
            <textarea name="syllabus" rows="3" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;"></textarea>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" style="background: #28a745; color: white; padding: 0.8rem 2rem; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;">
                <i class="fas fa-save"></i> Save Course
            </button>
            <a href="{{ route('admin.courses.index') }}" style="background: #6c757d; color: white; padding: 0.8rem 2rem; border-radius: 5px; text-decoration: none;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection