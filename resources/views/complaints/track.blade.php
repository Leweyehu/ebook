@extends('layouts.app')

@section('title', 'Complaint Status')

@section('content')
<div class="container" style="padding: 4rem 0;">
    <div style="max-width: 800px; margin: 0 auto;">
        <div style="background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="color: #1a2b3c;">Complaint Status</h2>
                <p style="color: #6c757d;">Reference: <strong>{{ $complaint->reference_no }}</strong></p>
            </div>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 2rem; flex-wrap: wrap;">
                <div><strong>Status:</strong> {!! $complaint->status_badge !!}</div>
                <div><strong>Priority:</strong> {!! $complaint->priority_badge !!}</div>
                <div><strong>Submitted:</strong> {{ $complaint->created_at->format('M d, Y') }}</div>
            </div>
            
            <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin-bottom: 1.5rem;">
                <h3>Subject: {{ $complaint->subject }}</h3>
                <p style="margin-top: 1rem;">{{ $complaint->description }}</p>
            </div>
            
            @if($complaint->admin_response)
            <div style="background: #e8f5e9; padding: 1.5rem; border-radius: 10px;">
                <h3>Response from Department:</h3>
                <p>{{ $complaint->admin_response }}</p>
                @if($complaint->resolved_at)
                    <small>Resolved on: {{ $complaint->resolved_at->format('M d, Y') }}</small>
                @endif
            </div>
            @endif
            
            <div style="margin-top: 2rem; text-align: center;">
                <a href="{{ route('home') }}" style="background: #6c757d; color: white; padding: 0.8rem 2rem; text-decoration: none; border-radius: 5px;">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection