@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container">
    <!-- Hero Section with Fixed Text Colors -->
    <section class="hero-section" style="text-align: center; padding: 6rem 0; background: linear-gradient(135deg, #0033660%, #b3e0ff 50%, #80caff 100%); color: #003366; border-radius: 15px; margin-bottom: 4rem; position: relative; overflow: hidden; box-shadow: 0 15px 40px rgba(0, 100, 150, 0.2);">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\' viewBox=\'0 0 100 100\'><path d=\'M0 0 L100 0 L100 100 L0 100 Z\' fill=\'none\' stroke=\'rgba(0,51,102,0.1)\' stroke-width=\'0.5\'/><circle cx=\'50\' cy=\'50\' r=\'30\' fill=\'none\' stroke=\'rgba(0,51,102,0.1)\' stroke-width=\'0.5\'/></svg>'); opacity: 0.15; background-repeat: repeat;"></div>
        <div style="position: absolute; top: -50%; left: -50%; right: -50%; bottom: -50%; background: radial-gradient(circle at 30% 50%, rgba(22, 106, 175, 0.1) 0%, transparent 50%); animation: rotate 20s linear infinite;"></div>
        
        <div style="position: relative; z-index: 2; max-width: 900px; margin: 0 auto; padding: 0 20px;">
            <h1 style="font-size: 4rem; margin-bottom: 1.2rem; font-weight: 700; text-shadow: 2px 2px 4px rgba(9, 79, 132, 0.5); letter-spacing: -0.5px; color: #003366;">
                Mekdela Amba University
            </h1>
            <div class="scrolling-text-container" style="overflow: hidden; white-space: nowrap; margin: 0 auto 1rem;">
                <p class="scrolling-text" style="font-size: 1.5rem; font-weight: 500; letter-spacing: 1px; color: #00509e; text-shadow: 1px 1px 2px rgba(255,255,255,0.3); display: inline-block; white-space: nowrap;">
                   <div style="width: 100%; overflow: hidden; background: FFFAFA; padding: 20px 0;">
  <div style="display: inline-block; animation: scrollRTL 8s linear infinite; white-space: nowrap; font-size: 1.5rem; color: #00ffbf;">
    <b style="font-size:40px">Welcome to Computer Science</b>
  </div>
</div>

<style>
  @keyframes scrollRTL {
    /* 0% { transform: translateX(100%); }
    100% { transform: translateX(-100%); } */
  }
</style>
                </p>
            </div>
            <p style="font-size: 1.2rem; max-width: 800px; margin: 0 auto 2rem; font-weight: 400; letter-spacing: 0.5px; color: #00509e; text-shadow: 1px 1px 2px rgba(255,255,255,0.3);">
                Innovating the Future through Technology and Research
            </p>
            <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
                <a href="{{ route('about') }}" class="btn-primary" style="display: inline-block; padding: 15px 45px; background: #FFD700; color: #4575a5; text-decoration: none; border-radius: 50px; font-weight: 600; font-size: 1.1rem; border: 2px solid transparent; transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); text-transform: uppercase; letter-spacing: 1px;">Learn More</a>
                <a href="{{ route('contact') }}" class="btn-secondary" style="display: inline-block; padding: 15px 45px; background: #003366; color: white; text-decoration: none; border-radius: 50px; font-weight: 600; font-size: 1.1rem; border: 2px solid #FFD700; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 1px;">Contact Us</a>
            </div>
        </div>
    </section>

    <!-- Interactive Academic Program Section -->
    <section style="margin-bottom: 5rem;">
        <div style="text-align: center; margin-bottom: 3rem;">
            <h2 style="font-size: 3rem; color: #003366; font-weight: 700; margin-bottom: 1rem;">
                Our Academic Program
                <span style="display: block; width: 120px; height: 4px; background: linear-gradient(90deg, #003366, #FFD700, #003366); margin: 20px auto 0; border-radius: 2px;"></span>
            </h2>
            <p style="color: #4a5568; font-size: 1.2rem; max-width: 700px; margin: 1.5rem auto 0;">Explore our comprehensive computer science curriculum designed to shape future tech leaders</p>
        </div>

        <!-- Program Cards with Interactive Hover Effects -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
            <!-- Card 1: B.Sc. Computer Science -->
            <div class="program-card-interactive" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,51,102,0.1); transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); cursor: pointer; position: relative;">
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 5px; background: linear-gradient(90deg, #003366, #FFD700);"></div>
                <div style="padding: 2rem; text-align: center;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #003366, #1c4b7a); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; transition: transform 0.3s ease;">
                        <i class="fas fa-laptop-code" style="font-size: 2.5rem; color: #FFD700;"></i>
                    </div>
                    <h3 style="color: #003366; font-size: 1.6rem; margin-bottom: 1rem; font-weight: 700;">B.Sc. Computer Science</h3>
                    <div style="height: 3px; width: 50px; background: #FFD700; margin: 1rem auto;"></div>
                    <p style="color: #4a5568; line-height: 1.7; margin-bottom: 1.5rem;">Comprehensive program covering algorithms, data structures, software engineering, database systems, and theoretical foundations of computing.</p>
                    <div style="background: #f8f9fa; padding: 1rem; border-radius: 10px; margin-top: 1rem;">
                        <div style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 1rem;">
                            <span><i class="fas fa-clock" style="color: #FFD700;"></i> 4 Years</span>
                            <span><i class="fas fa-book" style="color: #FFD700;"></i> 150+ Credits</span>
                            <span><i class="fas fa-project-diagram" style="color: #FFD700;"></i> Capstone</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Curriculum & Specializations -->
            <div class="program-card-interactive" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,51,102,0.1); transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); cursor: pointer; position: relative;">
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 5px; background: linear-gradient(90deg, #FFD700, #003366);"></div>
                <div style="padding: 2rem; text-align: center;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #FFD700, #ffed4a); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; transition: transform 0.3s ease;">
                        <i class="fas fa-network-wired" style="font-size: 2.5rem; color: #003366;"></i>
                    </div>
                    <h3 style="color: #003366; font-size: 1.6rem; margin-bottom: 1rem; font-weight: 700;">Curriculum & Specializations</h3>
                    <div style="height: 3px; width: 50px; background: #FFD700; margin: 1rem auto;"></div>
                    <p style="color: #4a5568; line-height: 1.7; margin-bottom: 1rem;">Choose your path with specialized tracks:</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem; margin-top: 1rem;">
                        <div style="background: #f8f9fa; padding: 0.5rem; border-radius: 8px; font-size: 0.9rem;">
                            <i class="fas fa-brain" style="color: #FFD700;"></i> AI & ML
                        </div>
                        <div style="background: #f8f9fa; padding: 0.5rem; border-radius: 8px; font-size: 0.9rem;">
                            <i class="fas fa-shield-alt" style="color: #FFD700;"></i> Cybersecurity
                        </div>
                        <div style="background: #f8f9fa; padding: 0.5rem; border-radius: 8px; font-size: 0.9rem;">
                            <i class="fas fa-gamepad" style="color: #FFD700;"></i> Game Design
                        </div>
                        <div style="background: #f8f9fa; padding: 0.5rem; border-radius: 8px; font-size: 0.9rem;">
                            <i class="fas fa-database" style="color: #FFD700;"></i> Data Science
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Full-Stack & AI/ML (Expanded with Tabs) -->
            <div class="program-card-interactive" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,51,102,0.1); transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); cursor: pointer; position: relative;">
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 5px; background: linear-gradient(90deg, #003366, #FFD700, #003366);"></div>
                <div style="padding: 2rem; text-align: center;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #1c4b7a, #003366); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; transition: transform 0.3s ease;">
                        <i class="fas fa-code" style="font-size: 2.5rem; color: #FFD700;"></i>
                    </div>
                    <h3 style="color: #003366; font-size: 1.6rem; margin-bottom: 0.5rem; font-weight: 700;">Full-Stack & AI/ML</h3>
                    <div style="height: 3px; width: 50px; background: #FFD700; margin: 1rem auto;"></div>
                    
                    <!-- Interactive Toggle Section -->
                    <div style="margin-top: 1rem;">
                        <div style="display: flex; gap: 0.5rem; justify-content: center; margin-bottom: 1rem;">
                            <button class="tab-btn active" data-tab="web" style="padding: 0.5rem 1rem; background: #003366; color: white; border: none; border-radius: 25px; cursor: pointer; font-size: 0.85rem;">🌐 Web Dev</button>
                            <button class="tab-btn" data-tab="ai" style="padding: 0.5rem 1rem; background: #e9ecef; color: #003366; border: none; border-radius: 25px; cursor: pointer; font-size: 0.85rem;">🤖 AI/ML</button>
                        </div>
                        
                        <div id="web-tab" class="tab-content" style="display: block;">
                            <ul style="list-style: none; padding: 0; text-align: left;">
                                <li style="margin-bottom: 0.75rem; display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-check-circle" style="color: #FFD700;"></i>
                                    <span>React, Vue, Angular</span>
                                </li>
                                <li style="margin-bottom: 0.75rem; display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-check-circle" style="color: #FFD700;"></i>
                                    <span>Node.js, Python, Go</span>
                                </li>
                                <li style="margin-bottom: 0.75rem; display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-check-circle" style="color: #FFD700;"></i>
                                    <span>RESTful & GraphQL APIs</span>
                                </li>
                                <li style="margin-bottom: 0.75rem; display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-check-circle" style="color: #FFD700;"></i>
                                    <span>Responsive Design</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div id="ai-tab" class="tab-content" style="display: none;">
                            <ul style="list-style: none; padding: 0; text-align: left;">
                                <li style="margin-bottom: 0.75rem; display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-check-circle" style="color: #FFD700;"></i>
                                    <span>Neural Networks & Deep Learning</span>
                                </li>
                                <li style="margin-bottom: 0.75rem; display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-check-circle" style="color: #FFD700;"></i>
                                    <span>Natural Language Processing</span>
                                </li>
                                <li style="margin-bottom: 0.75rem; display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-check-circle" style="color: #FFD700;"></i>
                                    <span>Computer Vision</span>
                                </li>
                                <li style="margin-bottom: 0.75rem; display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-check-circle" style="color: #FFD700;"></i>
                                    <span>Ethics in AI</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div style="background: #f8f9fa; padding: 1rem; border-radius: 10px; margin-top: 1rem;">
                        <div style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 1rem;">
                            <span><i class="fas fa-tasks" style="color: #FFD700;"></i> Agile/Scrum</span>
                            <span><i class="fas fa-briefcase" style="color: #FFD700;"></i> Industry Internship</span>
                            <span><i class="fas fa-certificate" style="color: #FFD700;"></i> 4 Years</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Interactive Stats Counter -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-top: 3rem;">
            <div class="stat-card" style="background: linear-gradient(135deg, #003366, #1c4b7a); color: white; padding: 1.5rem; border-radius: 15px; text-align: center; transition: transform 0.3s ease;">
                <i class="fas fa-graduation-cap" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                <div class="stat-number" data-target="112" style="font-size: 2.5rem; font-weight: 700;">0</div>
                <p>Active Students</p>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #FFD700, #ffed4a); color: #003366; padding: 1.5rem; border-radius: 15px; text-align: center; transition: transform 0.3s ease;">
                <i class="fas fa-chalkboard-teacher" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                <div class="stat-number" data-target="12" style="font-size: 2.5rem; font-weight: 700;">0</div>
                <p>Expert Staff</p>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #28a745, #34ce57); color: white; padding: 1.5rem; border-radius: 15px; text-align: center; transition: transform 0.3s ease;">
                <i class="fas fa-briefcase" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                <div class="stat-number" data-target="95" style="font-size: 2.5rem; font-weight: 700;">0</div>
                <p>Graduate Employment Rate</p>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #17a2b8, #20c9e0); color: white; padding: 1.5rem; border-radius: 15px; text-align: center; transition: transform 0.3s ease;">
                <i class="fas fa-flask" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                <div class="stat-number" data-target="4" style="font-size: 2.5rem; font-weight: 700;">0</div>
                <p>Laboratory Classes</p>
            </div>
        </div>
    </section>

    <!-- Why Choose Us - Interactive Animated Section -->
    <section style="background: linear-gradient(135deg, #0a2342 0%, #1c3a5f 100%); padding: 5rem 0; margin: 5rem 0; border-radius: 30px; position: relative; overflow: hidden;">
        <!-- Animated Background Pattern -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.05;">
            <div style="position: absolute; width: 100%; height: 100%; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'60\' height=\'60\' viewBox=\'0 0 60 60\'><path d=\'M30 0 L60 30 L30 60 L0 30 Z\' fill=\'none\' stroke=\'white\' stroke-width=\'0.5\'/></svg>'); background-repeat: repeat; animation: rotate 60s linear infinite;"></div>
        </div>
        
        <!-- Floating Particles -->
        <div class="particles" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden;">
            <div class="particle" style="position: absolute; width: 2px; height: 2px; background: #FFD700; border-radius: 50%; opacity: 0.3; animation: float 20s infinite;"></div>
            <div class="particle" style="position: absolute; width: 3px; height: 3px; background: white; border-radius: 50%; opacity: 0.2; animation: float 25s infinite;"></div>
        </div>
        
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 2;">
            <h2 style="text-align: center; font-size: 3rem; margin-bottom: 1rem; color: white; font-weight: 700;">
                Why Choose Us?
                <span style="display: block; width: 120px; height: 4px; background: #FFD700; margin: 20px auto 0; border-radius: 2px;"></span>
            </h2>
            <p style="text-align: center; color: rgba(255,255,255,0.8); font-size: 1.2rem; max-width: 700px; margin: 1.5rem auto 3rem;">Discover what makes our Computer Science department exceptional</p>
            
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem;">
                <!-- Feature 1: Expert Faculty with 3D Flip Effect -->
                <div class="feature-3d-card" style="perspective: 1000px; cursor: pointer;">
                    <div class="feature-inner" style="position: relative; width: 100%; height: 100%; text-align: center; transition: transform 0.6s; transform-style: preserve-3d;">
                        <div class="feature-front" style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); position: relative; backface-visibility: hidden;">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #003366, #1c4b7a); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                                <i class="fas fa-chalkboard-teacher" style="font-size: 2.5rem; color: #FFD700;"></i>
                            </div>
                            <h3 style="color: #003366; margin-bottom: 1rem; font-size: 1.4rem;">Expert Staffs</h3>
                            <div class="progress-bar" style="height: 3px; background: #FFD700; width: 0%; transition: width 1s ease;"></div>
                            <p style="color: #4a5568; margin-top: 1rem; font-size: 0.9rem;">Hover to learn more →</p>
                        </div>
                        <div class="feature-back" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, #003366, #1c4b7a); color: white; padding: 2rem; border-radius: 20px; transform: rotateY(180deg); backface-visibility: hidden; text-align: center;">
                            <i class="fas fa-star" style="font-size: 2rem; color: #FFD700; margin-bottom: 1rem;"></i>
                            <h3 style="margin-bottom: 1rem;">Expert Faculty</h3>
                            <p style="font-size: 0.9rem; line-height: 1.6;">MSc & BSc holders from top universities , bringing cutting-edge projects and industry experience in Ethiopia.</p>
                            <div style="margin-top: 1rem;">
                                <span class="stat-badge" style="background: rgba(255,215,0,0.2); padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem;">12+ Faculty</span>
                                <span class="stat-badge" style="background: rgba(255,215,0,0.2); padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem; margin-left: 0.5rem;">100% Qualified</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feature 2: Modern Labs with Pulse Animation -->
                <div class="feature-card-modern" style="background: white; padding: 2rem; border-radius: 20px; text-align: center; transition: all 0.3s ease; position: relative; overflow: hidden; cursor: pointer;">
                    <div class="pulse-effect" style="position: absolute; top: 50%; left: 50%; width: 100%; height: 100%; background: radial-gradient(circle, rgba(255,215,0,0.1) 0%, transparent 70%); transform: translate(-50%, -50%); animation: pulse 2s infinite;"></div>
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #17a2b8, #20c9e0); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                        <i class="fas fa-flask" style="font-size: 2.5rem; color: white;"></i>
                    </div>
                    <h3 style="color: #003366; margin-bottom: 1rem;">Modern Labs</h3>
                    <div class="feature-stats" style="display: flex; justify-content: center; gap: 1rem; margin-bottom: 1rem;">
                        <span><i class="fas fa-microchip"></i> 4 Labs</span>
                        <span><i class="fas fa-server"></i> 100+ PCs</span>
                    </div>
                    <p style="color: #4a5568;">State-of-the-art facilities with cutting-edge technology and experience Lab Assistances.</p>
                    <div class="hover-reveal" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease;">
                        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e9ecef;">
                            <span style="color: #FFD700;">✓</span> 24/7 Lab Access<br>
                            <span style="color: #FFD700;">✓</span> Latest Software Stack<br>
                            <span style="color: #FFD700;">✓</span> Cloud Computing Resources
                        </div>
                    </div>
                </div>

                <!-- Feature 3: Industry Connections with Icons Instead of Company Logos -->
                <div class="feature-card-modern" style="background: white; padding: 2rem; border-radius: 20px; text-align: center; transition: all 0.3s ease; cursor: pointer;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #28a745, #34ce57); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                        <i class="fas fa-handshake" style="font-size: 2.5rem; color: white;"></i>
                    </div>
                    <h3 style="color: #003366; margin-bottom: 1rem;">Industry Connections</h3>
                    <div class="industry-icons" style="display: flex; justify-content: center; gap: 1.2rem; margin-bottom: 1rem;">
                        <i class="fas fa-building" style="font-size: 1.5rem; color: #FFD700;"></i>
                        <i class="fas fa-chart-line" style="font-size: 1.5rem; color: #FFD700;"></i>
                        <i class="fas fa-users" style="font-size: 1.5rem; color: #FFD700;"></i>
                        <i class="fas fa-code-branch" style="font-size: 1.5rem; color: #FFD700;"></i>
                    </div>
                    <p style="color: #4a5568;">Strong partnerships with leading tech companies in Ethiopia for internships and job placement.</p>
                    <div class="hover-slide" style="transform: translateX(0); transition: transform 0.3s ease;">
                        <span class="badge" style="display: inline-block; background: #FFD700; color: #003366; padding: 0.3rem 0.8rem; border-radius: 20px; margin-top: 0.5rem;">95% Placement Rate</span>
                    </div>
                </div>

                <!-- Feature 4: Global Impact with Ripple Effect -->
                <div class="feature-card-modern" style="background: white; padding: 2rem; border-radius: 20px; text-align: center; transition: all 0.3s ease; position: relative; overflow: hidden; cursor: pointer;">
                    <div class="ripple" style="position: absolute; border-radius: 50%; background: rgba(255,215,0,0.3); transform: scale(0); animation: ripple 3s infinite;"></div>
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #2e7d32, #3c8c40); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                        <i class="fas fa-globe-africa" style="font-size: 2.5rem; color: white;"></i>
                    </div>
                    <h3 style="color: #003366; margin-bottom: 1rem;">Global Impact</h3>
                    <div style="margin-bottom: 1rem;">
                        <i class="fas fa-map-marker-alt" style="color: #FFD700;"></i> Our staffs have been participating on 3 countries including Our country on Freelance and Remote Job<br>
                        <i class="fas fa-users" style="color: #FFD700;"></i> 200+ Alumni Worldwide
                    </div>
                    <p style="color: #4a5568;">Projects addressing real-world challenges in Ethiopia and beyond.</p>
                    <div class="impact-stats" style="margin-top: 0.5rem; opacity: 0; transition: opacity 0.3s ease;">
                        <small>National collaborations with 5+ universities</small>
                    </div>
                </div>
            </div>
            
            <!-- Additional Highlight Stats -->
            <div style="display: flex; justify-content: center; gap: 3rem; margin-top: 3rem; flex-wrap: wrap;">
                <div class="highlight-stat" style="text-align: center;">
                    <div style="font-size: 2rem; color: #FFD700;">🏆</div>
                    <div style="font-size: 1.5rem; font-weight: 700; color: white;">100%</div>
                    <div style="color: rgba(255,255,255,0.8);">Exam Pass Rate</div>
                </div>
                <div class="highlight-stat" style="text-align: center;">
                    <div style="font-size: 2rem; color: #FFD700;">📚</div>
                    <div style="font-size: 1.5rem; font-weight: 700; color: white;">10+</div>
                    <div style="color: rgba(255,255,255,0.8);">Research Publications</div>
                </div>
                <div class="highlight-stat" style="text-align: center;">
                    <div style="font-size: 2rem; color: #FFD700;">🎓</div>
                    <div style="font-size: 1.5rem; font-weight: 700; color: white;">4.5/5</div>
                    <div style="color: rgba(255,255,255,0.8);">Student Satisfaction</div>
                </div>
                <div class="highlight-stat" style="text-align: center;">
                    <div style="font-size: 2rem; color: #FFD700;">💡</div>
                    <div style="font-size: 1.5rem; font-weight: 700; color: white;">15+</div>
                    <div style="color: rgba(255,255,255,0.8);">Student Projects Yearly</div>
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
    /* Existing Animations */
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
    
    @keyframes pulse {
        0% { transform: translate(-50%, -50%) scale(0.8); opacity: 0.5; }
        100% { transform: translate(-50%, -50%) scale(2); opacity: 0; }
    }
    
    @keyframes float {
        0% { transform: translateY(0px) translateX(0px); opacity: 0; }
        50% { opacity: 0.5; }
        100% { transform: translateY(-100px) translateX(50px); opacity: 0; }
    }
    
    @keyframes ripple {
        0% { transform: scale(0); opacity: 0.5; }
        100% { transform: scale(4); opacity: 0; }
    }
    
    /* Scrolling Text Animation */
    @keyframes scrollLeft {
        0% {
            transform: translateX(100%);
        }
        100% {
            transform: translateX(-100%);
        }
    }
    
    .scrolling-text-container {
        overflow: hidden;
        white-space: nowrap;
        width: 100%;
    }
    
    .scrolling-text {
        display: inline-block;
        animation: scrollLeft 15s linear infinite;
        white-space: nowrap;
    }
    
    .scrolling-text:hover {
        animation-play-state: paused;
    }
    
    /* Program Card Hover Effects */
    .program-card-interactive {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .program-card-interactive:hover {
        transform: translateY(-15px) scale(1.02);
        box-shadow: 0 25px 50px rgba(0,51,102,0.2) !important;
    }
    
    .program-card-interactive:hover > div:first-child div:first-child {
        transform: scale(1.1);
    }
    
    /* Stat Card Hover */
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }
    
    /* 3D Flip Card Effect */
    .feature-3d-card:hover .feature-inner {
        transform: rotateY(180deg);
    }
    
    .feature-inner {
        transition: transform 0.6s;
        transform-style: preserve-3d;
    }
    
    .feature-front, .feature-back {
        backface-visibility: hidden;
    }
    
    .feature-back {
        transform: rotateY(180deg);
    }
    
    /* Modern Card Hover Effects */
    .feature-card-modern {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .feature-card-modern:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
    
    .feature-card-modern:hover .hover-reveal {
        max-height: 150px;
    }
    
    .feature-card-modern:hover .hover-slide {
        transform: translateX(10px);
    }
    
    .feature-card-modern:hover .impact-stats {
        opacity: 1;
    }
    
    .feature-card-modern:hover .progress-bar {
        width: 100%;
    }
    
    /* Industry Icons Animation */
    .industry-icons i {
        transition: transform 0.3s ease;
    }
    
    .feature-card-modern:hover .industry-icons i {
        transform: translateY(-3px);
    }
    
    .industry-icons i:nth-child(1) { animation: bounce 1s ease infinite; }
    .industry-icons i:nth-child(2) { animation: bounce 1s ease 0.2s infinite; }
    .industry-icons i:nth-child(3) { animation: bounce 1s ease 0.4s infinite; }
    .industry-icons i:nth-child(4) { animation: bounce 1s ease 0.6s infinite; }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    
    /* Particle Animation */
    .particle {
        animation: float linear infinite;
    }
    
    /* Generate multiple particles */
    .particle:nth-child(1) { top: 10%; left: 10%; animation-duration: 15s; }
    .particle:nth-child(2) { top: 20%; left: 85%; animation-duration: 20s; animation-delay: 2s; }
    
    /* Tab Button Active State */
    .tab-btn.active {
        background: #003366 !important;
        color: white !important;
    }
    
    /* Hero Section Animations */
    .hero-section h1 {
        animation: fadeInUp 0.8s ease;
    }
    
    .hero-section .scrolling-text-container {
        animation: fadeInUp 0.8s ease 0.2s both;
    }
    
    .hero-section p {
        animation: fadeInUp 0.8s ease 0.3s both;
    }
    
    .hero-section div {
        animation: fadeInUp 0.8s ease 0.4s both;
    }
    
    /* Button Hover Effects */
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
    
    /* Highlight Stats Hover */
    .highlight-stat {
        transition: transform 0.3s ease;
    }
    
    .highlight-stat:hover {
        transform: translateY(-5px);
    }
    
    /* Responsive Design */
    @media (max-width: 1024px) {
        .hero-section h1 {
            font-size: 3.2rem !important;
        }
        
        [style*="grid-template-columns: repeat(3, 1fr)"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        .scrolling-text {
            animation-duration: 20s;
        }
    }
    
    @media (max-width: 768px) {
        [style*="grid-template-columns: repeat(3, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
        
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
        
        .hero-section {
            padding: 4rem 1rem !important;
        }
        
        .hero-section h1 {
            font-size: 2.5rem !important;
        }
        
        .scrolling-text {
            font-size: 1.2rem !important;
            animation-duration: 12s;
        }
        
        .hero-section p {
            font-size: 1rem !important;
        }
        
        h2 {
            font-size: 2.2rem !important;
        }
        
        [style*="padding: 5rem"] {
            padding: 3rem !important;
        }
        
        .feature-3d-card {
            min-height: 350px;
        }
    }
    
    @media (max-width: 480px) {
        .hero-section h1 {
            font-size: 2rem !important;
        }
        
        .scrolling-text {
            font-size: 1rem !important;
            animation-duration: 10s;
        }
        
        .hero-section p {
            font-size: 0.9rem !important;
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

@push('scripts')
<script>
    // Tab Switching Functionality
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const parent = this.closest('.program-card-interactive');
            const tabs = parent.querySelectorAll('.tab-btn');
            const contents = parent.querySelectorAll('.tab-content');
            
            tabs.forEach(tab => tab.classList.remove('active'));
            this.classList.add('active');
            
            contents.forEach(content => content.style.display = 'none');
            const tabId = this.getAttribute('data-tab');
            document.getElementById(`${tabId}-tab`).style.display = 'block';
        });
    });
    
    // Animated Counter for Stats
    function animateCounter(element, target) {
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target + (element.closest('.stat-card').querySelector('p').textContent.includes('Rate') ? '%' : '');
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current) + (element.closest('.stat-card').querySelector('p').textContent.includes('Rate') ? '%' : '');
            }
        }, 30);
    }
    
    // Intersection Observer for Stats
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const numberElement = entry.target.querySelector('.stat-number');
                const target = parseInt(numberElement.getAttribute('data-target'));
                animateCounter(numberElement, target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    document.querySelectorAll('.stat-card').forEach(card => {
        observer.observe(card);
    });
    
    // Create floating particles
    function createParticles() {
        const particlesContainer = document.querySelector('.particles');
        if (particlesContainer) {
            for (let i = 0; i < 20; i++) {
                const particle = document.createElement('div');
                particle.style.position = 'absolute';
                particle.style.width = Math.random() * 3 + 1 + 'px';
                particle.style.height = particle.style.width;
                particle.style.background = Math.random() > 0.5 ? '#FFD700' : 'white';
                particle.style.borderRadius = '50%';
                particle.style.opacity = Math.random() * 0.3;
                particle.style.top = Math.random() * 100 + '%';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animation = `float ${Math.random() * 20 + 15}s linear infinite`;
                particle.style.animationDelay = Math.random() * 5 + 's';
                particlesContainer.appendChild(particle);
            }
        }
    }
    
    // Initialize particles
    createParticles();
</script>
@endpush