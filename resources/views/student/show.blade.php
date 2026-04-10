{{-- resources/views/student/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Submission Details #{{ $submission->id }}</h4>
                <span class="badge bg-{{ $submission->status_badge }} float-end">
                    {{ ucfirst($submission->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Full Name:</strong>
                        <p>{{ $submission->full_name }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Student ID:</strong>
                        <p>{{ $submission->student_id }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <strong>Semester:</strong>
                        <p>{{ $submission->semester }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Academic Year:</strong>
                        <p>{{ $submission->academic_year }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Batch:</strong>
                        <p>{{ $submission->batch }}</p>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <strong>Document Category:</strong>
                        <p><span class="badge bg-{{ $submission->category_badge }}">{{ ucfirst($submission->document_category) }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Project Title:</strong>
                        <p>{{ $submission->project_title ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <strong>Original Filename:</strong>
                        <p><code>{{ $submission->original_filename }}</code></p>
                    </div>
                    <div class="col-md-4">
                        <strong>Stored As:</strong>
                        <p><code>{{ $submission->stored_filename }}</code></p>
                    </div>
                    <div class="col-md-4">
                        <strong>File Size:</strong>
                        <p>{{ $submission->formatted_file_size }}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Description:</strong>
                    <p>{{ $submission->description ?? 'No description provided.' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Submitted On:</strong>
                    <p>{{ $submission->submitted_at->format('F j, Y, g:i a') }}</p>
                </div>

                @if($submission->admin_notes)
                <div class="alert alert-info">
                    <strong>Admin Notes:</strong><br>
                    {{ $submission->admin_notes }}
                </div>
                @endif

                <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                    <a href="{{ route('student.submission.download', $submission->id) }}" class="btn btn-success">
                        <i class="fas fa-download"></i> Download File
                    </a>
                    <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection