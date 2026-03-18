@extends('layouts.app')

@section('title', 'News & Events')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>News & Events</h1>
        <p>Stay updated with the latest happenings in the Computer Science Department</p>
    </div>
</div>

<div class="container">

    <!-- Upcoming Events Section -->
    @if(isset($upcomingEvents) && $upcomingEvents->count() > 0)
    <section style="margin-bottom: 3rem;">
        <h2 style="color: #1a2b3c; margin-bottom: 1.5rem;">Upcoming Events</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            @foreach($upcomingEvents as $event)
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 10px;">
                <span style="background: #ffc107; color: #1a2b3c; padding: 0.25rem 0.75rem; border-radius: 3px; font-size: 0.85rem; display: inline-block; margin-bottom: 1rem;">EVENT</span>
                <h3 style="margin-bottom: 0.5rem;">{{ $event->title }}</h3>
                <p style="margin-bottom: 1rem; opacity: 0.9;">{{ Str::limit($event->content, 100) }}</p>
                <div style="display: flex; gap: 1rem; font-size: 0.9rem;">
                    <span><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</span>
                    @if($event->event_location)
                    <span><i class="fas fa-map-marker-alt"></i> {{ $event->event_location }}</span>
                    @endif
                </div>
                <a href="{{ route('news.show', $event->slug) }}" style="display: inline-block; margin-top: 1rem; color: white; text-decoration: underline;">Read More →</a>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Latest News Section -->
    <h2 style="color: #1a2b3c; margin-bottom: 1.5rem;">Latest News</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem;">
        @forelse($news as $newsItem)
        <div style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
            @if($newsItem->featured_image)
            <img src="{{ asset($newsItem->featured_image) }}" alt="{{ $newsItem->title }}" style="width: 100%; height: 200px; object-fit: cover;">
            @else
            <div style="width: 100%; height: 200px; background: #e9ecef; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                <i class="fas fa-newspaper" style="font-size: 3rem;"></i>
            </div>
            @endif
            
            <div style="padding: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <span style="background: {{ $newsItem->category === 'event' ? '#17a2b8' : ($newsItem->category === 'announcement' ? '#ffc107' : '#667eea') }}; color: {{ $newsItem->category === 'announcement' ? '#1a2b3c' : 'white' }}; padding: 0.25rem 0.75rem; border-radius: 3px; font-size: 0.85rem;">
                        {{ ucfirst($newsItem->category) }}
                    </span>
                    <span style="color: #999; font-size: 0.9rem;">
                        {{ $newsItem->created_at->format('M d, Y') }}
                    </span>
                </div>
                
                <h3 style="margin-bottom: 0.5rem;">{{ $newsItem->title }}</h3>
                <p style="color: #666; margin-bottom: 1rem;">{{ Str::limit($newsItem->content, 120) }}</p>
                
                <a href="{{ route('news.show', $newsItem->slug) }}" style="color: #667eea; text-decoration: none; font-weight: 600;">
                    Read More <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        @empty
        <div style="grid-column: 1/-1; text-align: center; padding: 3rem; background: white; border-radius: 10px;">
            <i class="fas fa-newspaper" style="font-size: 3rem; color: #6c757d; margin-bottom: 1rem;"></i>
            <p style="color: #6c757d;">No news articles found.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(method_exists($news, 'links'))
    <div style="margin-top: 3rem; display: flex; justify-content: center;">
        {{ $news->links() }}
    </div>
    @endif
</div>
@endsection