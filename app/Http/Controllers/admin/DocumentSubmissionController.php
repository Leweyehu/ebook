<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentSubmissionController extends Controller
{
    /**
     * Display a listing of all document submissions.
     */
    public function index(Request $request)
    {
        $query = DocumentSubmission::with('user')->orderBy('created_at', 'desc');
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('document_category', $request->category);
        }
        
        // Search by student name or ID
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%")
                  ->orWhere('project_title', 'like', "%{$search}%");
            });
        }
        
        $submissions = $query->paginate(15);
        
        // Get statistics
        $stats = [
            'total' => DocumentSubmission::count(),
            'pending' => DocumentSubmission::where('status', 'pending')->count(),
            'approved' => DocumentSubmission::where('status', 'approved')->count(),
            'rejected' => DocumentSubmission::where('status', 'rejected')->count(),
        ];
        
        return view('admin.document-submissions.index', compact('submissions', 'stats'));
    }

    /**
     * Display the specified document submission.
     */
    public function show($id)
    {
        $submission = DocumentSubmission::with('user')->findOrFail($id);
        return view('admin.document-submissions.show', compact('submission'));
    }

    /**
     * Download the file associated with the submission.
     */
    public function download($id)
    {
        $submission = DocumentSubmission::findOrFail($id);
        
        $filePath = storage_path('app/public/' . $submission->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }
        
        return response()->download($filePath, $submission->original_filename);
    }

    /**
     * Approve a document submission.
     */
    public function approve(Request $request, $id)
    {
        $submission = DocumentSubmission::findOrFail($id);
        
        $submission->update([
            'status' => 'approved',
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
        ]);
        
        return redirect()->route('admin.document-submissions.index')
            ->with('success', 'Document submission approved successfully!');
    }

    /**
     * Reject a document submission.
     */
    public function reject(Request $request, $id)
    {
        $submission = DocumentSubmission::findOrFail($id);
        
        $request->validate([
            'admin_notes' => 'required|string|min:10|max:500',
        ]);
        
        $submission->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
        ]);
        
        return redirect()->route('admin.document-submissions.index')
            ->with('success', 'Document submission rejected successfully.');
    }

    /**
     * Delete a document submission.
     */
    public function destroy($id)
    {
        $submission = DocumentSubmission::findOrFail($id);
        
        // Delete file from storage
        Storage::disk('public')->delete($submission->file_path);
        
        // Delete record
        $submission->delete();
        
        return redirect()->route('admin.document-submissions.index')
            ->with('success', 'Document submission deleted successfully.');
    }

    /**
     * Export submissions to CSV.
     */
    public function export(Request $request)
    {
        $query = DocumentSubmission::with('user');
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('category') && $request->category != '') {
            $query->where('document_category', $request->category);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%")
                  ->orWhere('project_title', 'like', "%{$search}%");
            });
        }
        
        $submissions = $query->get();
        
        $filename = 'document-submissions-' . date('Y-m-d-H-i-s') . '.csv';
        
        return response()->streamDownload(function() use ($submissions) {
            $handle = fopen('php://output', 'w');
            
            // Add CSV headers with UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($handle, [
                'ID',
                'Student Name', 
                'Student ID', 
                'Semester', 
                'Academic Year', 
                'Batch', 
                'Document Type', 
                'Project Title', 
                'Status', 
                'File Size (KB)', 
                'MIME Type',
                'Submitted Date', 
                'Reviewed Date', 
                'Admin Notes'
            ]);
            
            // Add data rows
            foreach ($submissions as $submission) {
                fputcsv($handle, [
                    $submission->id,
                    $submission->full_name,
                    $submission->student_id,
                    $submission->semester,
                    $submission->academic_year,
                    $submission->batch,
                    ucfirst(str_replace('_', ' ', $submission->document_category)),
                    $submission->project_title ?? 'N/A',
                    ucfirst($submission->status),
                    round($submission->file_size / 1024, 2),
                    $submission->mime_type,
                    $submission->created_at->format('Y-m-d H:i:s'),
                    $submission->reviewed_at ? $submission->reviewed_at->format('Y-m-d H:i:s') : 'Not Reviewed',
                    $submission->admin_notes ?? 'N/A'
                ]);
            }
            
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}