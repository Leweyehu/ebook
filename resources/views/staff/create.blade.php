@extends('layouts.app')

@section('title', 'Add Staff')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Add New Staff Member</h1>
        <p>Fill in the information below</p>
    </div>
</div>

<div class="container">
    <div style="max-width: 800px; margin: 0 auto; background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <form action="{{ route('admin.staff.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if($errors->any())
                <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem;">
                    <ul style="margin-bottom: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                    <i class="fas fa-user" style="color: #ffc107; margin-right: 0.5rem;"></i>Full Name *
                </label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                @error('name') <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                    <i class="fas fa-briefcase" style="color: #ffc107; margin-right: 0.5rem;"></i>Position *
                </label>
                <input type="text" name="position" value="{{ old('position') }}" required
                       style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                @error('position') <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                    <i class="fas fa-graduation-cap" style="color: #ffc107; margin-right: 0.5rem;"></i>Qualification *
                </label>
                <input type="text" name="qualification" value="{{ old('qualification') }}" required
                       style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                @error('qualification') <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                    <i class="fas fa-envelope" style="color: #ffc107; margin-right: 0.5rem;"></i>Email *
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                @error('email') <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                    <i class="fas fa-phone" style="color: #ffc107; margin-right: 0.5rem;"></i>Phone
                </label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                       style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                @error('phone') <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                    <i class="fas fa-tag" style="color: #ffc107; margin-right: 0.5rem;"></i>Staff Type *
                </label>
                <select name="staff_type" required style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                    <option value="">Select Type</option>
                    <option value="academic" {{ old('staff_type') == 'academic' ? 'selected' : '' }}>Academic</option>
                    <option value="administrative" {{ old('staff_type') == 'administrative' ? 'selected' : '' }}>Administrative</option>
                    <option value="technical" {{ old('staff_type') == 'technical' ? 'selected' : '' }}>Technical</option>
                </select>
                @error('staff_type') <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                    <i class="fas fa-image" style="color: #ffc107; margin-right: 0.5rem;"></i>Profile Image
                </label>
                <input type="file" name="profile_image" accept="image/*"
                       style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                <p style="color: #6c757d; font-size: 0.85rem; margin-top: 0.3rem;">Accepted formats: JPG, PNG. Max size: 2MB</p>
                @error('profile_image') <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                    <i class="fas fa-align-left" style="color: #ffc107; margin-right: 0.5rem;"></i>Bio / Description
                </label>
                <textarea name="bio" rows="5" style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">{{ old('bio') }}</textarea>
                @error('bio') <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                    <i class="fas fa-sort-numeric-down" style="color: #ffc107; margin-right: 0.5rem;"></i>Display Order
                </label>
                <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                       style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                <p style="color: #6c757d; font-size: 0.85rem; margin-top: 0.3rem;">Lower numbers appear first</p>
                @error('order') <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p> @enderror
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" style="background: #ffc107; color: #1a2b3c; padding: 1rem 2rem; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-save"></i> Save Staff Member
                </button>
                <a href="{{ route('admin.staff.index') }}" style="background: #6c757d; color: white; padding: 1rem 2rem; border-radius: 5px; text-decoration: none;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection