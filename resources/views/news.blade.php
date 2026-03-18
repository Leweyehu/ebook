@extends('layouts.app')

@section('title', 'CS Department News')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div style="text-align: center; margin-bottom: 3rem;">
        <h1 style="font-size: 3rem; color: #333; margin-bottom: 1rem;">Department of Computer Science News</h1>
        <div style="width: 100px; height: 4px; background: #ffc107; margin: 0 auto;"></div>
        <p style="color: #666; margin-top: 1rem; font-size: 1.1rem;">Stay updated with the latest happenings in the Computer Science Department</p>
    </div>

    <!-- Featured News -->
    <section style="margin-bottom: 4rem;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; padding: 3rem; color: white; position: relative; overflow: hidden;">
            <div style="position: relative; z-index: 2;">
                <span style="background: #ffc107; color: #333; padding: 0.5rem 1rem; border-radius: 5px; font-weight: bold; margin-bottom: 1rem; display: inline-block;">FEATURED NEWS</span>
                <h2 style="font-size: 2.5rem; margin: 1rem 0;">Annual CS Research Symposium 2024</h2>
                <p style="font-size: 1.1rem; margin-bottom: 2rem; opacity: 0.9;">Join us for the biggest computer science event of the year featuring keynote speakers from top tech companies and research presentations from our faculty and students.</p>
                <div style="display: flex; gap: 2rem; margin-bottom: 2rem;">
                    <div><i class="far fa-calendar-alt" style="margin-right: 0.5rem;"></i> March 15-17, 2026</div>
                    <div><i class="far fa-clock" style="margin-right: 0.5rem;"></i> 9:00 AM - 5:00 PM</div>
                    <div><i class="fas fa-map-marker-alt" style="margin-right: 0.5rem;"></i> Main Auditorium</div>
                </div>
                <a href="#" style="background: #ffc107; color: #333; padding: 1rem 2rem; border-radius: 5px; text-decoration: none; font-weight: bold; display: inline-block;">Register Now →</a>
            </div>
        </div>
    </section>

    <!-- Latest News Grid -->
    <section style="margin-bottom: 4rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2 style="font-size: 2rem;">Latest News</h2>
            <div style="display: flex; gap: 1rem;">
                <select style="padding: 0.5rem; border: 1px solid #ddd; border-radius: 5px;">
                    <option>All Categories</option>
                    <option>Events</option>
                    <option>Research</option>
                    <option>Achievements</option>
                    <option>Announcements</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
            <!-- News Card 1 -->
            <article style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
                <img src="https://via.placeholder.com/400x200" alt="News Image" style="width: 100%; height: 200px; object-fit: cover;">
                <div style="padding: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <span style="background: #667eea; color: white; padding: 0.25rem 0.75rem; border-radius: 3px; font-size: 0.85rem;">RESEARCH</span>
                        <span style="color: #999; font-size: 0.9rem;">March 1, 2025</span>
                    </div>
                    <a href="#" style="color: #667eea; text-decoration: none; font-weight: bold;">Read More →</a>
                </div>
            </article>

            <!-- News Card 2 -->
            <article style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
                <img src="https://via.placeholder.com/400x200" alt="News Image" style="width: 100%; height: 200px; object-fit: cover;">
                <div style="padding: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <span style="background: #ffc107; color: #333; padding: 0.25rem 0.75rem; border-radius: 3px; font-size: 0.85rem;">EVENT</span>
                        <span style="color: #999; font-size: 0.9rem;">February 28, 2025</span>
                    </div>
                </div>
            </article>

            <!-- News Card 3 -->
            <article style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
                <img src="https://via.placeholder.com/400x200" alt="News Image" style="width: 100%; height: 200px; object-fit: cover;">
            </article>
        </div>
    </section>

    <!-- News by Category -->
    <section style="margin-bottom: 4rem;">
        <h2 style="font-size: 2rem; margin-bottom: 2rem;">News by Category</h2>
        
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            <!-- Left Column - More News -->
            <div>
                <!-- News Item 1 -->
                <div style="display: flex; gap: 1.5rem; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #eee;">
                    <img src="https://via.placeholder.com/150x100" alt="News" style="width: 150px; height: 100px; object-fit: cover; border-radius: 5px;">
                    <div>
                        <div style="display: flex; gap: 1rem; margin-bottom: 0.5rem;">
                            <span style="background: #667eea; color: white; padding: 0.25rem 0.75rem; border-radius: 3px; font-size: 0.85rem;">ANNOUNCEMENT</span>
                            <span style="color: #999;">April 20, 2026</span>
                        </div>
                        <h3 style="margin-bottom: 0.5rem;">New Computer Lab Inauguration</h3>
                        <p style="color: #666;">State-of-the-art laboratory with 50 workstations opened for students.</p>
                        <a href="#" style="color: #667eea; text-decoration: none;">Read More</a>
                    </div>
                </div>

                <!-- News Item 2 -->
                <div style="display: flex; gap: 1.5rem; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #eee;">
                    <img src="https://via.placeholder.com/150x100" alt="News" style="width: 150px; height: 100px; object-fit: cover; border-radius: 5px;">
                    <div>
                        <div style="display: flex; gap: 1rem; margin-bottom: 0.5rem;">
                            <span style="background: #ffc107; color: #333; padding: 0.25rem 0.75rem; border-radius: 3px; font-size: 0.85rem;">SEMINAR</span>
                            <span style="color: #999;">Feb 18, 2025</span>
                        </div>
                        <h3 style="margin-bottom: 0.5rem;">Guest Lecture: Cybersecurity Trends</h3>
                        <p style="color: #666;">Industry expert from Google Ethiopia shares insights on modern security challenges.</p>
                        <a href="#" style="color: #667eea; text-decoration: none;">Read More</a>
                    </div>
                </div>

                <!-- News Item 3 -->
                <div style="display: flex; gap: 1.5rem; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #eee;">
                    <img src="https://via.placeholder.com/150x100" alt="News" style="width: 150px; height: 100px; object-fit: cover; border-radius: 5px;">
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div>
                <!-- Upcoming Events -->
                <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem;">
                    <h3 style="margin-bottom: 1.5rem;">Upcoming Events</h3>
                    <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #ddd;">
                        <div style="font-weight: bold;">CS Career Fair</div>
                        <div style="color: #666; font-size: 0.9rem;">March 20, 2024 • 10:00 AM</div>
                    </div>
                    <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #ddd;">
                        <div style="font-weight: bold;">Python Workshop</div>
                        <div style="color: #666; font-size: 0.9rem;">March 22, 2024 • 2:00 PM</div>
                    </div>
                    <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #ddd;">
                        <div style="font-weight: bold;">Research Seminar</div>
                        <div style="color: #666; font-size: 0.9rem;">March 25, 2024 • 11:00 AM</div>
                    </div>
                    <div>
                        <div style="font-weight: bold;">Alumni Meetup</div>
                        <div style="color: #666; font-size: 0.9rem;">March 30, 2024 • 4:00 PM</div>
                    </div>
                </div>

                <!-- Newsletter Signup -->
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 2rem; border-radius: 10px; color: white;">
                    <h3 style="margin-bottom: 1rem;">Newsletter</h3>
                    <p style="margin-bottom: 1.5rem;">Subscribe to get the latest news delivered to your inbox.</p>
                    <form>
                        <input type="email" placeholder="Your email address" style="width: 100%; padding: 0.75rem; margin-bottom: 1rem; border: none; border-radius: 5px;">
                        <button type="submit" style="width: 100%; background: #ffc107; color: #333; padding: 0.75rem; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Archive Section -->
    <section style="text-align: center; margin: 4rem 0;">
        <a href="#" style="background: transparent; border: 2px solid #667eea; color: #667eea; padding: 1rem 3rem; border-radius: 5px; text-decoration: none; font-weight: bold; display: inline-block; margin-right: 1rem;">View Older News</a>
        <a href="#" style="background: #667eea; color: white; padding: 1rem 3rem; border-radius: 5px; text-decoration: none; font-weight: bold; display: inline-block;">Submit News</a>
    </section>
</div>
@endsection