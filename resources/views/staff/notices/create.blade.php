@extends('layouts.staff')

@section('title', 'Post Notice')
@section('page-title', 'Post Notice for ' . $course->course_code)

@section('content')
<div style="background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <form action="{{ route('staff.notices.store', $course) }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Notice Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required 
                   style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
            @error('title')
                <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Priority</label>
                <select name="priority" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="normal" {{ old('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                    <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                </select>
                @error('priority')
                    <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Expires At (Optional)</label>
                <input type="date" name="expires_at" value="{{ old('expires_at') }}" 
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                @error('expires_at')
                    <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Notice Content</label>
            <textarea name="content" rows="8" required 
                      style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">{{ old('content') }}</textarea>
            @error('content')
                <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Attachment (Optional)</label>
            <input type="file" name="attachment" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 5px;">
            <p style="color: #666; font-size: 0.85rem; margin-top: 0.3rem;">Max file size: 10MB</p>
            @error('attachment')
                <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" style="background: #28a745; color: white; padding: 0.75rem 2rem; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
                <i class="fas fa-paper-plane"></i> Post Notice
            </button>
            <a href="{{ route('staff.courses.show', $course) }}" style="background: #6c757d; color: white; padding: 0.75rem 2rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection