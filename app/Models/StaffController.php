<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /**
     * Display a listing of staff (public view)
     */
    public function index()
    {
        $staff = Staff::where('is_active', true)
                      ->orderBy('sort_order')
                      ->orderBy('name')
                      ->get();
        
        $stats = [
            'total' => $staff->count(),
            'lecturers' => $staff->whereIn('position', ['Lecturer', 'Senior Lecturer', 'Assistant Lecturer'])->count(),
            'technical' => $staff->whereIn('position', ['Senior Technical Assistant', 'Technical Assistant'])->count(),
            'msc' => $staff->filter(function($s) {
                return str_contains($s->qualification, 'MSc') || str_contains($s->qualification, 'Master');
            })->count()
        ];

        return view('staff.index', compact('staff', 'stats'));
    }

    /**
     * Show admin management page (protected)
     */
    public function admin()
    {
        $staff = Staff::orderBy('sort_order')->orderBy('name')->get();
        return view('staff.admin', compact('staff'));
    }

    /**
     * Store a newly created staff (protected)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'specialization' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string',
            'sort_order' => 'nullable|integer'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('staff', 'public');
            $validated['image'] = $imagePath;
        }

        Staff::create($validated);

        return redirect()->route('staff.admin')->with('success', 'Staff member added successfully!');
    }

    /**
     * Update the specified staff (protected)
     */
    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'specialization' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string',
            'sort_order' => 'nullable|integer'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($staff->image) {
                Storage::disk('public')->delete($staff->image);
            }
            $imagePath = $request->file('image')->store('staff', 'public');
            $validated['image'] = $imagePath;
        }

        $staff->update($validated);

        return redirect()->route('staff.admin')->with('success', 'Staff member updated successfully!');
    }

    /**
     * Remove the specified staff (protected)
     */
    public function destroy(Staff $staff)
    {
        if ($staff->image) {
            Storage::disk('public')->delete($staff->image);
        }
        $staff->delete();

        return redirect()->route('staff.admin')->with('success', 'Staff member deleted successfully!');
    }

    /**
     * Toggle staff active status (protected)
     */
    public function toggleActive(Staff $staff)
    {
        $staff->update(['is_active' => !$staff->is_active]);
        return response()->json(['success' => true]);
    }

    /**
     * Update sort order (protected)
     */
    public function updateOrder(Request $request)
    {
        foreach ($request->order as $item) {
            Staff::where('id', $item['id'])->update(['sort_order' => $item['order']]);
        }
        return response()->json(['success' => true]);
    }
}