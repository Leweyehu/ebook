{{-- staff/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Staff')
@section('page-title', 'Edit Staff Member')

@section('content')
<div class="container">
    <!-- Form Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <h2 style="color: #1a2b3c; margin: 0;">Edit Staff Member: {{ $staff->name }}</h2>
        <a href="{{ route('admin.staff.index') }}" style="background: #6c757d; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-arrow-left"></i> Back to Staff List
        </a>
    </div>

    <!-- Staff Edit Form -->
    <div style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); padding: 2rem;">
        <form method="POST" action="{{ route('admin.staff.update', $staff) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                <!-- Name -->
                <div>
                    <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">Full Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $staff->name) }}" required 
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem;">
                    @error('name')
                        <p style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">Email Address *</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $staff->email) }}" required 
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem;">
                    @error('email')
                        <p style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $staff->phone) }}" 
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem;">
                    @error('phone')
                        <p style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Position -->
                <div>
                    <label for="position" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">Position *</label>
                    <input type="text" name="position" id="position" value="{{ old('position', $staff->position) }}" required 
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem;">
                    @error('position')
                        <p style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Department -->
                <div>
                    <label for="department" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">Department *</label>
                    <select name="department" id="department" required 
                            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem;">
                        <option value="">Select Department</option>
                        <option value="Computer Science" {{ old('department', $staff->department) == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                        <option value="Information Technology" {{ old('department', $staff->department) == 'Information Technology' ? 'selected' : '' }}>Information Technology</option>
                        <option value="Software Engineering" {{ old('department', $staff->department) == 'Software Engineering' ? 'selected' : '' }}>Software Engineering</option>
                        <option value="Data Science" {{ old('department', $staff->department) == 'Data Science' ? 'selected' : '' }}>Data Science</option>
                    </select>
                    @error('department')
                        <p style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Qualification -->
                <div>
                    <label for="qualification" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">Qualification *</label>
                    <input type="text" name="qualification" id="qualification" value="{{ old('qualification', $staff->qualification) }}" required 
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem;">
                    @error('qualification')
                        <p style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Join Date -->
                <div>
                    <label for="join_date" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">Join Date</label>
                    <input type="date" name="join_date" id="join_date" value="{{ old('join_date', $staff->join_date) }}" 
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem;">
                    @error('join_date')
                        <p style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="is_active" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">Status</label>
                    <select name="is_active" id="is_active" 
                            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem;">
                        <option value="1" {{ old('is_active', $staff->is_active) == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active', $staff->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('is_active')
                        <p style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Profile Image -->
                <div>
                    <label for="profile_image" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">Profile Image</label>
                    @if($staff->profile_image)
                        <div style="margin-bottom: 0.5rem;">
                            <img src="{{ asset('storage/'.$staff->profile_image) }}" alt="{{ $staff->name }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                        </div>
                    @endif
                    <input type="file" name="profile_image" id="profile_image" accept="image/*" 
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem;">
                    @error('profile_image')
                        <p style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bio -->
                <div style="grid-column: 1/-1;">
                    <label for="bio" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">Biography</label>
                    <textarea name="bio" id="bio" rows="5" 
                              style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem;">{{ old('bio', $staff->bio) }}</textarea>
                    @error('bio')
                        <p style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Buttons -->
            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #e9ecef;">
                <a href="{{ route('admin.staff.index') }}" style="background: #6c757d; color: white; padding: 0.75rem 1.5rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
                    Cancel
                </a>
                <button type="submit" style="background: #28a745; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;">
                    <i class="fas fa-save"></i> Update Staff Member
                </button>
            </div>
        </form>
    </div>
</div>
@endsection