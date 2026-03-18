@extends('layouts.app')

@section('title', 'News & Events')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>News & Events</h1>
        <p>Stay updated with the latest happenings</p>
    </div>
</div>

<div class="container">
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-bottom: 3rem;">
        <!-- Main News Section -->
        <div>
            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 10px; margin-bottom: 2rem;">
                    {{ session('success') }}
                </div>
            @endif

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
                @forelse($news as $item)
                <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s;">
                    @if($item->featured_image)
                    <img src="{{ asset($item->featured_image) }}" alt="{{ $item->title }}" style="width: 100%; height: 200px; object-fit: cover;">
                    @else
                    <div style="height: 200px; background: linear-gradient(135deg, #1a2b3c, #2c3e50); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-newspaper" style="font-size: 4rem; color: #ffc107;"></i>
                    </div>
                    @endif
                    
                    <div style="padding: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <span style="background: #ffc107; color: #1a2b3c; padding: 0.2rem 0.8rem; border-radius: 20px; font-size: 0.8rem;">
                                {{ ucfirst($item->category) }}
                            </span>
                            <span style="color: #6c757d; font-size: 0.85rem;">
                                {{ $item->created_at->format('M d, Y') }}
                            </span>
                        </div>
                        
                        <h3 style="color: #1a2b3c; margin-bottom: 0.5rem;">{{ $item->title }}</h3>
                        
                        <p style="color: #6c757d; margin-bottom: 1rem;">
                            {{ Str::limit(strip_tags($item->content), 100) }}
                        </p>
                        
                        @if($item->category == 'event' && $item->event_date)
                        <div style="background: #f8f9fa; padding: 0.5rem; border-radius: 5px; margin-bottom: 1rem;">
                            <i class="fas fa-calendar" style="color: #ffc107;"></i>
                            {{ \Carbon\Carbon::parse($item->event_date)->format('F d, Y') }}
                            @if($item->event_location)
                            <span style="margin-left: 1rem;"><i class="fas fa-map-marker-alt" style="color: #ffc107;"></i> {{ $item->event_location }}</span>
                            @endif
                        </div>
                        @endif
                        
                        <a href="{{ route('news.show', $item->slug) }}" style="color: #ffc107; text-decoration: none; font-weight: 600;">
                            Read More <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 3rem;">
                    <i class="fas fa-newspaper" style="font-size: 4rem; color: #6c757d;"></i>
                    <p style="color: #6c757d; margin-top: 1rem;">No news available at the moment.</p>
                </div>
                @endforelse
            </div>
            
            <div style="margin-top: 2rem;">
                {{ $news->links() }}
            </div>
        </div>
        
        <!-- Sidebar - Upcoming Events -->
        <div>
            <div style="background: white; border-radius: 15px; padding: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1); position: sticky; top: 100px;">
                <h3 style="color: #1a2b3c; margin-bottom: 1.5rem; padding-bottom: 0.5rem; border-bottom: 2px solid #ffc107;">
                    <i class="fas fa-calendar-alt"></i> Upcoming Events
                </h3>
                
                @forelse($events as $event)
                <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e9ecef;">
                    <div style="display: flex; gap: 1rem;">
                        <div style="background: #ffc107; color: #1a2b3c; padding: 0.5rem; border-radius: 8px; text-align: center; min-width: 60px;">
                            <div style="font-weight: 700; font-size: 1.2rem;">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</div>
                            <div style="font-size: 0.8rem;">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</div>
                        </div>
                        <div>
                            <h4 style="font-size: 1rem; margin-bottom: 0.3rem;">{{ $event->title }}</h4>
                            @if($event->event_location)
                            <p style="font-size: 0.85rem; color: #6c757d;">
                                <i class="fas fa-map-marker-alt" style="color: #ffc107;"></i> {{ $event->event_location }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <p style="color: #6c757d; text-align: center;">No upcoming events</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection