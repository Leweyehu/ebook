<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\ProgramRequirement;
use App\Models\AdmissionRequirement;
use App\Models\GraduationRequirement;

class ProgramController extends Controller
{
    public function index()
    {
        $undergraduatePrograms = Program::where('type', 'undergraduate')
            ->where('is_active', true)
            ->orderBy('order_position')
            ->get();

        $postgraduatePrograms = Program::where('type', 'postgraduate')
            ->where('is_active', true)
            ->orderBy('order_position')
            ->get();

        $requirements = ProgramRequirement::orderBy('order_position')->get();
        
        $admissionRequirements = AdmissionRequirement::where('is_active', true)
            ->orderBy('order_position')
            ->get();
        
        $graduationRequirements = GraduationRequirement::where('is_active', true)
            ->orderBy('order_position')
            ->get();

        $totalCourses = ProgramRequirement::sum('number_of_courses');
        $totalCreditHours = ProgramRequirement::sum('credit_hours');
        $totalEcts = ProgramRequirement::sum('ects');

        return view('programs', compact(
            'undergraduatePrograms',
            'postgraduatePrograms',
            'requirements',
            'admissionRequirements',
            'graduationRequirements',
            'totalCourses',
            'totalCreditHours',
            'totalEcts'
        ));
    }
}