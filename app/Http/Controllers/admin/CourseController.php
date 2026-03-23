<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CoursesImport;

class CourseController extends Controller
{
    /**
     * Display course listing
     */
    public function index(Request $request)
    {
        $query = Course::query();
        
        if ($request->filled('year')) {
            $query->where('year_level', $request->year);
        }
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('course_code', 'LIKE', "%{$request->search}%")
                  ->orWhere('course_name', 'LIKE', "%{$request->search}%");
        }
        
        $courses = $query->orderBy('year_level')->orderBy('semester')->orderBy('order')->paginate(20);
        
        $stats = [
            'total' => Course::count(),
            'active' => Course::where('status', 'active')->count(),
            'elective' => Course::where('is_elective', true)->count(),
            'years' => Course::distinct('year_level')->count('year_level')
        ];
        
        $years = [1, 2, 3, 4];
        $semesters = [1, 2];
        $statuses = ['active', 'inactive', 'archived'];
        
        return view('admin.courses.index', compact('courses', 'stats', 'years', 'semesters', 'statuses'));
    }

    /**
     * Show course creation form
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    /**
     * Store new course
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_code' => 'required|string|max:20|unique:courses',
            'course_name' => 'required|string|max:255',
            'credit_hours' => 'required|integer|min:1|max:6',
            'year_level' => 'required|integer|min:1|max:4',
            'semester' => 'required|in:1,2',
            'description' => 'required|string',
            'objectives' => 'nullable|string',
            'syllabus' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'instructor' => 'nullable|string|max:255',
            'prerequisites' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:10|max:200',
            'status' => 'required|in:active,inactive,archived',
            'is_elective' => 'boolean',
            'order' => 'nullable|integer'
        ]);

        $data = $request->except('featured_image');
        
        // Handle image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = 'course_' . time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/courses', $imageName);
            $data['featured_image'] = 'courses/' . $imageName;
        }

        $data['is_elective'] = $request->has('is_elective');
        $data['order'] = $request->order ?? 0;

        Course::create($data);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course created successfully!');
    }

    /**
     * Show course details
     */
    public function show(Course $course)
    {
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show edit form
     */
    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update course
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'course_code' => 'required|string|max:20|unique:courses,course_code,' . $course->id,
            'course_name' => 'required|string|max:255',
            'credit_hours' => 'required|integer|min:1|max:6',
            'year_level' => 'required|integer|min:1|max:4',
            'semester' => 'required|in:1,2',
            'description' => 'required|string',
            'objectives' => 'nullable|string',
            'syllabus' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'instructor' => 'nullable|string|max:255',
            'prerequisites' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:10|max:200',
            'status' => 'required|in:active,inactive,archived',
            'is_elective' => 'boolean',
            'order' => 'nullable|integer'
        ]);

        $data = $request->except('featured_image');
        
        // Handle image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($course->featured_image && Storage::disk('public')->exists($course->featured_image)) {
                Storage::disk('public')->delete($course->featured_image);
            }
            
            $image = $request->file('featured_image');
            $imageName = 'course_' . time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/courses', $imageName);
            $data['featured_image'] = 'courses/' . $imageName;
        }

        $data['is_elective'] = $request->has('is_elective');

        $course->update($data);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully!');
    }

    /**
     * Delete course
     */
    public function destroy(Course $course)
    {
        // Delete image if exists
        if ($course->featured_image && Storage::disk('public')->exists($course->featured_image)) {
            Storage::disk('public')->delete($course->featured_image);
        }
        
        $course->delete();
        
        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully!');
    }

    /**
     * Toggle course status
     */
    public function toggleStatus(Course $course)
    {
        $newStatus = $course->status === 'active' ? 'inactive' : 'active';
        $course->update(['status' => $newStatus]);
        
        return redirect()->back()->with('success', 'Course status updated!');
    }

    /**
     * Bulk upload courses via Excel
     */
    public function uploadForm()
    {
        return view('admin.courses.upload');
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
            $import = new CoursesImport();
            Excel::import($import, $request->file('file'));
            
            $successCount = $import->getSuccessCount();
            $failedCount = $import->getFailedCount();
            
            $message = "✅ {$successCount} courses imported successfully!";
            if ($failedCount > 0) {
                $message .= " ⚠️ {$failedCount} rows failed.";
            }
            
            return redirect()->route('admin.courses.index')->with('success', $message);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error uploading file: ' . $e->getMessage());
        }
    }

    /**
     * Download template
     */
    public function downloadTemplate()
    {
        $headers = ['course_code', 'course_name', 'credit_hours', 'year_level', 'semester', 'description', 'instructor', 'capacity'];
        
        $filename = "course_template.csv";
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $handle = fopen('php://output', 'w');
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($handle, $headers);
        fputcsv($handle, ['CS101', 'Introduction to Programming', '3', '1', '1', 'Basic programming concepts using Python', 'Dr. Abebe Kebede', '60']);
        fputcsv($handle, ['CS201', 'Data Structures', '3', '2', '1', 'Advanced data structures and algorithms', 'Dr. Tigist Mulugeta', '50']);
        fclose($handle);
        
        exit;
    }
}