@extends('layouts.app')

@section('title', 'Our Students - Department of Computer Science')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Our Students</h1>
        <p>Meet the brilliant minds of the Computer Science Department</p>
    </div>
</div>

<div class="container">
    <!-- Hero Section - Student Life Overview (Public Friendly) -->
    <section style="margin-bottom: 4rem; text-align: center;">
        <div style="max-width: 800px; margin: 0 auto;">
            <h2 style="color: #0a2342; font-size: 2.5rem; margin-bottom: 1rem;">Students at CS Department</h2>
            <div style="width: 100px; height: 4px; background: linear-gradient(90deg, #0a2342, #FFD700); margin: 0 auto 2rem; border-radius: 2px;"></div>
            <p style="color: #4a5568; font-size: 1.2rem; line-height: 1.8;">Our students are at the heart of everything we do. They are innovators, creators, and future leaders in technology. Discover the vibrant community of learners shaping the future of computer science.</p>
        </div>
    </section>

    <!-- Student Achievements (Public Friendly) -->
    <section style="margin-bottom: 4rem;">
        <h2 style="color: #0a2342; margin-bottom: 2rem; text-align: center; font-size: 2.2rem;">Student Achievements</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div style="background: white; padding: 2.5rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(10,35,66,0.1); text-align: center; transition: transform 0.3s ease;">
                <div style="background: linear-gradient(135deg, #0a2342 0%, #1c3a5f 100%); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                    <i class="fas fa-medal" style="font-size: 2.5rem; color: #FFD700;"></i>
                </div>
                <h3 style="color: #0a2342; margin-bottom: 1rem; font-size: 1.5rem;">Excellence in Education</h3>
                <p style="color: #4a5568; line-height: 1.8;">Mekdela Amba University Computer Science students consistently demonstrate outstanding performance. Our students achieve 100% pass rate in national examinations for four consecutive years, reflecting the quality of our academic programs.</p>
            </div>
            
            <div style="background: white; padding: 2.5rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(10,35,66,0.1); text-align: center; transition: transform 0.3s ease;">
                <div style="background: linear-gradient(135deg, #1c3a5f 0%, #2a4f7a 100%); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                    <i class="fas fa-flask" style="font-size: 2.5rem; color: #FFD700;"></i>
                </div>
                <h3 style="color: #0a2342; margin-bottom: 1rem; font-size: 1.5rem;">Innovative Projects</h3>
                <p style="color: #4a5568; line-height: 1.8;">Undergraduate students showcase their creativity through innovative graduation projects. Recent cohorts successfully presented outstanding projects addressing real-world challenges.</p>
            </div>
            
            <div style="background: white; padding: 2.5rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(10,35,66,0.1); text-align: center; transition: transform 0.3s ease;">
                <div style="background: linear-gradient(135deg, #2a5f8a 0%, #3a6fa0 100%); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                    <i class="fas fa-briefcase" style="font-size: 2.5rem; color: #FFD700;"></i>
                </div>
                <h3 style="color: #0a2342; margin-bottom: 1rem; font-size: 1.5rem;">Industry Readiness</h3>
                <p style="color: #4a5568; line-height: 1.8;">Our students gain practical experience through internships and industry collaborations. Many secure positions at leading tech companies, contributing to Ethiopia's growing digital economy.</p>
            </div>
        </div>
    </section>

    <!-- Student Testimonials (Public Friendly) -->
    <section style="margin-bottom: 4rem; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); padding: 4rem; border-radius: 20px;">
        <h2 style="color: #0a2342; margin-bottom: 3rem; text-align: center; font-size: 2.2rem;">What Our Students Say</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 25px rgba(10,35,66,0.08);">
                <i class="fas fa-quote-left" style="font-size: 2rem; color: #FFD700; margin-bottom: 1rem;"></i>
                <p style="color: #4a5568; margin-bottom: 1.5rem; line-height: 1.8;">The CS department at Mekdela University provided me with the skills and knowledge I needed to succeed in my career. The faculty are supportive and the curriculum is industry-relevant.</p>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #0a2342, #1c3a5f); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.2rem;">A</div>
                    <div>
                        <strong style="color: #0a2342; font-size: 1.1rem;">Abebu Wubete</strong>
                        <p style="color: #666; font-size: 0.9rem;">Final Year Student</p>
                    </div>
                </div>
            </div>
            
            <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 25px rgba(10,35,66,0.08);">
                <i class="fas fa-quote-left" style="font-size: 2rem; color: #FFD700; margin-bottom: 1rem;"></i>
                <p style="color: #4a5568; margin-bottom: 1.5rem; line-height: 1.8;">The hands-on projects and modern labs gave me practical experience that helped me secure an internship. I'm grateful for the opportunities provided by the department.</p>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #1c3a5f, #2a4f7a); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.2rem;">B</div>
                    <div>
                        <strong style="color: #0a2342; font-size: 1.1rem;">Tsegaye Aderajew</strong>
                        <p style="color: #666; font-size: 0.9rem;">Year 3 Student</p>
                    </div>
                </div>
            </div>
            
            <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 25px rgba(10,35,66,0.08);">
                <i class="fas fa-quote-left" style="font-size: 2rem; color: #FFD700; margin-bottom: 1rem;"></i>
                <p style="color: #4a5568; margin-bottom: 1.5rem; line-height: 1.8;">Participating in coding competitions and workshops helped me improve my skills. The department creates an environment where students can grow and innovate.</p>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #2a5f8a, #3a6fa0); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.2rem;">C</div>
                    <div>
                        <strong style="color: #0a2342; font-size: 1.1rem;">Abibo Eshetie</strong>
                        <p style="color: #666; font-size: 0.9rem;">Year 4 Student</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Student Clubs and Activities (Public Friendly) -->
    <section style="margin-bottom: 4rem;">
        <h2 style="color: #0a2342; margin-bottom: 2rem; text-align: center; font-size: 2.2rem;">Student Clubs & Activities</h2>
        <p style="text-align: center; color: #4a5568; max-width: 800px; margin: 0 auto 3rem;">Our students lead and participate in various clubs that foster learning, collaboration, and innovation outside the classroom.</p>
        
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem;">
            <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 25px rgba(10,35,66,0.08); text-align: center; transition: transform 0.3s ease;">
                <div style="background: #0a2342; width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <i class="fas fa-code" style="font-size: 2rem; color: #FFD700;"></i>
                </div>
                <h3 style="color: #0a2342; margin-bottom: 0.5rem;">Coding Club</h3>
                <p style="color: #666; font-size: 0.95rem;">Weekly coding sessions and hackathons</p>
            </div>
            
            <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 25px rgba(10,35,66,0.08); text-align: center; transition: transform 0.3s ease;">
                <div style="background: #0a2342; width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <i class="fas fa-robot" style="font-size: 2rem; color: #FFD700;"></i>
                </div>
                <h3 style="color: #0a2342; margin-bottom: 0.5rem;">Robotics Club</h3>
                <p style="color: #666; font-size: 0.95rem;">Building and programming robots</p>
            </div>
            
            <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 25px rgba(10,35,66,0.08); text-align: center; transition: transform 0.3s ease;">
                <div style="background: #0a2342; width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <i class="fas fa-shield-alt" style="font-size: 2rem; color: #FFD700;"></i>
                </div>
                <h3 style="color: #0a2342; margin-bottom: 0.5rem;">Cyber Security Club</h3>
                <p style="color: #666; font-size: 0.95rem;">CTF competitions and security workshops</p>
            </div>
            
            <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 25px rgba(10,35,66,0.08); text-align: center; transition: transform 0.3s ease;">
                <div style="background: #0a2342; width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <i class="fas fa-gamepad" style="font-size: 2rem; color: #FFD700;"></i>
                </div>
                <h3 style="color: #0a2342; margin-bottom: 0.5rem;">Game Dev Club</h3>
                <p style="color: #666; font-size: 0.95rem;">Game design and development</p>
            </div>
        </div>
    </section>

    <!-- ========== SEARCH AND FILTER SECTION ========== -->
    <section style="margin-bottom: 3rem;">
        <div style="background: #f8f9fa; padding: 2rem; border-radius: 15px;">
            <form method="GET" action="{{ route('students') }}" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end;">
                <div style="flex: 2; min-width: 200px;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #0a2342; font-weight: 500;">Search by Name or ID</label>
                    <input type="text" name="search" class="form-control" placeholder="Enter student name or ID..." 
                           value="{{ request('search') }}" 
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>
                
                <div style="flex: 1; min-width: 150px;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #0a2342; font-weight: 500;">Filter by Batch</label>
                    <select name="batch" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                        <option value="">All Batches</option>
                        @foreach($batches as $batchOption)
                            <option value="{{ $batchOption }}" {{ request('batch') == $batchOption ? 'selected' : '' }}>
                                {{ $batchOption }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div style="flex: 0 0 auto;">
                    <button type="submit" style="background: #0a2342; color: white; padding: 0.75rem 2rem; border: none; border-radius: 8px; cursor: pointer; font-weight: 500;">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <a href="{{ route('students') }}" style="display: inline-block; background: #6c757d; color: white; padding: 0.75rem 2rem; border-radius: 8px; text-decoration: none; margin-left: 0.5rem;">
                        <i class="fas fa-sync-alt"></i> Reset
                    </a>
                </div>
            </form>
            
            <!-- Search Results Info -->
            @if(request('search') || request('batch'))
                <div style="margin-top: 1rem; padding: 0.75rem; background: #e9ecef; border-radius: 8px;">
                    <i class="fas fa-info-circle"></i> 
                    Showing results for:
                    @if(request('search')) <strong>"{{ request('search') }}"</strong> @endif
                    @if(request('batch')) <strong>Batch {{ request('batch') }}</strong> @endif
                    <a href="{{ route('students') }}" style="margin-left: 1rem; color: #0a2342;">Clear filters</a>
                </div>
            @endif
        </div>
    </section>

    <!-- ========== STUDENT DIRECTORY WITH SEARCH RESULTS ========== -->
    <section style="margin-bottom: 4rem;">
        <h2 style="color: #0a2342; margin-bottom: 2rem; text-align: center; font-size: 2.2rem;">Student Directory</h2>
        <p style="text-align: center; color: #4a5568; max-width: 800px; margin: 0 auto 3rem;">
            @if($allStudents->total() > 0)
                Showing {{ $allStudents->firstItem() }} to {{ $allStudents->lastItem() }} of {{ $allStudents->total() }} students
            @else
                No students found
            @endif
        </p>
        
        @if($allStudents->count() > 0)
        <!-- Card Grid View -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
            @foreach($allStudents as $student)
            <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 25px rgba(10,35,66,0.1); transition: transform 0.3s ease;">
                <!-- Student Card Header -->
                <div style="background: linear-gradient(135deg, #0a2342 0%, #1c3a5f 100%); padding: 2rem 1.5rem; text-align: center;">
                    <!-- Profile Image or Initials -->
                    @if($student->profile_image)
                        <img src="{{ asset($student->profile_image) }}" 
                             alt="{{ $student->name }}" 
                             style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 4px solid #FFD700; margin-bottom: 1rem;">
                    @else
                        <div style="width: 100px; height: 100px; border-radius: 50%; background: #FFD700; color: #0a2342; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; border: 4px solid white; font-size: 2.5rem; font-weight: bold;">
                            {{ substr($student->name, 0, 1) }}
                        </div>
                    @endif
                    
                    <!-- Student Name - PUBLIC -->
                    <h3 style="color: white; margin-bottom: 0.5rem; font-size: 1.3rem;">{{ $student->name }}</h3>
                    
                    <!-- Year Badge - PUBLIC -->
                    <span style="background: rgba(255,255,255,0.2); color: white; padding: 0.3rem 1rem; border-radius: 50px; font-size: 0.9rem; display: inline-block;">
                        <i class="fas fa-graduation-cap" style="margin-right: 0.3rem;"></i> Year {{ $student->year }}
                    </span>
                </div>
                
                <!-- Student Card Body -->
                <div style="padding: 1.5rem;">
                    <!-- Section - PUBLIC -->
                    @if($student->section)
                    <div style="margin-bottom: 0.8rem; display: flex; align-items: center; gap: 0.5rem; color: #4a5568;">
                        <i class="fas fa-users" style="color: #FFD700; width: 20px;"></i>
                        <span>Section {{ $student->section }}</span>
                    </div>
                    @endif
                    
                    <!-- Batch - PUBLIC -->
                    @if($student->batch)
                    <div style="margin-bottom: 0.8rem; display: flex; align-items: center; gap: 0.5rem; color: #4a5568;">
                        <i class="fas fa-calendar-alt" style="color: #FFD700; width: 20px;"></i>
                        <span>Batch {{ $student->batch }}</span>
                    </div>
                    @endif
                    
                    <!-- Divider -->
                    <div style="height: 1px; background: linear-gradient(90deg, transparent, #e2e8f0, transparent); margin: 1rem 0;"></div>
                    
                    <!-- View Profile Link -->
                    @if(isset($student->bio) || isset($student->achievements))
                    <a href="{{ route('students.show', $student->id) }}" style="color: #0a2342; text-decoration: none; font-weight: 500; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                        View Profile <i class="fas fa-arrow-right" style="font-size: 0.9rem;"></i>
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($allStudents->hasPages())
        <div style="margin-top: 2rem; display: flex; justify-content: center;">
            <style>
                .pagination {
                    display: flex;
                    gap: 0.5rem;
                    list-style: none;
                    flex-wrap: wrap;
                    justify-content: center;
                }
                
                .pagination li a,
                .pagination li span {
                    display: block;
                    padding: 0.5rem 1rem;
                    background: white;
                    border: 1px solid #dee2e6;
                    border-radius: 5px;
                    color: #0a2342;
                    text-decoration: none;
                    transition: all 0.3s;
                }
                
                .pagination li.active span {
                    background: #0a2342;
                    color: white;
                    border-color: #0a2342;
                }
                
                .pagination li a:hover {
                    background: #f8f9fa;
                    border-color: #0a2342;
                }
            </style>
            {{ $allStudents->appends(request()->query())->links() }}
        </div>
        @endif
        
        @else
        <div style="text-align: center; padding: 4rem; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(10,35,66,0.1);">
            <i class="fas fa-user-graduate" style="font-size: 4rem; color: #cbd5e0; margin-bottom: 1rem;"></i>
            <p style="color: #4a5568; font-size: 1.2rem;">No students found matching your criteria.</p>
            <a href="{{ route('students') }}" style="display: inline-block; margin-top: 1rem; padding: 0.75rem 1.5rem; background: #0a2342; color: white; border-radius: 8px; text-decoration: none;">View All Students</a>
        </div>
        @endif
    </section>

    <!-- Call to Action for Prospective Students -->
    <section style="background: linear-gradient(135deg, #0a2342 0%, #1c3a5f 100%); padding: 4rem; border-radius: 20px; margin-bottom: 3rem; text-align: center; color: white;">
        <h2 style="font-size: 2.2rem; margin-bottom: 1rem;">Join Our Community</h2>
        <p style="font-size: 1.2rem; max-width: 700px; margin: 0 auto 2rem; opacity: 0.95;">Become part of a vibrant community of learners and innovators. Explore our programs and start your journey in computer science.</p>
        <div>
            <a href="{{ route('programs') }}" style="display: inline-block; padding: 15px 40px; background: #FFD700; color: #0a2342; text-decoration: none; border-radius: 50px; font-weight: 600; margin-right: 15px;">Explore Programs</a>
            <a href="{{ route('contact') }}" style="display: inline-block; padding: 15px 40px; background: transparent; color: white; text-decoration: none; border-radius: 50px; font-weight: 600; border: 2px solid rgba(255,255,255,0.5);">Contact Admissions</a>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    /* Hover effects for cards */
    [style*="box-shadow"]:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease;
    }
    
    /* Student card hover effect */
    [style*="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr))"] > div:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(10,35,66,0.15) !important;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        h1 {
            font-size: 2.5rem !important;
        }
        
        h2 {
            font-size: 1.8rem !important;
        }
        
        section[style*="padding: 4rem"] {
            padding: 2rem !important;
        }
        
        form[style*="display: flex"] {
            flex-direction: column !important;
        }
        
        form[style*="display: flex"] button,
        form[style*="display: flex"] a {
            width: 100% !important;
            margin: 0.5rem 0 !important;
            text-align: center;
        }
    }
    
    @media (max-width: 480px) {
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
        
        [style*="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr))"] {
            grid-template-columns: 1fr !important;
        }
        
        h1 {
            font-size: 2rem !important;
        }
        
        [style*="padding: 4rem"] {
            padding: 1.5rem !important;
        }
        
        a[style*="padding: 15px 40px"] {
            display: block !important;
            margin: 10px auto !important;
            width: 80% !important;
        }
    }
</style>
@endpush