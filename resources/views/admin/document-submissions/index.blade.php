@extends('layouts.admin')

@section('title', 'Document Submissions Management')
@section('page-title', 'Document Submissions')

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

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.25rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        position: relative;
        overflow: hidden;
        border-left: 4px solid;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .stat-card.primary { border-left-color: var(--primary); }
    .stat-card.warning { border-left-color: var(--warning); }
    .stat-card.info { border-left-color: var(--info); }
    .stat-card.success { border-left-color: var(--success); }
    .stat-card.danger { border-left-color: var(--danger); }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.75rem;
        font-size: 1.5rem;
    }

    .stat-icon.primary-bg { background: rgba(0,62,114,0.1); color: var(--primary); }
    .stat-icon.warning-bg { background: rgba(255,193,7,0.1); color: var(--warning); }
    .stat-icon.info-bg { background: rgba(23,162,184,0.1); color: var(--info); }
    .stat-icon.success-bg { background: rgba(40,167,69,0.1); color: var(--success); }
    .stat-icon.danger-bg { background: rgba(220,53,69,0.1); color: var(--danger); }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.8rem;
        font-weight: 500;
    }

    /* Filter Bar */
    .filter-bar {
        background: white;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .search-box {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--gray-light);
        padding: 0.5rem 1rem;
        border-radius: 40px;
        flex: 1;
        max-width: 300px;
    }

    .search-box i {
        color: #6c757d;
    }

    .search-box input {
        border: none;
        background: none;
        outline: none;
        width: 100%;
    }

    .filter-select {
        padding: 0.5rem 1rem;
        border: 1px solid var(--gray-border);
        border-radius: 8px;
        background: white;
    }

    .btn-export {
        background: linear-gradient(135deg, var(--success), #20c997);
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40,167,69,0.3);
    }

    /* Table Container */
    .table-container {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .submissions-table {
        width: 100%;
        border-collapse: collapse;
    }

    .submissions-table thead th {
        background: #f8f9fc;
        padding: 1rem 1rem;
        font-weight: 600;
        color: var(--primary);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--gray-border);
    }

    .submissions-table tbody tr {
        border-bottom: 1px solid var(--gray-border);
        transition: all 0.2s ease;
    }

    .submissions-table tbody tr:hover {
        background: #f8f9fc;
    }

    .submissions-table tbody td {
        padding: 1rem;
        vertical-align: middle;
    }

    /* Status Badges */
    .badge-pending {
        background: #fff3cd;
        color: #856404;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .badge-approved {
        background: #d4edda;
        color: #155724;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .badge-rejected {
        background: #f8d7da;
        color: #721c24;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    /* Priority Badges */
    .priority-high {
        background: #f8d7da;
        color: #721c24;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .priority-medium {
        background: #fff3cd;
        color: #856404;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .priority-low {
        background: #d4edda;
        color: #155724;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    /* Document Type Badges */
    .doc-letter { background: #e3f2fd; color: #0d47a1; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600; display: inline-block; }
    .doc-proposal { background: #fff3e0; color: #e65100; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600; display: inline-block; }
    .doc-internship { background: #e8f5e9; color: #1b5e20; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600; display: inline-block; }
    .doc-project { background: #f3e5f5; color: #4a148c; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600; display: inline-block; }
    .doc-other { background: #eceff1; color: #455a64; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600; display: inline-block; }

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
        border: none;
        cursor: pointer;
    }

    .btn-view { background: rgba(23, 162, 184, 0.1); color: var(--info); }
    .btn-view:hover { background: var(--info); color: white; }

    .btn-download { background: rgba(40, 167, 69, 0.1); color: var(--success); }
    .btn-download:hover { background: var(--success); color: white; }

    .btn-approve { background: rgba(40, 167, 69, 0.1); color: var(--success); }
    .btn-approve:hover { background: var(--success); color: white; }

    .btn-reject { background: rgba(220, 53, 69, 0.1); color: var(--danger); }
    .btn-reject:hover { background: var(--danger); color: white; }

    .btn-delete { background: rgba(108, 117, 125, 0.1); color: #6c757d; }
    .btn-delete:hover { background: #6c757d; color: white; }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .empty-icon i {
        font-size: 2rem;
        color: var(--primary);
    }

    /* Pagination */
    .pagination-wrapper {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--gray-border);
        background: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .submissions-table thead {
            display: none;
        }
        
        .submissions-table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .submissions-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--gray-border);
        }
        
        .submissions-table tbody td:last-child {
            border-bottom: none;
        }
        
        .submissions-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--primary);
            font-size: 0.7rem;
            text-transform: uppercase;
        }
        
        .filter-bar {
            flex-direction: column;
            align-items: stretch;
        }
        
        .search-box {
            max-width: 100%;
        }
    }
</style>

<div class="admin-document-submissions">
    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-icon primary-bg">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Submissions</div>
        </div>
        <div class="stat-card warning">
            <div class="stat-icon warning-bg">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-value">{{ $stats['pending'] }}</div>
            <div class="stat-label">Pending</div>
        </div>
        <div class="stat-card info">
            <div class="stat-icon info-bg">
                <i class="fas fa-spinner"></i>
            </div>
            <div class="stat-value">{{ $stats['pending'] }}</div>
            <div class="stat-label">Under Review</div>
        </div>
        <div class="stat-card success">
            <div class="stat-icon success-bg">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value">{{ $stats['approved'] }}</div>
            <div class="stat-label">Resolved</div>
        </div>
        <div class="stat-card danger">
            <div class="stat-icon danger-bg">
                <i class="fas fa-fire"></i>
            </div>
            <div class="stat-value">{{ $stats['rejected'] }}</div>
            <div class="stat-label">Rejected</div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <form method="GET" action="{{ route('admin.document-submissions.index') }}" id="filterForm" style="display: flex; gap: 1rem; flex-wrap: wrap; flex: 1;">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Search by name, ID..." value="{{ request('search') }}">
            </div>
            <select name="status" class="filter-select">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <select name="category" class="filter-select">
                <option value="">All Categories</option>
                <option value="letter" {{ request('category') == 'letter' ? 'selected' : '' }}>Letter</option>
                <option value="proposal" {{ request('category') == 'proposal' ? 'selected' : '' }}>Proposal</option>
                <option value="internship" {{ request('category') == 'internship' ? 'selected' : '' }}>Internship</option>
                <option value="project_document" {{ request('category') == 'project_document' ? 'selected' : '' }}>Project</option>
                <option value="other" {{ request('category') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
            <button type="submit" class="btn-filter" style="background: var(--primary); color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px;">
                <i class="fas fa-filter"></i> Filter
            </button>
            <a href="{{ route('admin.document-submissions.index') }}" class="btn-reset" style="background: #6c757d; color: white; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none;">
                <i class="fas fa-sync-alt"></i> Reset
            </a>
        </form>
        <a href="{{ route('admin.document-submissions.export', request()->query()) }}" class="btn-export">
            <i class="fas fa-download"></i> Export to CSV
        </a>
    </div>

    <!-- Table Container -->
    <div class="table-container">
        <table class="submissions-table">
            <thead>
                <tr>
                    <th>Ref No</th>
                    <th>Date</th>
                    <th>Student Name</th>
                    <th>Student ID</th>
                    <th>Document Type</th>
                    <th>Title</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($submissions as $submission)
                <tr>
                    <td data-label="Ref No">
                        <span class="fw-bold text-primary">#{{ $submission->id }}</span>
                    </td>
                    <td data-label="Date">
                        {{ $submission->created_at->format('M d, Y') }}
                    </td>
                    <td data-label="Student Name">
                        <strong>{{ $submission->full_name }}</strong>
                    </td>
                    <td data-label="Student ID">
                        {{ $submission->student_id }}
                    </td>
                    <td data-label="Document Type">
                        @php
                            $typeClass = '';
                            $typeIcon = '';
                            $typeLabel = '';
                            switch($submission->document_category) {
                                case 'letter': $typeClass = 'doc-letter'; $typeIcon = 'fa-envelope'; $typeLabel = 'Letter'; break;
                                case 'proposal': $typeClass = 'doc-proposal'; $typeIcon = 'fa-file-powerpoint'; $typeLabel = 'Proposal'; break;
                                case 'internship': $typeClass = 'doc-internship'; $typeIcon = 'fa-briefcase'; $typeLabel = 'Internship'; break;
                                case 'project_document': $typeClass = 'doc-project'; $typeIcon = 'fa-folder-open'; $typeLabel = 'Project'; break;
                                default: $typeClass = 'doc-other'; $typeIcon = 'fa-file'; $typeLabel = 'Other';
                            }
                        @endphp
                        <span class="{{ $typeClass }}">
                            <i class="fas {{ $typeIcon }}"></i> {{ $typeLabel }}
                        </span>
                    </td>
                    <td data-label="Title">
                        {{ Str::limit($submission->project_title ?? '—', 30) }}
                    </td>
                    <td data-label="Priority">
                        @if($submission->status == 'pending')
                            <span class="priority-high"><i class="fas fa-fire"></i> Urgent</span>
                        @elseif($submission->status == 'approved')
                            <span class="priority-low"><i class="fas fa-check"></i> Normal</span>
                        @else
                            <span class="priority-medium"><i class="fas fa-clock"></i> Low</span>
                        @endif
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
                            <a href="{{ route('admin.document-submissions.show', $submission->id) }}" class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.document-submissions.download', $submission->id) }}" class="btn-icon btn-download" title="Download">
                                <i class="fas fa-download"></i>
                            </a>
                            @if($submission->status == 'pending')
                                <form action="{{ route('admin.document-submissions.approve', $submission->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-icon btn-approve" title="Approve" onclick="return confirm('Approve this submission?')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <button type="button" class="btn-icon btn-reject" title="Reject" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $submission->id }}">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                            <form action="{{ route('admin.document-submissions.destroy', $submission->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this submission?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- Reject Modal -->
                @if($submission->status == 'pending')
                <div class="modal fade" id="rejectModal{{ $submission->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">
                                    <i class="fas fa-times-circle me-2"></i> Reject Submission #{{ $submission->id }}
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('admin.document-submissions.reject', $submission->id) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <p>Are you sure you want to reject this submission?</p>
                                    <div class="alert alert-warning">
                                        <strong>Student:</strong> {{ $submission->full_name }}<br>
                                        <strong>Document:</strong> {{ $submission->project_title ?? 'Untitled' }}
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Reason for Rejection <span class="text-danger">*</span></label>
                                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="Please provide a reason..." required></textarea>
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
                @endif
                @empty
                <tr>
                    <td colspan="9" class="text-center">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <h5 class="mb-2">No Submissions Found</h5>
                            <p class="text-muted mb-0">There are no document submissions matching your criteria.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($submissions->hasPages())
        <div class="pagination-wrapper">
            {{ $submissions->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    // Auto-submit filter on select change
    document.querySelectorAll('.filter-select').forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });
</script>
@endsection