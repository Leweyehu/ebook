<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Student;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    /**
     * Show create assignment form
     */
    public function create(Course $course)
    {
        $this->authorize('update', $course);
        return view('staff.assignments.create', compact('course'));
    }

    /**
     * Store new assignment
     */
    public function store(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date|after:today',
            'total_points' => 'required|integer|min:1|max:100',
            'assignment_type' => 'required|in:homework,quiz,project,lab,midterm,final',
            'file' => 'nullable|file|max:10240', // 10MB max
        ]);

        $data = [
            'course_id' => $course->id,
            'created_by' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'total_points' => $request->total_points,
            'assignment_type' => $request->assignment_type,
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('assignments/' . $course->id, $fileName, 'public');
            
            $data['file_path'] = $filePath;
            $data['file_name'] = $file->getClientOriginalName();
        }

        $assignment = Assignment::create($data);

        return redirect()->route('staff.courses.show', $course)
            ->with('success', 'Assignment created successfully!');
    }

    /**
     * Show assignment details
     */
    public function show(Assignment $assignment)
    {
        $this->authorize('view', $assignment->course);

        $submissions = $assignment->submissions()->with('student')->get();
        $enrolledStudents = $assignment->course->students;
        
        $submittedIds = $submissions->pluck('student_id')->toArray();
        $pendingStudents = $enrolledStudents->whereNotIn('id', $submittedIds);

        return view('staff.assignments.show', compact('assignment', 'submissions', 'pendingStudents'));
    }

    /**
     * Show edit form
     */
    public function edit(Assignment $assignment)
    {
        $this->authorize('update', $assignment->course);
        return view('staff.assignments.edit', compact('assignment'));
    }

    /**
     * Update assignment
     */
    public function update(Request $request, Assignment $assignment)
    {
        $this->authorize('update', $assignment->course);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'total_points' => 'required|integer|min:1|max:100',
            'assignment_type' => 'required|in:homework,quiz,project,lab,midterm,final',
            'file' => 'nullable|file|max:10240',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['title', 'description', 'due_date', 'total_points', 'assignment_type', 'is_active']);

        if ($request->hasFile('file')) {
            // Delete old file
            if ($assignment->file_path) {
                Storage::disk('public')->delete($assignment->file_path);
            }
            
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('assignments/' . $assignment->course_id, $fileName, 'public');
            
            $data['file_path'] = $filePath;
            $data['file_name'] = $file->getClientOriginalName();
        }

        $assignment->update($data);

        return redirect()->route('staff.assignments.show', $assignment)
            ->with('success', 'Assignment updated successfully!');
    }

    /**
     * Show grading interface for a specific submission
     */
    public function gradeSubmission(AssignmentSubmission $submission)
    {
        $this->authorize('update', $submission->assignment->course);
        
        return view('staff.assignments.grade', compact('submission'));
    }

    /**
     * Submit grade for submission
     */
    public function submitGrade(Request $request, AssignmentSubmission $submission)
    {
        $this->authorize('update', $submission->assignment->course);

        $request->validate([
            'score' => 'required|numeric|min:0|max:' . $submission->assignment->total_points,
            'feedback' => 'nullable|string',
        ]);

        $percentage = ($request->score / $submission->assignment->total_points) * 100;

        $submission->update([
            'score' => $request->score,
            'feedback' => $request->feedback,
            'graded_at' => now(),
            'graded_by' => Auth::id(),
        ]);

        // Create grade record
        Grade::create([
            'student_id' => $submission->student_id,
            'course_id' => $submission->assignment->course_id,
            'assignment_id' => $submission->assignment_id,
            'score' => $request->score,
            'percentage' => $percentage,
            'letter_grade' => Grade::calculateLetterGrade($percentage),
            'grade_type' => 'assignment',
            'graded_by' => Auth::id(),
        ]);

        return redirect()->route('staff.assignments.show', $submission->assignment)
            ->with('success', 'Grade submitted successfully!');
    }

    /**
     * Bulk grade interface
     */
    public function bulkGrade(Assignment $assignment)
    {
        $this->authorize('update', $assignment->course);

        $students = $assignment->course->students;
        $submissions = $assignment->submissions()->with('student')->get()->keyBy('student_id');

        return view('staff.assignments.bulk-grade', compact('assignment', 'students', 'submissions'));
    }

    /**
     * Submit bulk grades
     */
    public function submitBulkGrade(Request $request, Assignment $assignment)
    {
        $this->authorize('update', $assignment->course);

        $grades = $request->input('grades', []);
        $feedback = $request->input('feedback', []);

        foreach ($grades as $studentId => $score) {
            if (!empty($score)) {
                $submission = $assignment->submissions()
                    ->where('student_id', $studentId)
                    ->first();

                if ($submission) {
                    $percentage = ($score / $assignment->total_points) * 100;
                    
                    $submission->update([
                        'score' => $score,
                        'feedback' => $feedback[$studentId] ?? null,
                        'graded_at' => now(),
                        'graded_by' => Auth::id(),
                    ]);

                    Grade::updateOrCreate(
                        [
                            'student_id' => $studentId,
                            'assignment_id' => $assignment->id,
                        ],
                        [
                            'course_id' => $assignment->course_id,
                            'score' => $score,
                            'percentage' => $percentage,
                            'letter_grade' => Grade::calculateLetterGrade($percentage),
                            'grade_type' => 'assignment',
                            'graded_by' => Auth::id(),
                        ]
                    );
                }
            }
        }

        return redirect()->route('staff.assignments.show', $assignment)
            ->with('success', 'Bulk grading completed successfully!');
    }

    /**
     * Download all submissions as ZIP
     */
    public function downloadAllSubmissions(Assignment $assignment)
    {
        $this->authorize('view', $assignment->course);

        // Create a temporary zip file
        $zipFileName = 'submissions_' . $assignment->id . '_' . time() . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new \ZipArchive();
        $zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($assignment->submissions as $submission) {
            $filePath = storage_path('app/public/' . $submission->file_path);
            if (file_exists($filePath)) {
                $fileName = $submission->student->student_id . '_' . $submission->student->name . '_' . $submission->file_name;
                $zip->addFile($filePath, $fileName);
            }
        }

        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}