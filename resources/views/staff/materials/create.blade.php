@extends('layouts.staff')

@section('title', 'Upload Material')
@section('page-title', 'Upload Course Material for ' . $course->course_code)

@section('content')
<div style="background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <form action="{{ route('staff.materials.store', $course) }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Material Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required 
                   style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
            @error('title')
                <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Material Type</label>
            <select name="material_type" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                <option value="">Select Type</option>
                <option value="lecture_note" {{ old('material_type') == 'lecture_note' ? 'selected' : '' }}>Lecture Note</option>
                <option value="slide" {{ old('material_type') == 'slide' ? 'selected' : '' }}>Slide Presentation</option>
                <option value="tutorial" {{ old('material_type') == 'tutorial' ? 'selected' : '' }}>Tutorial</option>
                <option value="reference" {{ old('material_type') == 'reference' ? 'selected' : '' }}>Reference Material</option>
                <option value="lab_manual" {{ old('material_type') == 'lab_manual' ? 'selected' : '' }}>Lab Manual</option>
                <option value="other" {{ old('material_type') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('material_type')
                <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Description (Optional)</label>
            <textarea name="description" rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">{{ old('description') }}</textarea>
            @error('description')
                <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Upload File</label>
            <input type="file" name="file" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 5px;">
            <p style="color: #666; font-size: 0.85rem; margin-top: 0.3rem;">Max file size: 20MB. Supported formats: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, etc.</p>
            @error('file')
                <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" style="background: #28a745; color: white; padding: 0.75rem 2rem; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
                <i class="fas fa-upload"></i> Upload Material
            </button>
            <a href="{{ route('staff.courses.show', $course) }}" style="background: #6c757d; color: white; padding: 0.75rem 2rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection