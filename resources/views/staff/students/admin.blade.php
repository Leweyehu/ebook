@extends('layouts.app')

@section('title', 'Manage Students')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Manage Students</h1>
        <p>Bulk upload student data via Excel</p>
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

    <!-- Statistics -->
    <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem; margin-bottom: 2rem;">
        <div style="background: #1a2b3c; color: white; padding: 1rem; border-radius: 10px; text-align: center;">
            <h3 style="font-size: 1.8rem;">{{ $stats['total'] }}</h3>
            <p>Total</p>
        </div>
        <div style="background: #28a745; color: white; padding: 1rem; border-radius: 10px; text-align: center;">
            <h3 style="font-size: 1.8rem;">{{ $stats['year1'] }}</h3>
            <p>Year 1</p>
        </div>
        <div style="background: #17a2b8; color: white; padding: 1rem; border-radius: 10px; text-align: center;">
            <h3 style="font-size: 1.8rem;">{{ $stats['year2'] }}</h3>
            <p>Year 2</p>
        </div>
        <div style="background: #ffc107; color: #1a2b3c; padding: 1rem; border-radius: 10px; text-align: center;">
            <h3 style="font-size: 1.8rem;">{{ $stats['year3'] }}</h3>
            <p>Year 3</p>
        </div>
        <div style="background: #dc3545; color: white; padding: 1rem; border-radius: 10px; text-align: center;">
            <h3 style="font-size: 1.8rem;">{{ $stats['year4'] }}</h3>
            <p>Year 4</p>
        </div>
    </div>

    <!-- Upload Form -->
    <div style="background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 2rem;">
        <h3 style="color: #1a2b3c; margin-bottom: 1.5rem;">Bulk Upload Students</h3>
        
        <div style="margin-bottom: 1rem;">
            <a href="{{ route('admin.students.template') }}" style="color: #ffc107; text-decoration: none;">
                <i class="fas fa-download"></i> Download Sample Template
            </a>
        </div>
        
        <form action="{{ route('admin.students.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 1rem;">
                <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                       style="padding: 0.5rem; border: 2px solid #e9ecef; border-radius: 5px; width: 100%;">
                <p style="color: #6c757d; font-size: 0.85rem; margin-top: 0.3rem;">
                    Accepted formats: Excel (.xlsx, .xls) or CSV. Max size: 2MB
                </p>
            </div>
            <button type="submit" style="background: #ffc107; color: #1a2b3c; padding: 0.8rem 2rem; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
                <i class="fas fa-upload"></i> Upload Students
            </button>
        </form>
    </div>

    <!-- Student List -->
    <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div style="padding: 1.5rem; border-bottom: 1px solid #e9ecef;">
            <h3 style="color: #1a2b3c;">Student List ({{ $students->count() }})</h3>
        </div>
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f8f9fa;">
                <tr>
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
                @forelse($students as $student)
                <tr style="border-bottom: 1px solid #e9ecef;">
                    <td style="padding: 1rem;">{{ $student->student_id }}</td>
                    <td style="padding: 1rem;">{{ $student->name }}</td>
                    <td style="padding: 1rem;">{{ $student->email }}</td>
                    <td style="padding: 1rem;">Year {{ $student->year }}</td>
                    <td style="padding: 1rem;">{{ $student->section ?? '—' }}</td>
                    <td style="padding: 1rem;">{{ $student->batch ?? '—' }}</td>
                    <td style="padding: 1rem;">
                        <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Delete this student?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color: #dc3545; background: none; border: 1px solid #dc3545; padding: 0.3rem 0.8rem; border-radius: 5px; cursor: pointer;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 3rem; text-align: center; color: #6c757d;">
                        <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                        <p>No students found. Upload an Excel file to add students.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection