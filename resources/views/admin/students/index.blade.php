@extends('layouts.admin')

@section('title', 'Manage Students')
@section('page-title', 'Student Management')

@section('content')
<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-users" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ \App\Models\Student::count() }}</h3>
        <p>Total Students</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-user-graduate" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ \App\Models\Student::where('year', 1)->count() }}</h3>
        <p>Year 1</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-user-graduate" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ \App\Models\Student::where('year', 2)->count() }}</h3>
        <p>Year 2</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-user-graduate" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ \App\Models\Student::where('year', 3)->count() }}</h3>
        <p>Year 3</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-user-graduate" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
        <h3 style="font-size: 2rem;">{{ \App\Models\Student::where('year', 4)->count() }}</h3>
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

<!-- Upload Modal -->
<div id="uploadModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
    <div style="background: white; width: 500px; margin: 100px auto; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.2);">
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

<!-- Students Table -->
<div style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead style="background: #1a2b3c; color: white;">
            <tr>
                <th style="padding: 1rem; text-align: left;">ID</th>
                <th style="padding: 1rem; text-align: left;">Student ID</th>
                <th style="padding: 1rem; text-align: left;">Name</th>
                <th style="padding: 1rem; text-align: left;">Email</th>
                <th style="padding: 1rem; text-align: left;">Year</th>
                <th style="padding: 1rem; text-align: left;">Section</th>
                <th style="padding: 1rem; text-align: left;">Batch</th>
                <th style="padding: 1rem; text-align: left;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse(\App\Models\Student::orderBy('year')->orderBy('name')->get() as $student)
            <tr style="border-bottom: 1px solid #e9ecef;">
                <td style="padding: 1rem;">{{ $student->id }}</td>
                <td style="padding: 1rem;">{{ $student->student_id }}</td>
                <td style="padding: 1rem;">{{ $student->name }}</td>
                <td style="padding: 1rem;">{{ $student->email }}</td>
                <td style="padding: 1rem;">Year {{ $student->year }}</td>
                <td style="padding: 1rem;">{{ $student->section ?? 'N/A' }}</td>
                <td style="padding: 1rem;">{{ $student->batch ?? 'N/A' }}</td>
                <td style="padding: 1rem;">
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="#" style="background: #ffc107; color: #1a2b3c; padding: 0.25rem 0.75rem; border-radius: 3px; text-decoration: none; font-size: 0.85rem;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');" style="display: inline;">
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
                <td colspan="8" style="padding: 3rem; text-align: center; color: #6c757d;">
                    <i class="fas fa-user-graduate" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                    <p>No students found. Upload a file to get started.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
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
@endsection