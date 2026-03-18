<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    /**
     * Show gradebook for a course
     */
    public function index(Course $course)
    {
        $this->authorize('view', $course);

        $students = $course->students()->orderBy('name')->get();
        $assignments = $course->assignments()->where('is_active', true)->get();
        
        $grades = [];
        foreach ($students as $student) {
            foreach ($assignments as $assignment) {
                $grade = Grade::where('student_id', $student->id)
                    ->where('assignment_id', $assignment->id)
                    ->first();
                
                $grades[$student->id][$assignment->id] = $grade;
            }
        }

        return view('staff.grades.index', compact('course', 'students', 'assignments', 'grades'));
    }

    /**
     * Enter/update grade for a student
     */
    public function store(Request $request, Course $course, Student $student)
    {
        $this->authorize('update', $course);

        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'score' => 'required|numeric|min:0',
        ]);

        $assignment = Assignment::findOrFail($request->assignment_id);
        
        if ($request->score > $assignment->total_points) {
            return back()->with('error', 'Score cannot exceed total points (' . $assignment->total_points . ')');
        }

        $percentage = ($request->score / $assignment->total_points) * 100;

        Grade::updateOrCreate(
            [
                'student_id' => $student->id,
                'assignment_id' => $assignment->id,
            ],
            [
                'course_id' => $course->id,
                'score' => $request->score,
                'percentage' => $percentage,
                'letter_grade' => Grade::calculateLetterGrade($percentage),
                'grade_type' => 'assignment',
                'graded_by' => Auth::id(),
            ]
        );

        return back()->with('success', 'Grade saved successfully!');
    }

    /**
     * Show final grades for a course
     */
    public function finalGrades(Course $course)
    {
        $this->authorize('view', $course);

        $students = $course->students()->orderBy('name')->get();
        $grades = [];

        foreach ($students as $student) {
            $studentGrades = Grade::where('student_id', $student->id)
                ->where('course_id', $course->id)
                ->get();

            $total = $studentGrades->sum('score');
            $maxPossible = $course->assignments()->sum('total_points');
            
            $percentage = $maxPossible > 0 ? ($total / $maxPossible) * 100 : 0;
            
            $grades[$student->id] = [
                'total' => $total,
                'percentage' => round($percentage, 2),
                'letter' => Grade::calculateLetterGrade($percentage),
                'grades' => $studentGrades,
            ];
        }

        return view('staff.grades.final', compact('course', 'students', 'grades'));
    }

    /**
     * Export grades to CSV
     */
    public function export(Course $course)
    {
        $this->authorize('view', $course);

        $students = $course->students()->orderBy('name')->get();
        $assignments = $course->assignments()->where('is_active', true)->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="grades_' . $course->course_code . '_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($students, $assignments) {
            $file = fopen('php://output', 'w');
            
            // Headers
            $headerRow = ['Student ID', 'Student Name'];
            foreach ($assignments as $assignment) {
                $headerRow[] = $assignment->title . ' (' . $assignment->total_points . ')';
            }
            $headerRow[] = 'Total';
            $headerRow[] = 'Percentage';
            $headerRow[] = 'Grade';
            fputcsv($file, $headerRow);

            // Data rows
            foreach ($students as $student) {
                $row = [
                    $student->student_id,
                    $student->name,
                ];

                $total = 0;
                $maxPossible = 0;

                foreach ($assignments as $assignment) {
                    $grade = Grade::where('student_id', $student->id)
                        ->where('assignment_id', $assignment->id)
                        ->first();
                    
                    $score = $grade ? $grade->score : 0;
                    $row[] = $score;
                    $total += $score;
                    $maxPossible += $assignment->total_points;
                }

                $percentage = $maxPossible > 0 ? round(($total / $maxPossible) * 100, 2) : 0;
                $row[] = $total;
                $row[] = $percentage . '%';
                $row[] = Grade::calculateLetterGrade($percentage);

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}