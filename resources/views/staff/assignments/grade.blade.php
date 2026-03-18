@extends('layouts.staff')

@section('title', 'Grade Submission')
@section('page-title', 'Grade: ' . $submission->assignment->title)

@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <!-- Left Column - Grading Form -->
    <div style="background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <h2 style="margin-bottom: 1.5rem;">Grade Submission</h2>

        <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px; margin-bottom: 1.5rem;">
            <p><strong>Student:</strong> {{ $submission->student->name }} ({{ $submission->student->student_id }})</p>
            <p><strong>Submitted:</strong> {{ $submission->submitted_at->format('F d, Y H:i') }}</p>
            @if($submission->is_late)
                <p><span style="background: #dc3545; color: white; padding: 0.15rem 0.5rem; border-radius: 3px;">Late Submission</span></p>
            @endif
        </div>

        <form action="{{ route('staff.assignments.submit-grade', $submission) }}" method="POST">
            @csrf

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Score (out of {{ $submission->assignment->total_points }})</label>
                <input type="number" name="score" value="{{ old('score', $submission->score) }}" required 
                       min="0" max="{{ $submission->assignment->total_points }}" step="0.5"
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                @error('score')
                    <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Feedback</label>
                <textarea name="feedback" rows="5" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">{{ old('feedback', $submission->feedback) }}</textarea>
                @error('feedback')
                    <p style="color: #dc3545; margin-top: 0.3rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" style="background: #28a745; color: white; padding: 0.75rem 2rem; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-save"></i> Submit Grade
                </button>
                <a href="{{ route('staff.assignments.show', $submission->assignment) }}" style="background: #6c757d; color: white; padding: 0.75rem 2rem; border-radius: 5px; text-decoration: none; font-weight: 600;">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </form>
    </div>

    <!-- Right Column - Student Submission -->
    <div style="background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <h3 style="margin-bottom: 1rem;">Student Submission</h3>
        
        @if($submission->file_path)
        <div style="text-align: center; padding: 2rem; background: #f8f9fa; border-radius: 5px;">
            <i class="fas fa-file-alt" style="font-size: 3rem; color: #667eea; margin-bottom: 1rem;"></i>
            <p style="margin-bottom: 1rem;">{{ $submission->file_name }}</p>
            <a href="{{ route('staff.submissions.download', $submission) }}" style="display: inline-block; background: #28a745; color: white; padding: 0.5rem 1.5rem; border-radius: 5px; text-decoration: none;">
                <i class="fas fa-download"></i> Download Submission
            </a>
        </div>
        @else
        <p style="color: #666;">No file attached to this submission.</p>
        @endif

        @if($submission->comments)
        <div style="margin-top: 1.5rem;">
            <h4 style="margin-bottom: 0.5rem;">Student Comments:</h4>
            <p style="color: #666;">{{ $submission->comments }}</p>
        </div>
        @endif
    </div>
</div>
@endsection