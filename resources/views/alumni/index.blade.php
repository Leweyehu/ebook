@extends('layouts.app')

@section('title', 'Alumni Directory')

@section('content')
<div class="page-header" style="background: linear-gradient(135deg, #003E72 0%, #002b4f 100%); color: white; padding: 4rem 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Our Alumni</h1>
        <p style="font-size: 1.2rem;">Meet our successful graduates making an impact worldwide</p>
    </div>
</div>

<div class="container">
    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 3rem;">
        <div style="background: white; padding: 1.5rem; border-radius: 15px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            <i class="fas fa-users" style="font-size: 2.5rem; color: #ffc107;"></i>
            <h3 style="font-size: 2rem; margin: 0.5rem 0;">{{ $stats['total'] }}</h3>
            <p>Total Alumni</p>
        </div>
        <div style="background: white; padding: 1.5rem; border-radius: 15px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            <i class="fas fa-building" style="font-size: 2.5rem; color: #ffc107;"></i>
            <h3 style="font-size: 2rem; margin: 0.5rem 0;">{{ $stats['companies'] }}</h3>
            <p>Companies</p>
        </div>
        <div style="background: white; padding: 1.5rem; border-radius: 15px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            <i class="fas fa-calendar-alt" style="font-size: 2.5rem; color: #ffc107;"></i>
            <h3 style="font-size: 2rem; margin: 0.5rem 0;">{{ $stats['years'] }}</h3>
            <p>Graduation Years</p>
        </div>
    </div>

    <!-- Search and Filter -->
    <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 15px; margin-bottom: 2rem;">
        <form method="GET" action="{{ route('alumni.index') }}" style="display: flex; flex-wrap: wrap; gap: 1rem;">
            <div style="flex: 2;">
                <input type="text" name="search" placeholder="Search by name, company, or job title..." 
                       value="{{ request('search') }}" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 8px;">
            </div>
            <div style="flex: 1;">
                <select name="year" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 8px;">
                    <option value="">All Years</option>
                    @foreach($years as $y)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" style="background: #ffc107; color: #003E72; padding: 0.8rem 2rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-search"></i> Search
                </button>
                <a href="{{ route('alumni.index') }}" style="display: inline-block; background: #6c757d; color: white; padding: 0.8rem 2rem; border-radius: 8px; text-decoration: none;">
                    Reset
                </a>
            </div>
        </form>
    </div>

    @if($alumni->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
        @foreach($alumni as $graduate)
        <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
            <div style="background: linear-gradient(135deg, #003E72, #1c5a8a); padding: 2rem; text-align: center;">
                @if($graduate->profile_image)
                    <img src="{{ asset($graduate->profile_image) }}" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #ffc107;">
                @else
                    <div style="width: 120px; height: 120px; border-radius: 50%; background: #ffc107; color: #003E72; display: flex; align-items: center; justify-content: center; margin: 0 auto; font-size: 3rem; font-weight: bold;">
                        {{ $graduate->initials }}
                    </div>
                @endif
                <h3 style="color: white; margin-top: 1rem;">{{ $graduate->name }}</h3>
                <p style="color: rgba(255,255,255,0.9);">Class of {{ $graduate->graduation_year }}</p>
            </div>
            <div style="padding: 1.5rem;">
                <div><i class="fas fa-briefcase" style="color: #ffc107; width: 25px;"></i> {{ $graduate->current_job_title ?? 'Not Specified' }}</div>
                <div style="margin: 0.5rem 0;"><i class="fas fa-building" style="color: #ffc107; width: 25px;"></i> {{ $graduate->current_company ?? 'Not Specified' }}</div>
                <div><i class="fas fa-map-marker-alt" style="color: #ffc107; width: 25px;"></i> {{ $graduate->location ?? 'Location Not Specified' }}</div>
                <a href="{{ route('alumni.show', $graduate) }}" style="display: block; background: #ffc107; color: #003E72; text-align: center; padding: 0.5rem; border-radius: 5px; text-decoration: none; margin-top: 1rem; font-weight: 600;">View Profile</a>
            </div>
        </div>
        @endforeach
    </div>
    <div style="margin-top: 3rem;">{{ $alumni->appends(request()->query())->links() }}</div>
    @else
    <div style="text-align: center; padding: 4rem; background: white; border-radius: 15px;">
        <i class="fas fa-users" style="font-size: 4rem; color: #ccc;"></i>
        <p style="margin-top: 1rem;">No alumni found. Check back later!</p>
        <a href="{{ route('alumni.register') }}" style="display: inline-block; margin-top: 1rem; background: #ffc107; color: #003E72; padding: 0.5rem 1.5rem; border-radius: 5px; text-decoration: none;">Register as Alumnus</a>
    </div>
    @endif
</div>

<style>
    [style*="border-radius: 15px"]:hover { transform: translateY(-8px); transition: transform 0.3s; }
    @media (max-width: 768px) { [style*="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr))"] { grid-template-columns: 1fr !important; } }
</style>
@endsection