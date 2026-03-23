@extends('layouts.admin')

@section('title', 'Course Management')
@section('page-title', 'Course Management')

@section('content')
<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-book" style="font-size: 2rem;"></i>
        <h3 style="font-size: 2rem; margin: 0.5rem 0;">{{ $stats['total'] }}</h3>
        <p>Total Courses</p>
    </div>
    <div style="background: linear-gradient(135deg, #28a745 0%, #218838 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-check-circle" style="font-size: 2rem;"></i>
        <h3 style="font-size: 2rem; margin: 0.5rem 0;">{{ $stats['active'] }}</h3>
        <p>Active Courses</p>
    </div>
    <div style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); color: #1a2b3c; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-star" style="font-size: 2rem;"></i>
        <h3 style="font-size: 2rem; margin: 0.5rem 0;">{{ $stats['elective'] }}</h3>
        <p>Elective Courses</p>
    </div>
    <div style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-layer-group" style="font-size: 2rem;"></i>
        <h3 style="font-size: 2rem; margin: 0.5rem 0;">{{ $stats['years'] }}</h3>
        <p>Year Levels</p>
    </div>
</div>

<!-- Action Buttons -->
<div style="display: flex; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
    <a href="{{ route('admin.courses.create') }}" style="background: #28a745; color: white; padding: 0.6rem 1.2rem; border-radius: 5px; text-decoration: none;">
        <i class="fas fa-plus"></i> Add New Course
    </a>
    <a href="{{ route('admin.courses.upload-form') }}" style="background: #17a2b8; color: white; padding: 0.6rem 1.2rem; border-radius: 5px; text-decoration: none;">
        <i class="fas fa-upload"></i> Bulk Upload
    </a>
    <a href="{{ route('admin.courses.template') }}" style="background: #ffc107; color: #1a2b3c; padding: 0.6rem 1.2rem; border-radius: 5px; text-decoration: none;">
        <i class="fas fa-download"></i> Download Template
    </a>
</div>

<!-- Filter Section -->
<div style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem;">
    <form method="GET" action="{{ route('admin.courses.index') }}" style="display: flex; flex-wrap: wrap; gap: 1rem;">
        <div style="flex: 2;">
            <input type="text" name="search" placeholder="Search by course code or name..." value="{{ request('search') }}" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        <div>
            <select name="year" style="padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                <option value="">All Years</option>
                @foreach($years as $y)
                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>Year {{ $y }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <select name="semester" style="padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                <option value="">All Semesters</option>
                @foreach($semesters as $s)
                    <option value="{{ $s }}" {{ request('semester') == $s ? 'selected' : '' }}>Semester {{ $s }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <select name="status" style="padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                <option value="">All Status</option>
                @foreach($statuses as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <button type="submit" style="background: #ffc107; color: #1a2b3c; padding: 0.8rem 1.5rem; border: none; border-radius: 5px; cursor: pointer;">
                <i class="fas fa-search"></i> Filter
            </button>
            <a href="{{ route('admin.courses.index') }}" style="display: inline-block; background: #6c757d; color: white; padding: 0.8rem 1.5rem; border-radius: 5px; text-decoration: none;">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Courses Table -->
<div style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead style="background: #1a2b3c; color: white;">
            32
                <th style="padding: 1rem; text-align: left;">Code</th>
                <th style="padding: 1rem; text-align: left;">Course Name</th>
                <th style="padding: 1rem; text-align: left;">Credit</th>
                <th style="padding: 1rem; text-align: left;">Year</th>
                <th style="padding: 1rem; text-align: left;">Semester</th>
                <th style="padding: 1rem; text-align: left;">Instructor</th>
                <th style="padding: 1rem; text-align: left;">Status</th>
                <th style="padding: 1rem; text-align: left;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses as $course)
            <tr style="border-bottom: 1px solid #e9ecef;">
                <td style="padding: 1rem;"><strong>{{ $course->course_code }}</strong></td>
                <td style="padding: 1rem;">{{ $course->course_name }}</td>
                <td style="padding: 1rem;">{{ $course->credit_hours }}</td>
                <td style="padding: 1rem;">Year {{ $course->year_level }}</td>
                <td style="padding: 1rem;">Semester {{ $course->semester }}</td>
                <td style="padding: 1rem;">{{ $course->instructor ?? 'N/A' }}</td>
                <td style="padding: 1rem;">{!! $course->status_badge !!}</td>
                <td style="padding: 1rem;">
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.courses.show', $course) }}" style="background: #17a2b8; color: white; padding: 0.3rem 0.6rem; border-radius: 3px; text-decoration: none; font-size: 0.8rem;">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('admin.courses.edit', $course) }}" style="background: #ffc107; color: #1a2b3c; padding: 0.3rem 0.6rem; border-radius: 3px; text-decoration: none; font-size: 0.8rem;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.courses.toggle-status', $course) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" style="background: {{ $course->status == 'active' ? '#dc3545' : '#28a745' }}; color: white; border: none; padding: 0.3rem 0.6rem; border-radius: 3px; cursor: pointer; font-size: 0.8rem;">
                                <i class="fas {{ $course->status == 'active' ? 'fa-ban' : 'fa-check' }}"></i>
                                {{ $course->status == 'active' ? 'Disable' : 'Enable' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Delete this course?');" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: #dc3545; color: white; border: none; padding: 0.3rem 0.6rem; border-radius: 3px; cursor: pointer; font-size: 0.8rem;">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="padding: 3rem; text-align: center;">
                    <i class="fas fa-book" style="font-size: 3rem; color: #ccc;"></i>
                    <p style="margin-top: 1rem;">No courses found. Click "Add New Course" to get started.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 2rem;">
    {{ $courses->appends(request()->query())->links() }}
</div>

@if(session('success'))
<div style="position: fixed; bottom: 20px; right: 20px; background: #28a745; color: white; padding: 1rem; border-radius: 5px; box-shadow: 0 3px 10px rgba(0,0,0,0.2); z-index: 1001;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div style="position: fixed; bottom: 20px; right: 20px; background: #dc3545; color: white; padding: 1rem; border-radius: 5px; box-shadow: 0 3px 10px rgba(0,0,0,0.2); z-index: 1001;">
    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
</div>
@endif

<script>
    setTimeout(function() {
        const messages = document.querySelectorAll('[style*="position: fixed; bottom: 20px; right: 20px;"]');
        messages.forEach(function(message) {
            message.style.opacity = '0';
            setTimeout(function() { message.style.display = 'none'; }, 500);
        });
    }, 5000);
</script>
@endsection