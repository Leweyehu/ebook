<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Mekedela Amba University - Department of Computer Science">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Mekedela CS') - Dept of Computer Science</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles -->
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
            background: #f8f9fa;
            overflow-x: hidden;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
            width: 100%;
        }
        
        /* Navigation Styles - Professional International Standard */
        .navbar {
            background: #003E72;
            padding: 0.8rem 0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
            width: 100%;
        }
        
        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        
        /* Logo Section - Left aligned */
        .logo {
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }
        
        .logo a {
            display: flex;
            align-items: center;
            text-decoration: none;
            gap: 12px;
        }
        
        .logo-img {
            height: 50px;
            width: auto;
            border-radius: 6px;
            object-fit: contain;
            background: white;
            padding: 4px;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .logo-img:hover {
            transform: scale(1.05);
        }
        
        .logo-text {
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            line-height: 1.2;
            letter-spacing: 0.3px;
        }
        
        .logo-text span {
            font-size: 0.8rem;
            display: block;
            font-weight: 400;
            color: rgba(255,255,255,0.9);
            letter-spacing: 0.3px;
            margin-top: 2px;
        }
        
        /* Fallback Logo Styles */
        .logo-fallback {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .logo-acronym {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #ffc107, #ff9800);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.2rem;
            color: #003E72;
            transition: transform 0.3s;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        
        .logo-acronym span {
            display: block;
            font-weight: 700;
        }
        
        .logo:hover .logo-acronym {
            transform: rotate(10deg);
        }
        
        /* Navigation Wrapper */
        .nav-wrapper {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        /* Main Navigation Menu */
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 1.5rem;
            align-items: center;
            margin: 0;
            padding: 0;
        }
        
        .nav-menu li {
            position: relative;
        }
        
        .nav-menu a, .nav-menu button {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 0;
            transition: all 0.2s ease;
            position: relative;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
            display: inline-block;
            background: none;
            border: none;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            white-space: nowrap;
            text-transform: capitalize;
        }
        
        .nav-menu a:hover,
        .nav-menu a.active,
        .nav-menu button:hover {
            color: #ffc107;
        }
        
        .nav-menu a.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: #ffc107;
            border-radius: 3px 3px 0 0;
        }
        
        /* Special Buttons */
        .nav-menu .login-link {
            background: #ffc107;
            color: #003E72;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
            text-transform: capitalize;
            white-space: nowrap;
            border: none;
        }
        
        .nav-menu .login-link:hover {
            background: #ffca2c;
            color: #003E72;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }
        
        .nav-menu .dashboard-link {
            background: #28a745;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
            text-transform: capitalize;
            white-space: nowrap;
            border: none;
        }
        
        .nav-menu .dashboard-link:hover {
            background: #34ce57;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }
        
        .role-badge {
            background: rgba(255,255,255,0.2);
            padding: 0.2rem 0.5rem;
            border-radius: 20px;
            font-size: 0.7rem;
            margin-left: 0.4rem;
            color: #ffc107;
            font-weight: 600;
            text-transform: uppercase;
            white-space: nowrap;
        }
        
        .admin-panel-btn {
            background: #ffc107;
            color: #003E72;
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            white-space: nowrap;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        
        .admin-panel-btn:hover {
            background: #ffca2c;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }
        
        .admin-panel-btn i {
            font-size: 0.85rem;
        }
        
        /* Mobile Toggle - Hidden by default */
        .mobile-toggle {
            display: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            background: rgba(255,255,255,0.1);
            width: 40px;
            height: 40px;
            border-radius: 8px;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        
        .mobile-toggle:hover {
            background: rgba(255,255,255,0.2);
        }
        
        /* Footer Styles */
        .footer {
            background: #003E72;
            color: white;
            padding: 3rem 0 1.5rem;
            margin-top: 4rem;
            width: 100%;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .footer-section h3 {
            color: #ffc107;
            margin-bottom: 1rem;
            font-size: 1.2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        .footer-section ul {
            list-style: none;
        }
        
        .footer-section ul li {
            margin-bottom: 0.7rem;
        }
        
        .footer-section ul li i {
            color: #ffc107;
            margin-right: 0.5rem;
            width: 20px;
        }
        
        .footer-section a {
            color: #ecf0f1;
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 400;
            font-size: 0.95rem;
            word-break: break-word;
        }
        
        .footer-section a:hover {
            color: #ffc107;
            transform: translateX(5px);
            display: inline-block;
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }
        
        .social-links a {
            color: white;
            background: rgba(255,255,255,0.15);
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            font-size: 1rem;
        }
        
        .social-links a:hover {
            background: #ffc107;
            color: #003E72;
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 2px solid rgba(255,255,255,0.1);
            font-size: 0.9rem;
            color: #ecf0f1;
        }
        
        .footer-bottom a {
            color: #ffc107;
            text-decoration: none;
            font-weight: 600;
        }
        
        .footer-bottom a:hover {
            text-decoration: underline;
        }
        
        /* Main Content Styles */
        .main-content {
            min-height: calc(100vh - 400px);
            padding: 3rem 0;
            width: 100%;
            overflow-x: hidden;
        }
        
        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, #003E72 0%, #002b4f 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
            text-align: center;
            width: 100%;
        }
        
        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
            word-wrap: break-word;
        }
        
        .page-header p {
            font-size: 1.1rem;
            opacity: 0.95;
            word-wrap: break-word;
        }
        
        /* Dashboard specific styles */
        .dashboard-welcome {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .dashboard-logout {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255,255,255,0.3);
        }
        
        .dashboard-logout:hover {
            background: #dc3545;
            color: white;
            border-color: #dc3545;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(220,53,69,0.3);
        }
        
        .stat-card {
            padding: 1.5rem;
            border-radius: 10px;
            color: white;
            text-align: center;
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .management-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s;
        }
        
        .management-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .icon-circle {
            background: #ffc107;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }
        
        .icon-circle i {
            font-size: 2.5rem;
            color: #1a2b3c;
        }
        
        .btn-view {
            background: #ffc107;
            color: #1a2b3c;
            padding: 0.5rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
        }
        
        .btn-create {
            background: #28a745;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
        }
        
        .btn-template {
            background: #17a2b8;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
        }
        
        .unread-badge {
            background: #dc3545;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-weight: 600;
        }
        
        /* Mobile Responsive Styles */
        @media (max-width: 1200px) {
            .nav-menu {
                gap: 1.2rem;
            }
            
            .nav-menu a, .nav-menu button {
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 992px) {
            .container {
                padding: 0 20px;
            }
            
            .nav-menu {
                gap: 1rem;
            }
            
            .nav-menu a, .nav-menu button {
                font-size: 0.85rem;
            }
            
            .logo-text {
                font-size: 1rem;
            }
            
            .logo-text span {
                font-size: 0.75rem;
            }
            
            .logo-img {
                height: 45px;
            }
            
            .admin-panel-btn {
                padding: 0.4rem 1rem;
                font-size: 0.8rem;
            }
        }
        
        @media (max-width: 768px) {
            .navbar {
                padding: 0.6rem 0;
            }
            
            .container {
                padding: 0 15px;
            }
            
            .logo-img {
                height: 40px;
            }
            
            .logo-text {
                font-size: 0.9rem;
            }
            
            .logo-text span {
                font-size: 0.7rem;
            }
            
            .logo-acronym {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
            
            /* Mobile toggle visible */
            .mobile-toggle {
                display: flex;
            }
            
            .nav-wrapper {
                position: static;
            }
            
            .nav-menu {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: #003E72;
                flex-direction: column;
                padding: 1rem;
                gap: 0.5rem;
                width: 100%;
                max-width: 100%;
                border-radius: 0;
                box-shadow: 0 10px 20px rgba(0,0,0,0.2);
                border-top: 1px solid rgba(255,255,255,0.1);
                z-index: 999;
            }
            
            .nav-menu.active {
                display: flex;
            }
            
            .nav-menu li {
                width: 100%;
            }
            
            .nav-menu a, .nav-menu button {
                font-size: 1rem;
                padding: 0.8rem 1rem;
                display: block;
                width: 100%;
                text-align: left;
                border-radius: 6px;
                white-space: normal;
                word-wrap: break-word;
            }
            
            .nav-menu a:hover {
                background: rgba(255,255,255,0.1);
            }
            
            .nav-menu a.active::after {
                display: none;
            }
            
            .nav-menu .login-link,
            .nav-menu .dashboard-link {
                margin-left: 0;
                width: 100%;
                text-align: center;
                padding: 0.8rem 1rem;
                white-space: normal;
            }
            
            .admin-panel-btn {
                margin: 0.5rem 0 0;
                width: 100%;
                justify-content: center;
                padding: 0.8rem;
            }
            
            .role-badge {
                display: inline-block;
                margin-left: 0.5rem;
            }
            
            /* Footer responsive */
            .footer-content {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .footer-section {
                text-align: center;
            }
            
            .footer-section ul li {
                text-align: center;
            }
            
            .footer-section ul li i {
                display: inline-block;
                margin-right: 0.5rem;
            }
            
            .social-links {
                justify-content: center;
            }
            
            /* Page header responsive */
            .page-header {
                padding: 2rem 1rem;
            }
            
            .page-header h1 {
                font-size: 2rem;
            }
            
            .page-header p {
                font-size: 1rem;
            }
            
            /* Dashboard responsive */
            .dashboard-welcome {
                flex-direction: column;
                text-align: center;
                padding: 1.5rem;
            }
            
            .dashboard-logout {
                width: 100%;
                justify-content: center;
            }
            
            /* Grid adjustments */
            [style*="grid-template-columns: repeat(3, 1fr)"] {
                grid-template-columns: 1fr !important;
            }
            
            [style*="grid-template-columns: repeat(4, 1fr)"] {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }
        
        @media (max-width: 576px) {
            [style*="grid-template-columns: repeat(4, 1fr)"] {
                grid-template-columns: 1fr !important;
            }
            
            .logo a {
                gap: 8px;
            }
            
            .logo-img {
                height: 35px;
            }
            
            .logo-text {
                font-size: 0.85rem;
            }
            
            .logo-text span {
                font-size: 0.65rem;
            }
            
            .nav-menu {
                max-height: 80vh;
                overflow-y: auto;
            }
            
            .footer-section h3 {
                font-size: 1.1rem;
            }
            
            .footer-section a {
                font-size: 0.9rem;
            }
            
            .page-header h1 {
                font-size: 1.8rem;
            }
            
            .page-header p {
                font-size: 0.95rem;
            }
        }
        
        @media (max-width: 375px) {
            .logo-img {
                height: 30px;
            }
            
            .logo-text {
                font-size: 0.75rem;
            }
            
            .logo-text span {
                font-size: 0.6rem;
            }
            
            .mobile-toggle {
                width: 35px;
                height: 35px;
                font-size: 1.2rem;
            }
            
            .nav-menu a, .nav-menu button {
                font-size: 0.9rem;
                padding: 0.7rem;
            }
            
            .nav-menu .login-link,
            .nav-menu .dashboard-link {
                font-size: 0.85rem;
                padding: 0.7rem;
            }
            
            .footer-section h3 {
                font-size: 1rem;
            }
            
            .footer-section a {
                font-size: 0.85rem;
            }
            
            .social-links a {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <a href="{{ route('home') }}">
                    @php
                        $logoFiles = [
                            'mekdela-amba-university-logo.jpg',
                            'mekdela-amba-university-logo.png',
                            'mau-logo.jpg',
                            'mau-logo.png',
                            'mekdela-logo.jpg',
                            'mekdela-logo.png',
                            'university-logo.jpg',
                            'logo.jpg',
                            'logo.png'
                        ];
                        
                        $logoFound = false;
                        $logoPath = '';
                        
                        foreach($logoFiles as $file) {
                            if(file_exists(public_path('images/' . $file))) {
                                $logoFound = true;
                                $logoPath = 'images/' . $file;
                                break;
                            }
                        }
                    @endphp
                    
                    @if($logoFound)
                        <img src="{{ asset($logoPath) }}" 
                             alt="Mekdela Amba University Logo" 
                             class="logo-img"
                             id="university-logo"
                             onerror="this.style.display='none'; document.getElementById('logo-fallback-container').style.display='flex';">
                        
                        <div class="logo-text">
                            Mekdela Amba University
                            <span>Department of Computer Science</span>
                        </div>
                        
                        <div id="logo-fallback-container" class="logo-fallback" style="display: none;">
                            <div class="logo-acronym">
                                <span>MAU</span>
                            </div>
                            <div class="logo-text">
                                Mekdela Amba University
                                <span>Computer Science</span>
                            </div>
                        </div>
                    @else
                        <div class="logo-fallback">
                            <div class="logo-acronym">
                                <span>MAU</span>
                            </div>
                            <div class="logo-text">
                                Mekdela Amba University
                                <span>Department of Computer Science</span>
                            </div>
                        </div>
                    @endif
                </a>
            </div>
            
            <div class="nav-wrapper">
                <div class="mobile-toggle" onclick="toggleMenu()">
                    <i class="fas fa-bars"></i>
                </div>
                
                <ul class="nav-menu" id="navMenu">
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
                    <li><a href="{{ route('programs') }}" class="{{ request()->routeIs('programs') ? 'active' : '' }}">Programs</a></li>
                    <li><a href="{{ route('program-courses') }}" class="{{ request()->routeIs('program-courses') ? 'active' : '' }}">Program Courses</a></li>
                    <li><a href="{{ route('staff') }}" class="{{ request()->routeIs('staff') ? 'active' : '' }}">Staff</a></li>
                    <li><a href="{{ route('news') }}" class="{{ request()->routeIs('news') ? 'active' : '' }}">News</a></li>
                    <li><a href="{{ route('students') }}" class="{{ request()->routeIs('students') ? 'active' : '' }}">Students</a></li>
                    <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
                    
                    @guest
                        <li>
                            <a href="{{ route('login') }}" class="login-link {{ request()->routeIs('login') ? 'active' : '' }}">
                                Login
                            </a>
                        </li>
                    @else
                        <li>
                            @php
                                $dashboardRoute = match(Auth::user()->role) {
                                    'admin' => route('admin.dashboard'),
                                    'staff' => route('staff.dashboard'),
                                    'student' => route('student.dashboard'),
                                    default => '#'
                                };
                                $roleName = ucfirst(Auth::user()->role);
                            @endphp
                            
                            <a href="{{ $dashboardRoute }}" class="dashboard-link {{ request()->routeIs('*.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                                <span class="role-badge">{{ $roleName }}</span>
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" style="background: none; border: none; color: white; cursor: pointer; padding: 0.4rem 0; font-size: 0.8rem;">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    @endguest
                </ul>
                
                @auth
                    @if(Auth::user()->role === 'admin')
                        <div style="display: flex; align-items: center;">
                            <a href="{{ route('admin.staff.index') }}" class="admin-panel-btn">
                                <i class="fas fa-cog"></i> Manage Staff
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> Mekedela Amba University, South Wollo, Ethiopia</li>
                        <li><i class="fas fa-phone"></i> +251-988-322-475</li>
                        <li><i class="fas fa-envelope"></i> cs@mau.edu.et</li>
                        <li><i class="fas fa-globe"></i> www.mau.edu.et/cs</li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('programs') }}">Academic Programs</a></li>
                        <li><a href="{{ route('program-courses') }}">Program Courses</a></li>
                        <li><a href="{{ route('staff') }}">Our Staff</a></li>
                        <li><a href="{{ route('students') }}">Students</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="http://172.16.0.21/">Student Portal</a></li>
                        <li><a href="https://mkau.edu.et/wordpress_e/?page_id=2127">Library</a></li>
                        <li><a href="https://courses.mkau.edu.et/">E-Learning</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Resources</h3>
                    <ul>
                        <li><a href="{{ route('students') }}">Students</a></li>
                        <li><a href="#">Publications</a></li>
                        <li><a href="#">Labs</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Follow Us</h3>
                    <p style="margin-bottom: 1rem; color: #ecf0f1;">Stay connected through our social media channels</p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/Mekdela.Amba.University"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://x.com/mekdela_amba"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://t.me/+BS-_eELl6QJmZjVk"><i class="fab fa-telegram-plane"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Mekedela Amba University - Department of Computer Science. All rights reserved. | 
                <a href="#">Privacy Policy</a> | 
                <a href="#">Terms of Use</a></p>
            </div>
        </div>
    </footer>

    <!-- JavaScript for mobile menu -->
    <script>
        function toggleMenu() {
            const navMenu = document.getElementById('navMenu');
            navMenu.classList.toggle('active');
        }

        document.addEventListener('click', function(event) {
            const navMenu = document.getElementById('navMenu');
            const toggle = document.querySelector('.mobile-toggle');
            
            if (navMenu && toggle && !navMenu.contains(event.target) && !toggle.contains(event.target)) {
                navMenu.classList.remove('active');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const currentLocation = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-menu a, .nav-menu button');
            
            navLinks.forEach(link => {
                const linkPath = link.getAttribute('href');
                if (linkPath && (currentLocation === linkPath || 
                    (currentLocation === '/' && linkPath === '{{ route('home') }}'))) {
                    link.classList.add('active');
                }
            });
        });

        window.addEventListener('load', function() {
            const logo = document.getElementById('university-logo');
            if (logo) {
                logo.addEventListener('error', function() {
                    this.style.display = 'none';
                    document.getElementById('logo-fallback-container').style.display = 'flex';
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>