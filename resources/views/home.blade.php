@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container">
    <!-- Hero Section with Fixed Text Colors -->
    <section class="hero-section" style="text-align: center; padding: 6rem 0; background: linear-gradient(135deg, #0033660%, #b3e0ff 50%, #80caff 100%); color: #003366; border-radius: 15px; margin-bottom: 4rem; position: relative; overflow: hidden; box-shadow: 0 15px 40px rgba(0, 100, 150, 0.2);">
        <!-- Professional geometric pattern overlay -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\' viewBox=\'0 0 100 100\'><path d=\'M0 0 L100 0 L100 100 L0 100 Z\' fill=\'none\' stroke=\'rgba(0,51,102,0.1)\' stroke-width=\'0.5\'/><circle cx=\'50\' cy=\'50\' r=\'30\' fill=\'none\' stroke=\'rgba(0,51,102,0.1)\' stroke-width=\'0.5\'/></svg>'); opacity: 0.15; background-repeat: repeat;"></div>
        
        <!-- Subtle glow effect -->
        <div style="position: absolute; top: -50%; left: -50%; right: -50%; bottom: -50%; background: radial-gradient(circle at 30% 50%, rgba(22, 106, 175, 0.1) 0%, transparent 50%); animation: rotate 20s linear infinite;"></div>
        
        <div style="position: relative; z-index: 2; max-width: 900px; margin: 0 auto; padding: 0 20px;">
            <h1 style="font-size: 4rem; margin-bottom: 1.2rem; font-weight: 700; text-shadow: 2px 2px 4px rgba(9, 79, 132, 0.5); letter-spacing: -0.5px; color: #003366;">
                Mekdela Amba University
            </h1>
            <p style="font-size: 1.5rem; max-width: 800px; margin: 0 auto 2.5rem; font-weight: 500; letter-spacing: 1px; color: #00509e; text-shadow: 1px 1px 2px rgba(255,255,255,0.3);">
                Welcome to Computer Science
                <br> 
                Innovating the Future through Technology and Research
            </p>
            <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
                <a href="{{ route('about') }}" class="btn-primary" style="display: inline-block; padding: 15px 45px; background: #FFD700; color: #4575a5; text-decoration: none; border-radius: 50px; font-weight: 600; font-size: 1.1rem; border: 2px solid transparent; transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); text-transform: uppercase; letter-spacing: 1px;">Learn More</a>
                <a href="{{ route('contact') }}" class="btn-secondary" style="display: inline-block; padding: 15px 45px; background: #003366; color: white; text-decoration: none; border-radius: 50px; font-weight: 600; font-size: 1.1rem; border: 2px solid #FFD700; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 1px;">Contact Us</a>
            </div>
        </div>
    </section>

    <!-- Programs Overview Section - Centered -->
    <section style="margin-bottom: 5rem; text-align: center;">
        <h2 style="text-align: center; font-size: 3rem; margin-bottom: 3rem; position: relative; display: inline-block; width: 100%; color: #003366; font-weight: 600;">
            Our Academic Program
            <span style="display: block; width: 120px; height: 4px; background: linear-gradient(90deg, #003366, #FFD700, #003366); margin: 20px auto 0; border-radius: 2px;"></span>
        </h2>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2.5rem; text-align: left;">
            <!-- B.Sc. Computer Science -->
            <div class="program-card" style="background: white; padding: 2.5rem; border-radius: 15px; box-shadow: 0 15px 30px rgba(0,51,102,0.1); transition: all 0.3s ease; border: 1px solid rgba(0,51,102,0.05);">
                <i class="fas fa-laptop-code" style="font-size: 3.5rem; color: #003366; margin-bottom: 1.2rem;"></i>
                <h3 style="margin-bottom: 1rem; color: #003366; font-size: 1.6rem;">B.Sc. in Computer Science</h3>
                <p style="color: #4a5568; line-height: 1.7; margin-bottom: 1.5rem;">A comprehensive program covering algorithms, data structures, software engineering, database systems, and theoretical foundations of computing.</p>
                <ul style="color: #4a5568; padding-left: 1.2rem;">
                    <li style="margin-bottom: 0.7rem;">✓ 4 Years Duration</li>
                    <li style="margin-bottom: 0.7rem;">✓ 150+ Credit Hours</li>
                    <li style="margin-bottom: 0.7rem;">✓ Capstone Project Required</li>
                </ul>
            </div>

            <div class="program-card" style="background: white; padding: 2.5rem; border-radius: 15px; box-shadow: 0 15px 30px rgba(0,51,102,0.1); transition: all 0.3s ease; border: 1px solid rgba(0,51,102,0.05);">
                <i class="fas fa-network-wired" style="font-size: 3.5rem; color: #1c3a5f; margin-bottom: 1.2rem;"></i>
                <h3 style="margin-bottom: 1rem; color: #003366; font-size: 1.6rem;">Curriculum & Specializations</h3>
                <p style="color: #4a5568; line-height: 1.7; margin-bottom: 1.5rem;">A clear breakdown of core requirements (like Data Structures, Algorithms, and Software Engineering) alongside elective "tracks." Mentioning specializations like Artificial Intelligence, Cybersecurity, or Game Design helps students see how they can tailor the degree to their specific interests.</p>
            </div>

            <div class="program-card" style="background: white; padding: 2.5rem; border-radius: 15px; box-shadow: 0 15px 30px rgba(0,51,102,0.1); transition: all 0.3s ease; border: 1px solid rgba(0,51,102,0.05);">
                <i class="fas fa-code" style="font-size: 3.5rem; color: #0f2c44; margin-bottom: 1.2rem;"></i>
                <h3 style="margin-bottom: 1rem; color: #003366; font-size: 1.6rem;">Full-Stack Web Development, Artificial Intelligence & Machine Learning</h3>
                <p style="color: #4a5568; line-height: 1.7; margin-bottom: 1.5rem;">Foundations of Neural Networks: Dive into the architecture of deep learning, covering backpropagation, activation functions, and model optimization.</p>
                <p style="color: #4a5568; line-height: 1.7; margin-bottom: 1.5rem;">Natural Language Processing (NLP): Learn how machines understand human speech and text, from basic sentiment analysis to advanced Large Language Models (LLMs).</p>
                <p style="color: #4a5568; line-height: 1.7; margin-bottom: 1.5rem;">Computer Vision: Explore how systems process visual data to recognize objects, navigate autonomous vehicles, and perform facial recognition.</p>
                <p style="color: #4a5568; line-height: 1.7; margin-bottom: 1.5rem;">Ethics in AI: A critical look at algorithmic bias, data privacy, and the societal impact of automated decision-making.</p>
                <p style="color: #4a5568; line-height: 1.7; margin-bottom: 1.5rem;">Modern Frontend Frameworks: Master the art of building responsive, high-performance user interfaces using tools like React, Vue, or Angular.</p>
                <p style="color: #4a5568; line-height: 1.7; margin-bottom: 1.5rem;">Backend Systems & APIs: Build the "brains" of applications by designing robust RESTful and GraphQL APIs using Node.js, Python, or Go.</p>
                <ul style="color: #4a5568; padding-left: 1.2rem;">
                    <li style="margin-bottom: 0.7rem;">✓ 4 Years Duration</li>
                    <li style="margin-bottom: 0.7rem;">✓ Agile/Scrum Training</li>
                    <li style="margin-bottom: 0.7rem;">✓ Industry Internship</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Why Choose Us - Centered -->
    <section style="background: linear-gradient(135deg, #f0f9ff 0%, #e6f3ff 100%); padding: 5rem 0; margin: 5rem 0; border-radius: 20px;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <h2 style="text-align: center; font-size: 3rem; margin-bottom: 3rem; position: relative; color: #003366; font-weight: 600;">
                Why Choose Us?
                <span style="display: block; width: 120px; height: 4px; background: linear-gradient(90deg, #003366, #FFD700, #003366); margin: 20px auto 0; border-radius: 2px;"></span>
            </h2>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem;">
                <div class="feature-card" style="text-align: left; background: white; padding: 2.5rem; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,51,102,0.08);">
                    <i class="fas fa-chalkboard-teacher" style="font-size: 3rem; color: #003366; margin-bottom: 1.2rem;"></i>
                    <h3 style="margin-bottom: 1rem; color: #003366;">Expert and Skilled Professionals</h3>
                    <div style="color: #4a5568;">
                        <p style="margin-bottom: 1rem;">Our department comprises a perfect blend of highly qualified academics and industry practitioners. With Master's (MSc) and Bachelor's (BSc) degree holders specializing in various computer science domains, our instructors bring both theoretical depth and practical expertise to the classroom.</p>
                        
                        <p style="margin-bottom: 0.8rem; font-weight: 600; color: #003366;">This diverse mix ensures students receive:</p>
                        
                        <ul style="list-style: none; padding: 0;">
                            <li style="margin-bottom: 0.8rem; display: flex; align-items: flex-start; gap: 10px;">
                                <span style="color: #FFD700; font-size: 1.2rem;">✓</span>
                                <span><strong style="color: #003366;">Strong theoretical foundations</strong> from our MSc-qualified academics</span>
                            </li>
                            <li style="margin-bottom: 0.8rem; display: flex; align-items: flex-start; gap: 10px;">
                                <span style="color: #FFD700; font-size: 1.2rem;">✓</span>
                                <span><strong style="color: #003366;">Hands-on industry insights</strong> from our experienced BSc practitioners</span>
                            </li>
                            <li style="margin-bottom: 0.8rem; display: flex; align-items: flex-start; gap: 10px;">
                                <span style="color: #FFD700; font-size: 1.2rem;">✓</span>
                                <span><strong style="color: #003366;">Mentorship at every level</strong> of your academic journey</span>
                            </li>
                            <li style="margin-bottom: 0.8rem; display: flex; align-items: flex-start; gap: 10px;">
                                <span style="color: #FFD700; font-size: 1.2rem;">✓</span>
                                <span><strong style="color: #003366;">Real-world problem-solving skills</strong> combined with research-backed knowledge</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="feature-card" style="text-align: center; background: white; padding: 2.5rem; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,51,102,0.08);">
                    <i class="fas fa-flask" style="font-size: 3rem; color: #1c3a5f; margin-bottom: 1.2rem;"></i>
                    <h3 style="margin-bottom: 1rem; color: #003366;">Modern Labs</h3>
                    <p style="color: #4a5568;">State-of-the-art facilities with cutting-edge technology and high-performance computing.</p>
                </div>
                <div class="feature-card" style="text-align: center; background: white; padding: 2.5rem; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,51,102,0.08);">
                    <i class="fas fa-briefcase" style="font-size: 3rem; color: #FFD700; margin-bottom: 1.2rem;"></i>
                    <h3 style="margin-bottom: 1rem; color: #003366;">Industry Connections</h3>
                    <p style="color: #4a5568;">Strong partnerships with leading tech companies for internships and job placement.</p>
                </div>
                <div class="feature-card" style="text-align: center; background: white; padding: 2.5rem; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,51,102,0.08);">
                    <i class="fas fa-globe-africa" style="font-size: 3rem; color: #2e7d32; margin-bottom: 1.2rem;"></i>
                    <h3 style="margin-bottom: 1rem; color: #003366;">Global Impact</h3>
                    <p style="color: #4a5568;">Research and projects addressing real-world challenges in Ethiopia and beyond.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section style="margin-bottom: 5rem; background: linear-gradient(135deg, #00f2fe0%, #1996cb 50%, #14afde8e 100%); padding: 5rem; border-radius: 20px; color: white; text-align: center; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(23, 169, 192, 0.3);">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\' viewBox=\'0 0 100 100\'><circle cx=\'50\' cy=\'50\' r=\'40\' fill=\'none\' stroke=\'rgba(46, 147, 210, 0.03)\' stroke-width=\'2\'/></svg>'); opacity: 0.1; background-repeat: repeat;"></div>
        
        <div style="position: relative; z-index: 2; max-width: 900px; margin: 0 auto;">
            <h2 style="font-size: 4rem; margin-bottom: 1.2rem; font-weight: 700; text-shadow: 2px 2px 4px rgba(9, 79, 132, 0.5); letter-spacing: -0.5px; color: #003366;">Join Our Community of Innovators</h2>
            <p style="font-size: 1.3rem; max-width: 800px; margin: 0 auto 2.5rem; line-height: 1.8; opacity: 0.95; color: rgba(23, 184, 233, 0.95);">
                Whether you're a prospective student, researcher, or industry partner, discover how you can be part of shaping the future of technology.
            </p>
            <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
                <a href="{{ route('programs') }}" style="display: inline-block; padding: 16px 50px; background: #FFD700; color: #003366; text-decoration: none; border-radius: 50px; font-weight: 600; font-size: 1.1rem; border: 2px solid transparent; transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(26, 165, 186, 0.73); text-transform: uppercase; letter-spacing: 1px;">Explore more about our Program</a>
                <a href="{{ route('contact') }}" style="display: inline-block; padding: 16px 50px; background: transparent; color: black; text-decoration: none; border-radius: 50px; font-weight: 600; font-size: 1.1rem; border: 0.5px solid #003366; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 1px;">Contact Admissions</a>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    /* Animations */
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes confetti {
        0% { background-position: 0 0; }
        100% { background-position: 100px 100px; }
    }
    
    .hero-section {
        position: relative;
        overflow: hidden;
    }
    
    .hero-section h1 {
        animation: fadeInUp 0.8s ease;
    }
    
    .hero-section p {
        animation: fadeInUp 0.8s ease 0.2s both;
    }
    
    .hero-section div {
        animation: fadeInUp 0.8s ease 0.4s both;
    }
    
    /* Card hover effects */
    .program-card, .feature-card {
        transition: all 0.3s ease;
    }
    
    .program-card:hover, .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,51,102,0.15) !important;
    }
    
    /* Button hover effects */
    .btn-primary:hover, .btn-secondary:hover, 
    a[style*="background: #FFD700"]:hover,
    a[style*="background: transparent"]:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2) !important;
    }
    
    .btn-primary:hover, a[style*="background: #FFD700"]:hover {
        background: #ffed4a !important;
    }
    
    .btn-secondary:hover, a[style*="background: transparent"]:hover {
        background: rgba(255,215,0,0.15) !important;
        border-color: #FFD700 !important;
    }
    
    a[style*="background: #003366"]:hover {
        background: #1c4b7a !important;
    }
    
    /* Responsive Design */
    @media (max-width: 1024px) {
        .hero-section h1 {
            font-size: 3.2rem !important;
        }
    }
    
    @media (max-width: 768px) {
        [style*="grid-template-columns: repeat(3, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
        
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        .hero-section {
            padding: 4rem 1rem !important;
        }
        
        .hero-section h1 {
            font-size: 2.5rem !important;
        }
        
        .hero-section p {
            font-size: 1.2rem !important;
        }
        
        h2 {
            font-size: 2.2rem !important;
        }
        
        [style*="padding: 5rem"] {
            padding: 3rem !important;
        }
    }
    
    @media (max-width: 480px) {
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
        
        .hero-section h1 {
            font-size: 2rem !important;
        }
        
        .hero-section p {
            font-size: 1.1rem !important;
        }
        
        h2 {
            font-size: 1.8rem !important;
        }
        
        [style*="padding: 5rem"] {
            padding: 2rem !important;
        }
        
        .btn-primary, .btn-secondary,
        a[style*="padding: 16px 50px"] {
            display: block !important;
            margin: 10px auto !important;
            width: 100% !important;
            max-width: 300px;
        }
    }
</style>
@endpush