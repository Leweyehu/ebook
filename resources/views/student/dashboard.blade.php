@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">Student Dashboard</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h5 class="mb-3">Welcome, <strong>{{ $user->name ?? Auth::user()->name }}</strong>!</h5>
                            <p class="text-muted">You are logged in as a Student.</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <span class="badge bg-primary p-2">Student ID: {{ $student->student_id ?? 'N/A' }}</span>
                        </div>
                    </div>
                    
                    <!-- Stats Cards -->
                    <div class="row mt-4">
                        <div class="col-md-3 mb-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">Total Courses</h6>
                                            <h3 class="mb-0">{{ $stats['total_courses'] ?? 0 }}</h3>
                                        </div>
                                        <i class="fas fa-book fa-3x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">Pending Assignments</h6>
                                            <h3 class="mb-0">{{ $stats['pending_assignments'] ?? 0 }}</h3>
                                        </div>
                                        <i class="fas fa-tasks fa-3x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">Average Grade</h6>
                                            <h3 class="mb-0">{{ isset($stats['average_grade']) ? number_format($stats['average_grade'], 1) : 0 }}%</h3>
                                        </div>
                                        <i class="fas fa-chart-line fa-3x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">Announcements</h6>
                                            <h3 class="mb-0">{{ $stats['total_notices'] ?? 0 }}</h3>
                                        </div>
                                        <i class="fas fa-bullhorn fa-3x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="row mt-4">
                        <div class="col-md-3 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-book-open fa-4x text-primary mb-3"></i>
                                    <h5 class="card-title">My Courses</h5>
                                    <p class="card-text">View your enrolled courses and materials</p>
                                    <a href="{{ route('student.courses') }}" class="btn btn-primary">
                                        <i class="fas fa-arrow-right"></i> View Courses
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-chart-line fa-4x text-success mb-3"></i>
                                    <h5 class="card-title">My Grades</h5>
                                    <p class="card-text">Check your academic performance</p>
                                    <a href="{{ route('student.grades') }}" class="btn btn-success">
                                        <i class="fas fa-arrow-right"></i> View Grades
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-tasks fa-4x text-warning mb-3"></i>
                                    <h5 class="card-title">Assignments</h5>
                                    <p class="card-text">View and submit your assignments</p>
                                    @if(isset($courses) && $courses->count() > 0)
                                        <a href="{{ route('student.assignments', ['course' => $courses->first()->id]) }}" class="btn btn-warning">
                                            <i class="fas fa-arrow-right"></i> View Assignments
                                        </a>
                                    @else
                                        <button class="btn btn-secondary" disabled>
                                            <i class="fas fa-arrow-right"></i> No Courses
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-bell fa-4x text-info mb-3"></i>
                                    <h5 class="card-title">Announcements</h5>
                                    <p class="card-text">Latest news and updates</p>
                                    <a href="{{ route('student.notices') }}" class="btn btn-info">
                                        <i class="fas fa-arrow-right"></i> View Announcements
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Activity -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="mb-0">Recent Assignments</h5>
                                </div>
                                <div class="card-body">
                                    @if(isset($recentAssignments) && $recentAssignments->count() > 0)
                                        <ul class="list-group">
                                            @foreach($recentAssignments as $assignment)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong>{{ $assignment->title }}</strong>
                                                        <br>
                                                        <small class="text-muted">Due: {{ $assignment->due_date->format('M d, Y') }}</small>
                                                    </div>
                                                    <span class="badge bg-warning">Pending</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted mb-0">No pending assignments.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="mb-0">Recent Announcements</h5>
                                </div>
                                <div class="card-body">
                                    @if(isset($recentNotices) && $recentNotices->count() > 0)
                                        <ul class="list-group">
                                            @foreach($recentNotices as $notice)
                                                <li class="list-group-item">
                                                    <strong>{{ $notice->title }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $notice->created_at->diffForHumans() }}</small>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted mb-0">No recent announcements.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Links -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="mb-0">Quick Links</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <a href="{{ route('student.profile') }}" class="btn btn-outline-primary w-100 mb-2">
                                                <i class="fas fa-user me-2"></i> My Profile
                                            </a>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="{{ route('student.password.change') }}" class="btn btn-outline-warning w-100 mb-2">
                                                <i class="fas fa-key me-2"></i> Change Password
                                            </a>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="{{ route('news') }}" class="btn btn-outline-info w-100 mb-2">
                                                <i class="fas fa-newspaper me-2"></i> News
                                            </a>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="{{ route('contact') }}" class="btn btn-outline-secondary w-100 mb-2">
                                                <i class="fas fa-envelope me-2"></i> Contact
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection