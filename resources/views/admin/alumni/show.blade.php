@extends('layouts.admin')

@section('title', 'Alumni Details')
@section('page-title', 'Alumni Details')

@section('content')
<a href="{{ route('admin.alumni.index') }}" style="background:#6c757d; color:white; padding:0.5rem 1rem; border-radius:5px; text-decoration:none;">← Back</a>
<div style="background:white; border-radius:10px; padding:2rem; margin-top:1rem;">
    <div style="display:flex; gap:2rem;">
        @if($alumni->profile_image)<img src="{{ asset($alumni->profile_image) }}" style="width:150px; height:150px; border-radius:50%; object-fit:cover;">@else<div style="width:150px; height:150px; border-radius:50%; background:#ffc107; display:flex; align-items:center; justify-content:center; font-size:3rem;">{{ $alumni->initials }}</div>@endif
        <div><h2>{{ $alumni->name }}</h2><p><strong>Student ID:</strong> {{ $alumni->student_id }}</p><p><strong>Email:</strong> {{ $alumni->email }}</p><p><strong>Graduation Year:</strong> {{ $alumni->graduation_year }}</p><p><strong>Degree:</strong> {{ $alumni->degree }}</p></div>
        <div><span style="background:{{ $alumni->status=='pending'?'#ffc107':($alumni->status=='approved'?'#28a745':'#dc3545') }}; color:white; padding:0.5rem 1rem; border-radius:20px;">{{ ucfirst($alumni->status) }}</span></div>
    </div>
    <hr>
    <h3>Professional Info</h3>
    <p><strong>Job Title:</strong> {{ $alumni->current_job_title ?? 'N/A' }}</p>
    <p><strong>Company:</strong> {{ $alumni->current_company ?? 'N/A' }}</p>
    <p><strong>Location:</strong> {{ $alumni->location ?? 'N/A' }}</p>
    @if($alumni->bio)<h3>Bio</h3><p>{{ $alumni->bio }}</p>@endif
    @if($alumni->linkedin_url || $alumni->github_url)<h3>Links</h3>@if($alumni->linkedin_url)<a href="{{ $alumni->linkedin_url }}" target="_blank">LinkedIn</a> @endif @if($alumni->github_url)<a href="{{ $alumni->github_url }}" target="_blank">GitHub</a>@endif @endif
</div>
@endsection