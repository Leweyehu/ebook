@extends('layouts.app')

@section('title', 'Alumni Dashboard')

@section('content')
<div class="page-header" style="background: linear-gradient(135deg, #003E72 0%, #002b4f 100%); color: white; padding: 4rem 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Alumni Dashboard</h1>
        <p>Welcome back, {{ $alumni->name }}!</p>
    </div>
</div>

<div class="container">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        <div style="background: white; border-radius: 15px; padding: 1.5rem; text-align: center;">
            <i class="fas fa-briefcase" style="font-size: 2rem; color: #ffc107;"></i>
            <h3>Jobs Posted</h3>
            <p style="font-size: 2rem; font-weight: bold;">{{ $jobs->count() }}</p>
            <a href="{{ route('alumni.jobs.create') }}" style="background: #ffc107; color: #003E72; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">Post New Job</a>
        </div>
        
        <div style="background: white; border-radius: 15px; padding: 1.5rem; text-align: center;">
            <i class="fas fa-star" style="font-size: 2rem; color: #ffc107;"></i>
            <h3>Success Stories</h3>
            <p style="font-size: 2rem; font-weight: bold;">{{ $stories->count() }}</p>
            <a href="{{ route('alumni.stories') }}" style="background: #ffc107; color: #003E72; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">View Stories</a>
        </div>
        
        <div style="background: white; border-radius: 15px; padding: 1.5rem; text-align: center;">
            <i class="fas fa-user-edit" style="font-size: 2rem; color: #ffc107;"></i>
            <h3>My Profile</h3>
            <a href="{{ route('alumni.profile.edit') }}" style="background: #ffc107; color: #003E72; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">Edit Profile</a>
        </div>
    </div>
</div>
@endsection