@extends('layouts.app')

@section('title', 'Academic Programs')

@section('content')
<div class="container">
    <!-- Page Header with Professional Styling -->
    <div style="text-align: center; margin-bottom: 4rem;">
        <h1 style="font-size: 3.5rem; color: #0a2342; margin-bottom: 1rem; font-weight: 600;">We are striving to our academic program international Excellence</h1>
        <div style="width: 150px; height: 4px; background: linear-gradient(90deg, #0a2342, #FFD700, #0a2342); margin: 20px auto; border-radius: 2px;"></div>
        <div style="font-size: 1.2rem; color: #4a5568; max-width: 800px; margin: 0 auto; text-align: center;">
            <ul style="list-style: none; padding: 0; display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap;">
                <li style="display: flex; align-items: center;"><i class="fas fa-check-circle" style="color: #FFD700; margin-right: 0.5rem;"></i> Striving for Internationally Accredite Programs</li>
                <li style="display: flex; align-items: center;"><i class="fas fa-check-circle" style="color: #FFD700; margin-right: 0.5rem;"></i> Excellence in Computing Education</li>
                <li style="display: flex; align-items: center;"><i class="fas fa-check-circle" style="color: #FFD700; margin-right: 0.5rem;"></i> Industry-Ready Graduates</li>
            </ul>
        </div>
    </div>

    <!-- Undergraduate Programs -->
    <section style="margin-bottom: 5rem;">
        <h2 style="font-size: 2.5rem; margin-bottom: 2.5rem; color: #0a2342; position: relative; display: inline-block;">
            Our Undergraduate Programs (B.Sc.)
            <span style="display: block; width: 60px; height: 3px; background: #FFD700; margin-top: 10px;"></span>
        </h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2.5rem;">
            <!-- Computer Science -->
            <div class="program-card" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 15px 30px rgba(10,35,66,0.1); transition: all 0.3s ease;">
                <div style="background: linear-gradient(135deg, #0a2342 0%, #1c3a5f 100%); padding: 2.5rem 2rem; text-align: center; color: white;">
                    <i class="fas fa-laptop-code" style="font-size: 3.5rem; margin-bottom: 1rem; color: #FFD700;"></i>
                    <h3 style="font-size: 1.8rem; font-weight: 600;">B.Sc. in Computer Science</h3>
                </div>
                <div style="padding: 2.5rem;">
                    <p style="color: #4a5568; margin-bottom: 2rem; line-height: 1.8;">A comprehensive program covering core computing principles, algorithms, software engineering, and theoretical foundations. Graduates are prepared for diverse roles in technology and research.</p>
                    
                    <h4 style="color: #0a2342; margin-bottom: 1rem; font-size: 1.2rem;">Career Opportunities:</h4>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.5rem;">
                        <span style="color: #4a5568;">✓ Software Developer</span>
                        <span style="color: #4a5568;">✓ Systems Analyst</span>
                        <span style="color: #4a5568;">✓ Database Administrator</span>
                        <span style="color: #4a5568;">✓ Research Scientist</span>
                        <span style="color: #4a5568;">✓ AI/ML Engineer</span>
                        <span style="color: #4a5568;">✓ Cloud Architect</span>
                    </div>
                </div>
            </div>

            <!-- Duration of Study Card (Replacing Information Technology) -->
            <div class="program-card" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 15px 30px rgba(10,35,66,0.1); transition: all 0.3s ease;">
                <div style="background: linear-gradient(135deg, #1c3a5f 0%, #2a4f7a 100%); padding: 2.5rem 2rem; text-align: center; color: white;">
                    <i class="fas fa-clock" style="font-size: 3.5rem; margin-bottom: 1rem; color: #FFD700;"></i>
                    <h3 style="font-size: 1.8rem; font-weight: 600;">Program Duration</h3>
                </div>
                <div style="padding: 2.5rem;">
                    <div style="text-align: center; margin-bottom: 2rem;">
                        <span style="font-size: 4rem; font-weight: 700; color: #0a2342;">4</span>
                        <span style="font-size: 2rem; color: #4a5568;"> Years</span>
                    </div>
                    
                    <div style="background: #f8fafc; padding: 1.5rem; border-radius: 10px; margin-bottom: 1.5rem;">
                        <p style="margin-bottom: 0.8rem;"><strong style="color: #0a2342;">Total Credit Hours:</strong> 150+ ECTS</p>
                        <p style="margin-bottom: 0.8rem;"><strong style="color: #0a2342;">Semesters:</strong> 8</p>
                        <p style="margin-bottom: 0.8rem;"><strong style="color: #0a2342;">Study Mode:</strong> Full-time, Regular</p>
                        <p><strong style="color: #0a2342;">Teaching Method:</strong> Face-to-Face, Semester-based</p>
                    </div>
                    
                    <h4 style="color: #0a2342; margin-bottom: 1rem; font-size: 1.2rem;">Program Structure:</h4>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.5rem;">
                        <span style="color: #4a5568;">✓ Year 1: Fundamentals</span>
                        <span style="color: #4a5568;">✓ Year 2: Core Concepts</span>
                        <span style="color: #4a5568;">✓ Year 3: Advanced Topics</span>
                        <span style="color: #4a5568;">✓ Year 4: Specialization</span>
                        <span style="color: #4a5568;">✓ Internship Program</span>
                        <span style="color: #4a5568;">✓ Capstone Project</span>
                    </div>
                </div>
            </div>

            <!-- Career Opportunities Card (Replacing Software Engineering) -->
            <div class="program-card" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 15px 30px rgba(10,35,66,0.1); transition: all 0.3s ease;">
                <div style="background: linear-gradient(135deg, #2a5f8a 0%, #3a6fa0 100%); padding: 2.5rem 2rem; text-align: center; color: white;">
                    <i class="fas fa-briefcase" style="font-size: 3.5rem; margin-bottom: 1rem; color: #FFD700;"></i>
                    <h3 style="font-size: 1.8rem; font-weight: 600;">Career Opportunities</h3>
                </div>
                <div style="padding: 2.5rem;">
                    <p style="color: #4a5568; margin-bottom: 2rem; line-height: 1.8; text-align: center;">Graduates of our Computer Science program are prepared for diverse and rewarding careers in technology and research.</p>
                    
                    <h4 style="color: #0a2342; margin-bottom: 1rem; font-size: 1.2rem;">Top Career Paths:</h4>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.8rem;">
                        <span style="color: #4a5568;">✓ Software Developer</span>
                        <span style="color: #4a5568;">✓ Systems Architect</span>
                        <span style="color: #4a5568;">✓ Data Scientist</span>
                        <span style="color: #4a5568;">✓ AI/ML Engineer</span>
                        <span style="color: #4a5568;">✓ Cloud Architect</span>
                        <span style="color: #4a5568;">✓ Cybersecurity Analyst</span>
                        <span style="color: #4a5568;">✓ IT Consultant</span>
                        <span style="color: #4a5568;">✓ Research Scientist</span>
                        <span style="color: #4a5568;">✓ Database Administrator</span>
                        <span style="color: #4a5568;">✓ Project Manager</span>
                    </div>
                    
                    <div style="margin-top: 2rem; padding: 1rem; background: #e6f0fa; border-radius: 8px;">
                        <p style="color: #0a2342; text-align: center; font-weight: 500;">Top Employers: Software Company, government organizations, Telecom companies, banks, IT companies, and international organizations, Commercial Bank of Ethiopia, International Software Companies</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pathways for Further Study in Computer Science-->
    <section style="margin-bottom: 5rem;">
        <h2 style="font-size: 2.5rem; margin-bottom: 2.5rem; color: #0a2342; position: relative; display: inline-block;">
            Pathways for Further Study in Computer Science
            <span style="display: block; width: 60px; height: 3px; background: #FFD700; margin-top: 10px;"></span>
        </h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2.5rem;">
            <!-- M.Sc. Computer Science -->
            <div class="program-card" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 15px 30px rgba(10,35,66,0.1); transition: all 0.3s ease;">
                <div style="background: linear-gradient(135deg, #0f2c44 0%, #1e3a5a 100%); padding: 2.5rem 2rem; text-align: center; color: white;">
                    <i class="fas fa-graduation-cap" style="font-size: 3.5rem; margin-bottom: 1rem; color: #FFD700;"></i>
                    <h3 style="font-size: 1.8rem; font-weight: 600;">M.Sc. in Computer Science</h3>
                </div>
                <div style="padding: 2.5rem;">
                    <p style="color: #4a5568; margin-bottom: 2rem; line-height: 1.8;">Advanced degree focusing on research, theoretical foundations, and specialized areas of computing.</p>
                    
                    <div style="background: #f8fafc; padding: 1.5rem; border-radius: 10px; margin-bottom: 1.5rem;">
                        <p style="margin-bottom: 0.5rem;"><strong style="color: #0a2342;">Duration:</strong> 2 Years</p>
                        <p style="margin-bottom: 0.5rem;"><strong style="color: #0a2342;">Thesis Required:</strong> Yes</p>
                        <p><strong style="color: #0a2342;">Research Focus:</strong> Strong</p>
                    </div>
                    
                    <h4 style="color: #0a2342; margin-bottom: 1rem; font-size: 1.2rem;">Specializations:</h4>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.5rem;">
                        <span style="color: #4a5568;">✓ Artificial Intelligence</span>
                        <span style="color: #4a5568;">✓ Data Science</span>
                        <span style="color: #4a5568;">✓ Network Computing</span>
                        <span style="color: #4a5568;">✓ Software Engineering</span>
                    </div>
                </div>
            </div>

            <!-- M.Sc. Data Science -->
            <div class="program-card" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 15px 30px rgba(10,35,66,0.1); transition: all 0.3s ease;">
                <div style="background: linear-gradient(135deg, #2e7d32 0%, #3e8f41 100%); padding: 2.5rem 2rem; text-align: center; color: white;">
                    <i class="fas fa-chart-bar" style="font-size: 3.5rem; margin-bottom: 1rem; color: #FFD700;"></i>
                    <h3 style="font-size: 1.8rem; font-weight: 600;">M.Sc. in Data Science</h3>
                </div>
                <div style="padding: 2.5rem;">
                    <p style="color: #4a5568; margin-bottom: 2rem; line-height: 1.8;">Specialized program meeting the growing demand for data science experts across industries.</p>
                    
                    <div style="background: #f8fafc; padding: 1.5rem; border-radius: 10px; margin-bottom: 1.5rem;">
                        <p style="margin-bottom: 0.5rem;"><strong style="color: #0a2342;">Duration:</strong> 2 Years</p>
                        <p style="margin-bottom: 0.5rem;"><strong style="color: #0a2342;">Project Required:</strong> Yes</p>
                        <p><strong style="color: #0a2342;">Industry Partnership:</strong> Yes</p>
                    </div>
                    
                    <h4 style="color: #0a2342; margin-bottom: 1rem; font-size: 1.2rem;">Core Courses:</h4>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.5rem;">
                        <span style="color: #4a5568;">✓ Machine Learning</span>
                        <span style="color: #4a5568;">✓ Big Data Analytics</span>
                        <span style="color: #4a5568;">✓ Statistical Computing</span>
                        <span style="color: #4a5568;">✓ Data Visualization</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Requirements Section -->
    <section style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); padding: 4rem; border-radius: 20px; margin-bottom: 5rem;">
        <h2 style="font-size: 2.5rem; margin-bottom: 3rem; color: #0a2342; text-align: center; position: relative;">
            Program Requirements
            <span style="display: block; width: 100px; height: 4px; background: linear-gradient(90deg, #0a2342, #FFD700); margin: 15px auto 0; border-radius: 2px;"></span>
        </h2>
        
        <!-- Program Overview Grid -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-bottom: 3rem;">
            <div style="text-align: center; padding: 2rem; background: white; border-radius: 15px; box-shadow: 0 10px 25px rgba(10,35,66,0.08);">
                <i class="fas fa-clock" style="font-size: 2.5rem; color: #0a2342; margin-bottom: 1rem;"></i>
                <h3 style="color: #0a2342; margin-bottom: 0.5rem;">Duration of Study</h3>
                <p style="color: #4a5568; font-size: 1.2rem;">4 Years (Regular)</p>
                <p style="color: #666; font-size: 0.95rem;">Full-time, semester-based</p>
            </div>
            
            <div style="text-align: center; padding: 2rem; background: white; border-radius: 15px; box-shadow: 0 10px 25px rgba(10,35,66,0.08);">
                <i class="fas fa-chalkboard-teacher" style="font-size: 2.5rem; color: #0a2342; margin-bottom: 1rem;"></i>
                <h3 style="color: #0a2342; margin-bottom: 0.5rem;">Mode of Delivery</h3>
                <p style="color: #4a5568; font-size: 1.2rem;">Face-to-Face</p>
                <p style="color: #666; font-size: 0.95rem;">Semester-based instruction</p>
            </div>
            
            <div style="text-align: center; padding: 2rem; background: white; border-radius: 15px; box-shadow: 0 10px 25px rgba(10,35,66,0.08);">
                <i class="fas fa-users" style="font-size: 2.5rem; color: #0a2342; margin-bottom: 1rem;"></i>
                <h3 style="color: #0a2342; margin-bottom: 0.5rem;">Teaching Method</h3>
                <p style="color: #4a5568; font-size: 1.2rem;">Active Learning</p>
                <p style="color: #666; font-size: 0.95rem;">Assignments, labs, projects, tutorials</p>
            </div>
        </div>

        <!-- Admission Requirements -->
        <div style="background: white; padding: 2.5rem; border-radius: 15px; margin-bottom: 2.5rem; box-shadow: 0 10px 25px rgba(10,35,66,0.08);">
            <div style="display: flex; align-items: center; margin-bottom: 1.5rem;">
                <i class="fas fa-clipboard-check" style="font-size: 2rem; color: #0a2342; margin-right: 1rem;"></i>
                <h3 style="color: #0a2342; font-size: 1.8rem;">Admission Requirements</h3>
            </div>
            
            <div style="background: #f0f5fa; padding: 2rem; border-radius: 12px; margin-bottom: 2rem;">
                <h4 style="color: #0a2342; margin-bottom: 1rem;">Undergraduate Admission</h4>
                <p style="color: #4a5568; margin-bottom: 1.5rem; line-height: 1.8;">Placements to all regular undergraduate programs are processed through the Ministry of Science and Higher Education (MoSHE). The universities then conduct admission and enrollment to the program based on results of the Ethiopian Higher Education Entrance Certificate Examination (EHEECE).</p>
                <p style="color: #4a5568; line-height: 1.8;">For second year and above, and other applicants holding diploma (regular advanced), evening, distance (if any) and summer programs, admission will be provided if an applicant meets the minimum requirements set by each university.</p>
            </div>
            
        <!-- Graduation Requirements -->
        <div style="background: white; padding: 2.5rem; border-radius: 15px; box-shadow: 0 10px 25px rgba(10,35,66,0.08);">
            <div style="display: flex; align-items: center; margin-bottom: 2rem;">
                <i class="fas fa-graduation-cap" style="font-size: 2rem; color: #0a2342; margin-right: 1rem;"></i>
                <h3 style="color: #0a2342; font-size: 1.8rem;">Graduation Requirements</h3>
            </div>
            
            <p style="color: #0a2342; font-weight: 600; margin-bottom: 1.5rem;">Every candidate for B.Sc. degree in Computer Science must fulfill the following requirements for graduation:</p>
            
            <ul style="color: #4a5568; margin-bottom: 2rem;">
                <li style="margin-bottom: 0.8rem; display: flex; align-items: center;"><span style="color: #FFD700; margin-right: 0.5rem;">✓</span> Minimum cumulative Grade Point Average for graduation is <strong>2.00</strong></li>
                <li style="margin-bottom: 0.8rem; display: flex; align-items: center;"><span style="color: #FFD700; margin-right: 0.5rem;">✓</span> Completion of all compulsory, elective, supportive and common courses</li>
                <li style="margin-bottom: 0.8rem; display: flex; align-items: center;"><span style="color: #FFD700; margin-right: 0.5rem;">✓</span> Successful completion of capstone project</li>
            </ul>

            <!-- Course Requirements Table -->
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                    <thead>
                        <tr style="background: #0a2342; color: white;">
                            <th style="padding: 1.2rem; text-align: left;">Course Category</th>
                            <th style="padding: 1.2rem; text-align: center;">Number of Courses</th>
                            <th style="padding: 1.2rem; text-align: center;">Credit Hours</th>
                            <th style="padding: 1.2rem; text-align: center;">ECTS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 1.2rem; font-weight: 500;">Compulsory Courses</td>
                            <td style="padding: 1.2rem; text-align: center;">27</td>
                            <td style="padding: 1.2rem; text-align: center;">95</td>
                            <td style="padding: 1.2rem; text-align: center;">150</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
                            <td style="padding: 1.2rem; font-weight: 500;">Elective Courses</td>
                            <td style="padding: 1.2rem; text-align: center;">7</td>
                            <td style="padding: 1.2rem; text-align: center;">18</td>
                            <td style="padding: 1.2rem; text-align: center;">30</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 1.2rem; font-weight: 500;">Supportive Courses</td>
                            <td style="padding: 1.2rem; text-align: center;">8</td>
                            <td style="padding: 1.2rem; text-align: center;">24</td>
                            <td style="padding: 1.2rem; text-align: center;">40</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
                            <td style="padding: 1.2rem; font-weight: 500;">Common Courses</td>
                            <td style="padding: 1.2rem; text-align: center;">12</td>
                            <td style="padding: 1.2rem; text-align: center;">36</td>
                            <td style="padding: 1.2rem; text-align: center;">60</td>
                        </tr>
                        <tr style="background: #e6f0fa;">
                            <td style="padding: 1.2rem; font-weight: 700; color: #0a2342;">Total</td>
                            <td style="padding: 1.2rem; text-align: center; font-weight: 700; color: #0a2342;">54</td>
                            <td style="padding: 1.2rem; text-align: center; font-weight: 700; color: #0a2342;">173</td>
                            <td style="padding: 1.2rem; text-align: center; font-weight: 700; color: #0a2342;">280</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <p style="color: #4a5568; margin-top: 1.5rem; font-style: italic;">* Students must complete all requirements within the maximum allowed study period</p>
        </div>
    </section>

    <!-- Accreditation Badges -->
    <section style="text-align: center; margin-bottom: 3rem;">
        <div style="display: flex; justify-content: center; gap: 3rem; flex-wrap: wrap;">
            <div style="background: white; padding: 1rem 2rem; border-radius: 50px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); display: flex; align-items: center;">
                <i class="fas fa-check-circle" style="color: #0a2342; font-size: 1.5rem; margin-right: 0.5rem;"></i>
                <span style="color: #0a2342; font-weight: 500;">Applied for national Accreditation</span>
            </div>
            <div style="background: white; padding: 1rem 2rem; border-radius: 50px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); display: flex; align-items: center;">
                <i class="fas fa-trophy" style="color: #FFD700; font-size: 1.5rem; margin-right: 0.5rem;"></i>
                <span style="color: #0a2342; font-weight: 500;">Ministry of Education Liscenced</span>
            </div>
            <div style="background: white; padding: 1rem 2rem; border-radius: 50px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); display: flex; align-items: center;">
                <i class="fas fa-globe" style="color: #1c3a5f; font-size: 1.5rem; margin-right: 0.5rem;"></i>
                <span style="color: #0a2342; font-weight: 500;">We are striving for global recognition</span>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    /* Card hover effects */
    .program-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(10,35,66,0.2) !important;
    }
    
    /* Table styles */
    table {
        border: 1px solid #e2e8f0;
    }
    
    th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
    }
    
    td {
        color: #4a5568;
    }
    
    /* Responsive design */
    @media (max-width: 768px) {
        [style*="grid-template-columns: repeat(3, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
        
        h1 {
            font-size: 2.5rem !important;
        }
        
        h2 {
            font-size: 2rem !important;
        }
        
        section[style*="padding: 4rem"] {
            padding: 2rem !important;
        }
        
        table {
            font-size: 0.9rem;
        }
        
        th, td {
            padding: 0.8rem !important;
        }
    }
    
    @media (max-width: 480px) {
        table {
            font-size: 0.8rem;
        }
        
        th, td {
            padding: 0.5rem !important;
        }
        
        [style*="grid-template-columns: repeat(2, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endpush