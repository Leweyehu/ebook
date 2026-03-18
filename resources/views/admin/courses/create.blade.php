@extends('layouts.admin')

@section('title', 'Create Course')
@section('page-title', 'Create New Course')

@section('content')
<div style="background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <form action="{{ route('admin.courses.store') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Course Code</label>
                <input type="text" name="course_code" value="{{ old('course_code') }}" required 
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                @error('course_code')
                    <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Course Name</label>
                <input type="text" name="course_name" value="{{ old('course_name') }}" required 
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                @error('course_name')
                    <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Description</label>
            <textarea name="description" rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">{{ old('description') }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Credit Hours</label>
                <input type="number" name="credit_hours" value="{{ old('credit_hours', 3) }}" required min="1" max="10"
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">ECTS</label>
                <input type="number" name="ects" value="{{ old('ects', 5) }}" min="1" max="30"
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Year</label>
                <select name="year" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                    <option value="1">Year 1</option>
                    <option value="2">Year 2</option>
                    <option value="3">Year 3</option>
                    <option value="4">Year 4</option>
                </select>
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Semester</label>
                <select name="semester" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                    <option value="Semester 1">Semester 1</option>
                    <option value="Semester 2">Semester 2</option>
                </select>
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Status</label>
            <select name="status" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Select Instructors</label>
            <select name="instructors[]" multiple required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; min-height: 150px;">
                @foreach($staff as $member)
                    <option value="{{ $member->id }}">{{ $member->name }} - {{ $member->position }}</option>
                @endforeach
            </select>
            <p style="color: #666; font-size: 0.85rem; margin-top: 0.3rem;">Hold Ctrl/Cmd to select multiple instructors</p>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Primary Instructor</label>
            <select name="primary_instructor" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                <option value="">Select Primary Instructor</option>
                @foreach($staff as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" style="background: #28a745; color: white; padding: 0.75rem 2rem; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
                <i class="fas fa-save"></i> Create Course
            </button>
            <a href="{{ route('admin.courses.index') }}" style="background: #6c757d; color: white; padding: 0.75rem 2rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection