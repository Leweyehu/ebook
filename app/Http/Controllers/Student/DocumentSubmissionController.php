<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\DocumentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentSubmissionController extends Controller
{
    // Max file size: 250MB = 250 * 1024 * 1024 bytes
    const MAX_FILE_SIZE = 262144000;
    
    // Allowed mime types
    const ALLOWED_MIMES = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'image/jpeg',
        'image/png',
        'image/jpg',
        'image/gif',
        'image/webp',
    ];

    /**
     * Display a listing of the user's document submissions.
     */
    public function index()
    {
        $submissions = DocumentSubmission::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('student.submissions.index', compact('submissions'));
    }

    /**
     * Show the form for creating a new document submission.
     */
    public function create()
    {
        return view('student.submissions.create');
    }

    /**
     * Store a newly created document submission in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'student_id' => 'required|string|max:50',
            'semester' => 'required|in:Semester I,Semester II',
            'academic_year' => 'required|regex:/^\d{4}-\d{4}$/',
            'batch' => 'required|in:First Year,Second Year,Third Year,Fourth Year',
            'project_title' => 'nullable|required_if:document_category,proposal,project_document|string|max:500',
            'document_category' => 'required|in:letter,proposal,internship,project_document,other',
            'document' => [
                'required',
                'file',
                'max:' . (self::MAX_FILE_SIZE / 1024), // in KB
                function ($attribute, $value, $fail) {
                    $mime = $value->getMimeType();
                    if (!in_array($mime, self::ALLOWED_MIMES)) {
                        $fail('The file must be a PDF, Word document, or image (JPEG, PNG, GIF, WEBP).');
                    }
                },
            ],
            'description' => 'nullable|string|max:1000',
        ]);

        // Get current year
        $currentYear = (int)date('Y');
        
        // Extract start year from academic_year (e.g., "2024-2025" -> 2024)
        $academicYearParts = explode('-', $request->academic_year);
        $startYear = (int)$academicYearParts[0];
        $endYear = (int)$academicYearParts[1];
        
        // Validate that academic year starts from current year or later (NOT in the future)
        if ($startYear > $currentYear) {
            return back()->withErrors(['academic_year' => 'Academic year cannot be greater than the current year (' . $currentYear . '). Please select ' . $currentYear . ' or earlier.'])->withInput();
        }
        
        // Validate that academic year is not in the future (cannot select future years)
        if ($startYear < $currentYear && $endYear < $currentYear) {
            // This is allowed - past years are fine
            // No error for past years
        }
        
        // Validate that end year is not greater than current year (prevents future selection)
        if ($endYear > $currentYear) {
            return back()->withErrors(['academic_year' => 'You cannot select an academic year that ends in the future (' . $endYear . '). The maximum allowed end year is ' . $currentYear . '.'])->withInput();
        }
        
        // Validate academic year format (must be consecutive years)
        if ($endYear != ($startYear + 1)) {
            return back()->withErrors(['academic_year' => 'Invalid academic year format. Academic year must be consecutive (e.g., 2024-2025, not 2024-2026).'])->withInput();
        }

        $file = $request->file('document');
        $extension = $file->getClientOriginalExtension();
        
        // Generate filename: Firstname_Lastname_TypeOfDocument.pdf
        $firstName = explode(' ', trim($request->full_name))[0] ?? 'Student';
        $lastNameParts = explode(' ', trim($request->full_name));
        $lastName = count($lastNameParts) > 1 ? end($lastNameParts) : $firstName;
        
        $categoryMap = [
            'letter' => 'Letter',
            'proposal' => 'Proposal',
            'internship' => 'InternshipReport',
            'project_document' => 'ProjectDocument',
            'other' => 'Other',
        ];
        
        $typeName = $categoryMap[$request->document_category];
        $newFilename = $firstName . '_' . $lastName . '_' . $typeName . '.' . $extension;
        
        // Sanitize filename (remove special characters)
        $newFilename = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $newFilename);
        
        // Store file using the public disk
        $filePath = $file->storeAs('submissions/' . Auth::id(), $newFilename, 'public');
        
        // Create submission record
        $submission = DocumentSubmission::create([
            'user_id' => Auth::id(),
            'full_name' => $request->full_name,
            'student_id' => $request->student_id,
            'semester' => $request->semester,
            'academic_year' => $request->academic_year,
            'batch' => $request->batch,
            'project_title' => $request->project_title,
            'document_category' => $request->document_category,
            'original_filename' => $file->getClientOriginalName(),
            'stored_filename' => $newFilename,
            'file_path' => $filePath,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'description' => $request->description,
            'submitted_at' => now(),
        ]);
        
        return redirect()->route('student.submission.index')
            ->with('success', 'Document uploaded successfully! Your submission ID is: ' . $submission->id);
    }

    /**
     * Display the specified document submission.
     */
    public function show($id)
    {
        $submission = DocumentSubmission::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();
        
        return view('student.submissions.show', compact('submission'));
    }

    /**
     * Download the file associated with the submission.
     */
    public function download($id)
    {
        $submission = DocumentSubmission::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();
        
        $filePath = storage_path('app/public/' . $submission->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }
        
        return response()->download($filePath, $submission->original_filename);
    }

    /**
     * Remove the specified document submission from storage.
     */
    public function destroy($id)
    {
        $submission = DocumentSubmission::where('user_id', Auth::id())
            ->where('id', $id)
            ->where('status', 'pending')
            ->firstOrFail();
        
        // Delete file
        Storage::disk('public')->delete($submission->file_path);
        
        // Delete record
        $submission->delete();
        
        return redirect()->route('student.submission.index')
            ->with('success', 'Submission deleted successfully.');
    }
}