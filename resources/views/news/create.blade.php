@extends('layouts.app')

@section('title', 'Post News/Event')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Post News or Event</h1>
        <p>Share updates with students and visitors</p>
    </div>
</div>

<div class="container">
    <div style="max-width: 800px; margin: 0 auto; background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if($errors->any())
                <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem;">
                    <ul style="margin-bottom: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                    <i class="fas fa-heading" style="color: #ffc107; margin-right: 0.5rem;"></i>Title *
                </label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                @error('title') <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                    <i class="fas fa-tag" style="color: #ffc107; margin-right: 0.5rem;"></i>Category *
                </label>
                <select name="category" required style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                    <option value="">Select Category</option>
                    <option value="news" {{ old('category') == 'news' ? 'selected' : '' }}>News</option>
                    <option value="event" {{ old('category') == 'event' ? 'selected' : '' }}>Event</option>
                    <option value="announcement" {{ old('category') == 'announcement' ? 'selected' : '' }}>Announcement</option>
                </select>
                @error('category') <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p> @enderror
            </div>

            <div id="eventFields" style="display: {{ old('category') == 'event' ? 'block' : 'none' }}; margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 10px;">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                        <i class="fas fa-calendar" style="color: #ffc107; margin-right: 0.5rem;"></i>Event Date
                    </label>
                    <input type="date" name="event_date" value="{{ old('event_date') }}"
                           style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                        <i class="fas fa-map-marker-alt" style="color: #ffc107; margin-right: 0.5rem;"></i>Event Location
                    </label>
                    <input type="text" name="event_location" value="{{ old('event_location') }}"
                           style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                    <i class="fas fa-image" style="color: #ffc107; margin-right: 0.5rem;"></i>Featured Image
                </label>
                <input type="file" name="featured_image" accept="image/*"
                       style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                <p style="color: #6c757d; font-size: 0.85rem; margin-top: 0.3rem;">Recommended size: 1200x630px. Max size: 2MB</p>
                @error('featured_image') <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                    <i class="fas fa-align-left" style="color: #ffc107; margin-right: 0.5rem;"></i>Content *
                </label>
                <textarea name="content" rows="10" required
                          style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">{{ old('content') }}</textarea>
                @error('content') <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p> @enderror
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" style="background: #ffc107; color: #1a2b3c; padding: 1rem 2rem; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-save"></i> Publish
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