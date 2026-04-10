@extends('layouts.app')

@section('title', 'My Submissions')

@section('content')
<style>
    :root {
        --primary: #003E72;
        --primary-dark: #002b4f;
        --primary-light: #1a5d8f;
        --secondary: #ffc107;
        --success: #28a745;
        --danger: #dc3545;
        --warning: #ffc107;
        --info: #17a2b8;
        --gray-light: #f8f9fc;
        --gray-border: #e3e8ef;
    }

    /* Header Section */
    .submissions-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .submissions-header::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 250px;
        height: 250px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }

    .submissions-header::after {
        content: '';
        position: absolute;
        bottom: -20%;
        left: -5%;
        width: 180px;
        height: 180px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    /* Stats Cards */
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.25rem;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        background: rgba(0,62,114,0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
    }

    .stat-icon i {
        font-size: 1.5rem;
        color: var(--primary);
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* Table Styles */
    .submissions-table-container {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 25px rgba(0,0,0,0.05);
    }

    .table-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        padding: 1rem 1.5rem;
    }

    .table-header h5 {
        margin: 0;
        color: white;
        font-weight: 600;
    }

    .custom-table {
        margin-bottom: 0;
    }

    .custom-table thead th {
        background: #f8f9fc;
        border-bottom: 2px solid var(--gray-border);
        padding: 1rem 1rem;
        font-weight: 600;
        color: var(--primary);
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .custom-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid var(--gray-border);
    }

    .custom-table tbody tr:hover {
        background: #f8f9fc;
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .custom-table tbody td {
        padding: 1rem;
        vertical-align: middle;
    }

    /* Status Badges */
    .badge-pending {
        background: linear-gradient(135deg, #fff3cd 0%, #ffe69e 100%);
        color: #856404;
        padding: 0.35rem 0.85rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .badge-approved {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
        padding: 0.35rem 0.85rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .badge-rejected {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
        padding: 0.35rem 0.85rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    /* Document Type Icons */
    .doc-type {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .doc-letter { background: #e3f2fd; color: #0d47a1; }
    .doc-proposal { background: #fff3e0; color: #e65100; }
    .doc-internship { background: #e8f5e9; color: #1b5e20; }
    .doc-project { background: #f3e5f5; color: #4a148c; }
    .doc-other { background: #eceff1; color: #455a64; }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-view {
        background: rgba(23, 162, 184, 0.1);
        color: var(--info);
    }

    .btn-view:hover {
        background: var(--info);
        color: white;
        transform: translateY(-2px);
    }

    .btn-download {
        background: rgba(40, 167, 69, 0.1);
        color: var(--success);
    }

    .btn-download:hover {
        background: var(--success);
        color: white;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: rgba(220, 53, 69, 0.1);
        color: var(--danger);
    }

    .btn-delete:hover {
        background: var(--danger);
        color: white;
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .empty-icon i {
        font-size: 3rem;
        color: var(--primary);
    }

    /* File Size */
    .file-size {
        font-family: monospace;
        font-size: 0.8rem;
        font-weight: 500;
        color: #6c757d;
    }

    /* Date */
    .date-cell {
        font-size: 0.8rem;
        white-space: nowrap;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .submissions-header {
            padding: 1.5rem;
        }
        
        .stat-card {
            margin-bottom: 1rem;
        }
        
        .custom-table thead {
            display: none;
        }
        
        .custom-table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .custom-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--gray-border);
        }
        
        .custom-table tbody td:last-child {
            border-bottom: none;
        }
        
        .custom-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--primary);
            font-size: 0.75rem;
            text-transform: uppercase;
        }
        
        .action-buttons {
            justify-content: flex-end;
        }
    }
</style>

<div class="container">
    <!-- Header Section -->
    <div class="submissions-header">
        <div style="position: relative; z-index: 1;">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h2 class="fw-bold mb-2">
                        <i class="fas fa-file-alt me-2"></i> My Submissions
                    </h2>
                    <p class="mb-0 opacity-75">Track and manage all your submitted documents</p>
                </div>
                <a href="{{ route('student.submission.create') }}" class="btn btn-light rounded-pill px-4 py-2 fw-semibold" style="color: var(--primary);">
                    <i class="fas fa-plus-circle me-2"></i> New Submission
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-value">{{ $stats['total'] ?? $submissions->total() }}</div>
                <div class="stat-label">Total Submissions</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-value">{{ $stats['pending'] ?? $submissions->where('status', 'pending')->count() }}</div>
                <div class="stat-label">Pending Review</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value">{{ $stats['approved'] ?? $submissions->where('status', 'approved')->count() }}</div>
                <div class="stat-label">Approved</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-value">{{ $stats['rejected'] ?? $submissions->where('status', 'rejected')->count() }}</div>
                <div class="stat-label">Rejected</div>
            </div>
        </div>
    </div>

    <!-- Submissions Table -->
    <div class="submissions-table-container">
        <div class="table-header">
            <h5><i class="fas fa-list me-2"></i> All Submissions</h5>
        </div>
        
        <div class="table-responsive">
            <table class="custom-table table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Document Type</th>
                        <th>Title / Project</th>
                        <th>Submitted Date</th>
                        <th>File Size</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $submission)
                    <tr>
                        <td data-label="ID">
                            <span class="fw-bold text-primary">#{{ $submission->id }}</span>
                        </td>
                        <td data-label="Document Type">
                            @php
                                $typeClass = '';
                                $typeIcon = '';
                                $typeLabel = '';
                                
                                switch($submission->document_category) {
                                    case 'letter':
                                        $typeClass = 'doc-letter';
                                        $typeIcon = 'fa-envelope-open-text';
                                        $typeLabel = 'Letter';
                                        break;
                                    case 'proposal':
                                        $typeClass = 'doc-proposal';
                                        $typeIcon = 'fa-file-powerpoint';
                                        $typeLabel = 'Proposal';
                                        break;
                                    case 'internship':
                                        $typeClass = 'doc-internship';
                                        $typeIcon = 'fa-briefcase';
                                        $typeLabel = 'Internship';
                                        break;
                                    case 'project_document':
                                        $typeClass = 'doc-project';
                                        $typeIcon = 'fa-folder-open';
                                        $typeLabel = 'Project';
                                        break;
                                    default:
                                        $typeClass = 'doc-other';
                                        $typeIcon = 'fa-file';
                                        $typeLabel = 'Other';
                                }
                            @endphp
                            <span class="doc-type {{ $typeClass }}">
                                <i class="fas {{ $typeIcon }}"></i> {{ $typeLabel }}
                            </span>
                        </td>
                        <td data-label="Title">
                            <strong>{{ $submission->project_title ?? '—' }}</strong>
                        </td>
                        <td data-label="Submitted Date" class="date-cell">
                            <i class="far fa-calendar-alt text-muted me-1"></i>
                            {{ $submission->created_at->format('M d, Y') }}
                            <br>
                            <small class="text-muted">{{ $submission->created_at->format('h:i A') }}</small>
                        </td>
                        <td data-label="File Size" class="file-size">
                            <i class="fas fa-database me-1"></i>
                            {{ number_format($submission->file_size / 1024, 2) }} KB
                        </td>
                        <td data-label="Status">
                            @if($submission->status == 'pending')
                                <span class="badge-pending">
                                    <i class="fas fa-spinner fa-pulse"></i> Pending
                                </span>
                            @elseif($submission->status == 'approved')
                                <span class="badge-approved">
                                    <i class="fas fa-check-circle"></i> Approved
                                </span>
                            @else
                                <span class="badge-rejected">
                                    <i class="fas fa-times-circle"></i> Rejected
                                </span>
                            @endif
                        </td>
                        <td data-label="Actions">
                            <div class="action-buttons">
                                <a href="{{ route('student.submission.show', $submission->id) }}" class="btn-icon btn-view" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('student.submission.download', $submission->id) }}" class="btn-icon btn-download" title="Download">
                                    <i class="fas fa-download"></i>
                                </a>
                                @if($submission->status == 'pending')
                                    <button type="button" class="btn-icon btn-delete" title="Delete" onclick="confirmDelete({{ $submission->id }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <form id="delete-form-{{ $submission->id }}" action="{{ route('student.submission.destroy', $submission->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <h5 class="mb-2">No Submissions Yet</h5>
                                <p class="text-muted mb-4">You haven't submitted any documents yet.</p>
                                <a href="{{ route('student.submission.create') }}" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-plus-circle me-2"></i> Upload Your First Document
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($submissions->hasPages())
        <div class="p-3 border-top">
            {{ $submissions->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

<!-- SweetAlert2 for better delete confirmation -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection