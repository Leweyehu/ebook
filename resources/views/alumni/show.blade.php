@extends('layouts.app')

@section('title', $alumni->name . ' - Alumni Profile')

@section('content')
<div class="page-header" style="background: linear-gradient(135deg, #003E72 0%, #002b4f 100%); color: white; padding: 4rem 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Alumni Profile</h1>
    </div>
</div>

<div class="container" style="margin-top: -2rem;">
    <div style="max-width: 800px; margin: 0 auto; background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1); text-align: center;">
        <div style="width: 150px; height: 150px; margin: 0 auto 1rem;">
            @if($alumni->profile_image)
                <img src="{{ asset($alumni->profile_image) }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 4px solid #ffc107;">
            @else
                <div style="width: 100%; height: 100%; border-radius: 50%; background: #ffc107; display: flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: bold; color: #003E72;">
                    {{ $alumni->initials }}
                </div>
            @endif
        </div>
        <h2>{{ $alumni->name }}</h2>
        <p>Class of {{ $alumni->graduation_year }} | {{ $alumni->degree }}</p>
        
        @if($alumni->current_job_title || $alumni->current_company)
        <div style="margin: 1rem 0; color: #666;">
            <i class="fas fa-briefcase"></i> {{ $alumni->current_job_title ?? 'Not Specified' }}
            @if($alumni->current_company) at {{ $alumni->current_company }} @endif
        </div>
        @endif
        
        @if($alumni->location)
        <div style="margin-bottom: 1rem; color: #666;">
            <i class="fas fa-map-marker-alt"></i> {{ $alumni->location }}
        </div>
        @endif
        
        @if($alumni->bio)
        <div style="margin: 1.5rem 0; text-align: left;">
            <h3>About</h3>
            <p>{{ $alumni->bio }}</p>
        </div>
        @endif
        
        @if($alumni->linkedin_url || $alumni->github_url || $alumni->website_url)
        <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 1.5rem;">
            @if($alumni->linkedin_url)
                <a href="{{ $alumni->linkedin_url }}" target="_blank" style="background: #0077b5; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
                    <i class="fab fa-linkedin"></i> LinkedIn
                </a>
            @endif
            @if($alumni->github_url)
                <a href="{{ $alumni->github_url }}" target="_blank" style="background: #333; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
                    <i class="fab fa-github"></i> GitHub
                </a>
            @endif
            @if($alumni->website_url)
                <a href="{{ $alumni->website_url }}" target="_blank" style="background: #ffc107; color: #003E72; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
                    <i class="fas fa-globe"></i> Website
                </a>
            @endif
        </div>
        @endif
        
        <div style="margin-top: 2rem;">
            <a href="{{ route('alumni.index') }}" style="background: #6c757d; color: white; padding: 0.5rem 1.5rem; border-radius: 5px; text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Back to Directory
            </a>
        </div>
    </div>
</div>
@endsection