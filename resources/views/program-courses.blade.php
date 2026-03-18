@extends('layouts.app')

@section('title', 'Computer Science Courses')

@push('styles')
<style>
    .course-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid rgba(255,193,7,0.1);
    }
    
    .course-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(255,193,7,0.15);
        border-color: #ffc107;
    }
    
    .year-title {
        font-size: 2rem;
        color: #1a2b3c;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid #ffc107;
        position: relative;
        text-align: center;
    }
    
    .year-title::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 3px;
        background: #ffc107;
    }
    
    .semester-title {
        font-size: 1.3rem;
        color: #ffc107;
        margin-bottom: 1.5rem;
        text-align: center;
        font-weight: 600;
    }
    
    .course-list {
        list-style: none;
        padding: 0;
    }
    
    .course-item {
        margin-bottom: 1rem;
        padding: 0.8rem;
        background: #f8f9fa;
        border-radius: 8px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }
    
    .course-item:hover {
        background: #fff3cd;
        transform: translateX(5px);
    }
    
    .course-item i {
        color: #ffc107;
        margin-right: 15px;
        width: 25px;
        font-size: 1.1rem;
        text-align: center;
    }
    
    .course-code {
        font-weight: 600;
        color: #1a2b3c;
        margin-right: 10px;
        min-width: 90px;
    }
    
    .course-name {
        color: #495057;
        flex: 1;
    }
    
    .course-credits {
        background: #ffc107;
        color: #1a2b3c;
        padding: 0.2rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        white-space: nowrap;
        margin-left: 10px;
    }
    
    .elective-item {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        font-weight: 500;
    }
    
    .elective-item:hover {
        background: #ffc107;
        color: #1a2b3c;
        transform: scale(1.05);
        border-color: #1a2b3c;
    }
    
    .program-header {
        text-align: center;
        margin-bottom: 3rem;
        padding: 2rem;
        background: linear-gradient(135deg, #1a2b3c 0%, #2c3e50 100%);
        border-radius: 15px;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .program-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,193,7,0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }
    
    .program-header h2 {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        color: white;
        position: relative;
        z-index: 2;
    }
    
    .program-header p {
        font-size: 1.1rem;
        color: #ffc107;
        position: relative;
        z-index: 2;
    }
    
    .program-stats {
        display: flex;
        justify-content: center;
        gap: 3rem;
        margin-top: 2.5rem;
        position: relative;
        z-index: 2;
        flex-wrap: wrap;
    }
    
    .stat-item {
        text-align: center;
        min-width: 120px;
    }
    
    .stat-circle {
        width: 100px;
        height: 100px;
        margin: 0 auto 1rem;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .stat-circle svg {
        width: 100px;
        height: 100px;
        transform: rotate(-90deg);
    }
    
    .stat-circle circle {
        fill: none;
        stroke-width: 8;
        stroke-linecap: round;
    }
    
    .stat-circle .bg-circle {
        stroke: rgba(255,255,255,0.2);
    }
    
    .stat-circle .progress-circle {
        stroke: #ffc107;
        stroke-dasharray: 283;
        stroke-dashoffset: 283;
        transition: stroke-dashoffset 2s ease;
    }
    
    .stat-value {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 1.8rem;
        font-weight: 700;
        color: #ffc107;
    }
    
    .stat-label {
        font-size: 0.95rem;
        color: #ecf0f1;
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    
    .stat-unit {
        font-size: 1rem;
        color: #ffc107;
        margin-left: 2px;
    }
    
    .section-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .semester-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    
    .electives-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }
    
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @media (max-width: 768px) {
        .program-header h2 {
            font-size: 2rem;
        }
        
        .year-title {
            font-size: 1.5rem;
        }
        
        .semester-grid {
            grid-template-columns: 1fr;
        }
        
        .course-item {
            flex-wrap: wrap;
        }
        
        .course-credits {
            margin-top: 0.5rem;
            margin-left: 40px;
        }
        
        .program-stats {
            gap: 1.5rem;
        }
        
        .stat-circle {
            width: 80px;
            height: 80px;
        }
        
        .stat-circle svg {
            width: 80px;
            height: 80px;
        }
        
        .stat-value {
            font-size: 1.4rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <h1 data-aos="fade-up">Computer Science Courses</h1>
        <div class="breadcrumb" data-aos="fade-up" data-aos-delay="100">
            <a href="{{ route('home') }}">Home</a> 
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('programs') }}">Programs</a> 
            <i class="fas fa-chevron-right"></i>
            <span>CS Courses</span>
        </div>
    </div>
</div>

<!-- Main Content -->
<section style="padding: 4rem 0; background: #f8f9fa;">
    <div class="section-container">
        <!-- Program Header with Animated Stats -->
        <div class="program-header" data-aos="fade-up" id="program-stats-section">
            <h2>B.Sc. in Computer Science</h2>
            <p>Comprehensive program designed for future technology leaders provided by Mekdela Amba Computer Science department</p>
            
            <div class="program-stats">
                <!-- Total ECTS Stat -->
                <div class="stat-item">
                    <div class="stat-circle" id="ects-circle">
                        <svg viewBox="0 0 100 100">
                            <circle class="bg-circle" cx="50" cy="50" r="42"></circle>
                            <circle class="progress-circle" cx="50" cy="50" r="42" id="ects-progress"></circle>
                        </svg>
                        <span class="stat-value" id="ects-value">0</span>
                    </div>
                    <div class="stat-label">Total ECTS</div>
                </div>
                
                <!-- Duration Stat -->
                <div class="stat-item">
                    <div class="stat-circle" id="duration-circle">
                        <svg viewBox="0 0 100 100">
                            <circle class="bg-circle" cx="50" cy="50" r="42"></circle>
                            <circle class="progress-circle" cx="50" cy="50" r="42" id="duration-progress"></circle>
                        </svg>
                        <span class="stat-value" id="duration-value">0</span>
                    </div>
                    <div class="stat-label">Years</div>
                </div>
                
                <!-- Semesters Stat -->
                <div class="stat-item">
                    <div class="stat-circle" id="semesters-circle">
                        <svg viewBox="0 0 100 100">
                            <circle class="bg-circle" cx="50" cy="50" r="42"></circle>
                            <circle class="progress-circle" cx="50" cy="50" r="42" id="semesters-progress"></circle>
                        </svg>
                        <span class="stat-value" id="semesters-value">0</span>
                    </div>
                    <div class="stat-label">Semesters</div>
                </div>
                
                <!-- Courses Stat -->
                <div class="stat-item">
                    <div class="stat-circle" id="courses-circle">
                        <svg viewBox="0 0 100 100">
                            <circle class="bg-circle" cx="50" cy="50" r="42"></circle>
                            <circle class="progress-circle" cx="50" cy="50" r="42" id="courses-progress"></circle>
                        </svg>
                        <span class="stat-value" id="courses-value">0</span>
                    </div>
                    <div class="stat-label">Courses</div>
                </div>
            </div>
        </div>

        <!-- Year 1: Foundation -->
        <div style="margin-bottom: 4rem;" data-aos="fade-up">
            <h3 class="year-title">Year 1: Foundation</h3>
            <div class="semester-grid">
                <!-- Semester 1 -->
                <div class="course-card">
                    <h4 class="semester-title">Semester 1</h4>
                    <ul class="course-list">
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">Math1011</span>
                            <span class="course-name">Mathematics for Natural Science</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">FLEn1011</span>
                            <span class="course-name">Communicative English Language Skills I</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">Phys1011</span>
                            <span class="course-name">General Physics</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">Psch1011</span>
                            <span class="course-name">General Psychology</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">LoCT1011</span>
                            <span class="course-name">Critical Thinking</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">SpSc1011</span>
                            <span class="course-name">Physical Fitness</span>
                            <span class="course-credits">P/F | 2 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">GeES1011</span>
                            <span class="course-name">Geography of Ethiopia and the Horn</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                    </ul>
                    <div style="margin-top: 1rem; text-align: right; font-weight: bold; color: #1a2b3c;">
                        Sub Total: 30 ECTS | 18 Cr. Hrs.
                    </div>
                </div>
                
                <!-- Semester 2 -->
                <div class="course-card">
                    <h4 class="semester-title">Semester 2</h4>
                    <ul class="course-list">
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">FLEn1012</span>
                            <span class="course-name">Communicative English Language Skills II</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">Anth1012</span>
                            <span class="course-name">Social Anthropology</span>
                            <span class="course-credits">3 ECTS | 2 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">Math1041</span>
                            <span class="course-name">Applied Mathematics I</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">Econ-1011</span>
                            <span class="course-name">Economics</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">EmTe1012</span>
                            <span class="course-name">Introduction to Emerging Technologies</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">MCiE1012</span>
                            <span class="course-name">Moral and Civic Education</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">Chem1012</span>
                            <span class="course-name">General Chemistry</span>
                            <span class="course-credits">3 ECTS | 2 Cr. Hrs.</span>
                        </li>
                    </ul>
                    <div style="margin-top: 1rem; text-align: right; font-weight: bold; color: #1a2b3c;">
                        Sub Total: 31 ECTS | 19 Cr. Hrs.
                    </div>
                </div>
            </div>
        </div>

        <!-- Year 2: Core Concepts -->
        <div style="margin-bottom: 4rem;" data-aos="fade-up">
            <h3 class="year-title">Year 2: Core Concepts</h3>
            <div class="semester-grid">
                <!-- Semester 3 -->
                <div class="course-card">
                    <h4 class="semester-title">Semester 3</h4>
                    <ul class="course-list">
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">EENG2041</span>
                            <span class="course-name">Digital Logic Design</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc2051</span>
                            <span class="course-name">Object Oriented Programming</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">MATH2011</span>
                            <span class="course-name">Linear Algebra</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc2041</span>
                            <span class="course-name">Fundamentals of Database Systems</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc1012</span>
                            <span class="course-name">Computer Programming</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">STAT2015</span>
                            <span class="course-name">Probability and Statistics</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">SINE2011</span>
                            <span class="course-name">Inclusiveness</span>
                            <span class="course-credits">4 ECTS | 2 Cr. Hrs.</span>
                        </li>
                    </ul>
                    <div style="margin-top: 1rem; text-align: right; font-weight: bold; color: #1a2b3c;">
                        Sub Total: 34 ECTS | 20 Cr. Hrs.
                    </div>
                </div>
                
                <!-- Semester 4 -->
                <div class="course-card">
                    <h4 class="semester-title">Semester 4</h4>
                    <ul class="course-list">
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc2032</span>
                            <span class="course-name">Data Communication and Computer Networks</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc2042</span>
                            <span class="course-name">Advanced Database Systems</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">MATH2082</span>
                            <span class="course-name">Numerical Analysis</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">MATH2052</span>
                            <span class="course-name">Discrete Mathematics and Combinatorics</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc2092</span>
                            <span class="course-name">Data Structures and Algorithms</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc2022</span>
                            <span class="course-name">Computer Organization and Architecture</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                    </ul>
                    <div style="margin-top: 1rem; text-align: right; font-weight: bold; color: #1a2b3c;">
                        Sub Total: 30 ECTS | 18 Cr. Hrs.
                    </div>
                </div>
            </div>
        </div>

        <!-- Year 3: Advanced Topics -->
        <div style="margin-bottom: 4rem;" data-aos="fade-up">
            <h3 class="year-title">Year 3: Advanced Topics</h3>
            <div class="semester-grid">
                <!-- Semester 5 -->
                <div class="course-card">
                    <h4 class="semester-title">Semester 5</h4>
                    <ul class="course-list">
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc3023</span>
                            <span class="course-name">Operating Systems</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc3081</span>
                            <span class="course-name">Web Programming</span>
                            <span class="course-credits">7 ECTS | 4 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc3053</span>
                            <span class="course-name">Java Programming</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc3061</span>
                            <span class="course-name">Software Engineering</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc3101</span>
                            <span class="course-name">Automata and Complexity Theory</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc3025</span>
                            <span class="course-name">Microprocessor and Assembly Language Programming</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">IRGI3021</span>
                            <span class="course-name">Global Trends</span>
                            <span class="course-credits">4 ECTS | 2 Cr. Hrs.</span>
                        </li>
                    </ul>
                    <div style="margin-top: 1rem; text-align: right; font-weight: bold; color: #1a2b3c;">
                        Sub Total: 36 ECTS | 21 Cr. Hrs.
                    </div>
                </div>
                
                <!-- Semester 6 -->
                <div class="course-card">
                    <h4 class="semester-title">Semester 6</h4>
                    <ul class="course-list">
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc3034</span>
                            <span class="course-name">Wireless Communication and Mobile Computing</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc3112</span>
                            <span class="course-name">Introduction to Artificial Intelligence</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc3094</span>
                            <span class="course-name">Design and Analysis of Algorithms</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc3026</span>
                            <span class="course-name">Real Time and Embedded Systems</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc3072</span>
                            <span class="course-name">Computer Graphics</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc3122</span>
                            <span class="course-name">Industrial Practice</span>
                            <span class="course-credits">3 ECTS | 2 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">MGMT4102</span>
                            <span class="course-name">Entrepreneurship & Business Development</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                    </ul>
                    <div style="margin-top: 1rem; text-align: right; font-weight: bold; color: #1a2b3c;">
                        Sub Total: 33 ECTS | 20 Cr. Hrs.
                    </div>
                </div>
            </div>
        </div>

        <!-- Year 4: Specialization & Capstone -->
        <div style="margin-bottom: 4rem;" data-aos="fade-up">
            <h3 class="year-title">Year 4: Specialization & Capstone</h3>
            <div class="semester-grid">
                <!-- Semester 7 -->
                <div class="course-card">
                    <h4 class="semester-title">Semester 7</h4>
                    <ul class="course-list">
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc4035</span>
                            <span class="course-name">Computer Security</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc4113</span>
                            <span class="course-name">Computer Vision and Image Processing</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc4123</span>
                            <span class="course-name">Research Methods in Computer Science</span>
                            <span class="course-credits">3 ECTS | 2 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc4103</span>
                            <span class="course-name">Compiler Design</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc4125</span>
                            <span class="course-name">Final Year Project I</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">ELECTIVE I</span>
                            <span class="course-name">Elective I</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                    </ul>
                    <div style="margin-top: 1rem; text-align: right; font-weight: bold; color: #1a2b3c;">
                        Sub Total: 28 ECTS | 17 Cr. Hrs.
                    </div>
                </div>
                
                <!-- Semester 8 -->
                <div class="course-card">
                    <h4 class="semester-title">Semester 8</h4>
                    <ul class="course-list">
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc4036</span>
                            <span class="course-name">Network and System Administration</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc4038</span>
                            <span class="course-name">Introduction to Distributed Systems</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc4132</span>
                            <span class="course-name">Selected Topics in Computer Science</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">CoSc4126</span>
                            <span class="course-name">Final Year Project II</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                        <li class="course-item">
                            <i class="fas fa-book-open"></i>
                            <span class="course-code">ELECTIVE II</span>
                            <span class="course-name">Elective II</span>
                            <span class="course-credits">5 ECTS | 3 Cr. Hrs.</span>
                        </li>
                    </ul>
                    <div style="margin-top: 1rem; text-align: right; font-weight: bold; color: #1a2b3c;">
                        Sub Total: 25 ECTS | 15 Cr. Hrs.
                    </div>
                </div>
            </div>
        </div>

        <!-- Electives Section -->
        <div class="course-card" data-aos="fade-up" style="margin-top: 2rem;">
            <h3 style="font-size: 1.8rem; color: #1a2b3c; margin-bottom: 1.5rem; text-align: center;">Available Elective Courses</h3>
            <p style="text-align: center; color: #6c757d; margin-bottom: 2rem;">The following courses are specialized elective courses that enhance our students high broader Skill development</p>
            <div class="electives-grid">
                <span class="elective-item"><i class="fas fa-book-open" style="margin-right: 8px;"></i> Mobile Application Development</span>
                <span class="elective-item"><i class="fas fa-book-open" style="margin-right: 8px;"></i>Introduction  to Data Mining and Data Warehousing </span>
                <span class="elective-item"><i class="fas fa-book-open" style="margin-right: 8px;"></i> Event-Driven Programming </span>
                <span class="elective-item"><i class="fas fa-book-open" style="margin-right: 8px;"></i> Introduction to Machine Learning</span>
                <span class="elective-item"><i class="fas fa-book-open" style="margin-right: 8px;"></i> Introduction to Natural Language Processing </span>
                <span class="elective-item"><i class="fas fa-book-open" style="margin-right: 8px;"></i> Simulation and Modeling</span>
                <span class="elective-item"><i class="fas fa-book-open" style="margin-right: 8px;"></i> Multimedia  </span>
                <span class="elective-item"><i class="fas fa-book-open" style="margin-right: 8px;"></i> Human Computer Interaction </span>
            </div>
        </div>

        <!-- Note about curriculum -->
        <div style="text-align: center; margin-top: 3rem; padding: 2rem; background: #e9ecef; border-radius: 10px;" data-aos="fade-up">
            <i class="fas fa-info-circle" style="font-size: 2rem; color: #ffc107; margin-bottom: 1rem;"></i>
            <p style="color: #495057; max-width: 600px; margin: 0 auto;">
                <strong>Note:</strong> This curriculum is regularly updated to meet industry standards and accreditation requirements. 
                Course offerings and credits may be subject to change. Please consult with your academic advisor for the most current information.
            </p>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate course items
    const courseItems = document.querySelectorAll('.course-item');
    courseItems.forEach((item, index) => {
        item.style.animation = `fadeInUp 0.5s ease forwards ${index * 0.05}s`;
    });
    
    // Statistics animation function
    function animateStats() {
        const targets = {
            ects: 280,
            duration: 4,
            semesters: 8,
            courses: 54
        };
        
        const durations = {
            ects: 30,
            duration: 20,
            semesters: 25,
            courses: 35
        };
        
        const progressCircles = {
            ects: document.getElementById('ects-progress'),
            duration: document.getElementById('duration-progress'),
            semesters: document.getElementById('semesters-progress'),
            courses: document.getElementById('courses-progress')
        };
        
        const valueElements = {
            ects: document.getElementById('ects-value'),
            duration: document.getElementById('duration-value'),
            semesters: document.getElementById('semesters-value'),
            courses: document.getElementById('courses-value')
        };
        
        // Function to animate a single stat
        function animateStat(stat, target, duration) {
            let start = 0;
            const increment = target / (duration / 5); // Update every 20ms
            const circle = progressCircles[stat];
            const valueEl = valueElements[stat];
            
            const timer = setInterval(() => {
                start += increment;
                if (start >= target) {
                    start = target;
                    clearInterval(timer);
                }
                
                // Update text value
                valueEl.textContent = Math.round(start);
                
                // Update progress circle
                if (circle) {
                    const circumference = 2 * Math.PI * 100; // 2πr where r=42
                    const offset = circumference - (start / target) * circumference;
                    circle.style.strokeDashoffset = offset;
                }
            }, 20);
        }
        
        // Animate each stat
        animateStat('ects', targets.ects, durations.ects);
        animateStat('duration', targets.duration, durations.duration);
        animateStat('semesters', targets.semesters, durations.semesters);
        animateStat('courses', targets.courses, durations.courses);
    }
    
    // Use Intersection Observer to trigger animation when section is visible
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateStats();
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });
    
    const statsSection = document.getElementById('program-stats-section');
    if (statsSection) {
        observer.observe(statsSection);
    }
});

// Add keyframe animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection