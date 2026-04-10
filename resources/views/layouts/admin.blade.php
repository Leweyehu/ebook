<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Mekedela Amba University - Admin Panel">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin Panel') - Mekedela CS</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/app.css'])
    @stack('styles')
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f4f7fa;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        /* SAFER REMOVAL OF PUBLIC ELEMENTS */
        /* Only hide headers/navs that are NOT part of the admin classes */
        header:not(.admin-header),
        nav:not(.admin-nav),
        .main-header,
        .public-header,
        .navbar:not(.admin-nav) {
            display: none !important;
        }
        
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Admin Sidebar */
        .admin-sidebar {
            width: 260px;
            background: #1a2b3c;
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
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
        
        .admin-badge {
            background: #ffc107;
            color: #1a2b3c;
            padding: 0.2rem 0.8rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            display: inline-block;
            margin-top: 0.5rem;
        }
        
        .admin-nav {
            padding: 1.5rem 0;
        }
        
        .admin-nav-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.8rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        
        .admin-nav-item:hover,
        .admin-nav-item.active {
            background: rgba(255,255,255,0.1);
            color: #ffc107;
            border-left-color: #ffc107;
        }
        
        .admin-nav-item i {
            width: 20px;
            font-size: 1.1rem;
        }
        
        .admin-nav-divider {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 1rem 1.5rem;
        }
        
        /* Main Content Area */
        .admin-main {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
            background: #f4f7fa;
            min-height: 100vh;
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e0e5ec;
            background: transparent;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .admin-header h1 {
            font-size: 1.8rem;
            color: #1a2b3c;
            margin: 0;
        }
        
        .admin-user {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .admin-user-info {
            text-align: right;
        }
        
        .admin-user-name {
            font-weight: 600;
            color: #1a2b3c;
            font-size: 0.9rem;
        }
        
        .admin-user-role {
            font-size: 0.7rem;
            color: #ffc107;
            font-weight: 600;
        }
        
        .admin-logout-btn {
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
        
        .admin-logout-btn i {
            font-size: 0.9rem;
        }
        
        .admin-logout-btn span {
            display: inline-block;
        }
        
        .admin-logout-btn:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(220,53,69,0.3);
        }
        
        .admin-content {
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
        
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        /* Flash Messages */
        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            border-left: 4px solid;
        }
        
        .alert-success { background: #d4edda; color: #155724; border-left-color: #28a745; }
        .alert-danger { background: #f8d7da; color: #721c24; border-left-color: #dc3545; }
        .alert-warning { background: #fff3cd; color: #856404; border-left-color: #ffc107; }
        .alert-info { background: #d1ecf1; color: #0c5460; border-left-color: #17a2b8; }
        
        .back-to-dashboard {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #6c757d;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .back-to-dashboard:hover {
            background: #5a6268;
            color: white;
        }
        
        /* Nav Badge for pending counts */
        .nav-badge {
            background: #dc3545;
            color: white;
            border-radius: 20px;
            padding: 0.2rem 0.6rem;
            font-size: 0.7rem;
            font-weight: 600;
            margin-left: auto;
        }
        
        .nav-badge-warning {
            background: #ffc107;
            color: #1a2b3c;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar { width: 200px; }
            .admin-main { margin-left: 200px; padding: 1rem; }
        }
        
        @media (max-width: 640px) {
            .admin-sidebar { width: 100%; height: auto; position: relative; }
            .admin-main { margin-left: 0; }
            .header-actions { width: 100%; justify-content: space-between; }
            
            .admin-logout-btn span {
                display: none;
            }
            
            .admin-logout-btn {
                padding: 0.5rem 0.8rem;
            }
        }
        
        @media (min-width: 641px) {
            .admin-logout-btn span {
                display: inline-block;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h2>Mekedela Amba University</h2>
                <p>Computer Science Dept</p>
                <span class="admin-badge">ADMIN PANEL</span>
            </div>
            
            <nav class="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.staff.index') }}" class="admin-nav-item {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> <span>Manage Staff</span>
                </a>
                <a href="{{ route('admin.students.index') }}" class="admin-nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate"></i> <span>Manage Students</span>
                </a>
                <a href="{{ route('admin.courses.index') }}" class="admin-nav-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i> <span>Course Management</span>
                </a>
                <a href="{{ route('admin.alumni.index') }}" class="admin-nav-item {{ request()->routeIs('admin.alumni.*') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap"></i> <span>Alumni Management</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="admin-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users-cog"></i> <span>User Management</span>
                </a>
                <a href="{{ route('admin.news.index') }}" class="admin-nav-item {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i> <span>Manage News</span>
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="admin-nav-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> <span>Contact Messages</span>
                </a>
                <a href="{{ route('admin.complaints.index') }}" class="admin-nav-item {{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> <span>Complaints</span>
                </a>
                <a href="{{ route('admin.document-submissions.index') }}" class="admin-nav-item {{ request()->routeIs('admin.document-submissions.*') ? 'active' : '' }}">
                    <i class="fas fa-file-upload"></i> <span>Document Submissions</span>
                </a>
                
                <a href="{{ route('admin.programs.index') }}" class="admin-nav-item {{ request()->routeIs('admin.programs.*') ? 'active' : '' }}">
    <i class="fas fa-book"></i> <span>Program Management</span>
</a>
                <div class="admin-nav-divider"></div>
                
                <a href="{{ route('home') }}" class="admin-nav-item" target="_blank">
                    <i class="fas fa-globe"></i> <span>View Public Site</span>
                </a>
            </nav>
        </aside>
        
        <main class="admin-main">
            <div class="admin-header">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    @if(!request()->routeIs('admin.dashboard'))
                        <a href="{{ route('admin.dashboard') }}" class="back-to-dashboard">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    @endif
                    <h1>@yield('page-title', 'Dashboard')</h1>
                </div>
                
                <div class="header-actions">
                    <a href="{{ route('home') }}" class="view-site-btn" target="_blank">
                        <i class="fas fa-external-link-alt"></i> View Site
                    </a>
                    
                    <div class="admin-user">
                        <div class="admin-user-info">
                            <div class="admin-user-name">{{ Auth::user()->name ?? 'Admin User' }}</div>
                            <div class="admin-user-role">{{ ucfirst(Auth::user()->role ?? 'admin') }}</div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="admin-logout-btn">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            @if(session('success')) 
                <div class="alert alert-success">{{ session('success') }}</div> 
            @endif
            @if(session('error')) 
                <div class="alert alert-danger">{{ session('error') }}</div> 
            @endif
            @if(session('warning')) 
                <div class="alert alert-warning">{{ session('warning') }}</div> 
            @endif
            @if(session('info')) 
                <div class="alert alert-info">{{ session('info') }}</div> 
            @endif
            
            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>
    
    @stack('scripts')
</body>
</html>