@extends('layouts.app')

@section('title', 'Track Complaint')

@section('content')
<div class="container" style="padding: 4rem 0;">
    <div style="max-width: 500px; margin: 0 auto;">
        <div style="background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1); text-align: center;">
            <i class="fas fa-search" style="font-size: 3rem; color: #ffc107;"></i>
            <h2 style="color: #1a2b3c; margin: 1rem 0;">Track Your Complaint</h2>
            <p>Enter your reference number to check the status</p>
            
            @if(session('error'))
                <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 10px; margin-bottom: 1rem;">
                    {{ session('error') }}
                </div>
            @endif
            
            <form action="{{ route('complaints.track') }}" method="POST">
                @csrf
                <div style="margin-bottom: 1.5rem;">
                    <input type="text" name="reference_no" placeholder="e.g., CMP2025XXXXXX" required
                           style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px; text-align: center;">
                </div>
                <button type="submit" style="width: 100%; padding: 0.8rem; background: #ffc107; color: #1a2b3c; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
                    Track Complaint
                </button>
            </form>
        </div>
    </div>
</div>
@endsection