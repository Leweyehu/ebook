<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Mekedela Amba University</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/app.css'])
    
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7fa; margin: 0; }
        .student-wrapper { display: flex; min-height: 100vh; }
        
        /* Sidebar */
        .sidebar { width: 260px; background: #1a2b3c; color: white; position: fixed; height: 100vh; z-index: 100; }
        .sidebar-brand { padding: 2rem 1.5rem; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-brand h2 { color: #ffc107; font-size: 1.1rem; margin: 0; text-transform: uppercase; }
        
        .nav-menu { padding: 1.5rem 0; }
        .nav-link { 
            display: flex; align-items: center; gap: 10px; padding: 0.8rem 1.5rem; 
            color: rgba(255,255,255,0.7); text-decoration: none; transition: 0.3s;
            border-left: 4px solid transparent;
        }
        .nav-link:hover, .nav-link.active { 
            background: rgba(255,255,255,0.05); color: #ffc107; border-left-color: #ffc107; 
        }

        /* Main Area */
        .main-content { flex: 1; margin-left: 260px; padding: 2rem; }
        
        .top-bar { 
            display: flex; justify-content: space-between; align-items: center; 
            margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid #dee2e6;
        }

        .user-profile { display: flex; align-items: center; gap: 12px; background: white; padding: 5px 15px; border-radius: 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .user-name { font-weight: 600; font-size: 0.9rem; color: #1a2b3c; }
        
        .btn-logout { background: #dc3545; color: white; border: none; padding: 8px; border-radius: 50%; cursor: pointer; transition: 0.3s; }
        .btn-logout:hover { background: #bd2130; }

        @media (max-width: 992px) {
            .sidebar { width: 80px; }
            .sidebar-brand h2, .nav-link span { display: none; }
            .main-content { margin-left: 80px; }
        }
    </style>
</head>
<body>
    <div class="student-wrapper">
        <aside class="sidebar">
            <div class="sidebar-brand">
                <h2>MAU Portal</h2>
                <small style="opacity: 0.6;">Student Access</small>
            </div>
            <nav class="nav-menu">
                <a href="{{ route('student.dashboard') }}" class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('student.courses') }}" class="nav-link {{ request()->routeIs('student.courses') ? 'active' : '' }}">
                    <i class="fas fa-book"></i> <span>My Courses</span>
                </a>
                <a href="{{ route('student.grades') }}" class="nav-link {{ request()->routeIs('student.grades') ? 'active' : '' }}">
                    <i class="fas fa-poll"></i> <span>Grades</span>
                </a>
                <a href="{{ route('messages.index') }}" class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> <span>Messages</span>
                </a>
                <div style="margin: 1rem 1.5rem; height: 1px; background: rgba(255,255,255,0.1);"></div>
                <a href="{{ route('student.profile') }}" class="nav-link">
                    <i class="fas fa-user-cog"></i> <span>Settings</span>
                </a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="top-bar">
                <h1 style="font-size: 1.5rem; color: #1a2b3c;">@yield('page-title')</h1>
                
                <div class="user-profile">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-logout" title="Logout">
                            <i class="fas fa-power-off"></i>
                        </button>
                    </form>
                </div>
            </header>

            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>