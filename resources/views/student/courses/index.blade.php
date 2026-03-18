@extends('layouts.app')

@section('title', 'My Courses')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">My Courses</h4>
        </div>
        <div class="card-body">
            <p class="text-muted">Your enrolled courses will appear here.</p>
            
            @if(isset($courses) && $courses->count() > 0)
                <div class="row">
                    @foreach($courses as $course)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $course->name ?? 'Course' }}</h5>
                                    <p class="card-text">{{ $course->description ?? 'No description available.' }}</p>
                                    <a href="{{ route('student.courses.show', $course->id ?? 1) }}" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    You are not enrolled in any courses yet.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection