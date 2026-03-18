@extends('layouts.app')

@section('title', 'Contact Messages')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Contact Messages</h1>
    </div>
</div>

<div class="container">
    <!-- Include Admin Header -->
    @include('admin.partials.admin-header')

    <!-- Back to Dashboard Button -->
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('admin.dashboard') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #6c757d; color: white; padding: 0.5rem 1.5rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <!-- Messages Table -->
    <div style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow: hidden;">
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
                @forelse(\App\Models\Contact::latest()->get() as $contact)
                <tr style="border-bottom: 1px solid #e9ecef;">
                    <td style="padding: 1rem;">{{ $contact->created_at->format('M d, Y') }}</td>
                    <td style="padding: 1rem;">{{ $contact->name }}</td>
                    <td style="padding: 1rem;">{{ $contact->email }}</td>
                    <td style="padding: 1rem;">{{ $contact->subject }}</td>
                    <td style="padding: 1rem;">
                        <span style="background: {{ $contact->status === 'unread' ? '#dc3545' : '#28a745' }}; color: white; padding: 0.25rem 0.5rem; border-radius: 3px; font-size: 0.85rem;">
                            {{ ucfirst($contact->status) }}
                        </span>
                    </td>
                    <td style="padding: 1rem;">
                        <a href="#" style="background: #17a2b8; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none; font-size: 0.9rem;">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 2rem; text-align: center; color: #6c757d;">No messages found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection