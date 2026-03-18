<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /**
     * Display public listing of staff
     */
    public function index()
    {
        $staff = Staff::where('is_active', true)
                      ->orderBy('order')
                      ->orderBy('name')
                      ->get();
        
        $academicStaff = $staff->where('staff_type', 'academic');
        $administrativeStaff = $staff->where('staff_type', 'administrative');
        $technicalStaff = $staff->where('staff_type', 'technical');
        
        return view('staff.index', compact('academicStaff', 'administrativeStaff', 'technicalStaff'));
    }

    /**
     * Display admin management page
     */
   public function admin()
{
    $staff = Staff::orderBy('order')->orderBy('name')->get();
    return view('staff.admin', compact('staff'));
}

    /**
     * Show form for creating new staff
     */
    public function create()
    {
        return view('staff.create');
    }

    /**
     * Store new staff member
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'position' => 'required|string|max:255',
        'qualification' => 'required|string|max:255',
        'email' => 'required|email|unique:staff',
        'phone' => 'nullable|string|max:20',
        'staff_type' => 'required|in:academic,administrative,technical',
        'bio' => 'nullable|string',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'order' => 'nullable|integer'
    ]);

    $data = $request->except('profile_image');
    
    // Handle image upload
    if ($request->hasFile('profile_image')) {
        $image = $request->file('profile_image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images/staff'), $imageName);
        $data['profile_image'] = 'images/staff/' . $imageName;
    }

    Staff::create($data);

    // FIXED: Changed from 'staff.admin' to 'admin.staff.index'
    return redirect()->route('admin.staff.index')->with('success', 'Staff member added successfully!');
}

    /**
     * Show form for editing staff
     */
    public function edit(Staff $staff)
    {
        return view('staff.edit', compact('staff'));
    }

    /**
     * Update staff member
     */
    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'phone' => 'nullable|string|max:20',
            'staff_type' => 'required|in:academic,administrative,technical',
            'bio' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'sometimes|boolean'
        ]);

        $data = $request->except('profile_image');
        
        // Handle image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image
            if ($staff->profile_image && file_exists(public_path($staff->profile_image))) {
                unlink(public_path($staff->profile_image));
            }
            
            $image = $request->file('profile_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/staff'), $imageName);
            $data['profile_image'] = 'images/staff/' . $imageName;
        }

        $staff->update($data);

        return redirect()->route('staff.admin')->with('success', 'Staff member updated successfully!');
    }

    /**
     * Delete staff member
     */
    public function destroy(Staff $staff)
    {
        // Delete image
        if ($staff->profile_image && file_exists(public_path($staff->profile_image))) {
            unlink(public_path($staff->profile_image));
        }
        
        $staff->delete();
        
        return redirect()->route('staff.admin')->with('success', 'Staff member deleted successfully!');
    }

    /**
     * Toggle staff active status
     */
    public function toggleStatus(Staff $staff)
    {
        $staff->update(['is_active' => !$staff->is_active]);
        
        return redirect()->route('staff.admin')->with('success', 'Staff status updated!');
    }
}