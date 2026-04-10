@extends('layouts.admin')

@section('title', 'Manage Complaints')
@section('page-title', 'Complaints Management')

@section('content')
<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-file-alt" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['total'] }}</h3>
        <p>Total Complaints</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); color: #1a2b3c; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-clock" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['pending'] }}</h3>
        <p>Pending</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-search" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['reviewing'] }}</h3>
        <p>Under Review</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #28a745 0%, #218838 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-check-circle" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['resolved'] }}</h3>
        <p>Resolved</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['urgent'] }}</h3>
        <p>Urgent</p>
    </div>
</div>

<!-- Export Button -->
<div style="margin-bottom: 1.5rem; text-align: right;">
    <a href="{{ route('admin.complaints.export') }}" class="btn btn-success" style="background: #28a745; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
        <i class="fas fa-download"></i> Export to CSV
    </a>
</div>

<!-- Complaints Table -->
<div style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead style="background: #1a2b3c; color: white;">
            32
                <th style="padding: 1rem; text-align: left;">Ref No</th>
                <th style="padding: 1rem; text-align: left;">Date</th>
                <th style="padding: 1rem; text-align: left;">Name</th>
                <th style="padding: 1rem; text-align: left;">Category</th>
                <th style="padding: 1rem; text-align: left;">Subject</th>
                <th style="padding: 1rem; text-align: left;">Priority</th>
                <th style="padding: 1rem; text-align: left;">Status</th>
                <th style="padding: 1rem; text-align: left;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($complaints as $complaint)
            <tr style="border-bottom: 1px solid #e9ecef; {{ $complaint->priority === 'urgent' ? 'background: #fff3cd;' : '' }}">
                <td style="padding: 1rem;">
                    <code>{{ $complaint->reference_no }}</code>
                </td>
                <td style="padding: 1rem;">{{ $complaint->created_at->format('M d, Y') }}</td>
                <td style="padding: 1rem;">
                    {{ $complaint->name }}
                    @if($complaint->is_anonymous)
                        <span style="background: #6c757d; color: white; padding: 0.2rem 0.4rem; border-radius: 3px; font-size: 0.7rem;">Anonymous</span>
                    @endif
                </td>
                <td style="padding: 1rem;">
                    <span style="background: #e9ecef; padding: 0.25rem 0.5rem; border-radius: 3px;">
                        {{ ucfirst($complaint->category) }}
                    </span>
                </td>
                <td style="padding: 1rem; max-width: 200px;">
                    <strong>{{ Str::limit($complaint->subject, 40) }}</strong>
                </td>
                <td style="padding: 1rem;">
                    @if($complaint->priority === 'urgent')
                        <span style="background: #dc3545; color: white; padding: 0.25rem 0.75rem; border-radius: 20px;">Urgent</span>
                    @elseif($complaint->priority === 'high')
                        <span style="background: #fd7e14; color: white; padding: 0.25rem 0.75rem; border-radius: 20px;">High</span>
                    @elseif($complaint->priority === 'medium')
                        <span style="background: #ffc107; color: #1a2b3c; padding: 0.25rem 0.75rem; border-radius: 20px;">Medium</span>
                    @else
                        <span style="background: #28a745; color: white; padding: 0.25rem 0.75rem; border-radius: 20px;">Low</span>
                    @endif
                </td>
                <td style="padding: 1rem;">
                    @if($complaint->status === 'pending')
                        <span style="background: #ffc107; color: #1a2b3c; padding: 0.25rem 0.75rem; border-radius: 20px;">Pending</span>
                    @elseif($complaint->status === 'reviewing')
                        <span style="background: #17a2b8; color: white; padding: 0.25rem 0.75rem; border-radius: 20px;">Reviewing</span>
                    @elseif($complaint->status === 'resolved')
                        <span style="background: #28a745; color: white; padding: 0.25rem 0.75rem; border-radius: 20px;">Resolved</span>
                    @elseif($complaint->status === 'rejected')
                        <span style="background: #dc3545; color: white; padding: 0.25rem 0.75rem; border-radius: 20px;">Rejected</span>
                    @else
                        <span style="background: #fd7e14; color: white; padding: 0.25rem 0.75rem; border-radius: 20px;">Escalated</span>
                    @endif
                </td>
                <td style="padding: 1rem;">
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <a href="{{ route('admin.complaints.show', $complaint) }}" style="background: #17a2b8; color: white; padding: 0.5rem 0.8rem; border-radius: 5px; text-decoration: none; display: inline-block; font-size: 0.85rem;">
                            <i class="fas fa-eye"></i> View
                        </a>
                        
                        @if($complaint->status === 'pending')
                            <form action="{{ route('admin.complaints.approve', $complaint) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" style="background: #28a745; color: white; border: none; padding: 0.5rem 0.8rem; border-radius: 5px; cursor: pointer; font-size: 0.85rem;" onclick="return confirm('Approve this complaint?')">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                            </form>
                            <form action="{{ route('admin.complaints.reject', $complaint) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" style="background: #dc3545; color: white; border: none; padding: 0.5rem 0.8rem; border-radius: 5px; cursor: pointer; font-size: 0.85rem;" onclick="return confirm('Reject this complaint?')">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('admin.complaints.destroy', $complaint) }}" method="POST" onsubmit="return confirm('Delete this complaint?');" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: #dc3545; color: white; border: none; padding: 0.5rem 0.8rem; border-radius: 5px; cursor: pointer; font-size: 0.85rem;">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="padding: 3rem; text-align: center; color: #6c757d;">
                    <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                    <p>No complaints found.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div style="margin-top: 2rem;">
    {{ $complaints->links() }}
</div>
@endsection