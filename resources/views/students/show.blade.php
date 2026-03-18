@extends('layouts.app')

@section('title', $student->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($student->profile_image)
                        <img src="{{ asset($student->profile_image) }}" 
                             alt="{{ $student->name }}" 
                             class="rounded-circle img-fluid mb-3"
                             style="width: 200px; height: 200px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                             style="width: 200px; height: 200px; font-size: 5rem;">
                            {{ substr($student->name, 0, 1) }}
                        </div>
                    @endif
                    
                    <h3>{{ $student->name }}</h3>
                    <p class="text-muted">
                        Year {{ $student->year }} Student
                        @if($student->section)
                            • Section {{ $student->section }}
                        @endif
                    </p>
                    
                    @if($student->batch)
                        <p class="text-muted">
                            <i class="fas fa-calendar-alt"></i> Batch: {{ $student->batch }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">About</h4>
                </div>
                <div class="card-body">
                    @if($student->bio)
                        <p>{{ $student->bio }}</p>
                    @else
                        <p class="text-muted">No bio available.</p>
                    @endif
                    
                    @if($student->achievements)
                        <h5 class="mt-4">Achievements</h5>
                        <p>{{ $student->achievements }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection