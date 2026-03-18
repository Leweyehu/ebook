@extends('layouts.app')

@section('title', 'Our Students')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Our Students</h1>
        <p>Meet the brilliant minds of the Computer Science Department</p>
    </div>
</div>

<div class="container">
    <!-- Student Statistics -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-bottom: 3rem;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem; border-radius: 10px; text-align: center;">
            <i class="fas fa-user-graduate" style="font-size: 3rem; margin-bottom: 1rem;"></i>
            <h3 style="font-size: 2.5rem;">{{ \App\Models\Student::count() }}</h3>
            <p>Total Students</p>
        </div>
        
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 2rem; border-radius: 10px; text-align: center;">
            <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 1rem;"></i>
            <h3 style="font-size: 2.5rem;">{{ \App\Models\Student::where('year', 1)->count() }}</h3>
            <p>Year 1 Students</p>
        </div>
        
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 2rem; border-radius: 10px; text-align: center;">
            <i class="fas fa-trophy" style="font-size: 3rem; margin-bottom: 1rem;"></i>
            <h3 style="font-size: 2.5rem;">{{ \App\Models\Student::where('year', 4)->count() }}</h3>
            <p>Year 4 Students</p>
        </div>
    </div>

    <!-- Student Achievements -->
    <section style="margin-bottom: 4rem;">
        <h2 style="color: #1a2b3c; margin-bottom: 2rem; text-align: center;">Student Achievements</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
                <i class="fas fa-medal" style="font-size: 2.5rem; color: #ffc107; margin-bottom: 1rem;"></i>
                <h3>National Programming Contest</h3>
                <p style="color: #666;">Our students won 1st place in the 2026 Ethiopian Collegiate Programming Contest.</p>
            </div>
            
            <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
                <i class="fas fa-flask" style="font-size: 2.5rem; color: #667eea; margin-bottom: 1rem;"></i>
                <h3>Research Publication</h3>
                <p style="color: #666;">Three undergraduate students published papers in international journals.</p>
            </div>
            
            <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
                <i class="fas fa-briefcase" style="font-size: 2.5rem; color: #28a745; margin-bottom: 1rem;"></i>
                <h3>Internship Placements</h3>
                <p style="color: #666;">85% of final year students secured internships at top tech companies.</p>
            </div>
        </div>
    </section>

    <!-- Student Testimonials -->
    <section style="margin-bottom: 4rem;">
        <h2 style="color: #1a2b3c; margin-bottom: 2rem; text-align: center;">What Our Students Say</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
                <i class="fas fa-quote-left" style="font-size: 2rem; color: #ffc107; margin-bottom: 1rem;"></i>
                <p style="color: #666; margin-bottom: 1rem;">The CS department at Mekedela Amba University provided me with the skills and knowledge I needed to succeed in my career.</p>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 50px; height: 50px; background: #667eea; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">A</div>
                    <div>
                        <strong>Abebe Kebede</strong>
                        <p style="color: #999; font-size: 0.9rem;">Year 4 Student</p>
                    </div>
                </div>
            </div>
            
            <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
                <i class="fas fa-quote-left" style="font-size: 2rem; color: #ffc107; margin-bottom: 1rem;"></i>
                <p style="color: #666; margin-bottom: 1rem;">The hands-on projects and experienced faculty made learning enjoyable and practical.</p>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 50px; height: 50px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">B</div>
                    <div>
                        <strong>Birtukan Ayele</strong>
                        <p style="color: #999; font-size: 0.9rem;">Year 3 Student</p>
                    </div>
                </div>
            </div>
            
            <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
                <i class="fas fa-quote-left" style="font-size: 2rem; color: #ffc107; margin-bottom: 1rem;"></i>
                <p style="color: #666; margin-bottom: 1rem;">I've had opportunities to work on research projects and attend international conferences.</p>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 50px; height: 50px; background: #dc3545; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">C</div>
                    <div>
                        <strong>Chala Desta</strong>
                        <p style="color: #999; font-size: 0.9rem;">Year 4 Student</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Student Clubs and Activities -->
    <section style="margin-bottom: 4rem;">
        <h2 style="color: #1a2b3c; margin-bottom: 2rem;">Student Clubs & Activities</h2>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem;">
            <div style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); text-align: center;">
                <i class="fas fa-code" style="font-size: 2rem; color: #667eea; margin-bottom: 0.5rem;"></i>
                <h3>Coding Club</h3>
            </div>
            <div style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); text-align: center;">
                <i class="fas fa-robot" style="font-size: 2rem; color: #28a745; margin-bottom: 0.5rem;"></i>
                <h3>Robotics Club</h3>
            </div>
            <div style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); text-align: center;">
                <i class="fas fa-shield-alt" style="font-size: 2rem; color: #ffc107; margin-bottom: 0.5rem;"></i>
                <h3>Cyber Security Club</h3>
            </div>
            <div style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); text-align: center;">
                <i class="fas fa-gamepad" style="font-size: 2rem; color: #17a2b8; margin-bottom: 0.5rem;"></i>
                <h3>Game Dev Club</h3>
            </div>
        </div>
    </section>
</div>
@endsection