<?php

namespace App\Http\Controllers\Admin;

use App\Models\Alumni;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumni::query();
        
        if ($request->filled('year')) {
            $query->where('graduation_year', $request->year);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', "%{$request->search}%")
                  ->orWhere('email', 'LIKE', "%{$request->search}%")
                  ->orWhere('student_id', 'LIKE', "%{$request->search}%");
        }
        
        $alumni = $query->orderBy('created_at', 'desc')->paginate(20);
        
        $stats = [
            'total' => Alumni::count(),
            'pending' => Alumni::where('status', 'pending')->count(),
            'approved' => Alumni::where('status', 'approved')->count(),
            'verified' => Alumni::where('is_verified', true)->count(),
        ];
        
        $years = Alumni::distinct()->pluck('graduation_year')->sort()->reverse()->values();
        $statuses = ['pending', 'approved', 'rejected'];
        
        return view('admin.alumni.index', compact('alumni', 'stats', 'years', 'statuses'));
    }

    public function show(Alumni $alumni)
    {
        return view('admin.alumni.show', compact('alumni'));
    }

    public function verify(Alumni $alumni)
    {
        $alumni->update(['is_verified' => true, 'status' => 'approved']);
        return redirect()->back()->with('success', 'Alumni verified successfully!');
    }

    public function reject(Alumni $alumni)
    {
        $alumni->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Alumni rejected.');
    }

    public function destroy(Alumni $alumni)
    {
        if ($alumni->profile_image && file_exists(public_path($alumni->profile_image))) {
            unlink(public_path($alumni->profile_image));
        }
        $alumni->delete();
        return redirect()->route('admin.alumni.index')->with('success', 'Alumni deleted.');
    }

    public function export(Request $request)
    {
        $alumni = Alumni::all();
        
        $filename = "alumni_export_" . date('Y-m-d') . ".csv";
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"$filename\""];
        
        $callback = function() use ($alumni) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Student ID', 'Name', 'Email', 'Year', 'Degree', 'Job', 'Company', 'Location', 'Status']);
            foreach ($alumni as $a) {
                fputcsv($file, [
                    $a->student_id, $a->name, $a->email, $a->graduation_year, $a->degree,
                    $a->current_job_title ?? 'N/A', $a->current_company ?? 'N/A', $a->location ?? 'N/A', $a->status
                ]);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}