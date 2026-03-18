@extends('layouts.staff')

@section('title', $assignment->title)
@section('page-title', $assignment->course->course_code . ' - ' . $assignment->title)

@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-bottom: 2rem;">
    <!-- Left Column - Assignment Details -->
    <div style="background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.5rem;">
            <div>
                <h2 style="margin-bottom: 0.5rem;">{{ $assignment->title }}</h2>
                <span style="background: {{ $assignment->assignment_type === 'midterm' ? '#dc3545' : ($assignment->assignment_type === 'final' ? '#fd7e14' : '#ffc107') }}; color: #1a2b3c; padding: 0.25rem 0.75rem; border-radius: 3px; font-size: 0.85rem;">
                    {{ ucfirst($assignment->assignment_type) }}
                </span>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('staff.assignments.edit', $assignment) }}" style="background: #ffc107; color: #1a2b3c; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('staff.assignments.bulk-grade', $assignment) }}" style="background: #28a745; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
                    <i class="fas fa-check-double"></i> Bulk Grade
                </a>
            </div>
        </div>

        <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px; margin-bottom: 1.5rem;">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
                <div>
                    <span style="color: #666;">Due Date:</span><br>
                    <strong>{{ $assignment->due_date->format('F d, Y') }}</strong>
                    @if($assignment->isPastDue())
                        <span style="color: #dc3545; font-size: 0.85rem; margin-left: 0.5rem;">(Past Due)</span>
                    @endif
                </div>
                <div>
                    <span style="color: #666;">Total Points:</span><br>
                    <strong>{{ $assignment->total_points }}</strong>
                </div>
                <div>
                    <span style="color: #666;">Status:</span><br>
                    <span style="color: {{ $assignment->is_active ? '#28a745' : '#dc3545' }};">
                        {{ $assignment->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>

        <h3 style="margin-bottom: 1rem;">Description</h3>
        <p style="color: #666; line-height: 1.8; margin-bottom: 1.5rem;">{{ $assignment->description }}</p>

        @if($assignment->file_path)
        <div style="margin-bottom: 1.5rem;">
            <h3 style="margin-bottom: 1rem;">Attachment</h3>
            <a href="{{ route('staff.assignments.download', $assignment) }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #f8f9fa; padding: 0.75rem 1.5rem; border-radius: 5px; text-decoration: none; color: #333;">
                <i class="fas fa-paperclip"></i>
                <span>{{ $assignment->file_name }}</span>
                <i class="fas fa-download" style="color: #28a745;"></i>
            </a>
        </div>
        @endif
    </div>

    <!-- Right Column - Stats -->
    <div style="background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <h3 style="margin-bottom: 1.5rem;">Submission Statistics</h3>
        
        <div style="margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                <span>Total Submissions</span>
                <strong>{{ $submissions->count() }}</strong>
            </div>
            <div style="height: 8px; background: #e9ecef; border-radius: 4px;">
                <div style="width: {{ ($submissions->count() / ($submissions->count() + $pendingStudents->count())) * 100 }}%; height: 100%; background: #28a745; border-radius: 4px;"></div>
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                <span>Graded</span>
                <strong>{{ $submissions->whereNotNull('score')->count() }}</strong>
            </div>
            <div style="height: 8px; background: #e9ecef; border-radius: 4px;">
                <div style="width: {{ $submissions->count() > 0 ? ($submissions->whereNotNull('score')->count() / $submissions->count()) * 100 : 0 }}%; height: 100%; background: #ffc107; border-radius: 4px;"></div>
            </div>
        </div>

        <div style="margin-bottom: 2rem;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                <span>Pending</span>
                <strong>{{ $pendingStudents->count() }}</strong>
            </div>
            <div style="height: 8px; background: #e9ecef; border-radius: 4px;">
                <div style="width: {{ ($pendingStudents->count() / ($submissions->count() + $pendingStudents->count())) * 100 }}%; height: 100%; background: #dc3545; border-radius: 4px;"></div>
            </div>
        </div>

        <div style="text-align: center;">
            <a href="{{ route('staff.assignments.download-all', $assignment) }}" style="display: block; background: #17a2b8; color: white; padding: 0.75rem; border-radius: 5px; text-decoration: none; margin-bottom: 0.5rem;">
                <i class="fas fa-file-archive"></i> Download All Submissions
            </a>
        </div>
    </div>
</div>

<!-- Submissions List -->
<div style="background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <h3 style="margin-bottom: 1.5rem;">Student Submissions</h3>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f8f9fa;">
                <tr>
                    <th style="padding: 1rem; text-align: left;">Student</th>
                    <th style="padding: 1rem; text-align: left;">Student ID</th>
                    <th style="padding: 1rem; text-align: left;">Submitted</th>
                    <th style="padding: 1rem; text-align: left;">Status</th>
                    <th style="padding: 1rem; text-align: left;">Score</th>
                    <th style="padding: 1rem; text-align: left;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($submissions as $submission)
                <tr style="border-bottom: 1px solid #e9ecef;">
                    <td style="padding: 1rem;">{{ $submission->student->name }}</td>
                    <td style="padding: 1rem;">{{ $submission->student->student_id }}</td>
                    <td style="padding: 1rem;">
                        {{ $submission->submitted_at->format('M d, Y H:i') }}
                        @if($submission->is_late)
                            <span style="background: #dc3545; color: white; padding: 0.15rem 0.5rem; border-radius: 3px; font-size: 0.75rem; margin-left: 0.5rem;">Late</span>
                        @endif
                    </td>
                    <td style="padding: 1rem;">
                        @if($submission->score)
                            <span style="background: #28a745; color: white; padding: 0.25rem 0.75rem; border-radius: 3px;">Graded</span>
                        @else
                            <span style="background: #ffc107; color: #1a2b3c; padding: 0.25rem 0.75rem; border-radius: 3px;">Pending</span>
                        @endif
                    </td>
                    <td style="padding: 1rem;">
                        @if($submission->score)
                            <strong>{{ $submission->score }}/{{ $assignment->total_points }}</strong>
                            <span style="color: #666; font-size: 0.85rem;">
                                ({{ round(($submission->score / $assignment->total_points) * 100, 1) }}%)
                            </span>
                        @else
                            -
                        @endif
                    </td>
                    <td style="padding: 1rem;">
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('staff.assignments.grade', $submission) }}" style="background: #667eea; color: white; padding: 0.25rem 0.75rem; border-radius: 3px; text-decoration: none;">
                                <i class="fas fa-check-circle"></i> Grade
                            </a>
                            <a href="{{ route('staff.submissions.download', $submission) }}" style="background: #17a2b8; color: white; padding: 0.25rem 0.75rem; border-radius: 3px; text-decoration: none;">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 2rem; text-align: center; color: #6c757d;">
                        No submissions yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection