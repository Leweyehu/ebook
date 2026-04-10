<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramRequirement;
use App\Models\AdmissionRequirement;
use App\Models\GraduationRequirement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    // Program Management
    public function index()
    {
        $programs = Program::orderBy('order_position')->get();
        $requirements = ProgramRequirement::orderBy('order_position')->get();
        $admissionRequirements = AdmissionRequirement::orderBy('order_position')->get();
        $graduationRequirements = GraduationRequirement::orderBy('order_position')->get();
        
        return view('admin.programs.index', compact('programs', 'requirements', 'admissionRequirements', 'graduationRequirements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:undergraduate,postgraduate',
            'description' => 'nullable|string',
            'duration_years' => 'nullable|integer',
            'credit_hours' => 'nullable|integer',
            'ects' => 'nullable|integer',
        ]);

        Program::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'type' => $request->type,
            'icon' => $request->icon,
            'description' => $request->description,
            'career_opportunities' => $request->career_opportunities ? explode(',', $request->career_opportunities) : [],
            'specializations' => $request->specializations ? explode(',', $request->specializations) : [],
            'duration_years' => $request->duration_years,
            'duration_text' => $request->duration_text,
            'mode_of_delivery' => $request->mode_of_delivery,
            'teaching_method' => $request->teaching_method,
            'credit_hours' => $request->credit_hours,
            'ects' => $request->ects,
            'semesters' => $request->semesters,
            'order_position' => Program::max('order_position') + 1,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.programs.index')->with('success', 'Program created successfully.');
    }

    public function update(Request $request, Program $program)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $program->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'type' => $request->type,
            'icon' => $request->icon,
            'description' => $request->description,
            'career_opportunities' => $request->career_opportunities ? explode(',', $request->career_opportunities) : [],
            'specializations' => $request->specializations ? explode(',', $request->specializations) : [],
            'duration_years' => $request->duration_years,
            'duration_text' => $request->duration_text,
            'mode_of_delivery' => $request->mode_of_delivery,
            'teaching_method' => $request->teaching_method,
            'credit_hours' => $request->credit_hours,
            'ects' => $request->ects,
            'semesters' => $request->semesters,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.programs.index')->with('success', 'Program updated successfully.');
    }

    public function destroy(Program $program)
    {
        $program->delete();
        return redirect()->route('admin.programs.index')->with('success', 'Program deleted successfully.');
    }

    // Program Requirements
    public function storeRequirement(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'number_of_courses' => 'required|integer',
            'credit_hours' => 'required|integer',
            'ects' => 'required|integer',
        ]);

        ProgramRequirement::create([
            'category_name' => $request->category_name,
            'number_of_courses' => $request->number_of_courses,
            'credit_hours' => $request->credit_hours,
            'ects' => $request->ects,
            'order_position' => ProgramRequirement::max('order_position') + 1,
        ]);

        return redirect()->route('admin.programs.index')->with('success', 'Course requirement added successfully.');
    }

    public function updateRequirement(Request $request, $id)
    {
        $requirement = ProgramRequirement::findOrFail($id);
        
        $requirement->update([
            'category_name' => $request->category_name,
            'number_of_courses' => $request->number_of_courses,
            'credit_hours' => $request->credit_hours,
            'ects' => $request->ects,
        ]);

        return redirect()->route('admin.programs.index')->with('success', 'Course requirement updated successfully.');
    }

    public function destroyRequirement($id)
    {
        $requirement = ProgramRequirement::findOrFail($id);
        $requirement->delete();
        
        return redirect()->route('admin.programs.index')->with('success', 'Course requirement deleted successfully.');
    }

    // Admission Requirements
    public function storeAdmission(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        AdmissionRequirement::create([
            'title' => $request->title,
            'content' => $request->content,
            'order_position' => AdmissionRequirement::max('order_position') + 1,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.programs.index')->with('success', 'Admission requirement added successfully.');
    }

    public function updateAdmission(Request $request, $id)
    {
        $admission = AdmissionRequirement::findOrFail($id);
        
        $admission->update([
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.programs.index')->with('success', 'Admission requirement updated successfully.');
    }

    public function destroyAdmission($id)
    {
        $admission = AdmissionRequirement::findOrFail($id);
        $admission->delete();
        
        return redirect()->route('admin.programs.index')->with('success', 'Admission requirement deleted successfully.');
    }

    // Graduation Requirements
    public function storeGraduation(Request $request)
    {
        $request->validate([
            'requirement' => 'required|string',
        ]);

        GraduationRequirement::create([
            'requirement' => $request->requirement,
            'order_position' => GraduationRequirement::max('order_position') + 1,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.programs.index')->with('success', 'Graduation requirement added successfully.');
    }

    public function updateGraduation(Request $request, $id)
    {
        $graduation = GraduationRequirement::findOrFail($id);
        
        $graduation->update([
            'requirement' => $request->requirement,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.programs.index')->with('success', 'Graduation requirement updated successfully.');
    }

    public function destroyGraduation($id)
    {
        $graduation = GraduationRequirement::findOrFail($id);
        $graduation->delete();
        
        return redirect()->route('admin.programs.index')->with('success', 'Graduation requirement deleted successfully.');
    }
}