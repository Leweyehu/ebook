{{-- news/index.blade.php --}}
@extends('layouts.admin')  {{-- CHANGED FROM layouts.app TO layouts.admin --}}

@section('title', 'Manage News')
@section('page-title', 'Manage News & Events')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Manage News & Events</h1>
    </div>
</div>

<div class="container">
    <!-- Page Header with Add Button -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <h2 style="color: #1a2b3c; margin: 0;">News Articles</h2>
        <a href="{{ route('admin.news.create') }}" style="background: #28a745; color: white; padding: 0.75rem 1.5rem; border-radius: 5px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-plus"></i> Create News
        </a>
    </div>

    <!-- Category Filter -->
    <div style="margin-bottom: 2rem;">
        <select id="categoryFilter" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; width: 200px;">
            <option value="">All Categories</option>
            <option value="news">News</option>
            <option value="event">Events</option>
            <option value="announcement">Announcements</option>
        </select>
    </div>

    <!-- News Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem;">
        @forelse(\App\Models\News::latest()->get() as $news)
        <div style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            @if($news->featured_image)
            <img src="{{ asset('storage/'.$news->featured_image) }}" alt="{{ $news->title }}" style="width: 100%; height: 200px; object-fit: cover;">
            @else
            <div style="width: 100%; height: 200px; background: #e9ecef; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                <i class="fas fa-image" style="font-size: 3rem;"></i>
            </div>
            @endif
            
            <div style="padding: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <span style="background: {{ $news->category === 'event' ? '#17a2b8' : ($news->category === 'announcement' ? '#ffc107' : '#667eea') }}; color: {{ $news->category === 'announcement' ? '#1a2b3c' : 'white' }}; padding: 0.25rem 0.75rem; border-radius: 3px; font-size: 0.85rem;">
                        {{ ucfirst($news->category) }}
                    </span>
                    <span style="background: {{ $news->is_published ? '#28a745' : '#dc3545' }}; color: white; padding: 0.25rem 0.75rem; border-radius: 3px; font-size: 0.85rem;">
                        {{ $news->is_published ? 'Published' : 'Draft' }}
                    </span>
                </div>
                
                <h3 style="margin-bottom: 0.5rem; font-size: 1.2rem;">{{ $news->title }}</h3>
                <p style="color: #6c757d; font-size: 0.9rem; margin-bottom: 1rem;">
                    {{ \Carbon\Carbon::parse($news->created_at)->format('M d, Y') }} • {{ $news->views }} views
                </p>
                <p style="color: #6c757d; margin-bottom: 1.5rem; line-height: 1.5;">{{ Str::limit($news->content, 100) }}</p>
                
                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                    <a href="{{ route('admin.news.edit', $news) }}" style="background: #ffc107; color: #1a2b3c; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none; font-size: 0.9rem;">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('admin.news.destroy', $news) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: #dc3545; color: white; border: none; padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer; font-size: 0.9rem;" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1/-1; text-align: center; padding: 3rem; background: white; border-radius: 10px;">
            <i class="fas fa-newspaper" style="font-size: 3rem; color: #6c757d; margin-bottom: 1rem;"></i>
            <p style="color: #6c757d;">No news articles found.</p>
            <a href="{{ route('admin.news.create') }}" style="display: inline-block; margin-top: 1rem; background: #ffc107; color: #1a2b3c; padding: 0.75rem 2rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
                Create Your First News Post
            </a>
        </div>
        @endforelse
    </div>
</div>

<script>
    // Simple category filter
    document.getElementById('categoryFilter').addEventListener('change', function() {
        const selectedCategory = this.value;
        const newsCards = document.querySelectorAll('.news-card');
        
        newsCards.forEach(card => {
            if (selectedCategory === '' || card.dataset.category === selectedCategory) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
@endsection