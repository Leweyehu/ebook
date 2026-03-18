@extends('layouts.app')

@section('title', 'Manage Staff')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Manage Staff</h1>
        <p>Add, edit, or remove staff members</p>
    </div>
</div>

<div class="container">
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 10px; margin-bottom: 2rem;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 10px; margin-bottom: 2rem;">
            {{ session('error') }}
        </div>
    @endif

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="color: #1a2b3c;">Staff List</h2>
        <a href="{{ route('admin.staff.create') }}" style="background: #ffc107; color: #1a2b3c; padding: 0.8rem 1.5rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
            <i class="fas fa-plus"></i> Add New Staff
        </a>
    </div>

    <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #1a2b3c; color: white;">
                <tr>
                    <th style="padding: 1rem; text-align: left;">Image</th>
                    <th style="padding: 1rem; text-align: left;">Name</th>
                    <th style="padding: 1rem; text-align: left;">Position</th>
                    <th style="padding: 1rem; text-align: left;">Type</th>
                    <th style="padding: 1rem; text-align: left;">Email</th>
                    <th style="padding: 1rem; text-align: left;">Status</th>
                    <th style="padding: 1rem; text-align: left;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staff as $staffMember)
                <tr style="border-bottom: 1px solid #e9ecef;">
                    <td style="padding: 1rem;">
                        @if($staffMember->profile_image)
                            <img src="{{ asset($staffMember->profile_image) }}" alt="" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                        @else
                            <div style="width: 50px; height: 50px; border-radius: 50%; background: #e9ecef; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user" style="color: #6c757d;"></i>
                            </div>
                        @endif
                    </td>
                    <td style="padding: 1rem;">{{ $staffMember->name }}</td>
                    <td style="padding: 1rem;">{{ $staffMember->position }}</td>
                    <td style="padding: 1rem;">
                        <span style="background: {{ $staffMember->staff_type == 'academic' ? '#cff4fc' : ($staffMember->staff_type == 'administrative' ? '#fff3cd' : '#d1e7dd') }}; 
                                     color: {{ $staffMember->staff_type == 'academic' ? '#055160' : ($staffMember->staff_type == 'administrative' ? '#856404' : '#0f5132') }}; 
                                     padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.85rem;">
                            {{ ucfirst($staffMember->staff_type) }}
                        </span>
                    </td>
                    <td style="padding: 1rem;">{{ $staffMember->email }}</td>
                    <td style="padding: 1rem;">
                        <span style="background: {{ $staffMember->is_active ? '#d4edda' : '#f8d7da' }}; 
                                     color: {{ $staffMember->is_active ? '#155724' : '#721c24' }}; 
                                     padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.85rem;">
                            {{ $staffMember->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td style="padding: 1rem;">
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.staff.edit', $staffMember) }}" style="color: #ffc107; text-decoration: none; padding: 0.3rem 0.8rem; border: 1px solid #ffc107; border-radius: 5px;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.staff.toggle-status', $staffMember) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" style="color: {{ $staffMember->is_active ? '#dc3545' : '#28a745' }}; background: none; border: 1px solid currentColor; padding: 0.3rem 0.8rem; border-radius: 5px; cursor: pointer;">
                                    <i class="fas {{ $staffMember->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.staff.destroy', $staffMember) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this staff member?');">
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
                    <td colspan="7" style="padding: 3rem; text-align: center; color: #6c757d;">
                        <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                        <p>No staff members found. Click "Add New Staff" to create one.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection