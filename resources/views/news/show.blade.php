@extends('layouts.app')

@section('title', $news->title)

@section('content')
<div class="page-header" style="background: linear-gradient(135deg, #1a2b3c 0%, #0f1a24 100%);">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto;">
            <span style="background: #ffc107; color: #1a2b3c; padding: 0.3rem 1rem; border-radius: 20px; display: inline-block; margin-bottom: 1rem;">
                {{ ucfirst($news->category) }}
            </span>
            <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">{{ $news->title }}</h1>
            <div style="display: flex; gap: 2rem; justify-content: center; color: #ecf0f1;">
                <span><i class="fas fa-calendar"></i> {{ $news->created_at->format('F d, Y') }}</span>
                <span><i class="fas fa-eye"></i> {{ $news->views }} views</span>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div style="max-width: 800px; margin: 0 auto;">
        @if($news->featured_image)
        <div style="margin-bottom: 2rem; border-radius: 15px; overflow: hidden;">
            <img src="{{ asset($news->featured_image) }}" alt="{{ $news->title }}" style="width: 100%; height: auto;">
        </div>
        @endif
        
        @if($news->category == 'event' && $news->event_date)
        <div style="background: #f8f9fa; padding: 1rem; border-radius: 10px; margin-bottom: 2rem; display: flex; gap: 2rem;">
            <div>
                <i class="fas fa-calendar-alt" style="color: #ffc107;"></i>
                <strong>Date:</strong> {{ \Carbon\Carbon::parse($news->event_date)->format('F d, Y') }}
            </div>
            @if($news->event_location)
            <div>
                <i class="fas fa-map-marker-alt" style="color: #ffc107;"></i>
                <strong>Location:</strong> {{ $news->event_location }}
            </div>
            @endif
        </div>
        @endif
        
        <div style="background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1); line-height: 1.8;">
            {!! nl2br(e($news->content)) !!}
        </div>
        
        @if($relatedNews->count() > 0)
        <div style="margin-top: 3rem;">
            <h3 style="color: #1a2b3c; margin-bottom: 1.5rem;">Related News</h3>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
                @foreach($relatedNews as $related)
                <div style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
                    @if($related->featured_image)
                    <img src="{{ asset($related->featured_image) }}" alt="" style="width: 100%; height: 150px; object-fit: cover;">
                    @endif
                    <div style="padding: 1rem;">
                        <h4 style="font-size: 1rem;">{{ $related->title }}</h4>
                        <a href="{{ route('news.show', $related->slug) }}" style="color: #ffc107; text-decoration: none;">Read More</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection