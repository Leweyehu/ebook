<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ Auth::id() }}">
    <meta name="user-name" content="{{ Auth::user()->name }}">
    <meta name="user-role" content="{{ Auth::user()->role }}">
    <meta name="user-initials" content="{{ Auth::user()->initials }}">
    <meta name="user-avatar" content="{{ Auth::user()->profile_photo_url }}">
    <title>Staff Dashboard - Mekedela Amba University</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f0f2f5;
            color: #333;
        }
        
        /* Header */
        .main-header {
            background: linear-gradient(135deg, #1a2b3c 0%, #2c3e50 100%);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .logo-area h1 {
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        .logo-area span {
            color: #ffc107;
            font-size: 0.9rem;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        /* Chat Icon with Badge */
        .chat-icon-wrapper {
            position: relative;
            display: inline-block;
        }
        
        .chat-icon {
            background: rgba(255,255,255,0.15);
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            transition: all 0.3s;
            text-decoration: none;
            border: 2px solid transparent;
        }
        
        .chat-icon:hover {
            background: #ffc107;
            color: #1a2b3c;
            transform: scale(1.1);
            border-color: white;
        }
        
        .chat-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 0.2rem 0.5rem;
            font-size: 0.7rem;
            font-weight: 600;
            min-width: 20px;
            text-align: center;
            border: 2px solid #1a2b3c;
        }
        
        .user-info {
            text-align: right;
        }
        
        .user-name {
            font-weight: 600;
        }
        
        .user-role {
            font-size: 0.8rem;
            color: #ffc107;
        }
        
        .logout-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1.2rem;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .logout-btn:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(220,53,69,0.3);
        }
        
        /* Main Container */
        .main-container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        /* Welcome Card */
        .welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(102,126,234,0.3);
        }
        
        .welcome-content {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        
        .profile-circle {
            width: 80px;
            height: 80px;
            background: #ffc107;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid white;
        }
        
        .profile-circle span {
            font-size: 2rem;
            color: #1a2b3c;
            font-weight: bold;
        }
        
        .welcome-text h2 {
            font-size: 2rem;
            margin-bottom: 0.3rem;
        }
        
        .quick-links {
            margin-top: 1rem;
        }
        
        .quick-links a {
            color: #ffc107;
            text-decoration: none;
            margin-right: 1.5rem;
            font-size: 0.95rem;
        }
        
        .quick-links a:hover {
            text-decoration: underline;
        }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 1.8rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .stat-card i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
        }
        
        .stat-label {
            color: #666;
            font-size: 0.95rem;
        }
        
        /* Academic Year Badge */
        .academic-year-badge {
            display: inline-block;
            background: #e9ecef;
            padding: 0.3rem 1rem;
            border-radius: 20px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        .current-year-badge {
            background: #28a745;
            color: white;
        }
        
        /* Course Cards */
        .course-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s;
        }
        
        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .course-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.5rem;
            color: white;
        }
        
        .course-header h3 {
            margin-bottom: 0.5rem;
        }
        
        .role-badge {
            background: #ffc107;
            color: #1a2b3c;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .course-body {
            padding: 1.5rem;
        }
        
        .course-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            color: #666;
        }
        
        .course-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .btn-view {
            flex: 1;
            background: #667eea;
            color: white;
            padding: 0.75rem;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .btn-view:hover {
            background: #5a67d8;
            transform: translateY(-2px);
        }
        
        .btn-students {
            flex: 1;
            background: #ffc107;
            color: #1a2b3c;
            padding: 0.75rem;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .btn-students:hover {
            background: #ffca2c;
            transform: translateY(-2px);
        }
        
        /* Action Cards */
        .section-title {
            font-size: 1.8rem;
            color: #1a2b3c;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: #ffc107;
        }
        
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        
        .action-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            text-decoration: none;
            color: #1a2b3c;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s;
        }
        
        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .action-card i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .action-card h3 {
            margin-bottom: 0.5rem;
        }
        
        .action-card p {
            color: #666;
            font-size: 0.9rem;
        }
        
        /* Two Column Layout */
        .two-column {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .activity-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .activity-header {
            font-size: 1.3rem;
            color: #1a2b3c;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
        }
        
        .activity-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .badge-warning {
            background: #ffc107;
            color: #1a2b3c;
        }
        
        .badge-success {
            background: #28a745;
            color: white;
        }
        
        .badge-danger {
            background: #dc3545;
            color: white;
        }
        
        .badge-info {
            background: #17a2b8;
            color: white;
        }
        
        /* Chat Notification */
        .chat-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            padding: 1rem;
            z-index: 9999;
            max-width: 350px;
            animation: slideIn 0.3s ease;
            border-left: 4px solid #ffc107;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .chat-notification-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .chat-notification-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ffc107;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a2b3c;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .chat-notification-text {
            flex: 1;
        }
        
        .chat-notification-sender {
            font-weight: 600;
            color: #1a2b3c;
            margin-bottom: 0.2rem;
        }
        
        .chat-notification-message {
            color: #666;
            font-size: 0.9rem;
        }
        
        .chat-notification-close {
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            font-size: 1.2rem;
            padding: 0 0.5rem;
        }
        
        .chat-notification-close:hover {
            color: #dc3545;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .two-column {
                grid-template-columns: 1fr;
            }
            
            .welcome-content {
                flex-direction: column;
                text-align: center;
            }
            
            .main-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .user-menu {
                flex-direction: column;
                gap: 1rem;
            }
            
            .chat-notification {
                left: 20px;
                right: 20px;
                max-width: none;
            }
        }
        
        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .main-container {
                padding: 1rem;
            }
            
            .course-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <div class="logo-area">
            <h1>Mekedela Amba University</h1>
            <span>Department of Computer Science - Staff Panel</span>
        </div>
        
        <div class="user-menu">
            <!-- Chat Icon -->
            <a href="{{ route('chat.index') }}" class="chat-icon-wrapper" title="Messages">
                <div class="chat-icon">
                    <i class="fas fa-comment"></i>
                </div>
                <span class="chat-badge" id="unread-messages-badge" style="display: none;">0</span>
            </a>
            
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">{{ ucfirst(Auth::user()->role) }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </header>
    
    <!-- Chat Notification Container -->
    <div id="chat-notification-container"></div>
    
    <!-- Main Content -->
    <div class="main-container">
        <!-- Welcome Card -->
        @php
            $staff = \App\Models\Staff::where('email', Auth::user()->email)->first();
            $currentAcademicYear = date('Y') . '/' . (date('Y')+1);
        @endphp
        
        <div class="welcome-card">
            <div class="welcome-content">
                @if($staff && $staff->image)
                    <img src="{{ asset($staff->image) }}" alt="{{ $staff->name }}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #ffc107;">
                @else
                    <div class="profile-circle">
                        <span>{{ Auth::user()->initials }}</span>
                    </div>
                @endif
                <div class="welcome-text">
                    <h2>Welcome, {{ Auth::user()->name }}!</h2>
                    <p>{{ $staff->position ?? 'Staff Member' }} | {{ $staff->qualification ?? '' }}</p>
                    <div class="quick-links">
                        <a href="{{ route('staff.profile.edit') }}"><i class="fas fa-user-edit"></i> Edit Profile</a>
                        <a href="{{ route('staff.password.change') }}"><i class="fas fa-key"></i> Change Password</a>
                        <a href="{{ route('messages.index') }}"><i class="fas fa-envelope"></i> Messages</a>
                        <a href="{{ route('chat.index') }}"><i class="fas fa-comment"></i> Chat <span id="quick-chat-badge" style="display: none;">(New)</span></a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-book" style="color: #667eea;"></i>
                <div class="stat-number">{{ $stats['total_courses'] ?? 0 }}</div>
                <div class="stat-label">My Assigned Courses</div>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-users" style="color: #f093fb;"></i>
                <div class="stat-number">{{ $stats['total_students'] ?? 0 }}</div>
                <div class="stat-label">My Students</div>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-clock" style="color: #4facfe;"></i>
                <div class="stat-number">{{ $stats['pending_grading'] ?? 0 }}</div>
                <div class="stat-label">Pending Grading</div>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-bullhorn" style="color: #43e97b;"></i>
                <div class="stat-number">{{ $stats['active_notices'] ?? 0 }}</div>
                <div class="stat-label">Active Notices</div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <h2 class="section-title">Quick Actions</h2>
        <div class="actions-grid">
            <a href="{{ route('staff.courses.index') }}" class="action-card">
                <i class="fas fa-book" style="color: #667eea;"></i>
                <h3>My Courses</h3>
                <p>View and manage your assigned courses</p>
            </a>
            
            <a href="{{ route('chat.index') }}" class="action-card" id="chat-action-card">
                <i class="fas fa-comment" style="color: #28a745;"></i>
                <h3>Live Chat <span id="action-chat-badge" style="display: none; background: #dc3545; color: white; padding: 0.1rem 0.5rem; border-radius: 10px; font-size: 0.8rem;">New</span></h3>
                <p>Real-time chat with students</p>
            </a>
            
            <a href="{{ route('messages.index') }}" class="action-card">
                <i class="fas fa-envelope" style="color: #17a2b8;"></i>
                <h3>Messages</h3>
                <p>Communicate with students</p>
            </a>
            
            <a href="{{ route('staff.news.index') }}" class="action-card">
                <i class="fas fa-newspaper" style="color: #ffc107;"></i>
                <h3>News</h3>
                <p>View department news</p>
            </a>
            
            <a href="{{ route('staff.profile.edit') }}" class="action-card">
                <i class="fas fa-user-cog" style="color: #6f42c1;"></i>
                <h3>My Profile</h3>
                <p>Update your profile</p>
            </a>
        </div>
        
        <!-- Two Column Section -->
        <div class="two-column">
            <!-- Recent Submissions -->
            <div class="activity-card">
                <div class="activity-header">
                    <i class="fas fa-clock" style="color: #667eea;"></i> Pending Submissions
                </div>
                @forelse($recentSubmissions ?? [] as $submission)
                    <div class="activity-item">
                        <div>
                            <strong>{{ $submission->student->name ?? 'N/A' }}</strong>
                            <div style="color: #666; font-size: 0.9rem;">{{ $submission->assignment->title ?? 'N/A' }} - {{ $submission->assignment->course->course_code ?? '' }}</div>
                        </div>
                        <div style="text-align: right;">
                            <div style="color: #999; font-size: 0.8rem;">{{ $submission->submitted_at->diffForHumans() }}</div>
                            <a href="{{ route('staff.assignments.grade', $submission) }}" class="badge badge-warning" style="text-decoration: none; display: inline-block; margin-top: 0.3rem;">Grade</a>
                        </div>
                    </div>
                @empty
                    <p style="color: #999; text-align: center; padding: 2rem;">No pending submissions</p>
                @endforelse
            </div>
            
            <!-- Recent Notices -->
            <div class="activity-card">
                <div class="activity-header">
                    <i class="fas fa-bullhorn" style="color: #ffc107;"></i> Recent Notices
                </div>
                @forelse($recentNotices ?? [] as $notice)
                    <div class="activity-item">
                        <div>
                            <strong>{{ $notice->title }}</strong>
                            <div style="color: #666; font-size: 0.9rem;">{{ $notice->course->course_code ?? '' }}</div>
                        </div>
                        <div style="color: #999; font-size: 0.8rem;">
                            {{ $notice->created_at->diffForHumans() }}
                        </div>
                    </div>
                @empty
                    <p style="color: #999; text-align: center; padding: 2rem;">No recent notices</p>
                @endforelse
            </div>
        </div>
        
        <!-- My Assigned Courses by Academic Year -->
        <h2 class="section-title">My Assigned Courses</h2>
        
        @forelse($coursesByYear ?? [] as $academicYear => $courses)
            <div style="margin-bottom: 3rem;">
                <div class="academic-year-badge {{ $academicYear === $currentAcademicYear ? 'current-year-badge' : '' }}">
                    <i class="fas fa-calendar-alt"></i> Academic Year: {{ $academicYear }}
                    @if($academicYear === $currentAcademicYear)
                        <span style="margin-left: 0.5rem;">(Current)</span>
                    @endif
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem;">
                    @foreach($courses as $course)
                        <div class="course-card">
                            <div class="course-header">
                                <div style="display: flex; justify-content: space-between; align-items: start;">
                                    <div>
                                        <h3>{{ $course->course_code }}</h3>
                                        <p style="opacity: 0.9;">{{ $course->course_name }}</p>
                                    </div>
                                    <span class="role-badge">
                                        {{ ucfirst($course->pivot->role ?? 'Instructor') }}
                                    </span>
                                </div>
                            </div>
                            <div class="course-body">
                                <div class="course-stats">
                                    <span>
                                        <i class="fas fa-users" style="color: #667eea;"></i> 
                                        <strong>{{ $course->students_count ?? 0 }}</strong> Students
                                    </span>
                                    <span>
                                        <i class="fas fa-calendar" style="color: #ffc107;"></i> 
                                        {{ $course->semester ?? 'N/A' }}
                                    </span>
                                </div>
                                <div class="course-stats">
                                    <span>
                                        <i class="fas fa-clock" style="color: #4facfe;"></i> 
                                        {{ $course->credit_hours ?? 0 }} Credits
                                    </span>
                                    <span>
                                        <i class="fas fa-layer-group" style="color: #43e97b;"></i> 
                                        Year {{ $course->year ?? 'N/A' }}
                                    </span>
                                </div>
                                <p style="color: #666; margin: 1rem 0;">{{ Str::limit($course->description ?? 'No description available.', 100) }}</p>
                                <div class="course-actions">
                                    <a href="{{ route('staff.courses.show', $course) }}" class="btn-view">
                                        <i class="fas fa-eye"></i> View Course
                                    </a>
                                    <a href="{{ route('staff.courses.students', $course) }}" class="btn-students">
                                        <i class="fas fa-users"></i> Students
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 4rem; background: white; border-radius: 10px;">
                <i class="fas fa-book-open" style="font-size: 4rem; color: #6c757d; margin-bottom: 1rem;"></i>
                <h3 style="color: #1a2b3c; margin-bottom: 0.5rem;">No Courses Assigned</h3>
                <p style="color: #6c757d; font-size: 1.1rem;">You haven't been assigned any courses yet.</p>
                <p style="color: #999; margin-top: 1rem;">Once admin assigns courses to you, they will appear here grouped by academic year.</p>
            </div>
        @endforelse
    </div>

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    
    <script>
        // Pass user data to JavaScript
        window.userId = {{ Auth::id() }};
        window.userName = "{{ Auth::user()->name }}";
        window.userRole = "{{ Auth::user()->role }}";
        window.userInitials = "{{ Auth::user()->initials }}";
        
        // Function to update unread messages count
        function updateUnreadCount() {
            fetch('/chat/api/unread-count', {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.count > 0) {
                    document.getElementById('unread-messages-badge').style.display = 'inline';
                    document.getElementById('unread-messages-badge').textContent = data.count;
                    
                    document.getElementById('quick-chat-badge').style.display = 'inline';
                    document.getElementById('action-chat-badge').style.display = 'inline';
                } else {
                    document.getElementById('unread-messages-badge').style.display = 'none';
                    document.getElementById('quick-chat-badge').style.display = 'none';
                    document.getElementById('action-chat-badge').style.display = 'none';
                }
            })
            .catch(error => console.error('Error fetching unread count:', error));
        }
        
        // Update unread count every 30 seconds
        updateUnreadCount();
        setInterval(updateUnreadCount, 30000);
        
        // Listen for new messages via Echo
        document.addEventListener('DOMContentLoaded', function() {
            if (window.Echo) {
                window.Echo.private(`user.${window.userId}`)
                    .listen('.message.sent', (event) => {
                        // Update unread count
                        updateUnreadCount();
                        
                        // Show notification
                        showChatNotification(event);
                    });
            }
        });
        
        // Function to show chat notification
        function showChatNotification(event) {
            const container = document.getElementById('chat-notification-container');
            const notification = document.createElement('div');
            notification.className = 'chat-notification';
            notification.innerHTML = `
                <div class="chat-notification-content">
                    <div class="chat-notification-avatar">${event.sender_initials || 'U'}</div>
                    <div class="chat-notification-text">
                        <div class="chat-notification-sender">${event.sender_name}</div>
                        <div class="chat-notification-message">${event.message.substring(0, 50)}${event.message.length > 50 ? '...' : ''}</div>
                    </div>
                    <button class="chat-notification-close" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            container.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }
    </script>
</body>
</html>