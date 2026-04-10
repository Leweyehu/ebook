@extends('layouts.admin')

@section('title', 'Course Structure Management')
@section('page-title', 'Course Structure Management')

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
        <h3 style="font-size: 2rem; margin: 0.5rem 0;">{{ $stats['electives'] }}</h3>
        <p>Elective Courses</p>
    </div>
    <div style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
        <i class="fas fa-layer-group" style="font-size: 2rem;"></i>
        <h3 style="font-size: 2rem; margin: 0.5rem 0;">{{ $stats['years'] }}</h3>
        <p>Years</p>
    </div>
</div>

<!-- Action Buttons -->
<div style="display: flex; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
    <a href="{{ route('admin.course-structure.create') }}" style="background: #28a745; color: white; padding: 0.6rem 1.2rem; border-radius: 5px; text-decoration: none;">
        <i class="fas fa-plus"></i> Add New Course
    </a>
    <a href="{{ route('admin.course-structure.upload-form') }}" style="background: #17a2b8; color: white; padding: 0.6rem 1.2rem; border-radius: 5px; text-decoration: none;">
        <i class="fas fa-upload"></i> Bulk Upload
    </a>
    <a href="{{ route('admin.course-structure.template') }}" style="background: #ffc107; color: #1a2b3c; padding: 0.6rem 1.2rem; border-radius: 5px; text-decoration: none;">
        <i class="fas fa-download"></i> Download Template
    </a>
</div>

<!-- Course Structure Display -->
@foreach($years as $year)
<div style="margin-bottom: 3rem;">
    <h2 style="color: #003366; border-left: 5px solid #ffc107; padding-left: 1rem; margin-bottom: 1.5rem;">
        Year {{ $year }}
    </h2>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        @foreach($semesters as $semester)
        <div style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow: hidden;">
            <div style="background: linear-gradient(135deg, #003366, #1c5a8a); color: white; padding: 1rem; text-align: center;">
                <h3 style="margin: 0;">Semester {{ $semester }}</h3>
                <small>Total Courses: {{ $courseStructure[$year][$semester]->count() }}</small>
            </div>
            <div style="padding: 1rem;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                            <th style="padding: 0.8rem; text-align: left;">Code</th>
                            <th style="padding: 0.8rem; text-align: left;">Course Name</th>
                            <th style="padding: 0.8rem; text-align: center;">ECTS</th>
                            <th style="padding: 0.8rem; text-align: center;">Cr.Hrs</th>
                            <th style="padding: 0.8rem; text-align: center;">Type</th>
                            <th style="padding: 0.8rem; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courseStructure[$year][$semester] as $course)
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td style="padding: 0.8rem;">
                                <code style="background: #f8f9fa; padding: 0.2rem 0.4rem; border-radius: 3px;">{{ $course->course_code }}</code>
                            </td>
                            <td style="padding: 0.8rem;">
                                <strong>{{ $course->course_name }}</strong>
                                @if($course->description)
                                    <div style="font-size: 0.7rem; color: #6c757d;">{{ Str::limit($course->description, 50) }}</div>
                                @endif
                            </td>
                            <td style="padding: 0.8rem; text-align: center;">{{ $course->ects }}</td>
                            <td style="padding: 0.8rem; text-align: center;">{{ $course->credit_hours }}</td>
                            <td style="padding: 0.8rem; text-align: center;">{!! $course->type_badge !!}</td>
                            <td style="padding: 0.8rem; text-align: center;">
                                <div style="display: flex; gap: 0.3rem; justify-content: center;">
                                    <a href="{{ route('admin.course-structure.edit', $course) }}" style="background: #ffc107; color: #1a2b3c; padding: 0.3rem 0.6rem; border-radius: 3px; text-decoration: none; font-size: 0.75rem;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.course-structure.toggle-status', $course) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" style="background: {{ $course->status === 'active' ? '#dc3545' : '#28a745' }}; color: white; border: none; padding: 0.3rem 0.6rem; border-radius: 3px; cursor: pointer; font-size: 0.75rem;">
                                            <i class="fas {{ $course->status === 'active' ? 'fa-ban' : 'fa-check' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.course-structure.destroy', $course) }}" method="POST" onsubmit="return confirm('Delete this course?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: #dc3545; color: white; border: none; padding: 0.3rem 0.6rem; border-radius: 3px; cursor: pointer; font-size: 0.75rem;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="padding: 2rem; text-align: center; color: #6c757d;">
                                <i class="fas fa-book-open"></i> No courses added yet
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
                @if($courseStructure[$year][$semester]->count() > 0)
                <div style="margin-top: 1rem; padding-top: 0.5rem; border-top: 1px solid #e9ecef;">
                    <strong>Sub Total:</strong> 
                    {{ $courseStructure[$year][$semester]->sum('ects') }} ECTS | 
                    {{ $courseStructure[$year][$semester]->sum('credit_hours') }} Cr. Hrs.
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endforeach

@if(session('success'))
<div style="position: fixed; bottom: 20px; right: 20px; background: #28a745; color: white; padding: 1rem; border-radius: 5px; box-shadow: 0 3px 10px rgba(0,0,0,0.2); z-index: 1001;">
    {!! session('success') !!}
</div>
<script>setTimeout(function() { document.querySelector('[style*="position: fixed; bottom: 20px; right: 20px;"]')?.remove(); }, 5000);</script>
@endif

@if(session('error'))
<div style="position: fixed; bottom: 20px; right: 20px; background: #dc3545; color: white; padding: 1rem; border-radius: 5px; box-shadow: 0 3px 10px rgba(0,0,0,0.2); z-index: 1001;">
    {!! session('error') !!}
</div>
<script>setTimeout(function() { document.querySelector('[style*="position: fixed; bottom: 20px; right: 20px;"]')?.remove(); }, 5000);</script>
@endif
@endsection