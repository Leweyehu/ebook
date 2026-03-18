<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Student Portal') - Mekedela CS</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f4f7fa;
            color: #333;
        }
        
        .student-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .student-sidebar {
            width: 260px;
            background: #1a2b3c;
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }
        
        .sidebar-header h2 {
            color: #ffc107;
            font-size: 1.2rem;
            margin-bottom: 0.3rem;
        }
        
        .sidebar-header p {
            font-size: 0.8rem;
            opacity: 0.7;
        }
        
        .student-badge {
            background: #ffc107;
            color: #1a2b3c;
            padding: 0.2rem 0.8rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            display: inline-block;
            margin-top: 0.5rem;
        }
        
        .student-nav {
            padding: 1.5rem 0;
        }
        
        .student-nav-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.8rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        
        .student-nav-item:hover,
        .student-nav-item.active {
            background: rgba(255,255,255,0.1);
            color: #ffc107;
            border-left-color: #ffc107;
        }
        
        .student-nav-item i {
            width: 20px;
            font-size: 1.1rem;
        }
        
        .student-nav-divider {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 1rem 1.5rem;
        }
        
        /* Main Content */
        .student-main {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
            background: #f4f7fa;
        }
        
        .student-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e0e5ec;
        }
        
        .student-header h1 {
            font-size: 1.8rem;
            color: #1a2b3c;
        }
        
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        /* Message Notification */
        .message-notification {
            position: relative;
            margin-right: 0.5rem;
        }
        
        .message-icon {
            background: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a2b3c;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .message-icon:hover {
            background: #ffc107;
            transform: translateY(-2px);
        }
        
        .unread-badge {
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
            display: none;
        }
        
        .student-user {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .student-user-info {
            text-align: right;
        }
        
        .student-user-name {
            font-weight: 600;
            color: #1a2b3c;
            font-size: 0.9rem;
        }
        
        .student-user-role {
            font-size: 0.7rem;
            color: #ffc107;
            font-weight: 600;
        }
        
        .student-logout-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .student-logout-btn:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(220,53,69,0.3);
        }
        
        .student-content {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .view-site-btn {
            background: #ffc107;
            color: #1a2b3c;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }
        
        .view-site-btn:hover {
            background: #ffca2c;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(255,193,7,0.3);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .student-sidebar {
                width: 200px;
            }
            
            .student-main {
                margin-left: 200px;
                padding: 1rem;
            }
        }
        
        @media (max-width: 640px) {
            .student-container {
                flex-direction: column;
            }
            
            .student-sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .student-main {
                margin-left: 0;
            }
            
            .header-actions {
                flex-wrap: wrap;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="student-container">
        <!-- Sidebar -->
        <aside class="student-sidebar">
            <div class="sidebar-header">
                <h2>Mekedela Amba University</h2>
                <p>Student Portal</p>
                <span class="student-badge">STUDENT</span>
            </div>
            
            <nav class="student-nav">
                <a href="{{ route('student.dashboard') }}" class="student-nav-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('messages.index') }}" class="student-nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i>
                    <span>Messages</span>
                </a>
                
                <a href="{{ route('student.courses') }}" class="student-nav-item {{ request()->routeIs('student.courses') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    <span>My Courses</span>
                </a>
                
                <a href="{{ route('student.grades') }}" class="student-nav-item {{ request()->routeIs('student.grades') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>My Grades</span>
                </a>
                
                <a href="{{ route('student.assignments', ['course' => 1]) }}" class="student-nav-item {{ request()->routeIs('student.assignments') ? 'active' : '' }}">
                    <i class="fas fa-tasks"></i>
                    <span>Assignments</span>
                </a>
                
                <a href="{{ route('student.notices') }}" class="student-nav-item {{ request()->routeIs('student.notices') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i>
                    <span>Notices</span>
                </a>
                
                <a href="{{ route('student.profile') }}" class="student-nav-item {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>My Profile</span>
                </a>
                
                <div class="student-nav-divider"></div>
                
                <a href="{{ route('home') }}" class="student-nav-item" target="_blank">
                    <i class="fas fa-globe"></i>
                    <span>View Public Site</span>
                </a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="student-main">
            <div class="student-header">
                <h1>@yield('page-title', 'Dashboard')</h1>
                
                <div class="header-actions">
                    <div class="message-notification">
                        <a href="{{ route('messages.index') }}" class="message-icon">
                            <i class="fas fa-envelope"></i>
                        </a>
                        <span id="unread-badge" class="unread-badge">0</span>
                    </div>
                    
                    <a href="{{ route('home') }}" class="view-site-btn" target="_blank">
                        <i class="fas fa-external-link-alt"></i> View Site
                    </a>
                    
                    <div class="student-user">
                        <div class="student-user-info">
                            <div class="student-user-name">{{ Auth::user()->name }}</div>
                            <div class="student-user-role">{{ ucfirst(Auth::user()->role) }}</div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="student-logout-btn">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="student-content">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Function to update unread message count
        function updateUnreadCount() {
            fetch('{{ route("messages.unread-count") }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('unread-badge');
                    if (data.count > 0) {
                        badge.textContent = data.count;
                        badge.style.display = 'inline';
                    } else {
                        badge.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error fetching unread count:', error));
        }

        // Update on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateUnreadCount();
            // Update every 30 seconds
            setInterval(updateUnreadCount, 30000);
        });
    </script>
    
    @stack('scripts')
</body>
</html>