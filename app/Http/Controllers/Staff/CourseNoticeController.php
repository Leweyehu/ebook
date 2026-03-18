<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseNotice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseNoticeController extends Controller
{
    /**
     * Show create notice form
     */
    public function create(Course $course)
    {
        $this->authorize('update', $course);
        return view('staff.notices.create', compact('course'));
    }

    /**
     * Store new notice
     */
    public function store(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'priority' => 'required|in:low,normal,high,urgent',
            'expires_at' => 'nullable|date|after:today',
            'attachment' => 'nullable|file|max:10240', // 10MB max
        ]);

        $data = [
            'course_id' => $course->id,
            'posted_by' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'priority' => $request->priority,
            'expires_at' => $request->expires_at,
        ];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('notices/' . $course->id, $fileName, 'public');
            
            $data['attachment_path'] = $filePath;
            $data['attachment_name'] = $file->getClientOriginalName();
        }

        $notice = CourseNotice::create($data);

        return redirect()->route('staff.courses.show', $course)
            ->with('success', 'Notice posted successfully!');
    }

    /**
     * Show edit form
     */
    public function edit(CourseNotice $notice)
    {
        $this->authorize('update', $notice->course);
        return view('staff.notices.edit', compact('notice'));
    }

    /**
     * Update notice
     */
    public function update(Request $request, CourseNotice $notice)
    {
        $this->authorize('update', $notice->course);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'priority' => 'required|in:low,normal,high,urgent',
            'expires_at' => 'nullable|date',
            'attachment' => 'nullable|file|max:10240',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['title', 'content', 'priority', 'expires_at', 'is_active']);

        if ($request->hasFile('attachment')) {
            // Delete old attachment
            if ($notice->attachment_path) {
                Storage::disk('public')->delete($notice->attachment_path);
            }
            
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('notices/' . $notice->course_id, $fileName, 'public');
            
            $data['attachment_path'] = $filePath;
            $data['attachment_name'] = $file->getClientOriginalName();
        }

        $notice->update($data);

        return redirect()->route('staff.courses.show', $notice->course)
            ->with('success', 'Notice updated successfully!');
    }

    /**
     * Delete notice
     */
    public function destroy(CourseNotice $notice)
    {
        $this->authorize('update', $notice->course);

        if ($notice->attachment_path) {
            Storage::disk('public')->delete($notice->attachment_path);
        }

        $notice->delete();

        return redirect()->route('staff.courses.show', $notice->course)
            ->with('success', 'Notice deleted successfully!');
    }

    /**
     * Download attachment
     */
    public function downloadAttachment(CourseNotice $notice)
    {
        $this->authorize('view', $notice->course);

        if (!$notice->attachment_path) {
            return back()->with('error', 'No attachment found.');
        }

        return Storage::disk('public')->download($notice->attachment_path, $notice->attachment_name);
    }
}