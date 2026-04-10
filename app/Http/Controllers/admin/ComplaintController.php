<?php

namespace App\Http\Controllers\Admin;

use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ComplaintController extends Controller
{
    /**
     * Display list of complaints
     */
    public function index()
    {
        $complaints = Complaint::orderBy('created_at', 'desc')->paginate(20);
        
        $stats = [
            'total' => Complaint::count(),
            'pending' => Complaint::where('status', 'pending')->count(),
            'reviewing' => Complaint::where('status', 'reviewing')->count(),
            'resolved' => Complaint::where('status', 'resolved')->count(),
            'urgent' => Complaint::where('priority', 'urgent')->count(),
        ];
        
        return view('admin.complaints.index', compact('complaints', 'stats'));
    }

    /**
     * View single complaint
     */
    public function show(Complaint $complaint)
    {
        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * Respond to complaint
     */
    public function respond(Request $request, Complaint $complaint)
    {
        $request->validate([
            'admin_response' => 'required|string',
            'status' => 'required|in:pending,reviewing,resolved,rejected,escalated'
        ]);

        $complaint->update([
            'admin_response' => $request->admin_response,
            'status' => $request->status,
            'resolved_at' => $request->status === 'resolved' ? now() : null
        ]);

        return redirect()->route('admin.complaints.show', $complaint)
            ->with('success', 'Response saved successfully!');
    }

    /**
     * Update complaint status
     */
    public function updateStatus(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewing,resolved,rejected,escalated'
        ]);

        $complaint->update([
            'status' => $request->status,
            'resolved_at' => $request->status === 'resolved' ? now() : null
        ]);

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    /**
     * Approve complaint
     */
    public function approve(Complaint $complaint)
    {
        $complaint->update([
            'status' => 'resolved',
            'resolved_at' => now()
        ]);
        
        return redirect()->route('admin.complaints.index')
            ->with('success', 'Complaint approved and marked as resolved!');
    }

    /**
     * Reject complaint
     */
    public function reject(Complaint $complaint)
    {
        $complaint->update(['status' => 'rejected']);
        
        return redirect()->route('admin.complaints.index')
            ->with('success', 'Complaint rejected!');
    }

    /**
     * Delete complaint
     */
    public function destroy(Complaint $complaint)
    {
        $complaint->delete();
        return redirect()->route('admin.complaints.index')
            ->with('success', 'Complaint deleted successfully!');
    }

    /**
     * Bulk delete complaints
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:complaints,id'
        ]);

        Complaint::whereIn('id', $request->ids)->delete();

        return redirect()->route('admin.complaints.index')
            ->with('success', count($request->ids) . ' complaints deleted successfully!');
    }

    /**
     * Export complaints to CSV
     */
    public function export()
    {
        $complaints = Complaint::all();
        
        $filename = "complaints_" . date('Y-m-d') . ".csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($complaints) {
            $file = fopen('php://output', 'w');
            
            // Headers
            fputcsv($file, ['Reference No', 'Date', 'Name', 'Email', 'Category', 'Subject', 'Priority', 'Status']);
            
            // Data
            foreach ($complaints as $complaint) {
                fputcsv($file, [
                    $complaint->reference_no,
                    $complaint->created_at->format('Y-m-d'),
                    $complaint->name,
                    $complaint->email,
                    $complaint->category,
                    $complaint->subject,
                    $complaint->priority,
                    $complaint->status
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}