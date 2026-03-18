@extends('layouts.app')

@section('title', $news->title)

@section('content')
<div class="page-header">
    <div class="container">
        <nav style="margin-bottom: 1rem;">
            <a href="{{ route('news') }}" style="color: white; text-decoration: none; opacity: 0.8;">
                <i class="fas fa-arrow-left"></i> Back to News
            </a>
        </nav>
        <h1>{{ $news->title }}</h1>
        <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 1rem; flex-wrap: wrap;">
            <span style="background: {{ $news->category === 'event' ? '#17a2b8' : ($news->category === 'announcement' ? '#ffc107' : '#667eea') }}; color: {{ $news->category === 'announcement' ? '#1a2b3c' : 'white' }}; padding: 0.25rem 0.75rem; border-radius: 3px;">
                {{ ucfirst($news->category) }}
            </span>
            <span style="color: white;">
                <i class="far fa-calendar-alt"></i> {{ $news->created_at->format('F d, Y') }}
            </span>
            @if($news->category === 'event' && $news->event_date)
            <span style="color: white;">
                <i class="far fa-clock"></i> Event: {{ \Carbon\Carbon::parse($news->event_date)->format('F d, Y') }}
            </span>
            @endif
            <span style="color: white;">
                <i class="far fa-eye"></i> {{ $news->views }} views
            </span>
        </div>
    </div>
</div>

<div class="container">
    <div style="max-width: 800px; margin: 0 auto;">
        @if($news->featured_image)
        <div style="margin-bottom: 2rem;">
            <img src="{{ asset($news->featured_image) }}" alt="{{ $news->title }}" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 10px;">
        </div>
        @endif

        @if($news->category === 'event' && ($news->event_date || $news->event_location))
        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem; border-left: 4px solid #ffc107;">
            <h3 style="color: #1a2b3c; margin-bottom: 1rem;">Event Details</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                @if($news->event_date)
                <div>
                    <strong style="color: #666;">Date:</strong>
                    <p style="font-size: 1.1rem;">{{ \Carbon\Carbon::parse($news->event_date)->format('l, F d, Y') }}</p>
                </div>
                @endif
                @if($news->event_location)
                <div>
                    <strong style="color: #666;">Location:</strong>
                    <p style="font-size: 1.1rem;">{{ $news->event_location }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); margin-bottom: 2rem;">
            <div style="line-height: 1.8; color: #333; font-size: 1.1rem;">
                {!! nl2br(e($news->content)) !!}
            </div>
        </div>
    </div>
</div>
@endsection