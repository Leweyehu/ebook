@extends('layouts.staff')

@section('title', $course->course_name)
@section('page-title', $course->course_code . ' - ' . $course->course_name)

@section('content')
<!-- Course Navigation Tabs -->
<div style="background: white; border-radius: 10px; margin-bottom: 2rem; overflow: hidden;">
    <div style="display: flex; border-bottom: 1px solid #e9ecef;">
        <button class="tab-btn active" onclick="showTab('overview')" style="padding: 1rem 2rem; background: none; border: none; cursor: pointer; font-weight: 600; color: #667eea; border-bottom: 3px solid #667eea;">Overview</button>
        <button class="tab-btn" onclick="showTab('materials')" style="padding: 1rem 2rem; background: none; border: none; cursor: pointer; font-weight: 600; color: #666;">Materials</button>
        <button class="tab-btn" onclick="showTab('assignments')" style="padding: 1rem 2rem; background: none; border: none; cursor: pointer; font-weight: 600; color: #666;">Assignments</button>
        <button class="tab-btn" onclick="showTab('notices')" style="padding: 1rem 2rem; background: none; border: none; cursor: pointer; font-weight: 600; color: #666;">Notices</button>
        <button class="tab-btn" onclick="showTab('grades')" style="padding: 1rem 2rem; background: none; border: none; cursor: pointer; font-weight: 600; color: #666;">Grades</button>
    </div>

    <!-- Overview Tab -->
    <div id="overview" class="tab-content" style="padding: 2rem;">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            <div>
                <h3 style="margin-bottom: 1rem;">Course Description</h3>
                <p style="color: #666; line-height: 1.8;">{{ $course->description }}</p>
                
                <h3 style="margin: 2rem 0 1rem;">Quick Stats</h3>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
                    <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px; text-align: center;">
                        <i class="fas fa-users" style="color: #667eea; font-size: 1.5rem;"></i>
                        <h4 style="margin: 0.5rem 0;">{{ $students->count() }}</h4>
                        <p style="color: #666;">Enrolled Students</p>
                    </div>
                    <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px; text-align: center;">
                        <i class="fas fa-file-alt" style="color: #ffc107; font-size: 1.5rem;"></i>
                        <h4 style="margin: 0.5rem 0;">{{ $materials->count() }}</h4>
                        <p style="color: #666;">Materials</p>
                    </div>
                    <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px; text-align: center;">
                        <i class="fas fa-tasks" style="color: #28a745; font-size: 1.5rem;"></i>
                        <h4 style="margin: 0.5rem 0;">{{ $assignments->count() }}</h4>
                        <p style="color: #666;">Assignments</p>
                    </div>
                </div>
            </div>
            
            <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px;">
                <h3 style="margin-bottom: 1rem;">Course Info</h3>
                <table style="width: 100%;">
                    <tr>
                        <td style="padding: 0.5rem 0; color: #666;">Course Code:</td>
                        <td style="padding: 0.5rem 0; font-weight: 600;">{{ $course->course_code }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.5rem 0; color: #666;">Year:</td>
                        <td style="padding: 0.5rem 0; font-weight: 600;">{{ $course->year }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.5rem 0; color: #666;">Semester:</td>
                        <td style="padding: 0.5rem 0; font-weight: 600;">{{ $course->semester }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.5rem 0; color: #666;">Credit Hours:</td>
                        <td style="padding: 0.5rem 0; font-weight: 600;">{{ $course->credit_hours }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.5rem 0; color: #666;">ECTS:</td>
                        <td style="padding: 0.5rem 0; font-weight: 600;">{{ $course->ects ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Materials Tab -->
    <div id="materials" class="tab-content" style="display: none; padding: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3>Course Materials</h3>
            <a href="{{ route('staff.materials.create', $course) }}" style="background: #28a745; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
                <i class="fas fa-upload"></i> Upload Material
            </a>
        </div>

        <div style="background: white; border: 1px solid #e9ecef; border-radius: 10px; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f8f9fa;">
                    <tr>
                        <th style="padding: 1rem; text-align: left;">Title</th>
                        <th style="padding: 1rem; text-align: left;">Type</th>
                        <th style="padding: 1rem; text-align: left;">File</th>
                        <th style="padding: 1rem; text-align: left;">Uploaded</th>
                        <th style="padding: 1rem; text-align: left;">Downloads</th>
                        <th style="padding: 1rem; text-align: left;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($materials as $material)
                    <tr style="border-bottom: 1px solid #e9ecef;">
                        <td style="padding: 1rem;">{{ $material->title }}</td>
                        <td style="padding: 1rem;">
                            <span style="background: #e9ecef; padding: 0.25rem 0.5rem; border-radius: 3px;">
                                {{ str_replace('_', ' ', ucfirst($material->material_type)) }}
                            </span>
                        </td>
                        <td style="padding: 1rem;">
                            <i class="{{ $material->file_icon }}"></i>
                            <span style="margin-left: 0.5rem;">{{ $material->file_name }}</span>
                            <span style="color: #999; font-size: 0.85rem; margin-left: 0.5rem;">({{ $material->formatted_size }})</span>
                        </td>
                        <td style="padding: 1rem;">{{ $material->created_at->format('M d, Y') }}</td>
                        <td style="padding: 1rem;">{{ $material->download_count }}</td>
                        <td style="padding: 1rem;">
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('staff.materials.download', $material) }}" style="color: #28a745; text-decoration: none;">
                                    <i class="fas fa-download"></i>
                                </a>
                                <form action="{{ route('staff.materials.destroy', $material) }}" method="POST" onsubmit="return confirm('Delete this material?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="color: #dc3545; background: none; border: none; cursor: pointer;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding: 2rem; text-align: center; color: #6c757d;">
                            No materials uploaded yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Assignments Tab -->
    <div id="assignments" class="tab-content" style="display: none; padding: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3>Assignments</h3>
            <a href="{{ route('staff.assignments.create', $course) }}" style="background: #28a745; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
                <i class="fas fa-plus"></i> Create Assignment
            </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem;">
            @forelse($assignments as $assignment)
            <div style="background: white; border: 1px solid #e9ecef; border-radius: 10px; overflow: hidden;">
                <div style="background: {{ $assignment->isPastDue() ? '#f8d7da' : '#f8f9fa' }}; padding: 1rem;">
                    <div style="display: flex; justify-content: space-between;">
                        <h4 style="margin: 0;">{{ $assignment->title }}</h4>
                        <span style="background: {{ $assignment->assignment_type === 'midterm' ? '#dc3545' : ($assignment->assignment_type === 'final' ? '#fd7e14' : '#ffc107') }}; color: #1a2b3c; padding: 0.25rem 0.5rem; border-radius: 3px; font-size: 0.85rem;">
                            {{ ucfirst($assignment->assignment_type) }}
                        </span>
                    </div>
                </div>
                <div style="padding: 1rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span><i class="far fa-calendar-alt"></i> Due: {{ $assignment->due_date->format('M d, Y') }}</span>
                        <span><i class="fas fa-star"></i> {{ $assignment->total_points }} pts</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                        <span><i class="fas fa-users"></i> {{ $assignment->submissions_count }} Submissions</span>
                        <span><i class="fas fa-hourglass-half"></i> {{ $assignment->pending_submissions }} Pending</span>
                    </div>
                    <p style="color: #666; margin-bottom: 1rem;">{{ Str::limit($assignment->description, 100) }}</p>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('staff.assignments.show', $assignment) }}" style="flex: 1; background: #667eea; color: white; padding: 0.5rem; text-align: center; border-radius: 5px; text-decoration: none;">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('staff.assignments.bulk-grade', $assignment) }}" style="flex: 1; background: #ffc107; color: #1a2b3c; padding: 0.5rem; text-align: center; border-radius: 5px; text-decoration: none;">
                            <i class="fas fa-check-double"></i> Grade
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 2rem;">
                <p style="color: #6c757d;">No assignments created yet.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Notices Tab -->
    <div id="notices" class="tab-content" style="display: none; padding: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3>Course Notices</h3>
            <a href="{{ route('staff.notices.create', $course) }}" style="background: #28a745; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
                <i class="fas fa-plus"></i> Post Notice
            </a>
        </div>

        <div style="display: grid; gap: 1rem;">
            @forelse($notices as $notice)
            <div style="background: white; border: 1px solid #e9ecef; border-radius: 10px; padding: 1.5rem; border-left: 4px solid {{ $notice->priority_badge }};">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                    <div>
                        <span style="background: {{ $notice->priority_badge }}; color: white; padding: 0.25rem 0.75rem; border-radius: 3px; font-size: 0.85rem; display: inline-block; margin-bottom: 0.5rem;">
                            {{ ucfirst($notice->priority) }}
                        </span>
                        <h3 style="margin: 0;">{{ $notice->title }}</h3>
                    </div>
                    <span style="color: #999;">{{ $notice->created_at->diffForHumans() }}</span>
                </div>
                <p style="color: #666; margin-bottom: 1rem;">{{ $notice->content }}</p>
                @if($notice->attachment_path)
                <div style="margin-bottom: 1rem;">
                    <a href="{{ route('staff.notices.download', $notice) }}" style="color: #667eea; text-decoration: none;">
                        <i class="fas fa-paperclip"></i> {{ $notice->attachment_name }}
                    </a>
                </div>
                @endif
                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                    <a href="{{ route('staff.notices.edit', $notice) }}" style="color: #ffc107; text-decoration: none;">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('staff.notices.destroy', $notice) }}" method="POST" onsubmit="return confirm('Delete this notice?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color: #dc3545; background: none; border: none; cursor: pointer;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 2rem;">
                <p style="color: #6c757d;">No notices posted yet.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Grades Tab -->
    <div id="grades" class="tab-content" style="display: none; padding: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3>Grade Management</h3>
            <div>
                <a href="{{ route('staff.grades.final', $course) }}" style="background: #17a2b8; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none; margin-right: 0.5rem;">
                    <i class="fas fa-chart-line"></i> Final Grades
                </a>
                <a href="{{ route('staff.grades.export', $course) }}" style="background: #28a745; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
                    <i class="fas fa-download"></i> Export CSV
                </a>
            </div>
        </div>
        <p style="color: #666;">Go to the Assignments tab to grade individual submissions.</p>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.style.display = 'none';
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
        btn.style.color = '#666';
        btn.style.borderBottom = 'none';
    });
    
    // Show selected tab
    document.getElementById(tabName).style.display = 'block';
    
    // Add active class to clicked button
    event.target.classList.add('active');
    event.target.style.color = '#667eea';
    event.target.style.borderBottom = '3px solid #667eea';
}
</script>
@endsection