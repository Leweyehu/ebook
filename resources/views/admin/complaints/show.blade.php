@extends('layouts.admin')

@section('title', 'Complaint Details')
@section('page-title', 'Complaint Details')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.complaints.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #6c757d; color: white; padding: 0.5rem 1.5rem; border-radius: 5px; text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Back to Complaints
    </a>
</div>

<div style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow: hidden;">
    <div style="padding: 2rem;">
        <!-- Header -->
        <div style="border-bottom: 2px solid #e9ecef; padding-bottom: 1.5rem; margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 style="color: #1a2b3c; margin-bottom: 0.5rem;">{{ $complaint->subject }}</h2>
                    <div style="color: #6c757d;">
                        <span>Reference: <strong>{{ $complaint->reference_no }}</strong></span>
                        @if($complaint->is_anonymous)
                            <span style="margin-left: 1rem; background: #6c757d; color: white; padding: 0.2rem 0.5rem; border-radius: 3px;">Anonymous</span>
                        @endif
                    </div>
                </div>
                <div>
                    @if($complaint->priority === 'urgent')
                        <span style="background: #dc3545; color: white; padding: 0.5rem 1rem; border-radius: 20px;">⚠️ Urgent</span>
                    @elseif($complaint->priority === 'high')
                        <span style="background: #fd7e14; color: white; padding: 0.5rem 1rem; border-radius: 20px;">High Priority</span>
                    @else
                        <span style="background: #ffc107; color: #1a2b3c; padding: 0.5rem 1rem; border-radius: 20px;">{{ ucfirst($complaint->priority) }} Priority</span>
                    @endif
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <!-- Complaint Details -->
            <div>
                <h3 style="color: #1a2b3c; margin-bottom: 1rem;">Complaint Details</h3>
                
                <div style="margin-bottom: 1rem;">
                    <strong>Date Submitted:</strong> {{ $complaint->created_at->format('F d, Y h:i A') }}
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <strong>Complainant:</strong> {{ $complaint->name }}
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <strong>Email:</strong> {{ $complaint->email }}
                </div>
                
                @if($complaint->phone)
                <div style="margin-bottom: 1rem;">
                    <strong>Phone:</strong> {{ $complaint->phone }}
                </div>
                @endif
                
                @if($complaint->student_id)
                <div style="margin-bottom: 1rem;">
                    <strong>Student ID:</strong> {{ $complaint->student_id }}
                </div>
                @endif
                
                <div style="margin-bottom: 1rem;">
                    <strong>Category:</strong> {{ ucfirst($complaint->category) }}
                    @if($complaint->sub_category) - {{ $complaint->sub_category }} @endif
                </div>
                
                @if($complaint->department)
                <div style="margin-bottom: 1rem;">
                    <strong>Department:</strong> {{ $complaint->department }}
                </div>
                @endif
                
                <div style="margin-bottom: 1rem;">
                    <strong>Status:</strong>
                    @if($complaint->status === 'pending')
                        <span style="background: #ffc107; padding: 0.25rem 0.75rem; border-radius: 20px;">Pending Review</span>
                    @elseif($complaint->status === 'reviewing')
                        <span style="background: #17a2b8; color: white; padding: 0.25rem 0.75rem; border-radius: 20px;">Under Review</span>
                    @elseif($complaint->status === 'resolved')
                        <span style="background: #28a745; color: white; padding: 0.25rem 0.75rem; border-radius: 20px;">Resolved</span>
                    @elseif($complaint->status === 'rejected')
                        <span style="background: #dc3545; color: white; padding: 0.25rem 0.75rem; border-radius: 20px;">Rejected</span>
                    @else
                        <span style="background: #fd7e14; color: white; padding: 0.25rem 0.75rem; border-radius: 20px;">Escalated</span>
                    @endif
                </div>
                
                <div style="margin-top: 1.5rem;">
                    <strong>Description:</strong>
                    <div style="background: #f8f9fa; padding: 1rem; border-radius: 10px; margin-top: 0.5rem;">
                        {{ $complaint->description }}
                    </div>
                </div>
                
                @if($complaint->attachment)
                <div style="margin-top: 1rem;">
                    <strong>Attachment:</strong><br>
                    <a href="{{ asset('storage/' . $complaint->attachment) }}" target="_blank" style="background: #17a2b8; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none; display: inline-block; margin-top: 0.5rem;">
                        <i class="fas fa-download"></i> Download Attachment
                    </a>
                </div>
                @endif
            </div>
            
            <!-- Response Form -->
            <div>
                <h3 style="color: #1a2b3c; margin-bottom: 1rem;">Respond to Complaint</h3>
                
                <form action="{{ route('admin.complaints.respond', $complaint) }}" method="POST">
                    @csrf
                    
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Update Status</label>
                        <select name="status" class="form-control" style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                            <option value="pending" {{ $complaint->status === 'pending' ? 'selected' : '' }}>Pending Review</option>
                            <option value="reviewing" {{ $complaint->status === 'reviewing' ? 'selected' : '' }}>Under Review</option>
                            <option value="resolved" {{ $complaint->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="rejected" {{ $complaint->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="escalated" {{ $complaint->status === 'escalated' ? 'selected' : '' }}>Escalated</option>
                        </select>
                    </div>
                    
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Admin Response</label>
                        <textarea name="admin_response" rows="6" class="form-control" style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">{{ $complaint->admin_response }}</textarea>
                    </div>
                    
                    <button type="submit" style="background: #28a745; color: white; padding: 0.8rem 2rem; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-reply"></i> Save Response
                    </button>
                </form>
                
                @if($complaint->admin_response)
                <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #e9ecef;">
                    <h4>Previous Response:</h4>
                    <div style="background: #e8f5e9; padding: 1rem; border-radius: 10px; margin-top: 0.5rem;">
                        {{ $complaint->admin_response }}
                    </div>
                    @if($complaint->resolved_at)
                        <div style="margin-top: 0.5rem; font-size: 0.85rem; color: #6c757d;">
                            Resolved on: {{ $complaint->resolved_at->format('F d, Y h:i A') }}
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
        
        <!-- Delete Button -->
        <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #e9ecef; text-align: right;">
            <form action="{{ route('admin.complaints.destroy', $complaint) }}" method="POST" onsubmit="return confirm('Delete this complaint?');">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: #dc3545; color: white; padding: 0.5rem 1.5rem; border: none; border-radius: 5px; cursor: pointer;">
                    <i class="fas fa-trash"></i> Delete Complaint
                </button>
            </form>
        </div>
    </div>
</div>
@endsection