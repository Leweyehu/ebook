@extends('layouts.app')

@section('title', 'Edit News')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Edit News/Event</h1>
        <p>Update information</p>
    </div>
</div>

<div class="container">
    <div style="max-width: 800px; margin: 0 auto; background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if($errors->any())
                <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem;">
                    <ul style="margin-bottom: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($news->featured_image)
            <div style="text-align: center; margin-bottom: 2rem;">
                <img src="{{ asset($news->featured_image) }}" alt="" style="max-width: 300px; max-height: 200px; border-radius: 10px;">
            </div>
            @endif

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                    <i class="fas fa-heading" style="color: #ffc107; margin-right: 0.5rem;"></i>Title *
                </label>
                <input type="text" name="title" value="{{ old('title', $news->title) }}" required
                       style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                @error('title') <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                    <i class="fas fa-tag" style="color: #ffc107; margin-right: 0.5rem;"></i>Category *
                </label>
                <select name="category" required style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                    <option value="news" {{ old('category', $news->category) == 'news' ? 'selected' : '' }}>News</option>
                    <option value="event" {{ old('category', $news->category) == 'event' ? 'selected' : '' }}>Event</option>
                    <option value="announcement" {{ old('category', $news->category) == 'announcement' ? 'selected' : '' }}>Announcement</option>
                </select>
            </div>

            <div id="eventFields" style="display: {{ old('category', $news->category) == 'event' ? 'block' : 'none' }}; margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 10px;">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                        <i class="fas fa-calendar" style="color: #ffc107; margin-right: 0.5rem;"></i>Event Date
                    </label>
                    <input type="date" name="event_date" value="{{ old('event_date', $news->event_date ? $news->event_date->format('Y-m-d') : '') }}"
                           style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                        <i class="fas fa-map-marker-alt" style="color: #ffc107; margin-right: 0.5rem;"></i>Event Location
                    </label>
                    <input type="text" name="event_location" value="{{ old('event_location', $news->event_location) }}"
                           style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                    <i class="fas fa-image" style="color: #ffc107; margin-right: 0.5rem;"></i>Featured Image
                </label>
                <input type="file" name="featured_image" accept="image/*"
                       style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                <p style="color: #6c757d; font-size: 0.85rem; margin-top: 0.3rem;">Leave empty to keep current image</p>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                    <i class="fas fa-align-left" style="color: #ffc107; margin-right: 0.5rem;"></i>Content *
                </label>
                <textarea name="content" rows="10" required
                          style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">{{ old('content', $news->content) }}</textarea>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                    <i class="fas fa-toggle-on" style="color: #ffc107; margin-right: 0.5rem;"></i>Status
                </label>
                <div>
                    <label style="margin-right: 1rem;">
                        <input type="radio" name="is_published" value="1" {{ old('is_published', $news->is_published) ? 'checked' : '' }}> Published
                    </label>
                    <label>
                        <input type="radio" name="is_published" value="0" {{ old('is_published', $news->is_published) ? '' : 'checked' }}> Draft
                    </label>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" style="background: #ffc107; color: #1a2b3c; padding: 1rem 2rem; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('admin.news.index') }}" style="background: #6c757d; color: white; padding: 1rem 2rem; border-radius: 5px; text-decoration: none;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelector('select[name="category"]').addEventListener('change', function() {
    document.getElementById('eventFields').style.display = this.value === 'event' ? 'block' : 'none';
});
</script>
@endsection