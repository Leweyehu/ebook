@extends('layouts.admin')

@section('title', 'User Management')
@section('page-title', 'User Management')

@section('content')
<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-users" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['total'] }}</h3>
        <p>Total Users</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-user-tie" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['admin'] }}</h3>
        <p>Admins</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: #1a2b3c; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-chalkboard-teacher" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['staff'] }}</h3>
        <p>Staff</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #28a745 0%, #218838 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-user-graduate" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['student'] }}</h3>
        <p>Students</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-check-circle" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['active'] }}</h3>
        <p>Active Users</p>
    </div>
</div>

<!-- Page Header with Actions -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="color: #1a2b3c; margin-bottom: 0.5rem;">User Accounts</h2>
        <p style="color: #666;">Manage user accounts for staff, students, and administrators</p>
    </div>
    
    <div style="display: flex; gap: 1rem;">
        <!-- Bulk Actions Dropdown -->
        <div style="position: relative;">
            <button onclick="toggleDropdown('bulkDropdown')" style="background: #17a2b8; color: white; padding: 0.75rem 1.5rem; border-radius: 5px; border: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <i class="fas fa-layer-group"></i> Bulk Actions <i class="fas fa-chevron-down"></i>
            </button>
            <div id="bulkDropdown" style="display: none; position: absolute; right: 0; background: white; min-width: 250px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); border-radius: 5px; z-index: 100; margin-top: 5px;">
                <a href="{{ route('admin.users.bulk.staff') }}" style="display: block; padding: 0.75rem 1rem; text-decoration: none; color: #1a2b3c; border-bottom: 1px solid #e9ecef;"
                   onclick="return confirm('Create accounts for all staff members without user accounts? Default password: password123')">
                    <i class="fas fa-chalkboard-teacher" style="margin-right: 10px;"></i> Create All Staff Accounts
                </a>
                <a href="{{ route('admin.users.bulk.students') }}" style="display: block; padding: 0.75rem 1rem; text-decoration: none; color: #1a2b3c;"
                   onclick="return confirm('Create accounts for all students without user accounts? Default password: password123')">
                    <i class="fas fa-user-graduate" style="margin-right: 10px;"></i> Create All Student Accounts
                </a>
            </div>
        </div>
        
        <!-- Create New Dropdown -->
        <div style="position: relative;">
            <button onclick="toggleDropdown('createDropdown')" style="background: #28a745; color: white; padding: 0.75rem 1.5rem; border-radius: 5px; border: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <i class="fas fa-plus"></i> Create New <i class="fas fa-chevron-down"></i>
            </button>
            <div id="createDropdown" style="display: none; position: absolute; right: 0; background: white; min-width: 250px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); border-radius: 5px; z-index: 100; margin-top: 5px;">
                <a href="{{ route('admin.users.create') }}" style="display: block; padding: 0.75rem 1rem; text-decoration: none; color: #1a2b3c; border-bottom: 1px solid #e9ecef;">
                    <i class="fas fa-user-plus" style="margin-right: 10px;"></i> Manual User Creation
                </a>
                <a href="{{ route('admin.users.create-from-staff') }}" style="display: block; padding: 0.75rem 1rem; text-decoration: none; color: #1a2b3c; border-bottom: 1px solid #e9ecef;">
                    <i class="fas fa-chalkboard-teacher" style="margin-right: 10px;"></i> From Staff Record
                </a>
                <a href="{{ route('admin.users.create-from-student') }}" style="display: block; padding: 0.75rem 1rem; text-decoration: none; color: #1a2b3c;">
                    <i class="fas fa-user-graduate" style="margin-right: 10px;"></i> From Student Record
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead style="background: #1a2b3c; color: white;">
            <tr>
                <th style="padding: 1rem; text-align: left;">ID</th>
                <th style="padding: 1rem; text-align: left;">Name</th>
                <th style="padding: 1rem; text-align: left;">Email</th>
                <th style="padding: 1rem; text-align: left;">Role</th>
                <th style="padding: 1rem; text-align: left;">Student/Staff ID</th>
                <th style="padding: 1rem; text-align: left;">Department</th>
                <th style="padding: 1rem; text-align: left;">Status</th>
                <th style="padding: 1rem; text-align: left;">Created</th>
                <th style="padding: 1rem; text-align: left;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr style="border-bottom: 1px solid #e9ecef;">
                <td style="padding: 1rem;">{{ $user->id }}</td>
                <td style="padding: 1rem;">{{ $user->name }}</td>
                <td style="padding: 1rem;">{{ $user->email }}</td>
                <td style="padding: 1rem;">
                    <span style="background: {{ 
                        $user->role === 'admin' ? '#dc3545' : 
                        ($user->role === 'staff' ? '#ffc107' : '#28a745') 
                    }}; color: {{ $user->role === 'staff' ? '#1a2b3c' : 'white' }}; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td style="padding: 1rem;">{{ $user->student_id ?? 'N/A' }}</td>
                <td style="padding: 1rem;">{{ $user->department ?? 'N/A' }}</td>
                <td style="padding: 1rem;">
                    <span style="background: {{ $user->is_active ? '#28a745' : '#dc3545' }}; color: white; padding: 0.25rem 0.75rem; border-radius: 3px; font-size: 0.85rem;">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td style="padding: 1rem;">{{ $user->created_at->format('M d, Y') }}</td>
                <td style="padding: 1rem;">
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <a href="{{ route('admin.users.show', $user) }}" style="background: #17a2b8; color: white; padding: 0.4rem 0.8rem; border-radius: 3px; text-decoration: none; font-size: 0.85rem;" title="View Details">
                            <i class="fas fa-eye"></i> View
                        </a>
                        
                        <a href="{{ route('admin.users.edit', $user) }}" style="background: #ffc107; color: #1a2b3c; padding: 0.4rem 0.8rem; border-radius: 3px; text-decoration: none; font-size: 0.85rem;" title="Edit User">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        
                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" style="background: {{ $user->is_active ? '#dc3545' : '#28a745' }}; color: white; border: none; padding: 0.4rem 0.8rem; border-radius: 3px; cursor: pointer; font-size: 0.85rem;" title="{{ $user->is_active ? 'Disable User' : 'Enable User' }}">
                                <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i> 
                                {{ $user->is_active ? 'Disable' : 'Enable' }}
                            </button>
                        </form>
                        
                        <!-- DELETE BUTTON - Only show if not current user -->
                        @if($user->id !== Auth::id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;" onsubmit="return confirm('⚠️ Are you sure you want to delete this user? This action cannot be undone and will remove all associated data.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: #dc3545; color: white; border: none; padding: 0.4rem 0.8rem; border-radius: 3px; cursor: pointer; font-size: 0.85rem;" title="Delete User Permanently">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                        @else
                        <span style="background: #6c757d; color: white; padding: 0.4rem 0.8rem; border-radius: 3px; font-size: 0.85rem; opacity: 0.6; cursor: not-allowed;" title="You cannot delete your own account">
                            <i class="fas fa-ban"></i> Cannot Delete
                        </span>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="padding: 3rem; text-align: center; color: #6c757d;">
                    <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                    <p>No users found. Create accounts for staff and students.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div style="margin-top: 2rem;">
    {{ $users->links() }}
</div>

<!-- JavaScript for Dropdowns -->
<script>
    // Toggle dropdown function
    function toggleDropdown(id) {
        var dropdown = document.getElementById(id);
        if (dropdown.style.display === 'none' || dropdown.style.display === '') {
            dropdown.style.display = 'block';
        } else {
            dropdown.style.display = 'none';
        }
    }

    // Close dropdowns when clicking outside
    window.onclick = function(event) {
        if (!event.target.matches('button')) {
            var dropdowns = document.getElementsByClassName('dropdown-content');
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.style.display === 'block') {
                    openDropdown.style.display = 'none';
                }
            }
        }
    }
</script>

<!-- Success/Error Messages -->
@if(session('success'))
<div style="position: fixed; bottom: 20px; right: 20px; background: #28a745; color: white; padding: 1rem; border-radius: 5px; box-shadow: 0 3px 10px rgba(0,0,0,0.2); z-index: 1001;">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div style="position: fixed; bottom: 20px; right: 20px; background: #dc3545; color: white; padding: 1rem; border-radius: 5px; box-shadow: 0 3px 10px rgba(0,0,0,0.2); z-index: 1001;">
    {{ session('error') }}
</div>
@endif

<style>
    /* Hover effects for buttons */
    a:hover, button:hover {
        transform: translateY(-2px);
        transition: all 0.2s ease;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    /* Responsive design */
    @media (max-width: 1200px) {
        [style*="grid-template-columns: repeat(5, 1fr)"] {
            grid-template-columns: repeat(3, 1fr) !important;
        }
    }
    
    @media (max-width: 768px) {
        [style*="grid-template-columns: repeat(5, 1fr)"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        td, th {
            padding: 0.75rem !important;
        }
    }
    
    @media (max-width: 480px) {
        [style*="grid-template-columns: repeat(5, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection