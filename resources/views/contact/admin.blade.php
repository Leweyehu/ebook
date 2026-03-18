@extends('layouts.app')

@section('title', 'Manage Contact Messages')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Contact Messages</h1>
        <p>Manage user feedback and inquiries</p>
    </div>
</div>

<div class="container">
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 10px; margin-bottom: 2rem;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2rem;">
        <div style="background: #1a2b3c; color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
            <i class="fas fa-envelope" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
            <h3 style="font-size: 2rem;">{{ $stats['total'] }}</h3>
            <p>Total Messages</p>
        </div>
        <div style="background: #dc3545; color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
            <i class="fas fa-envelope" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
            <h3 style="font-size: 2rem;">{{ $stats['unread'] }}</h3>
            <p>Unread</p>
        </div>
        <div style="background: #ffc107; color: #1a2b3c; padding: 1.5rem; border-radius: 10px; text-align: center;">
            <i class="fas fa-envelope-open" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
            <h3 style="font-size: 2rem;">{{ $stats['read'] }}</h3>
            <p>Read</p>
        </div>
        <div style="background: #28a745; color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
            <i class="fas fa-reply" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
            <h3 style="font-size: 2rem;">{{ $stats['replied'] }}</h3>
            <p>Replied</p>
        </div>
    </div>

    <!-- Bulk Delete Form -->
    <div style="background: white; border-radius: 15px; padding: 1.5rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="color: #1a2b3c;">Clean Up Old Messages</h3>
        <form action="{{ route('admin.contacts.bulk-delete') }}" method="POST" onsubmit="return confirm('Delete messages older than selected days?');">
            @csrf
            <select name="days" style="padding: 0.5rem; border: 2px solid #e9ecef; border-radius: 5px; margin-right: 0.5rem;">
                <option value="30">30 days</option>
                <option value="60">60 days</option>
                <option value="90">90 days</option>
                <option value="180">180 days</option>
                <option value="365">1 year</option>
            </select>
            <button type="submit" style="background: #dc3545; color: white; border: none; padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer;">
                <i class="fas fa-trash"></i> Delete Old
            </button>
        </form>
    </div>

    <!-- Messages Table -->
    <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #1a2b3c; color: white;">
                <tr>
                    <th style="padding: 1rem; text-align: left;">Status</th>
                    <th style="padding: 1rem; text-align: left;">Name</th>
                    <th style="padding: 1rem; text-align: left;">Email</th>
                    <th style="padding: 1rem; text-align: left;">Subject</th>
                    <th style="padding: 1rem; text-align: left;">Date</th>
                    <th style="padding: 1rem; text-align: left;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $message)
                <tr style="border-bottom: 1px solid #e9ecef; background: {{ $message->status === 'unread' ? '#fff3cd' : 'white' }};">
                    <td style="padding: 1rem;">
                        <span style="background: {{ 
                            $message->status === 'unread' ? '#dc3545' : 
                            ($message->status === 'read' ? '#ffc107' : '#28a745') 
                        }}; color: white; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem;">
                            {{ ucfirst($message->status) }}
                        </span>
                    </td>
                    <td style="padding: 1rem;">{{ $message->name }}</td>
                    <td style="padding: 1rem;">{{ $message->email }}</td>
                    <td style="padding: 1rem;">{{ Str::limit($message->subject, 30) }}</td>
                    <td style="padding: 1rem;">{{ $message->created_at->format('M d, Y H:i') }}</td>
                    <td style="padding: 1rem;">
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.contacts.show', $message) }}" style="color: #ffc107; text-decoration: none; padding: 0.3rem 0.8rem; border: 1px solid #ffc107; border-radius: 5px;">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($message->status === 'unread')
                            <form action="{{ route('admin.contacts.mark-read', $message) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" style="color: #28a745; background: none; border: 1px solid #28a745; padding: 0.3rem 0.8rem; border-radius: 5px; cursor: pointer;">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('admin.contacts.destroy', $message) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this message?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: #dc3545; background: none; border: 1px solid #dc3545; padding: 0.3rem 0.8rem; border-radius: 5px; cursor: pointer;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 3rem; text-align: center; color: #6c757d;">
                        <i class="fas fa-envelope" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                        <p>No messages found.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection