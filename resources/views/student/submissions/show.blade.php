@extends('layouts.app')

@section('title', 'Submission Details')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Submission Details #{{ $submission->id }}</h4>
                    <span>
                        @if($submission->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($submission->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Full Name:</strong>
                            <p class="border-bottom pb-1">{{ $submission->full_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Student ID:</strong>
                            <p class="border-bottom pb-1">{{ $submission->student_id }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Semester:</strong>
                            <p class="border-bottom pb-1">{{ $submission->semester }}</p>
                        </div>
                        <div class="col-md-4">
                            <strong>Academic Year:</strong>
                            <p class="border-bottom pb-1">{{ $submission->academic_year }}</p>
                        </div>
                        <div class="col-md-4">
                            <strong>Batch:</strong>
                            <p class="border-bottom pb-1">{{ $submission->batch }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Document Category:</strong>
                            <p class="border-bottom pb-1">
                                @if($submission->document_category == 'letter')
                                    📄 Letter
                                @elseif($submission->document_category == 'proposal')
                                    📑 Project Proposal
                                @elseif($submission->document_category == 'internship')
                                    💼 Internship Report
                                @elseif($submission->document_category == 'project_document')
                                    📁 Project Document
                                @else
                                    📎 Other
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <strong>Project Title:</strong>
                            <p class="border-bottom pb-1">{{ $submission->project_title ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Original Filename:</strong>
                            <p class="border-bottom pb-1"><code>{{ $submission->original_filename }}</code></p>
                        </div>
                        <div class="col-md-4">
                            <strong>Stored As:</strong>
                            <p class="border-bottom pb-1"><code>{{ $submission->stored_filename }}</code></p>
                        </div>
                        <div class="col-md-4">
                            <strong>File Size:</strong>
                            <p class="border-bottom pb-1">{{ number_format($submission->file_size / 1024, 2) }} KB</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Description:</strong>
                        <p class="border-bottom pb-1">{{ $submission->description ?? 'No description provided.' }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Submitted On:</strong>
                        <p class="border-bottom pb-1">{{ $submission->created_at->format('F j, Y, g:i a') }}</p>
                    </div>

                    @if($submission->admin_notes)
                    <div class="alert alert-info">
                        <strong><i class="fas fa-comment"></i> Admin Notes:</strong><br>
                        {{ $submission->admin_notes }}
                    </div>
                    @endif

                    <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-4">
                        <a href="{{ route('student.submission.download', $submission->id) }}" class="btn btn-success">
                            <i class="fas fa-download"></i> Download File
                        </a>
                        <a href="{{ route('student.submission.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Submissions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection