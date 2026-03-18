@extends('layouts.app')

@section('title', 'View Message')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Message Details</h1>
        <p>From: {{ $contact->name }} ({{ $contact->email }})</p>
    </div>
</div>

<div class="container">
    <div style="max-width: 800px; margin: 0 auto;">
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 10px; margin-bottom: 2rem;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Message Details -->
        <div style="background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 2px solid #ffc107;">
                <h2 style="color: #1a2b3c;">{{ $contact->subject }}</h2>
                <span style="background: {{ 
                    $contact->status === 'unread' ? '#dc3545' : 
                    ($contact->status === 'read' ? '#ffc107' : '#28a745') 
                }}; color: white; padding: 0.3rem 1rem; border-radius: 20px;">
                    {{ ucfirst($contact->status) }}
                </span>
            </div>

            <div style="margin-bottom: 2rem;">
                <p style="color: #6c757d; margin-bottom: 0.5rem;">
                    <i class="fas fa-user"></i> <strong>Name:</strong> {{ $contact->name }}
                </p>
                <p style="color: #6c757d; margin-bottom: 0.5rem;">
                    <i class="fas fa-envelope"></i> <strong>Email:</strong> <a href="mailto:{{ $contact->email }}" style="color: #ffc107;">{{ $contact->email }}</a>
                </p>
                <p style="color: #6c757d; margin-bottom: 0.5rem;">
                    <i class="fas fa-calendar"></i> <strong>Received:</strong> {{ $contact->created_at->format('F d, Y H:i A') }}
                </p>
            </div>

            <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem;">
                <h3 style="color: #1a2b3c; margin-bottom: 1rem;">Message:</h3>
                <p style="line-height: 1.8;">{{ $contact->message }}</p>
            </div>

            @if($contact->admin_reply)
            <div style="background: #d4edda; padding: 1.5rem; border-radius: 10px;">
                <h3 style="color: #155724; margin-bottom: 1rem;">Your Reply:</h3>
                <p style="line-height: 1.8;">{{ $contact->admin_reply }}</p>
                <p style="color: #6c757d; font-size: 0.9rem; margin-top: 1rem;">
                    Replied on {{ $contact->replied_at->format('F d, Y H:i A') }}
                </p>
            </div>
            @endif
        </div>

        <!-- Reply Form -->
        @if($contact->status !== 'replied')
        <div style="background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            <h3 style="color: #1a2b3c; margin-bottom: 1.5rem;">Reply to this Message</h3>
            
            <form action="{{ route('admin.contacts.reply', $contact) }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                        Your Reply *
                    </label>
                    <textarea name="admin_reply" rows="6" required
                              style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;"></textarea>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" style="background: #28a745; color: white; padding: 1rem 2rem; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-reply"></i> Send Reply
                    </button>
                    <a href="{{ route('admin.contacts.index') }}" style="background: #6c757d; color: white; padding: 1rem 2rem; border-radius: 5px; text-decoration: none;">
                        Back to Messages
                    </a>
                </div>
            </form>
        </div>
        @else
        <div style="text-align: center;">
            <a href="{{ route('admin.contacts.index') }}" style="background: #6c757d; color: white; padding: 1rem 2rem; border-radius: 5px; text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Back to Messages
            </a>
        </div>
        @endif
    </div>
</div>
@endsection