@extends('layouts.app')

@section('title', 'Create News')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Create News Article</h1>
    </div>
</div>

<div class="container">
    <!-- Include Admin Header -->
    @include('admin.partials.admin-header')

    <!-- Navigation Buttons -->
    <div style="display: flex; gap: 1rem; margin-bottom: 2rem;">
        <a href="{{ route('admin.dashboard') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #6c757d; color: white; padding: 0.5rem 1.5rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
            <i class="fas fa-arrow-left"></i> Dashboard
        </a>
        <a href="{{ route('admin.news.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #ffc107; color: #1a2b3c; padding: 0.5rem 1.5rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
            <i class="fas fa-arrow-left"></i> Back to News List
        </a>
    </div>

    <!-- Create Form -->
    <div style="background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Title *</label>
                <input type="text" name="title" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            
            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Slug *</label>
                <input type="text" name="slug" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                <small style="color: #6c757d;">URL-friendly version of the title (e.g., "my-news-article")</small>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Category *</label>
                    <select name="category" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="news">News</option>
                        <option value="event">Event</option>
                        <option value="announcement">Announcement</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Event Date (if event)</label>
                    <input type="date" name="event_date" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Event Location (if event)</label>
                    <input type="text" name="event_location" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                </div>
            </div>
            
            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Content *</label>
                <textarea name="content" rows="10" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;"></textarea>
            </div>
            
            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Featured Image</label>
                <input type="file" name="featured_image" accept="image/*" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            
            <div style="margin-bottom: 2rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="checkbox" name="is_published" value="1" checked>
                    <span>Publish immediately</span>
                </label>
            </div>
            
            <div style="display: flex; gap: 1rem;">
                <button type="submit" style="background: #28a745; color: white; padding: 1rem 2rem; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-save"></i> Create News
                </button>
                <a href="{{ route('admin.news.index') }}" style="background: #6c757d; color: white; padding: 1rem 2rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection