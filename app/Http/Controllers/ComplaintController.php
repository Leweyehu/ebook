<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ComplaintController extends Controller
{
    /**
     * Display complaint form
     */
    public function index()
    {
        $categories = [
            'academic' => ['label' => 'Academic Issues', 'icon' => 'fa-book', 'color' => '#667eea'],
            'administrative' => ['label' => 'Administrative', 'icon' => 'fa-building', 'color' => '#f093fb'],
            'facilities' => ['label' => 'Facilities & Infrastructure', 'icon' => 'fa-building', 'color' => '#4facfe'],
            'harassment' => ['label' => 'Harassment/Bullying', 'icon' => 'fa-exclamation-triangle', 'color' => '#dc3545'],
            'discrimination' => ['label' => 'Discrimination', 'icon' => 'fa-balance-scale', 'color' => '#fd7e14'],
            'staff' => ['label' => 'Staff Conduct', 'icon' => 'fa-chalkboard-teacher', 'color' => '#43e97b'],
            'other' => ['label' => 'Other', 'icon' => 'fa-question-circle', 'color' => '#6c757d']
        ];
        
        $priorities = [
            'low' => 'Low Priority (Response within 7 days)',
            'medium' => 'Medium Priority (Response within 3-5 days)',
            'high' => 'High Priority (Response within 24-48 hours)',
            'urgent' => 'Urgent (Immediate attention required)'
        ];
        
        return view('complaints.index', compact('categories', 'priorities'));
    }

    /**
     * Store complaint
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'complainant_type' => 'required|in:student,staff,parent,other',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'student_id' => 'nullable|string|max:50',
            'staff_id' => 'nullable|string|max:50',
            'department' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:10',
            'category' => 'required|in:academic,administrative,facilities,harassment,discrimination,staff,other',
            'sub_category' => 'nullable|string|max:255',
            'subject' => 'required|string|max:500',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'is_anonymous' => 'boolean',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120'
        ]);

        // Handle file upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $attachmentPath = $file->storeAs('complaints', $filename, 'public');
        }

        $complaint = Complaint::create([
            'reference_no' => Complaint::generateReferenceNo(),
            'complainant_type' => $validated['complainant_type'],
            'name' => $validated['is_anonymous'] ? 'Anonymous' : $validated['name'],
            'email' => $validated['is_anonymous'] ? 'anonymous@complaint' : $validated['email'],
            'phone' => $validated['is_anonymous'] ? null : ($validated['phone'] ?? null),
            'student_id' => $validated['student_id'] ?? null,
            'staff_id' => $validated['staff_id'] ?? null,
            'department' => $validated['department'] ?? null,
            'year' => $validated['year'] ?? null,
            'category' => $validated['category'],
            'sub_category' => $validated['sub_category'] ?? null,
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'attachment' => $attachmentPath,
            'priority' => $validated['priority'],
            'status' => 'pending',
            'is_anonymous' => $validated['is_anonymous'] ?? false,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Send confirmation email (optional)
        // Mail::to($complaint->email)->send(new ComplaintSubmitted($complaint));

        return redirect()->route('complaints.thankyou', $complaint->reference_no)
            ->with('success', 'Your complaint has been submitted successfully. Reference No: ' . $complaint->reference_no);
    }

    /**
     * Thank you page with tracking
     */
    public function thankyou($reference_no)
    {
        $complaint = Complaint::where('reference_no', $reference_no)->firstOrFail();
        return view('complaints.thankyou', compact('complaint'));
    }

    /**
     * Track complaint status
     */
    public function track(Request $request)
    {
        $request->validate([
            'reference_no' => 'required|string'
        ]);
        
        $complaint = Complaint::where('reference_no', $request->reference_no)->first();
        
        if (!$complaint) {
            return back()->with('error', 'Complaint not found. Please check your reference number.');
        }
        
        return view('complaints.track', compact('complaint'));
    }

    /**
     * Show tracking form
     */
    public function trackForm()
    {
        return view('complaints.track-form');
    }
}