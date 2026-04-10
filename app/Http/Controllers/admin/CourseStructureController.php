<?php

namespace App\Http\Controllers\Admin;

use App\Models\CourseStructure;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseStructureController extends Controller
{
    /**
     * Display course structure management
     */
    public function index()
    {
        $years = [1, 2, 3, 4];
        $semesters = [1, 2];
        
        $courseStructure = [];
        foreach ($years as $year) {
            foreach ($semesters as $semester) {
                $courseStructure[$year][$semester] = CourseStructure::where('year', $year)
                    ->where('semester', $semester)
                    ->where('status', 'active')
                    ->orderBy('order')
                    ->get();
            }
        }
        
        $stats = [
            'total' => CourseStructure::count(),
            'active' => CourseStructure::where('status', 'active')->count(),
            'electives' => CourseStructure::where('is_elective', true)->count(),
            'years' => CourseStructure::distinct('year')->count('year')
        ];
        
        return view('admin.course-structure.index', compact('courseStructure', 'years', 'semesters', 'stats'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.course-structure.create');
    }

    /**
     * Store new course
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:1|max:4',
            'semester' => 'required|integer|min:1|max:2',
            'course_code' => 'required|string|max:20|unique:course_structures',
            'course_name' => 'required|string|max:255',
            'ects' => 'required|integer|min:1|max:10',
            'credit_hours' => 'required|integer|min:1|max:6',
            'description' => 'nullable|string',
            'is_elective' => 'boolean',
            'order' => 'nullable|integer'
        ]);

        $validated['is_elective'] = $request->has('is_elective');
        $validated['order'] = $request->order ?? 0;
        $validated['status'] = 'active';

        CourseStructure::create($validated);

        return redirect()->route('admin.course-structure.index')
            ->with('success', 'Course added successfully!');
    }

    /**
     * Show edit form
     */
    public function edit(CourseStructure $courseStructure)
    {
        return view('admin.course-structure.edit', compact('courseStructure'));
    }

    /**
     * Update course
     */
    public function update(Request $request, CourseStructure $courseStructure)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:1|max:4',
            'semester' => 'required|integer|min:1|max:2',
            'course_code' => 'required|string|max:20|unique:course_structures,course_code,' . $courseStructure->id,
            'course_name' => 'required|string|max:255',
            'ects' => 'required|integer|min:1|max:10',
            'credit_hours' => 'required|integer|min:1|max:6',
            'description' => 'nullable|string',
            'is_elective' => 'boolean',
            'order' => 'nullable|integer'
        ]);

        $validated['is_elective'] = $request->has('is_elective');

        $courseStructure->update($validated);

        return redirect()->route('admin.course-structure.index')
            ->with('success', 'Course updated successfully!');
    }

    /**
     * Delete course
     */
    public function destroy(CourseStructure $courseStructure)
    {
        $courseStructure->delete();
        return redirect()->route('admin.course-structure.index')
            ->with('success', 'Course deleted successfully!');
    }

    /**
     * Toggle course status (active/inactive)
     */
    public function toggleStatus(CourseStructure $courseStructure)
    {
        $newStatus = $courseStructure->status === 'active' ? 'inactive' : 'active';
        $courseStructure->update(['status' => $newStatus]);
        
        return redirect()->back()->with('success', 'Course status updated!');
    }

    /**
     * Bulk import via Excel/CSV
     */
    public function uploadForm()
    {
        return view('admin.course-structure.upload');
    }

    /**
     * Process bulk upload
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120'
        ]);

        try {
            $file = $request->file('file');
            $handle = fopen($file->getPathname(), 'r');
            
            // Skip header row
            fgetcsv($handle);
            
            $rowCount = 0;
            $successCount = 0;
            $errors = [];
            
            while (($row = fgetcsv($handle)) !== FALSE) {
                $rowCount++;
                
                // Expected: year, semester, course_code, course_name, ects, credit_hours, is_elective, description
                $data = [
                    'year' => $row[0] ?? null,
                    'semester' => $row[1] ?? null,
                    'course_code' => $row[2] ?? null,
                    'course_name' => $row[3] ?? null,
                    'ects' => $row[4] ?? null,
                    'credit_hours' => $row[5] ?? null,
                    'is_elective' => ($row[6] ?? 'no') === 'yes',
                    'description' => $row[7] ?? null,
                    'status' => 'active',
                    'order' => 0
                ];
                
                // Validate required fields
                if (empty($data['year']) || empty($data['semester']) || empty($data['course_code']) || empty($data['course_name'])) {
                    $errors[] = "Row {$rowCount}: Missing required fields";
                    continue;
                }
                
                // Check for duplicate course code
                if (CourseStructure::where('course_code', $data['course_code'])->exists()) {
                    $errors[] = "Row {$rowCount}: Course code {$data['course_code']} already exists";
                    continue;
                }
                
                CourseStructure::create($data);
                $successCount++;
            }
            
            fclose($handle);
            
            $message = "✅ {$successCount} courses imported successfully!";
            if (count($errors) > 0) {
                $message .= "<br>⚠️ Errors: " . implode('<br>', array_slice($errors, 0, 10));
            }
            
            return redirect()->route('admin.course-structure.index')->with('success', $message);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error uploading file: ' . $e->getMessage());
        }
    }

    /**
     * Download template
     */
    public function downloadTemplate()
    {
        $headers = ['year', 'semester', 'course_code', 'course_name', 'ects', 'credit_hours', 'is_elective', 'description'];
        
        $filename = "course_structure_template.csv";
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $handle = fopen('php://output', 'w');
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($handle, $headers);
        fputcsv($handle, ['1', '1', 'MATH1011', 'Mathematics for Natural Science', '5', '3', 'no', '']);
        fputcsv($handle, ['1', '1', 'FLEN1011', 'Communicative English Language Skills I', '5', '3', 'no', '']);
        
        fclose($handle);
        exit;
    }
}