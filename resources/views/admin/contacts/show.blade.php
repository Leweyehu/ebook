@extends('layouts.admin')

@section('title', 'View Message')
@section('page-title', 'Message Details')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.contacts.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #6c757d; color: white; padding: 0.5rem 1.5rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
        <i class="fas fa-arrow-left"></i> Back to Messages
    </a>
</div>

<div style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow: hidden;">
    <div style="padding: 2rem;">
        <!-- Message Header -->
        <div style="border-bottom: 2px solid #e9ecef; padding-bottom: 1.5rem; margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 style="color: #1a2b3c; margin-bottom: 0.5rem;">{{ $contact->subject ?? 'No Subject' }}</h2>
                    <div style="color: #6c757d;">
                        <span>From: <strong>{{ $contact->name }}</strong> ({{ $contact->email }})</span>
                    </div>
                </div>
                <div>
                    <span style="background: {{ $contact->status === 'unread' ? '#dc3545' : ($contact->status === 'read' ? '#28a745' : '#ffc107') }}; color: {{ $contact->status === 'replied' ? '#1a2b3c' : 'white' }}; padding: 0.5rem 1rem; border-radius: 20px;">
                        {{ ucfirst($contact->status) }}
                    </span>
                </div>
            </div>
            <div style="color: #6c757d; margin-top: 0.5rem;">
                <i class="fas fa-calendar-alt"></i> Received: {{ $contact->created_at->format('F d, Y h:i A') }}
            </div>
        </div>

        <!-- Message Content -->
        <div style="margin-bottom: 2rem;">
            <h3 style="color: #1a2b3c; margin-bottom: 1rem;">Message:</h3>
            <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px; line-height: 1.6;">
                {{ $contact->message }}
            </div>
        </div>

        <!-- Reply Form -->
        <div style="border-top: 2px solid #e9ecef; padding-top: 2rem;">
            <h3 style="color: #1a2b3c; margin-bottom: 1rem;">Reply to {{ $contact->name }}</h3>
            
            @if($contact->status === 'replied' && $contact->admin_reply)
                <div style="background: #e8f5e9; padding: 1.5rem; border-radius: 10px; margin-bottom: 1.5rem;">
                    <strong style="color: #2e7d32;">Your Reply:</strong>
                    <div style="margin-top: 0.5rem; line-height: 1.6;">
                        {{ $contact->admin_reply }}
                    </div>
                    @if($contact->replied_at)
                        <div style="margin-top: 0.5rem; font-size: 0.85rem; color: #6c757d;">
                            <i class="fas fa-clock"></i> Replied on: {{ $contact->replied_at->format('F d, Y h:i A') }}
                        </div>
                    @endif
                </div>
            @endif

            <form action="{{ route('admin.contacts.reply', $contact) }}" method="POST">
                @csrf
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Your Reply *</label>
                    <textarea name="admin_reply" rows="5" class="form-control" style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;" required>{{ old('admin_reply') }}</textarea>
                </div>
                <button type="submit" style="background: #28a745; color: white; padding: 0.8rem 2rem; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;">
                    <i class="fas fa-reply"></i> Send Reply
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Delete Button -->
<div style="margin-top: 1.5rem; text-align: right;">
    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');">
        @csrf
        @method('DELETE')
        <button type="submit" style="background: #dc3545; color: white; padding: 0.5rem 1.5rem; border: none; border-radius: 5px; cursor: pointer;">
            <i class="fas fa-trash"></i> Delete Message
        </button>
    </form>
</div>
@endsection