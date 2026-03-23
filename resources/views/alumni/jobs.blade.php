@extends('layouts.app')

@section('title', 'Job Opportunities - Alumni')

@section('content')
<div class="page-header" style="background: linear-gradient(135deg, #003E72 0%, #002b4f 100%); color: white; padding: 4rem 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Job Opportunities</h1>
        <p style="font-size: 1.2rem;">Jobs posted by our alumni and industry partners</p>
    </div>
</div>

<div class="container">
    @if(isset($jobs) && $jobs->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 2rem;">
        @foreach($jobs as $job)
        <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s;">
            <div style="background: linear-gradient(135deg, #ffc107, #ffed4a); padding: 1rem 1.5rem;">
                <h3 style="color: #003E72; margin-bottom: 0.5rem;">{{ $job->title }}</h3>
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <span><i class="fas fa-building"></i> {{ $job->company }}</span>
                    <span><i class="fas fa-map-marker-alt"></i> {{ $job->location ?? 'Remote' }}</span>
                    <span><i class="fas fa-briefcase"></i> {{ ucfirst(str_replace('-', ' ', $job->job_type)) }}</span>
                </div>
            </div>
            <div style="padding: 1.5rem;">
                <p style="color: #666; margin-bottom: 1rem;">{{ Str::limit($job->description, 150) }}</p>
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <i class="fas fa-calendar-alt" style="color: #ffc107;"></i> Deadline: {{ $job->deadline->format('M d, Y') }}
                    </div>
                    <a href="{{ route('alumni.jobs.show', $job) }}" style="background: #ffc107; color: #003E72; padding: 0.5rem 1.5rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
                        View Details →
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div style="margin-top: 3rem;">
        {{ $jobs->appends(request()->query())->links() }}
    </div>
    @else
    <div style="text-align: center; padding: 4rem; background: white; border-radius: 15px;">
        <i class="fas fa-briefcase" style="font-size: 4rem; color: #ccc;"></i>
        <p style="margin-top: 1rem; color: #666;">No job opportunities available at the moment. Check back later!</p>
        @auth
            @php
                $isAlumni = \App\Models\Alumni::where('email', auth()->user()->email)->exists();
            @endphp
            @if($isAlumni)
            <a href="{{ route('alumni.jobs.create') }}" style="display: inline-block; margin-top: 1rem; background: #ffc107; color: #003E72; padding: 0.5rem 1.5rem; border-radius: 5px; text-decoration: none;">
                <i class="fas fa-plus"></i> Post a Job
            </a>
            @endif
        @endauth
    </div>
    @endif
</div>

<style>
    [style*="border-radius: 15px"]:hover {
        transform: translateY(-5px);
        transition: transform 0.3s;
    }
</style>
@endsection