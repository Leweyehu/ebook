@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div style="text-align: center; margin-bottom: 3rem;">
        <h1 style="font-size: 3rem; color: #333; margin-bottom: 1rem;">About Us</h1>
        <div style="width: 100px; height: 4px; background: #ffc107; margin: 0 auto;"></div>
    </div>

    <!-- Department Building Hero Image -->
    <div style="margin-bottom: 4rem; text-align: center;">
        <img src="{{ asset('images/cs-building.jpg') }}" 
             alt="Mekdela Amba University - Department of Computer Science Building" 
             style="width: 100%; max-height: 500px; object-fit: cover; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
    </div>

    <!-- Department Overview -->
    <section style="margin-bottom: 4rem;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
            <div>
                <h2 style="font-size: 2rem; margin-bottom: 1.5rem;">Department of Computer Science</h2>
                <p style="color: #666; line-height: 1.8; margin-bottom: 1rem;">
                    The Department of Computer Science at Mekedela Amba University is a center of academic excellence 
                    dedicated to the study and advancement of computing. Established in 2010, our department has grown 
                    to become a hub for talented students and dedicated faculty.
                </p>
                <p style="color: #666; line-height: 1.8; margin-bottom: 1rem;">
                    We are committed to providing a rigorous, modern education that equips students with the theoretical 
                    foundations and practical skills necessary for successful careers and advanced study. Our mission is 
                    to foster research that addresses local and global challenges.
                </p>
            </div>
            <div>
                <img src="{{ asset('images/building.jpg') }}" 
                     alt="" 
                     style="width: 100%; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section style="margin-bottom: 4rem;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div style="background: #667eea; color: white; padding: 3rem; border-radius: 10px;">
                <i class="fas fa-bullseye" style="font-size: 3rem; margin-bottom: 1.5rem;"></i>
                <h3 style="font-size: 1.8rem; margin-bottom: 1rem;">Our Mission</h3>
                <p style="line-height: 1.8;">To provide a rigorous, modern education that equips students with the theoretical foundations and practical skills necessary for successful careers and advanced study. We are committed to fostering research that addresses local and global challenges.</p>
            </div>
            <div style="background: #764ba2; color: white; padding: 3rem; border-radius: 10px;">
                <i class="fas fa-eye" style="font-size: 3rem; margin-bottom: 1.5rem;"></i>
                <h3 style="font-size: 1.8rem; margin-bottom: 1rem;">Our Vision</h3>
                <p style="line-height: 1.8;">To be a nationally recognized and internationally connected department, known for producing highly skilled, ethical, and innovative computer science professionals who contribute to the technological advancement of Ethiopia and beyond.</p>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    <section style="margin-bottom: 4rem;">
        <h2 style="text-align: center; font-size: 2.5rem; margin-bottom: 3rem;">Our Core Values</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem;">
            <div style="text-align: center;">
                <div style="background: #ffc107; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <i class="fas fa-star" style="font-size: 2rem; color: #333;"></i>
                </div>
                <h3>Excellence</h3>
            </div>
            <div style="text-align: center;">
                <div style="background: #ffc107; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <i class="fas fa-handshake" style="font-size: 2rem; color: #333;"></i>
                </div>
                <h3>Integrity</h3>
            </div>
            <div style="text-align: center;">
                <div style="background: #ffc107; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <i class="fas fa-lightbulb" style="font-size: 2rem; color: #333;"></i>
                </div>
                <h3>Innovation</h3>
            </div>
            <div style="text-align: center;">
                <div style="background: #ffc107; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <i class="fas fa-users" style="font-size: 2rem; color: #333;"></i>
                </div>
                <h3>Inclusivity</h3>
            </div>
        </div>
    </section>

    <!-- Animated Department Statistics -->
    <section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 4rem 0; border-radius: 10px; margin-bottom: 4rem;">
        <h2 style="text-align: center; font-size: 2.5rem; margin-bottom: 3rem; color: white;">Department by Numbers</h2>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; text-align: center;">
            <div class="stat-item">
                <div class="circular-progress" data-value="112">
                    <div class="progress-circle">
                        <div class="progress-circle-inner">
                            <span class="counter" data-target="112">0</span>
                        </div>
                    </div>
                </div>
                <p style="margin-top: 1rem; font-size: 1.2rem;">Current Students</p>
            </div>
            
            <div class="stat-item">
                <div class="circular-progress" data-value="12">
                    <div class="progress-circle">
                        <div class="progress-circle-inner">
                            <span class="counter" data-target="12">0</span>
                        </div>
                    </div>
                </div>
                <p style="margin-top: 1rem; font-size: 1.2rem;">Staff Members</p>
            </div>
            
            <div class="stat-item">
                <div class="circular-progress" data-value="4">
                    <div class="progress-circle">
                        <div class="progress-circle-inner">
                            <span class="counter" data-target="4">0</span>
                        </div>
                    </div>
                </div>
                <p style="margin-top: 1rem; font-size: 1.2rem;">Computer Labs</p>
            </div>
            
            <div class="stat-item">
                <div class="circular-progress" data-value="200">
                    <div class="progress-circle">
                        <div class="progress-circle-inner">
                            <span class="counter" data-target="200">0</span>
                        </div>
                    </div>
                </div>
                <p style="margin-top: 1rem; font-size: 1.2rem;">Graduated Students</p>
            </div>
        </div>
    </section>

    <!-- Campus Facilities Section -->
    <section style="margin-bottom: 4rem; text-align: center;">
        <h2 style="font-size: 2.5rem; margin-bottom: 2rem;">Our Campus Facilities</h2>
        <p style="color: #666; max-width: 800px; margin: 0 auto 2rem;">Explore our modern campus equipped with state-of-the-art facilities designed to enhance your learning experience.</p>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
            <div>
                <i class="fas fa-laptop" style="font-size: 3rem; color: #667eea; margin-bottom: 1rem;"></i>
                <h3>Computer Labs</h3>
                <p style="color: #666;">Modern computing facilities with latest software</p>
            </div>
            <div>
                <i class="fas fa-book" style="font-size: 3rem; color: #764ba2; margin-bottom: 1rem;"></i>
                <h3>Digital Library</h3>
                <p style="color: #666;">Access to online resources and research materials</p>
            </div>
            <div>
                <i class="fas fa-wifi" style="font-size: 3rem; color: #ffc107; margin-bottom: 1rem;"></i>
                <h3>Campus-wide WiFi</h3>
                <p style="color: #666;">High-speed internet across the campus</p>
            </div>
        </div>
    </section>
</div>

<style>
    .stat-item {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .circular-progress {
        width: 150px;
        height: 150px;
        position: relative;
        margin: 0 auto;
    }
    
    .progress-circle {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .progress-circle::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: conic-gradient(#ffc107 0deg, transparent 0deg);
        transition: all 0.3s;
    }
    
    .progress-circle-inner {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .progress-circle-inner span {
        font-size: 2rem;
        font-weight: 700;
        color: white;
    }
    
    @media (max-width: 768px) {
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        .circular-progress {
            width: 120px;
            height: 120px;
        }
        
        .progress-circle-inner {
            width: 96px;
            height: 96px;
        }
        
        .progress-circle-inner span {
            font-size: 1.6rem;
        }
    }
    
    @media (max-width: 480px) {
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter animation
    const counters = document.querySelectorAll('.counter');
    const speed = 1; // Lower number = faster animation
    
    // Progress circle animation
    const progressItems = document.querySelectorAll('.circular-progress');
    
    const animateCounters = () => {
        counters.forEach(counter => {
            const updateCount = () => {
                const target = parseInt(counter.getAttribute('data-target'));
                const count = parseInt(counter.innerText);
                
                // Calculate increment
                const increment = Math.ceil(target / 50);
                
                if (count < target) {
                    counter.innerText = Math.min(count + increment, target);
                    setTimeout(updateCount, 20);
                } else {
                    counter.innerText = target;
                }
                
                // Update progress circle
                const progressCircle = counter.closest('.circular-progress');
                if (progressCircle) {
                    const percentage = (count / target) * 100;
                    const circle = progressCircle.querySelector('.progress-circle');
                    const degrees = (percentage * 360) / 100;
                    circle.style.background = `conic-gradient(#ffc107 ${degrees}deg, rgba(255,255,255,0.1) ${degrees}deg)`;
                }
            };
            
            updateCount();
        });
    };
    
    // Intersection Observer to trigger animation when section is visible
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    const statsSection = document.querySelector('[style*="linear-gradient(135deg, #667eea"]');
    if (statsSection) {
        observer.observe(statsSection);
    }
});
</script>
@endsection