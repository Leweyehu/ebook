@extends('layouts.staff')

@section('title', 'Change Password')
@section('page-title', 'Change Password')

@section('content')
<div style="max-width: 500px; margin: 0 auto;">
    <div style="background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        @if(session('success'))
        <div style="background: #28a745; color: white; padding: 1rem; border-radius: 5px; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div style="background: #dc3545; color: white; padding: 1rem; border-radius: 5px; margin-bottom: 1.5rem;">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('staff.password.update') }}" method="POST">
            @csrf

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Current Password</label>
                <input type="password" name="current_password" required 
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                @error('current_password')
                    <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">New Password</label>
                <input type="password" name="new_password" required 
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                <p style="color: #666; font-size: 0.85rem; margin-top: 0.3rem;">Minimum 8 characters</p>
                @error('new_password')
                    <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" required 
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" style="flex: 1; background: #28a745; color: white; padding: 0.75rem; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-key"></i> Change Password
                </button>
                <a href="{{ route('staff.dashboard') }}" style="flex: 1; background: #6c757d; color: white; padding: 0.75rem; border-radius: 5px; text-decoration: none; text-align: center; font-weight: 600;">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </form>
    </div>
</div>
@endsection