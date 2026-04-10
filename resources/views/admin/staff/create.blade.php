@extends('layouts.admin')

@section('title', 'Add New Staff')
@section('page-title', 'Add New Staff Member')

@section('content')
<div class="container">
    <!-- Form Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <h2 style="color: #1a2b3c; margin: 0;">Add New Staff Member</h2>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('admin.staff.index') }}" style="background: #ffc107; color: #1a2b3c; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-arrow-left"></i> Back to Staff List
            </a>
        </div>
    </div>

    <!-- Create Form -->
    <div style="background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <form method="POST" action="{{ route('admin.staff.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Full Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                    @error('name')
                        <p style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Position/Title *</label>
                    <input type="text" name="position" value="{{ old('position') }}" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                    @error('position')
                        <p style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Department *</label>
                    <select name="department" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">Select Department</option>
                        <option value="Computer Science" {{ old('department') == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                        <option value="Information Technology" {{ old('department') == 'Information Technology' ? 'selected' : '' }}>Information Technology</option>
                        <option value="Software Engineering" {{ old('department') == 'Software Engineering' ? 'selected' : '' }}>Software Engineering</option>
                        <option value="Data Science" {{ old('department') == 'Data Science' ? 'selected' : '' }}>Data Science</option>
                    </select>
                    @error('department')
                        <p style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                    @error('email')
                        <p style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                    @error('phone')
                        <p style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Qualification</label>
                    <input type="text" name="qualification" value="{{ old('qualification') }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                    @error('qualification')
                        <p style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Join Date</label>
                    <input type="date" name="join_date" value="{{ old('join_date') }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                    @error('join_date')
                        <p style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Profile Image</label>
                    <input type="file" name="profile_image" accept="image/*" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                    @error('profile_image')
                        <p style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Biography/Bio</label>
                <textarea name="bio" rows="5" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">{{ old('bio') }}</textarea>
                @error('bio')
                    <p style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>
            
            <div style="margin-bottom: 2rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                    <span style="font-weight: 600;">Active (visible on website)</span>
                </label>
            </div>
            
            <div style="display: flex; gap: 1rem;">
                <button type="submit" style="background: #28a745; color: white; padding: 1rem 2rem; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-save"></i> Create Staff Member
                </button>
                <a href="{{ route('admin.staff.index') }}" style="background: #6c757d; color: white; padding: 1rem 2rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection