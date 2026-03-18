<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseMaterialController extends Controller
{
    /**
     * Show upload form
     */
    public function create(Course $course)
    {
        $this->authorize('update', $course);
        return view('staff.materials.create', compact('course'));
    }

    /**
     * Upload course material
     */
    public function store(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'material_type' => 'required|in:lecture_note,slide,tutorial,reference,lab_manual,other',
            'file' => 'required|file|max:20480', // 20MB max
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('course-materials/' . $course->id, $fileName, 'public');

        $material = CourseMaterial::create([
            'course_id' => $course->id,
            'uploaded_by' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'material_type' => $request->material_type,
        ]);

        return redirect()->route('staff.courses.show', $course)
            ->with('success', 'Course material uploaded successfully!');
    }

    /**
     * Download course material
     */
    public function download(CourseMaterial $material)
    {
        $this->authorize('view', $material->course);
        
        $material->incrementDownloadCount();
        
        return Storage::disk('public')->download($material->file_path, $material->file_name);
    }

    /**
     * Delete course material
     */
    public function destroy(CourseMaterial $material)
    {
        $this->authorize('update', $material->course);

        // Delete file from storage
        Storage::disk('public')->delete($material->file_path);
        
        $material->delete();

        return redirect()->route('staff.courses.show', $material->course)
            ->with('success', 'Course material deleted successfully!');
    }
}