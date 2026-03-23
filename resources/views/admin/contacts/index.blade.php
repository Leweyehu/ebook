@extends('layouts.admin')

@section('title', 'Contact Messages')
@section('page-title', 'Contact Messages')

@section('content')
<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-envelope" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['total'] ?? 0 }}</h3>
        <p>Total Messages</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-envelope-open" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['unread'] ?? 0 }}</h3>
        <p>Unread</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #28a745 0%, #218838 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-check-circle" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['read'] ?? 0 }}</h3>
        <p>Read</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: #1a2b3c; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-reply" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['replied'] ?? 0 }}</h3>
        <p>Replied</p>
    </div>
</div>

<!-- Back to Dashboard Button -->
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.dashboard') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #6c757d; color: white; padding: 0.5rem 1.5rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

<!-- Messages Table -->
<div style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead style="background: #1a2b3c; color: white;">
            <tr>
                <th style="padding: 1rem; text-align: left;">Date</th>
                <th style="padding: 1rem; text-align: left;">Name</th>
                <th style="padding: 1rem; text-align: left;">Email</th>
                <th style="padding: 1rem; text-align: left;">Subject</th>
                <th style="padding: 1rem; text-align: left;">Status</th>
                <th style="padding: 1rem; text-align: left;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contacts as $contact)
            <tr style="border-bottom: 1px solid #e9ecef; {{ $contact->status === 'unread' ? 'background: #fff3cd;' : '' }}">
                <td style="padding: 1rem;">{{ $contact->created_at->format('M d, Y H:i') }}</td>
                <td style="padding: 1rem;">
                    <strong>{{ $contact->name }}</strong>
                    @if($contact->status === 'unread')
                        <span style="background: #dc3545; color: white; padding: 0.2rem 0.4rem; border-radius: 3px; font-size: 0.7rem; margin-left: 0.5rem;">NEW</span>
                    @endif
                </td>
                <td style="padding: 1rem;">{{ $contact->email }}</td>
                <td style="padding: 1rem;">
                    <strong>{{ $contact->subject ?? 'No Subject' }}</strong>
                    @if($contact->message)
                        <div style="font-size: 0.8rem; color: #6c757d; margin-top: 0.2rem;">
                            {{ Str::limit($contact->message, 50) }}
                        </div>
                    @endif
                </td>
                <td style="padding: 1rem;">
                    @if($contact->status === 'unread')
                        <span style="background: #dc3545; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem;">
                            <i class="fas fa-envelope"></i> Unread
                        </span>
                    @elseif($contact->status === 'read')
                        <span style="background: #28a745; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem;">
                            <i class="fas fa-check-circle"></i> Read
                        </span>
                    @elseif($contact->status === 'replied')
                        <span style="background: #ffc107; color: #1a2b3c; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem;">
                            <i class="fas fa-reply"></i> Replied
                        </span>
                    @endif
                </td>
                <td style="padding: 1rem;">
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.contacts.show', $contact) }}" 
                           style="background: #17a2b8; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.3rem;">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: #dc3545; color: white; border: none; padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.3rem;">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding: 3rem; text-align: center; color: #6c757d;">
                    <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                    <p>No messages found.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination
@if(isset($contacts) && $contacts->hasPages())
<div style="margin-top: 2rem; display: flex; justify-content: center;">
    {{ $contacts->links() }}
</div>
@endif -->

<!-- Success/Error Messages -->
@if(session('success'))
<div style="position: fixed; bottom: 20px; right: 20px; background: #28a745; color: white; padding: 1rem; border-radius: 5px; box-shadow: 0 3px 10px rgba(0,0,0,0.2); z-index: 1001;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div style="position: fixed; bottom: 20px; right: 20px; background: #dc3545; color: white; padding: 1rem; border-radius: 5px; box-shadow: 0 3px 10px rgba(0,0,0,0.2); z-index: 1001;">
    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
</div>
@endif

<script>
    // Auto-hide messages after 5 seconds
    setTimeout(function() {
        const messages = document.querySelectorAll('[style*="position: fixed; bottom: 20px; right: 20px;"]');
        messages.forEach(function(message) {
            message.style.opacity = '0';
            setTimeout(function() {
                message.style.display = 'none';
            }, 500);
        });
    }, 5000);
</script>
@endsection