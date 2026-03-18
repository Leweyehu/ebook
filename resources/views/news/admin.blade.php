@extends('layouts.app')

@section('title', 'Manage News')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Manage News & Events</h1>
        <p>Post, edit, or remove news and events</p>
    </div>
</div>

<div class="container">
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 10px; margin-bottom: 2rem;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 10px; margin-bottom: 2rem;">
            {{ session('error') }}
        </div>
    @endif

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="color: #1a2b3c;">All News & Events</h2>
        <a href="{{ route('admin.news.create') }}" style="background: #ffc107; color: #1a2b3c; padding: 0.8rem 1.5rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
            <i class="fas fa-plus"></i> Post News/Event
        </a>
    </div>

    <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #1a2b3c; color: white;">
                <tr>
                    <th style="padding: 1rem; text-align: left;">Image</th>
                    <th style="padding: 1rem; text-align: left;">Title</th>
                    <th style="padding: 1rem; text-align: left;">Category</th>
                    <th style="padding: 1rem; text-align: left;">Date</th>
                    <th style="padding: 1rem; text-align: left;">Views</th>
                    <th style="padding: 1rem; text-align: left;">Status</th>
                    <th style="padding: 1rem; text-align: left;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $item)
                <tr style="border-bottom: 1px solid #e9ecef;">
                    <td style="padding: 1rem;">
                        @if($item->featured_image)
                            <img src="{{ asset($item->featured_image) }}" alt="" style="width: 50px; height: 50px; border-radius: 5px; object-fit: cover;">
                        @else
                            <div style="width: 50px; height: 50px; border-radius: 5px; background: #e9ecef; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-newspaper" style="color: #6c757d;"></i>
                            </div>
                        @endif
                    </td>
                    <td style="padding: 1rem;">
                        <strong>{{ $item->title }}</strong>
                        <div style="font-size: 0.85rem; color: #6c757d;">
                            {{ $item->created_at->format('M d, Y') }}
                        </div>
                    </td>
                    <td style="padding: 1rem;">
                        <span style="background: {{ 
                            $item->category == 'event' ? '#cff4fc' : 
                            ($item->category == 'announcement' ? '#fff3cd' : '#e2e3e5') 
                        }}; color: {{ 
                            $item->category == 'event' ? '#055160' : 
                            ($item->category == 'announcement' ? '#856404' : '#41464b') 
                        }}; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.85rem;">
                            {{ ucfirst($item->category) }}
                        </span>
                    </td>
                    <td style="padding: 1rem;">
                        @if($item->event_date)
                            <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($item->event_date)->format('M d, Y') }}
                        @else
                            <span style="color: #6c757d;">—</span>
                        @endif
                    </td>
                    <td style="padding: 1rem;">{{ $item->views }}</td>
                    <td style="padding: 1rem;">
                        <span style="background: {{ $item->is_published ? '#d4edda' : '#f8d7da' }}; 
                                     color: {{ $item->is_published ? '#155724' : '#721c24' }}; 
                                     padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.85rem;">
                            {{ $item->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td style="padding: 1rem;">
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.news.edit', $item) }}" style="color: #ffc107; text-decoration: none; padding: 0.3rem 0.8rem; border: 1px solid #ffc107; border-radius: 5px;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.news.toggle-status', $item) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" style="color: {{ $item->is_published ? '#dc3545' : '#28a745' }}; background: none; border: 1px solid currentColor; padding: 0.3rem 0.8rem; border-radius: 5px; cursor: pointer;">
                                    <i class="fas {{ $item->is_published ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.news.destroy', $item) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this news item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: #dc3545; background: none; border: 1px solid #dc3545; padding: 0.3rem 0.8rem; border-radius: 5px; cursor: pointer;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 3rem; text-align: center; color: #6c757d;">
                        <i class="fas fa-newspaper" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                        <p>No news or events found. Click "Post News/Event" to create one.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection