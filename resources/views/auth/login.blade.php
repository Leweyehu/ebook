@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Login</h1>
        <p>Access your account</p>
    </div>
</div>

<div class="container">
    <div style="max-width: 450px; margin: 0 auto; background: white; border-radius: 15px; padding: 2.5rem; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
        
        @if(session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem;">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem;">
                @foreach($errors->all() as $error)
                    <p style="margin-bottom: 0.3rem;">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}" autocomplete="off">
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                    <i class="fas fa-envelope" style="color: #ffc107; margin-right: 0.5rem;"></i>Email Address
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                       style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #e9ecef; border-radius: 10px; font-size: 1rem; transition: border-color 0.3s ease;"
                       placeholder="Enter your email"
                       autofocus>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                    <i class="fas fa-lock" style="color: #ffc107; margin-right: 0.5rem;"></i>Password
                </label>
                <input type="password" name="password" required 
                       style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #e9ecef; border-radius: 10px; font-size: 1rem; transition: border-color 0.3s ease;"
                       placeholder="Enter your password">
            </div>

            <div style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
                <!-- <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="remember" style="cursor: pointer;"> 
                </label> -->
            </div>

            <button type="submit" 
                    style="width: 100%; padding: 1rem; background: #ffc107; color: #1a2b3c; border: none; border-radius: 10px; font-weight: 600; font-size: 1.1rem; cursor: pointer; transition: all 0.3s ease;"
                    onmouseover="this.style.background='#e0a800'"
                    onmouseout="this.style.background='#ffc107'">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>

        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e9ecef; text-align: center;">
        </div>
    </div>
</div>

@push('styles')
<style>
    input:focus {
        outline: none;
        border-color: #ffc107 !important;
        box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.25);
    }
    
    button:active {
        transform: scale(0.98);
    }
</style>
@endpush

@push('scripts')
<script>
    // Prevent form resubmission on page refresh
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    
    // Add CSRF token to all AJAX requests if you're using them
    if (typeof $ !== 'undefined') {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
</script>
@endpush
@endsection