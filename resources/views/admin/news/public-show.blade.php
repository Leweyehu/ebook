@extends('layouts.app')

@section('title', $news->title . ' - Computer Science')

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
            <span style="background: {{ $news->category === 'event' ? '#17a2b8' : ($news->category === 'announcement' ? '#ffc107' : '#667eea') }}; color: {{ $news->category === 'announcement' ? '#1a2b3c' : 'white' }}; padding: 0.25rem 0.75rem; border-radius: 3px; font-weight: 600;">
                {{ strtoupper($news->category) }}
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
        <!-- Featured Image -->
        @if($news->featured_image)
        <div style="margin-bottom: 2rem;">
            <img src="{{ asset($news->featured_image) }}" alt="{{ $news->title }}" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
        </div>
        @endif

        <!-- Event Details -->
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

        <!-- Content -->
        <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); margin-bottom: 2rem;">
            <div style="line-height: 1.8; color: #333; font-size: 1.1rem;">
                {!! nl2br(e($news->content)) !!}
            </div>
        </div>

        <!-- Share Buttons -->
        <div style="margin-top: 2rem; padding: 2rem 0; border-top: 1px solid #e9ecef;">
            <h4 style="margin-bottom: 1rem; color: #1a2b3c;">Share this article:</h4>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" style="background: #3b5998; color: white; padding: 0.75rem 1.5rem; border-radius: 5px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                    <i class="fab fa-facebook-f"></i> Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($news->title) }}" target="_blank" style="background: #1da1f2; color: white; padding: 0.75rem 1.5rem; border-radius: 5px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                    <i class="fab fa-twitter"></i> Twitter
                </a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($news->title) }}" target="_blank" style="background: #0077b5; color: white; padding: 0.75rem 1.5rem; border-radius: 5px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                    <i class="fab fa-linkedin-in"></i> LinkedIn
                </a>
            </div>
        </div>

        <!-- Back to News -->
        <div style="text-align: center; margin: 2rem 0;">
            <a href="{{ route('news') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #667eea; color: white; padding: 0.75rem 2rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
                <i class="fas fa-arrow-left"></i> Back to All News
            </a>
        </div>
    </div>
</div>
@endsection