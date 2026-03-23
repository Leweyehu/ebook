@extends('layouts.app')

@section('title', 'Complaint Submitted')

@section('content')
<div class="container" style="text-align: center; padding: 4rem 0;">
    <div style="background: white; border-radius: 15px; padding: 3rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto;">
        <i class="fas fa-check-circle" style="font-size: 5rem; color: #28a745;"></i>
        <h2 style="color: #1a2b3c; margin: 1rem 0;">Complaint Submitted Successfully!</h2>
        <p style="color: #6c757d;">Your reference number is:</p>
        <div style="background: #f8f9fa; padding: 1rem; border-radius: 10px; margin: 1rem 0;">
            <strong style="font-size: 1.5rem; color: #ffc107;">{{ $complaint->reference_no }}</strong>
        </div>
        <p>Please save this reference number to track your complaint status.</p>
        <p>We will respond within 3-7 business days.</p>
        <div style="margin-top: 2rem;">
            <a href="{{ route('complaints.track-form') }}" class="btn btn-primary" style="background: #ffc107; color: #1a2b3c; padding: 0.8rem 2rem; text-decoration: none; border-radius: 5px;">
                Track Complaint
            </a>
            <a href="{{ route('home') }}" style="background: #6c757d; color: white; padding: 0.8rem 2rem; text-decoration: none; border-radius: 5px; margin-left: 1rem;">
                Back to Home
            </a>
        </div>
    </div>
</div>
@endsection