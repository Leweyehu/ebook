@extends('layouts.app')

@section('title', 'Add New Staff')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Add New Staff Member</h1>
    </div>
</div>

<div class="container">
    <!-- Include Admin Header -->
    @include('admin.partials.admin-header')

    <!-- Navigation Buttons -->
    <div style="display: flex; gap: 1rem; margin-bottom: 2rem;">
        <a href="{{ route('admin.dashboard') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #6c757d; color: white; padding: 0.5rem 1.5rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
            <i class="fas fa-arrow-left"></i> Dashboard
        </a>
        <a href="{{ route('admin.staff.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #ffc107; color: #1a2b3c; padding: 0.5rem 1.5rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
            <i class="fas fa-arrow-left"></i> Back to Staff List
        </a>
    </div>

    <!-- Create Form -->
    <div style="background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <form method="POST" action="{{ route('admin.staff.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Full Name *</label>
                    <input type="text" name="name" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Position/Title *</label>
                    <input type="text" name="position" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Department *</label>
                    <input type="text" name="department" value="Computer Science" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Email *</label>
                    <input type="email" name="email" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Phone</label>
                    <input type="text" name="phone" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Profile Image</label>
                    <input type="file" name="image" accept="image/*" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                </div>
            </div>
            
            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Biography/Bio</label>
                <textarea name="bio" rows="5" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;"></textarea>
            </div>
            
            <div style="margin-bottom: 2rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="checkbox" name="is_active" value="1" checked>
                    <span>Active (visible on website)</span>
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