@extends('layouts.admin')

@section('title', 'Manage Students')
@section('page-title', 'Student Management')

@section('content')
<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-users" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['total'] ?? 0 }}</h3>
        <p>Total Students</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-user-graduate" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['year1'] ?? 0 }}</h3>
        <p>Year 1</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-user-graduate" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['year2'] ?? 0 }}</h3>
        <p>Year 2</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-user-graduate" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['year3'] ?? 0 }}</h3>
        <p>Year 3</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-user-graduate" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ $stats['year4'] ?? 0 }}</h3>
        <p>Year 4</p>
    </div>
</div>

<!-- Page Header with Actions -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="color: #1a2b3c; margin-bottom: 0.5rem;">Student Records</h2>
        <p style="color: #666;">Manage all students in the department</p>
    </div>
    
    <div style="display: flex; gap: 1rem;">
        <a href="{{ route('admin.students.template') }}" style="background: #17a2b8; color: white; padding: 0.75rem 1.5rem; border-radius: 5px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-download"></i> Download Template
        </a>
        <button onclick="document.getElementById('uploadModal').style.display='block'" style="background: #28a745; color: white; padding: 0.75rem 1.5rem; border-radius: 5px; border: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer;">
            <i class="fas fa-upload"></i> Bulk Upload Students
        </button>
    </div>
</div>

<!-- Search and Filter Section -->
<div style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem;">
    <form method="GET" action="{{ route('admin.students.index') }}" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end;">
        <div style="flex: 2; min-width: 200px;">
            <label style="display: block; margin-bottom: 0.5rem; color: #1a2b3c; font-weight: 500;">Search</label>
            <input type="text" name="search" class="form-control" placeholder="Search by name, ID, or email..." 
                   value="{{ request('search') }}" 
                   style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        
        <div style="flex: 1; min-width: 150px;">
            <label style="display: block; margin-bottom: 0.5rem; color: #1a2b3c; font-weight: 500;">Filter by Batch</label>
            <select name="batch" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                <option value="">All Batches</option>
                @foreach($batches as $batchOption)
                    <option value="{{ $batchOption }}" {{ request('batch') == $batchOption ? 'selected' : '' }}>
                        {{ $batchOption }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div style="flex: 0 0 auto;">
            <button type="submit" style="background: #0a2342; color: white; padding: 0.75rem 2rem; border: none; border-radius: 5px; cursor: pointer; font-weight: 500;">
                <i class="fas fa-search"></i> Filter
            </button>
            <a href="{{ route('admin.students.index') }}" style="display: inline-block; background: #6c757d; color: white; padding: 0.75rem 2rem; border-radius: 5px; text-decoration: none; margin-left: 0.5rem;">
                <i class="fas fa-sync-alt"></i> Reset
            </a>
        </div>
    </form>
    
    @if(request('search') || request('batch'))
        <div style="margin-top: 1rem; padding: 0.75rem; background: #e9ecef; border-radius: 5px;">
            <i class="fas fa-info-circle"></i> 
            Showing filtered results:
            @if(request('search')) <strong>"{{ request('search') }}"</strong> @endif
            @if(request('batch')) <strong>Batch {{ request('batch') }}</strong> @endif
            <a href="{{ route('admin.students.index') }}" style="margin-left: 1rem; color: #0a2342;">Clear filters</a>
        </div>
    @endif
</div>

<!-- Students Table -->
<div style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead style="background: #1a2b3c; color: white;">
            <tr>
                <th style="padding: 1rem; text-align: left;">#</th>
                <th style="padding: 1rem; text-align: left;">Student ID</th>
                <th style="padding: 1rem; text-align: left;">Name</th>
                <th style="padding: 1rem; text-align: left;">Email</th>
                <th style="padding: 1rem; text-align: left;">Year</th>
                <th style="padding: 1rem; text-align: left;">Section</th>
                <th style="padding: 1rem; text-align: left;">Batch</th>
                <th style="padding: 1rem; text-align: left;">Status</th>
                <th style="padding: 1rem; text-align: left;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $index => $student)
            <tr style="border-bottom: 1px solid #e9ecef; transition: background 0.2s ease;">
                <td style="padding: 1rem;">{{ $students->firstItem() + $index }}</td>
                <td style="padding: 1rem;"><code style="background: #f8f9fa; padding: 0.25rem 0.5rem; border-radius: 3px;">{{ $student->student_id }}</code></td>
                <td style="padding: 1rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <div style="width: 35px; height: 35px; background: #0a2342; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                            {{ substr($student->name, 0, 1) }}
                        </div>
                        <strong>{{ $student->name }}</strong>
                    </div>
                </td>
                <td style="padding: 1rem;">{{ $student->email }}</td>
                <td style="padding: 1rem;">
                    <span style="background: #e9ecef; color: #1a2b3c; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem;">
                        Year {{ $student->year }}
                    </span>
                </td>
                <td style="padding: 1rem;">{{ $student->section ?? 'N/A' }}</td>
                <td style="padding: 1rem;">{{ $student->batch ?? 'N/A' }}</td>
                <td style="padding: 1rem;">
                    @if($student->is_active)
                        <span style="background: #28a745; color: white; padding: 0.25rem 0.5rem; border-radius: 3px; font-size: 0.75rem;">Active</span>
                    @else
                        <span style="background: #dc3545; color: white; padding: 0.25rem 0.5rem; border-radius: 3px; font-size: 0.75rem;">Inactive</span>
                    @endif
                </td>
                <td style="padding: 1rem;">
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="#" style="background: #ffc107; color: #1a2b3c; padding: 0.25rem 0.75rem; border-radius: 3px; text-decoration: none; font-size: 0.85rem;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete student: {{ $student->name }}?');" style="display: inline;">
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
            <tr>
                <td colspan="9" style="padding: 3rem; text-align: center; color: #6c757d;">
                    <i class="fas fa-user-graduate" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                    <p>No students found. Upload a file to get started.</p>
                    <button onclick="document.getElementById('uploadModal').style.display='block'" style="margin-top: 1rem; background: #28a745; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer;">
                        <i class="fas fa-upload"></i> Upload Students
                    </button>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($students->hasPages())
<div style="margin-top: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
    <div style="color: #6c757d;">
        Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} students
    </div>
    <div>
        <style>
            .pagination {
                display: flex;
                gap: 0.5rem;
                list-style: none;
                flex-wrap: wrap;
                margin: 0;
                padding: 0;
            }
            
            .pagination li a,
            .pagination li span {
                display: block;
                padding: 0.5rem 1rem;
                background: white;
                border: 1px solid #dee2e6;
                border-radius: 5px;
                color: #0a2342;
                text-decoration: none;
                transition: all 0.3s;
            }
            
            .pagination li.active span {
                background: #0a2342;
                color: white;
                border-color: #0a2342;
            }
            
            .pagination li a:hover {
                background: #f8f9fa;
                border-color: #0a2342;
            }
            
            .pagination li.disabled span {
                color: #6c757d;
                cursor: not-allowed;
            }
        </style>
        {{ $students->appends(request()->query())->links() }}
    </div>
</div>
@endif

<!-- Upload Modal -->
<div id="uploadModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
    <div style="background: white; width: 500px; max-width: 90%; margin: 100px auto; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.2);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="color: #1a2b3c;">Bulk Upload Students</h3>
            <button onclick="document.getElementById('uploadModal').style.display='none'" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>
        
        <form action="{{ route('admin.students.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Select Excel/CSV File</label>
                <input type="file" name="file" accept=".xlsx,.xls,.csv" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                <p style="color: #666; font-size: 0.85rem; margin-top: 0.5rem;">
                    <i class="fas fa-info-circle"></i> Upload file with columns: student_id, name, email, year, section, batch
                </p>
                <p style="color: #28a745; font-size: 0.85rem; margin-top: 0.5rem;">
                    <i class="fas fa-download"></i> 
                    <a href="{{ route('admin.students.template') }}" style="color: #28a745;">Download template</a> to see the correct format
                </p>
            </div>
            
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" onclick="document.getElementById('uploadModal').style.display='none'" style="background: #6c757d; color: white; padding: 0.5rem 1.5rem; border: none; border-radius: 5px; cursor: pointer;">Cancel</button>
                <button type="submit" style="background: #28a745; color: white; padding: 0.5rem 1.5rem; border: none; border-radius: 5px; cursor: pointer;">
                    <i class="fas fa-upload"></i> Upload
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript for Modal -->
<script>
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('uploadModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
    
    // Auto-hide success/error messages after 5 seconds
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

<!-- Success/Error Messages -->
@if(session('success'))
<div style="position: fixed; bottom: 20px; right: 20px; background: #28a745; color: white; padding: 1rem; border-radius: 5px; box-shadow: 0 3px 10px rgba(0,0,0,0.2); z-index: 1001; transition: opacity 0.5s;">
    <i class="fas fa-check-circle"></i> {!! session('success') !!}
</div>
@endif

@if(session('error'))
<div style="position: fixed; bottom: 20px; right: 20px; background: #dc3545; color: white; padding: 1rem; border-radius: 5px; box-shadow: 0 3px 10px rgba(0,0,0,0.2); z-index: 1001; transition: opacity 0.5s;">
    <i class="fas fa-exclamation-circle"></i> {!! session('error') !!}
</div>
@endif

@if(session('warning'))
<div style="position: fixed; bottom: 20px; right: 20px; background: #ffc107; color: #1a2b3c; padding: 1rem; border-radius: 5px; box-shadow: 0 3px 10px rgba(0,0,0,0.2); z-index: 1001; transition: opacity 0.5s;">
    <i class="fas fa-exclamation-triangle"></i> {!! session('warning') !!}
</div>
@endif
@endsection