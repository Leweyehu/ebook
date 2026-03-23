@extends('layouts.app')

@section('title', $job->title . ' - Job Opportunity')

@section('content')
<div class="page-header" style="background: linear-gradient(135deg, #003E72 0%, #002b4f 100%); color: white; padding: 4rem 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">{{ $job->title }}</h1>
        <p style="font-size: 1.2rem;">at {{ $job->company }}</p>
    </div>
</div>

<div class="container" style="margin-top: -2rem;">
    <div style="max-width: 900px; margin: 0 auto;">
        <div style="background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            
            <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e9ecef; margin-bottom: 1.5rem;">
                <div>
                    <strong><i class="fas fa-building"></i> Company:</strong><br>
                    {{ $job->company }}
                </div>
                <div>
                    <strong><i class="fas fa-map-marker-alt"></i> Location:</strong><br>
                    {{ $job->location ?? 'Remote / Flexible' }}
                </div>
                <div>
                    <strong><i class="fas fa-briefcase"></i> Job Type:</strong><br>
                    {{ ucfirst(str_replace('-', ' ', $job->job_type)) }}
                </div>
                <div>
                    <strong><i class="fas fa-calendar-alt"></i> Deadline:</strong><br>
                    {{ $job->deadline->format('F d, Y') }}
                </div>
                <div>
                    <strong><i class="fas fa-user"></i> Posted by:</strong><br>
                    {{ $job->alumni->name }} (Alumnus)
                </div>
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <h3 style="color: #003E72; margin-bottom: 1rem;">Job Description</h3>
                <div style="line-height: 1.8;">
                    {!! nl2br(e($job->description)) !!}
                </div>
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <h3 style="color: #003E72; margin-bottom: 1rem;">Requirements</h3>
                <div style="line-height: 1.8;">
                    {!! nl2br(e($job->requirements)) !!}
                </div>
            </div>
            
            @if($job->benefits)
            <div style="margin-bottom: 1.5rem;">
                <h3 style="color: #003E72; margin-bottom: 1rem;">Benefits</h3>
                <div style="line-height: 1.8;">
                    {!! nl2br(e($job->benefits)) !!}
                </div>
            </div>
            @endif
            
            <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin-top: 2rem;">
                <h3 style="color: #003E72; margin-bottom: 1rem;">How to Apply</h3>
                @if($job->application_link)
                    <p>Click the button below to apply for this position:</p>
                    <a href="{{ $job->application_link }}" target="_blank" style="display: inline-block; background: #28a745; color: white; padding: 0.8rem 2rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
                        <i class="fas fa-external-link-alt"></i> Apply Now
                    </a>
                @else
                    <p>Send your CV and cover letter to:</p>
                    <div style="background: white; padding: 1rem; border-radius: 8px; display: inline-block;">
                        <i class="fas fa-envelope" style="color: #ffc107;"></i> <strong>{{ $job->contact_email }}</strong>
                    </div>
                @endif
            </div>
            
            <div style="margin-top: 2rem; text-align: center;">
                <a href="{{ route('alumni.jobs') }}" style="background: #6c757d; color: white; padding: 0.5rem 1.5rem; border-radius: 5px; text-decoration: none;">
                    <i class="fas fa-arrow-left"></i> Back to Jobs
                </a>
            </div>
        </div>
    </div>
</div>
@endsection