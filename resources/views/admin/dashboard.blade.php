@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Quick Stats Row -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 10px;">
        <i class="fas fa-users" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ \App\Models\Staff::count() }}</h3>
        <p>Total Staff</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 1.5rem; border-radius: 10px;">
        <i class="fas fa-user-graduate" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ \App\Models\Student::count() }}</h3>
        <p>Total Students</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 1.5rem; border-radius: 10px;">
        <i class="fas fa-newspaper" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ \App\Models\News::count() }}</h3>
        <p>News Posts</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 1.5rem; border-radius: 10px;">
        <i class="fas fa-envelope" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ \App\Models\Contact::where('status', 'unread')->count() }}</h3>
        <p>Unread Messages</p>
    </div>
</div>

<!-- Welcome Card -->
<div style="background: linear-gradient(135deg, #1a2b3c 0%, #2c3e50 100%); color: white; padding: 2rem; border-radius: 10px; margin-bottom: 2rem;">
    <h2 style="margin-bottom: 0.5rem;">Welcome back, {{ Auth::user()->name }}!</h2>
    <p style="opacity: 0.9;">You're logged in as Administrator. Manage your department from the sidebar.</p>
</div>

<!-- Quick Actions -->
<h2 style="color: #1a2b3c; margin-bottom: 1.5rem;">Quick Actions</h2>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
    <a href="{{ route('admin.staff.create') }}" style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); text-decoration: none; color: #1a2b3c; text-align: center; transition: transform 0.3s;">
        <i class="fas fa-user-plus" style="font-size: 2rem; color: #28a745; margin-bottom: 0.5rem;"></i>
        <h3>Add New Staff</h3>
    </a>
    
    <a href="{{ route('admin.news.create') }}" style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); text-decoration: none; color: #1a2b3c; text-align: center; transition: transform 0.3s;">
        <i class="fas fa-plus-circle" style="font-size: 2rem; color: #ffc107; margin-bottom: 0.5rem;"></i>
        <h3>Create News Post</h3>
    </a>
    
    <a href="{{ route('admin.students.index') }}" style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); text-decoration: none; color: #1a2b3c; text-align: center; transition: transform 0.3s;">
        <i class="fas fa-upload" style="font-size: 2rem; color: #17a2b8; margin-bottom: 0.5rem;"></i>
        <h3>Bulk Upload Students</h3>
    </a>
    
    <a href="{{ route('admin.contacts.index') }}" style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); text-decoration: none; color: #1a2b3c; text-align: center; transition: transform 0.3s;">
        <i class="fas fa-envelope" style="font-size: 2rem; color: #dc3545; margin-bottom: 0.5rem;"></i>
        <h3>View Messages</h3>
        @if(\App\Models\Contact::where('status', 'unread')->count() > 0)
            <span style="background: #dc3545; color: white; padding: 0.2rem 0.5rem; border-radius: 3px; font-size: 0.8rem; margin-top: 0.5rem; display: inline-block;">
                {{ \App\Models\Contact::where('status', 'unread')->count() }} Unread
            </span>
        @endif
    </a>
</div>
@endsection