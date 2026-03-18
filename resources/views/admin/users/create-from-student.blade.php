@extends('layouts.admin')

@section('title', 'Create Student User')
@section('page-title', 'Create User from Student Record')

@section('content')
<div style="background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <form action="{{ route('admin.users.store-from-student') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Select Student</label>
            <select name="student_id" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                <option value="">-- Select Student --</option>
                @foreach($students as $student)
                <option value="{{ $student->id }}" data-email="{{ $student->email }}">
                    {{ $student->name }} - {{ $student->student_id }} (Year {{ $student->year }})
                </option>
                @endforeach
            </select>
            @error('student_id')
                <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Email Address</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                   style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
            <p style="color: #666; font-size: 0.85rem; margin-top: 0.3rem;">Student email will be used as username</p>
            @error('email')
                <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Password</label>
            <input type="password" name="password" required 
                   style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
            <p style="color: #666; font-size: 0.85rem; margin-top: 0.3rem;">Minimum 8 characters</p>
            @error('password')
                <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Confirm Password</label>
            <input type="password" name="password_confirmation" required 
                   style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" style="background: #28a745; color: white; padding: 0.75rem 2rem; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
                <i class="fas fa-save"></i> Create Student User
            </button>
            <a href="{{ route('admin.users.index') }}" style="background: #6c757d; color: white; padding: 0.75rem 2rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>

<script>
    // Auto-fill email when student is selected
    document.querySelector('select[name="student_id"]').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var email = selectedOption.getAttribute('data-email');
        if (email) {
            document.getElementById('email').value = email;
        }
    });
</script>
@endsection