<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Staff Panel') - Mekedela CS</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f4f7fa; }
        
        .staff-container { display: flex; min-height: 100vh; }
        
        /* Sidebar */
        .staff-sidebar {
            width: 260px;
            background: #1a2b3c;
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }
        
        .sidebar-header h2 { color: #ffc107; font-size: 1.2rem; }
        .sidebar-header p { font-size: 0.8rem; opacity: 0.7; }
        .staff-badge {
            background: #ffc107; color: #1a2b3c; padding: 0.2rem 0.8rem;
            border-radius: 20px; font-size: 0.7rem; font-weight: 700;
            display: inline-block; margin-top: 0.5rem;
        }
        
        .staff-nav { padding: 1.5rem 0; }
        .staff-nav-item {
            display: flex; align-items: center; gap: 0.8rem;
            padding: 0.8rem 1.5rem; color: rgba(255,255,255,0.8);
            text-decoration: none; transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        .staff-nav-item:hover,
        .staff-nav-item.active {
            background: rgba(255,255,255,0.1);
            color: #ffc107;
            border-left-color: #ffc107;
        }
        
        /* Main Content */
        .staff-main {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
        }
        
        .staff-header {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 2rem;
            padding-bottom: 1rem; border-bottom: 1px solid #e0e5ec;
        }
        
        .staff-header h1 { font-size: 1.8rem; color: #1a2b3c; }
        
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
        
        .staff-user {
            display: flex; align-items: center; gap: 1rem;
            background: white; padding: 0.5rem 1rem;
            border-radius: 50px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .staff-user-info { text-align: right; }
        .staff-user-name { font-weight: 600; color: #1a2b3c; }
        .staff-user-role { font-size: 0.7rem; color: #ffc107; font-weight: 600; }
        
        .staff-logout-btn {
            background: #dc3545; color: white; border: none;
            padding: 0.5rem 1rem; border-radius: 50px; cursor: pointer;
            display: flex; align-items: center; gap: 0.5rem;
            font-size: 0.8rem; font-weight: 600; transition: all 0.3s;
        }
        .staff-logout-btn:hover { background: #c82333; transform: translateY(-2px); }
        
        .staff-content {
            background: white; border-radius: 10px;
            padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .view-site-btn {
            background: #ffc107; color: #1a2b3c; padding: 0.5rem 1rem;
            border-radius: 5px; text-decoration: none; font-size: 0.8rem;
            font-weight: 600; display: flex; align-items: center; gap: 0.5rem;
            transition: all 0.3s;
        }
        .view-site-btn:hover { background: #ffca2c; transform: translateY(-2px); }
        
        @media (max-width: 768px) {
            .staff-sidebar { width: 200px; }
            .staff-main { margin-left: 200px; padding: 1rem; }
        }
        @media (max-width: 640px) {
            .staff-container { flex-direction: column; }
            .staff-sidebar { width: 100%; height: auto; position: relative; }
            .staff-main { margin-left: 0; }
            .header-actions { flex-wrap: wrap; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="staff-container">
        <!-- Sidebar -->
        <aside class="staff-sidebar">
            <div class="sidebar-header">
                <h2>Mekedela Amba University</h2>
                <p>Staff Panel</p>
                <span class="staff-badge">STAFF</span>
            </div>
            
            <nav class="staff-nav">
                <a href="{{ route('staff.dashboard') }}" class="staff-nav-item {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('messages.index') }}" class="staff-nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> <span>Messages</span>
                </a>
                <a href="{{ route('staff.courses.index') }}" class="staff-nav-item {{ request()->routeIs('staff.courses.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i> <span>My Courses</span>
                </a>
                <a href="{{ route('staff.news.index') }}" class="staff-nav-item {{ request()->routeIs('staff.news.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i> <span>News</span>
                </a>
                <a href="{{ route('staff.students.index') }}" class="staff-nav-item {{ request()->routeIs('staff.students.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> <span>Students</span>
                </a>
                <a href="{{ route('staff.profile.edit') }}" class="staff-nav-item {{ request()->routeIs('staff.profile.edit') ? 'active' : '' }}">
                    <i class="fas fa-user"></i> <span>My Profile</span>
                </a>
                <div style="height:1px; background:rgba(255,255,255,0.1); margin:1rem 1.5rem;"></div>
                <a href="{{ route('home') }}" class="staff-nav-item" target="_blank">
                    <i class="fas fa-globe"></i> <span>View Site</span>
                </a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="staff-main">
            <div class="staff-header">
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
                    
                    <div class="staff-user">
                        <div class="staff-user-info">
                            <div class="staff-user-name">{{ Auth::user()->name }}</div>
                            <div class="staff-user-role">{{ ucfirst(Auth::user()->role) }}</div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="staff-logout-btn">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="staff-content">
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