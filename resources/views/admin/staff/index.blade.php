{{-- staff/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manage Staff')
@section('page-title', 'Manage Staff')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Manage Staff</h1>
    </div>
</div>

<div class="container">
    <!-- Page Header with Add Button -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <h2 style="color: #1a2b3c; margin: 0;">Staff Members</h2>
        <a href="{{ route('admin.staff.create') }}" style="background: #28a745; color: white; padding: 0.75rem 1.5rem; border-radius: 5px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-plus"></i> Add New Staff
        </a>
    </div>

    <!-- Search and Filter Section -->
    <div style="margin-bottom: 2rem; display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
        <div style="flex: 1; min-width: 200px;">
            <input type="text" id="searchInput" placeholder="Search staff by name, email, or position..." 
                   style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem;">
        </div>
        <div>
            <select id="statusFilter" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; width: 150px;">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <div>
            <select id="departmentFilter" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; width: 200px;">
                <option value="">All Departments</option>
                <option value="Computer Science">Computer Science</option>
                <option value="Information Technology">Information Technology</option>
                <option value="Software Engineering">Software Engineering</option>
                <option value="Data Science">Data Science</option>
            </select>
        </div>
    </div>

    <!-- Staff Table -->
    <div style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #1a2b3c; color: white;">
                <tr>
                    <th style="padding: 1rem; text-align: left;">ID</th>
                    <th style="padding: 1rem; text-align: left;">Name</th>
                    <th style="padding: 1rem; text-align: left;">Position</th>
                    <th style="padding: 1rem; text-align: left;">Department</th>
                    <th style="padding: 1rem; text-align: left;">Email</th>
                    <th style="padding: 1rem; text-align: left;">Phone</th>
                    <th style="padding: 1rem; text-align: left;">Status</th>
                    <th style="padding: 1rem; text-align: left;">Actions</th>
                </tr>
            </thead>
            <tbody id="staffTableBody">
                @forelse(\App\Models\Staff::all() as $staff)
                <tr style="border-bottom: 1px solid #e9ecef;" 
                    data-name="{{ strtolower($staff->name) }}"
                    data-email="{{ strtolower($staff->email) }}"
                    data-position="{{ strtolower($staff->position) }}"
                    data-status="{{ $staff->is_active ? 'active' : 'inactive' }}"
                    data-department="{{ $staff->department }}">
                    <td style="padding: 1rem;">{{ $staff->id }}</td>
                    <td style="padding: 1rem; font-weight: 500;">{{ $staff->name }}</td>
                    <td style="padding: 1rem;">{{ $staff->position }}</td>
                    <td style="padding: 1rem;">{{ $staff->department }}</td>
                    <td style="padding: 1rem;">{{ $staff->email }}</td>
                    <td style="padding: 1rem;">{{ $staff->phone ?? 'N/A' }}</td>
                    <td style="padding: 1rem;">
                        <span class="status-badge" style="background: {{ $staff->is_active ? '#28a745' : '#dc3545' }}; color: white; padding: 0.25rem 0.5rem; border-radius: 3px; font-size: 0.85rem;">
                            {{ $staff->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td style="padding: 1rem;">
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.staff.edit', $staff) }}" style="background: #ffc107; color: #1a2b3c; padding: 0.25rem 0.75rem; border-radius: 3px; text-decoration: none; font-size: 0.85rem;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('admin.staff.destroy', $staff) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this staff member?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #dc3545; color: white; border: none; padding: 0.25rem 0.75rem; border-radius: 3px; cursor: pointer; font-size: 0.85rem;">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr id="noDataRow">
                    <td colspan="8" style="padding: 2rem; text-align: center; color: #6c757d;">
                        <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                        No staff members found.
                        <br>
                        <a href="{{ route('admin.staff.create') }}" style="display: inline-block; margin-top: 1rem; background: #ffc107; color: #1a2b3c; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
                            Add Your First Staff Member
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Staff Count -->
    <div style="margin-top: 1rem; padding: 0.5rem; color: #6c757d; font-size: 0.9rem;">
        Total Staff: <span id="staffCount">{{ \App\Models\Staff::count() }}</span>
    </div>
</div>

<script>
    // Search and Filter functionality
    function filterStaff() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const departmentFilter = document.getElementById('departmentFilter').value;
        
        const rows = document.querySelectorAll('#staffTableBody tr');
        let visibleCount = 0;
        
        rows.forEach(row => {
            if (row.id === 'noDataRow') return;
            
            const name = row.getAttribute('data-name') || '';
            const email = row.getAttribute('data-email') || '';
            const position = row.getAttribute('data-position') || '';
            const status = row.getAttribute('data-status') || '';
            const department = row.getAttribute('data-department') || '';
            
            let matchesSearch = searchTerm === '' || 
                               name.includes(searchTerm) || 
                               email.includes(searchTerm) || 
                               position.includes(searchTerm);
            
            let matchesStatus = statusFilter === '' || status === statusFilter;
            let matchesDepartment = departmentFilter === '' || department === departmentFilter;
            
            if (matchesSearch && matchesStatus && matchesDepartment) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Update staff count
        document.getElementById('staffCount').textContent = visibleCount;
        
        // Show/hide no data message
        const noDataRow = document.getElementById('noDataRow');
        if (noDataRow) {
            if (visibleCount === 0) {
                noDataRow.style.display = '';
            } else {
                noDataRow.style.display = 'none';
            }
        }
    }
    
    // Add event listeners
    document.getElementById('searchInput').addEventListener('keyup', filterStaff);
    document.getElementById('statusFilter').addEventListener('change', filterStaff);
    document.getElementById('departmentFilter').addEventListener('change', filterStaff);
    
    // Initial filter to show correct count
    filterStaff();
</script>
@endsection