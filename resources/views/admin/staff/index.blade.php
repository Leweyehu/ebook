@extends('layouts.app')

@section('title', 'Manage Staff')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Manage Staff</h1>
    </div>
</div>

<div class="container">
    <!-- Include Admin Header with Back to Dashboard -->
    @include('admin.partials.admin-header')

    <!-- Back to Dashboard Button (Additional) -->
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('admin.dashboard') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #6c757d; color: white; padding: 0.5rem 1.5rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <!-- Page Header with Add Button -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="color: #1a2b3c;">Staff Members</h2>
        <a href="{{ route('admin.staff.create') }}" style="background: #28a745; color: white; padding: 0.75rem 1.5rem; border-radius: 5px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-plus"></i> Add New Staff
        </a>
    </div>

    <!-- Staff Table -->
    <div style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #1a2b3c; color: white;">
                <tr>
                    <th style="padding: 1rem; text-align: left;">ID</th>
                    <th style="padding: 1rem; text-align: left;">Name</th>
                    <th style="padding: 1rem; text-align: left;">Position</th>
                    <th style="padding: 1rem; text-align: left;">Department</th>
                    <th style="padding: 1rem; text-align: left;">Email</th>
                    <th style="padding: 1rem; text-align: left;">Status</th>
                    <th style="padding: 1rem; text-align: left;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse(\App\Models\Staff::all() as $staff)
                <tr style="border-bottom: 1px solid #e9ecef;">
                    <td style="padding: 1rem;">{{ $staff->id }}</td>
                    <td style="padding: 1rem;">{{ $staff->name }}</td>
                    <td style="padding: 1rem;">{{ $staff->position }}</td>
                    <td style="padding: 1rem;">{{ $staff->department }}</td>
                    <td style="padding: 1rem;">{{ $staff->email }}</td>
                    <td style="padding: 1rem;">
                        <span style="background: {{ $staff->is_active ? '#28a745' : '#dc3545' }}; color: white; padding: 0.25rem 0.5rem; border-radius: 3px; font-size: 0.85rem;">
                            {{ $staff->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td style="padding: 1rem;">
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.staff.edit', $staff) }}" style="background: #ffc107; color: #1a2b3c; padding: 0.25rem 0.75rem; border-radius: 3px; text-decoration: none; font-size: 0.85rem;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('admin.staff.destroy', $staff) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #dc3545; color: white; border: none; padding: 0.25rem 0.75rem; border-radius: 3px; cursor: pointer; font-size: 0.85rem;" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 2rem; text-align: center; color: #6c757d;">No staff members found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection