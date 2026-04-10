@extends('layouts.admin')

@section('title', 'Manage Students')
@section('page-title', 'Manage Students')

@section('content')
<div class="container">
    {{-- Statistics Overview --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <i class="fas fa-users" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
            <h3 style="font-size: 2rem; margin: 0;">{{ $stats['total'] ?? 0 }}</h3>
            <p style="margin: 0; opacity: 0.9;">Total Students</p>
        </div>
        
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <i class="fas fa-user-graduate" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
            <h3 style="font-size: 2rem; margin: 0;">{{ $stats['year1'] ?? 0 }}</h3>
            <p style="margin: 0; opacity: 0.9;">Year 1</p>
        </div>
        
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <i class="fas fa-user-graduate" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
            <h3 style="font-size: 2rem; margin: 0;">{{ $stats['year2'] ?? 0 }}</h3>
            <p style="margin: 0; opacity: 0.9;">Year 2</p>
        </div>
        
        <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <i class="fas fa-user-graduate" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
            <h3 style="font-size: 2rem; margin: 0;">{{ $stats['year3'] ?? 0 }}</h3>
            <p style="margin: 0; opacity: 0.9;">Year 3</p>
        </div>
        
        <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <i class="fas fa-user-graduate" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
            <h3 style="font-size: 2rem; margin: 0;">{{ $stats['year4'] ?? 0 }}</h3>
            <p style="margin: 0; opacity: 0.9;">Year 4</p>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem; border: 1px solid #e9ecef;">
        <form method="GET" action="{{ route('admin.students.index') }}" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end;">
            <div style="flex: 2; min-width: 200px;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.85rem;">Search Records</label>
                <input type="text" name="search" placeholder="Search by name, ID, or email..." 
                       value="{{ request('search') }}" 
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            <div style="flex: 1; min-width: 150px;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.85rem;">Filter Batch</label>
                <select name="batch" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; background: white;">
                    <option value="">All Batches</option>
                    @if(isset($batches))
                        @foreach($batches as $batchOption)
                            <option value="{{ $batchOption }}" {{ request('batch') == $batchOption ? 'selected' : '' }}>
                                {{ $batchOption }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" style="background: #ffc107; color: #1a2b3c; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;">
                    <i class="fas fa-filter"></i> Apply
                </button>
                <a href="{{ route('admin.students.index') }}" style="background: #6c757d; color: white; padding: 0.75rem 1.5rem; border-radius: 5px; text-decoration: none; font-size: 0.9rem;">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Header Action Buttons --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <h2 style="color: #1a2b3c; margin: 0; font-size: 1.5rem;">Student Directory</h2>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <button type="button" onclick="openIndividualModal()" style="background: #007bff; color: white; padding: 0.75rem 1.25rem; border: none; border-radius: 5px; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer; transition: 0.3s;">
                <i class="fas fa-plus"></i> Add Student
            </button>

            <button type="button" onclick="openBulkUploadModal()" style="background: #28a745; color: white; padding: 0.75rem 1.25rem; border: none; border-radius: 5px; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer; transition: 0.3s;">
                <i class="fas fa-file-upload"></i> Bulk Import
            </button>
            
            <a href="{{ route('admin.students.template') }}" style="background: #17a2b8; color: white; padding: 0.75rem 1.25rem; border-radius: 5px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.9rem;">
                <i class="fas fa-file-download"></i> Template
            </a>
        </div>
    </div>

    {{-- Data Table --}}
    <div style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #eee;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #1a2b3c; color: white;">
                <tr>
                    <th style="padding: 1.2rem 1rem; text-align: left;">Student ID</th>
                    <th style="padding: 1.2rem 1rem; text-align: left;">Name</th>
                    <th style="padding: 1.2rem 1rem; text-align: left;">Email</th>
                    <th style="padding: 1.2rem 1rem; text-align: left;">Year</th>
                    <th style="padding: 1.2rem 1rem; text-align: left;">Section</th>
                    <th style="padding: 1.2rem 1rem; text-align: left;">Batch</th>
                    <th style="padding: 1.2rem 1rem; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr style="border-bottom: 1px solid #f1f1f1; transition: 0.2s;" onmouseover="this.style.background='#f8f9ff'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 1rem;"><code style="color: #d63384; font-weight: bold;">{{ $student->student_id }}</code></td>
                    <td style="padding: 1rem;"><strong>{{ $student->name }}</strong></td>
                    <td style="padding: 1rem; color: #666;">{{ $student->email }}</td>
                    <td style="padding: 1rem;">
                        <span style="background: #e9ecef; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600; color: #495057;">
                            Year {{ $student->year }}
                        </span>
                    </td>
                    <td style="padding: 1rem;">{{ $student->section ?? '—' }}</td>
                    <td style="padding: 1rem;">{{ $student->batch ?? '—' }}</td>
                    <td style="padding: 1rem; text-align: center;">
                        <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Delete student {{ $student->name }}? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: 1px solid #dc3545; color: #dc3545; padding: 0.4rem 0.75rem; border-radius: 4px; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='#dc3545'; this.style.color='white'" onmouseout="this.style.background='none'; this.style.color='#dc3545'">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 4rem; text-align: center; color: #adb5bd;">
                        <i class="fas fa-folder-open" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                        <p style="font-size: 1.1rem;">No students found in the database.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 2rem;">
        {{ $students->appends(request()->query())->links() }}
    </div>
</div>

{{-- MODAL: Bulk Upload --}}
<div id="bulkUploadModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 9999; justify-content: center; align-items: center; backdrop-filter: blur(4px);">
    <div style="background: white; border-radius: 12px; width: 90%; max-width: 500px; padding: 2.5rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid #eee; padding-bottom: 1rem;">
            <h3 style="margin: 0; color: #1a2b3c;">Bulk Import Students</h3>
            <button type="button" onclick="closeBulkUploadModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #999;">&times;</button>
        </div>
        
        <form id="bulkUploadForm" method="POST" action="{{ route('admin.students.upload') }}" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: #444;">Select CSV File</label>
                <input type="file" name="student_file" accept=".csv" required style="width: 100%; padding: 0.75rem; border: 2px dashed #ddd; border-radius: 8px; cursor: pointer;">
            </div>
            
            <div style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
                <p style="margin: 0; font-size: 0.85rem; color: #856404; line-height: 1.5;">
                    <i class="fas fa-info-circle"></i> Ensure your CSV follows the template format. <br>
                    <strong>Required:</strong> student_id, name, email, year.
                </p>
            </div>
            
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" onclick="closeBulkUploadModal()" style="background: #e9ecef; color: #495057; padding: 0.75rem 1.5rem; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">Cancel</button>
                <button type="submit" style="background: #28a745; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; box-shadow: 0 4px 6px rgba(40, 167, 69, 0.2);">
                    <i class="fas fa-upload"></i> Start Import
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: Individual Student --}}
<div id="individualStudentModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 9999; justify-content: center; align-items: center; backdrop-filter: blur(4px);">
    <div style="background: white; border-radius: 12px; width: 90%; max-width: 550px; padding: 2.5rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid #eee; padding-bottom: 1rem;">
            <h3 style="margin: 0; color: #1a2b3c;">New Student Enrollment</h3>
            <button type="button" onclick="closeIndividualModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #999;">&times;</button>
        </div>
        
        <form action="{{ route('admin.students.store') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.25rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; color: #555;">Student ID *</label>
                    <input type="text" name="student_id" placeholder="e.g. STU123" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; color: #555;">Full Name *</label>
                    <input type="text" name="name" placeholder="John Doe" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px;">
                </div>
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; color: #555;">Institutional Email *</label>
                <input type="email" name="email" placeholder="example@university.edu" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; color: #555;">Year Level *</label>
                    <select name="year" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; background: white;">
                        <option value="1">Year 1</option>
                        <option value="2">Year 2</option>
                        <option value="3">Year 3</option>
                        <option value="4">Year 4</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; color: #555;">Section</label>
                    <input type="text" name="section" placeholder="A" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; color: #555;">Batch</label>
                    <input type="text" name="batch" placeholder="2024" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px;">
                </div>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end; border-top: 1px solid #eee; padding-top: 1.5rem;">
                <button type="button" onclick="closeIndividualModal()" style="background: #e9ecef; color: #495057; padding: 0.75rem 1.5rem; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">Cancel</button>
                <button type="submit" style="background: #007bff; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; box-shadow: 0 4px 6px rgba(0, 123, 255, 0.2);">
                    Save Student
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Scripts --}}
<script>
    function openBulkUploadModal() { document.getElementById('bulkUploadModal').style.display = 'flex'; }
    function closeBulkUploadModal() { document.getElementById('bulkUploadModal').style.display = 'none'; }
    
    function openIndividualModal() { document.getElementById('individualStudentModal').style.display = 'flex'; }
    function closeIndividualModal() { document.getElementById('individualStudentModal').style.display = 'none'; }
    
    // Close modals when clicking outside
    window.onclick = function(event) {
        if (event.target === document.getElementById('bulkUploadModal')) closeBulkUploadModal();
        if (event.target === document.getElementById('individualStudentModal')) closeIndividualModal();
    }
</script>

{{-- Flash Messaging --}}
@if(session('success'))
<div class="alert-box" style="position: fixed; bottom: 20px; right: 20px; background: #28a745; color: white; padding: 1.25rem; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2); z-index: 10001; max-width: 450px; border-left: 5px solid #1e7e34;">
    <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
        <i class="fas fa-check-circle" style="margin-top: 4px;"></i>
        <div>{!! session('success') !!}</div>
    </div>
</div>
@endif

@if(session('error'))
<div class="alert-box" style="position: fixed; bottom: 20px; right: 20px; background: #dc3545; color: white; padding: 1.25rem; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2); z-index: 10001; max-width: 450px; border-left: 5px solid #bd2130;">
    <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
        <i class="fas fa-exclamation-triangle" style="margin-top: 4px;"></i>
        <div>{!! session('error') !!}</div>
    </div>
</div>
@endif

<script>
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert-box');
        alerts.forEach(el => {
            el.style.transition = 'all 0.5s ease';
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            setTimeout(() => el.remove(), 500);
        });
    }, 5000);
</script>
@endsection