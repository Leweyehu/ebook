@extends('layouts.app')

@section('title', 'Submission Details')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Submission Details #{{ $submission->id }}</h4>
                    <div>
                        <a href="{{ route('admin.document-submissions.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    
                    <!-- Status Badge -->
                    <div class="alert alert-info">
                        <strong>Current Status:</strong>
                        @if($submission->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending Review</span>
                        @elseif($submission->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Student Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Full Name</th>
                                    <td>{{ $submission->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>Student ID</th>
                                    <td>{{ $submission->student_id }}</td>
                                </tr>
                                <tr>
                                    <th>Semester</th>
                                    <td>{{ $submission->semester }}</td>
                                </tr>
                                <tr>
                                    <th>Academic Year</th>
                                    <td>{{ $submission->academic_year }}</td>
                                </tr>
                                <tr>
                                    <th>Batch</th>
                                    <td>{{ $submission->batch }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Document Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Document Type</th>
                                    <td>
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
                                    </td>
                                </tr>
                                <tr>
                                    <th>Project Title</th>
                                    <td>{{ $submission->project_title ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Original Filename</th>
                                    <td><code>{{ $submission->original_filename }}</code></td>
                                </tr>
                                <tr>
                                    <th>Stored As</th>
                                    <td><code>{{ $submission->stored_filename }}</code></td>
                                </tr>
                                <tr>
                                    <th>File Size</th>
                                    <td>{{ number_format($submission->file_size / 1024, 2) }} KB</td>
                                </tr>
                                <tr>
                                    <th>MIME Type</th>
                                    <td>{{ $submission->mime_type }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Description</h5>
                            <p class="border p-3 bg-light">{{ $submission->description ?? 'No description provided.' }}</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Submission Details</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Submitted Date</th>
                                    <td>{{ $submission->submitted_at->format('F j, Y, g:i a') }}</td>
                                </tr>
                                <tr>
                                    <th>Reviewed Date</th>
                                    <td>{{ $submission->reviewed_at ? $submission->reviewed_at->format('F j, Y, g:i a') : 'Not reviewed yet' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Admin Notes</h5>
                            <div class="border p-3 bg-light">
                                {{ $submission->admin_notes ?? 'No admin notes yet.' }}
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <!-- Action Buttons -->
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Actions</h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.document-submissions.download', $submission->id) }}" class="btn btn-success">
                                    <i class="fas fa-download"></i> Download Document
                                </a>
                                
                                @if($submission->status == 'pending')
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#approveModal">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                @endif
                                
                                <form action="{{ route('admin.document-submissions.destroy', $submission->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this submission? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-dark">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.document-submissions.approve', $submission->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Approve Document Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to approve this document submission?</p>
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Admin Notes (Optional)</label>
                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="Add any notes for the student..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Yes, Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.document-submissions.reject', $submission->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Reject Document Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to reject this document submission?</p>
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Reason for Rejection <span class="text-danger">*</span></label>
                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="Please provide a reason for rejection..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection