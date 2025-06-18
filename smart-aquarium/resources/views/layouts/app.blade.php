<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Smart Aquarium') }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        @push('styles')

        body {
            font-family: 'Poppins', sans-serif;
            color: #1e293b;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Login Container */
        .login-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 400px;
            padding: 0 20px;
            z-index: 1;
        }

        /* Aquarium Background Styles */
        .aquarium-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, #1a237e 0%, #0d47a1 100%);
            z-index: -1;
            overflow: hidden;
        }

        .bubbles {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
            top: 0;
            left: 0;
        }

        .bubbles::before,
        .bubbles::after {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 60%);
            animation: bubble 15s linear infinite;
        }

        .bubbles::after {
            animation-delay: -7.5s;
        }

        /* Water Particles */
        .water-particles {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: float 20s linear infinite;
            box-shadow: 0 0 4px rgba(255, 255, 255, 0.4);
        }

        .particle:nth-child(1) { left: 5%; animation-duration: 15s; animation-delay: 0s; }
        .particle:nth-child(2) { left: 10%; animation-duration: 18s; animation-delay: 1s; }
        .particle:nth-child(3) { left: 15%; animation-duration: 12s; animation-delay: 2s; }
        .particle:nth-child(4) { left: 20%; animation-duration: 16s; animation-delay: 3s; }
        .particle:nth-child(5) { left: 25%; animation-duration: 14s; animation-delay: 4s; }
        .particle:nth-child(6) { left: 30%; animation-duration: 17s; animation-delay: 5s; }
        .particle:nth-child(7) { left: 35%; animation-duration: 13s; animation-delay: 6s; }
        .particle:nth-child(8) { left: 40%; animation-duration: 19s; animation-delay: 7s; }
        .particle:nth-child(9) { left: 45%; animation-duration: 15s; animation-delay: 8s; }
        .particle:nth-child(10) { left: 50%; animation-duration: 16s; animation-delay: 9s; }
        .particle:nth-child(11) { left: 55%; animation-duration: 14s; animation-delay: 10s; }
        .particle:nth-child(12) { left: 60%; animation-duration: 17s; animation-delay: 11s; }
        .particle:nth-child(13) { left: 65%; animation-duration: 13s; animation-delay: 12s; }
        .particle:nth-child(14) { left: 70%; animation-duration: 19s; animation-delay: 13s; }
        .particle:nth-child(15) { left: 75%; animation-duration: 15s; animation-delay: 14s; }
        .particle:nth-child(16) { left: 80%; animation-duration: 16s; animation-delay: 15s; }
        .particle:nth-child(17) { left: 85%; animation-duration: 14s; animation-delay: 16s; }
        .particle:nth-child(18) { left: 90%; animation-duration: 17s; animation-delay: 17s; }
        .particle:nth-child(19) { left: 95%; animation-duration: 13s; animation-delay: 18s; }
        .particle:nth-child(20) { left: 98%; animation-duration: 19s; animation-delay: 19s; }

        @keyframes float {
            0% {
                transform: translateY(100vh) scale(0);
                opacity: 0;
            }
            10% {
                opacity: 0.8;
                transform: translateY(90vh) scale(1);
            }
            90% {
                opacity: 0.8;
                transform: translateY(10vh) scale(1);
            }
            100% {
                transform: translateY(0) scale(0);
                opacity: 0;
            }
        }

        @keyframes bubble {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        /* Fish Styles */
        .fish {
            position: absolute;
            width: 30px;
            height: 20px;
            background-size: contain;
            background-repeat: no-repeat;
            filter: brightness(0.8);
            opacity: 0.7;
            z-index: 1;
        }

        .fish::before {
            content: '';
            position: absolute;
            width: 10px;
            height: 10px;
            background: inherit;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
        }

        .fish-1 {
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 50"><path d="M90,25 C90,25 70,10 50,25 C30,40 10,25 10,25 C10,25 30,40 50,25 C70,10 90,25 90,25 Z" fill="%23FFD700"/></svg>');
            animation: swim 20s linear infinite;
        }

        .fish-2 {
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 50"><path d="M90,25 C90,25 70,10 50,25 C30,40 10,25 10,25 C10,25 30,40 50,25 C70,10 90,25 90,25 Z" fill="%23FF69B4"/></svg>');
            animation: swim 25s linear infinite;
            top: 20%;
        }

        .fish-3 {
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 50"><path d="M90,25 C90,25 70,10 50,25 C30,40 10,25 10,25 C10,25 30,40 50,25 C70,10 90,25 90,25 Z" fill="%234CAF50"/></svg>');
            animation: swim 18s linear infinite;
            top: 40%;
        }

        .fish-4 {
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 50"><path d="M90,25 C90,25 70,10 50,25 C30,40 10,25 10,25 C10,25 30,40 50,25 C70,10 90,25 90,25 Z" fill="%23FF9800"/></svg>');
            animation: swim 22s linear infinite;
            top: 60%;
        }

        .fish-5 {
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 50"><path d="M90,25 C90,25 70,10 50,25 C30,40 10,25 10,25 C10,25 30,40 50,25 C70,10 90,25 90,25 Z" fill="%23E91E63"/></svg>');
            animation: swim 28s linear infinite;
            top: 80%;
        }

        .fish-6 {
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 50"><path d="M90,25 C90,25 70,10 50,25 C30,40 10,25 10,25 C10,25 30,40 50,25 C70,10 90,25 90,25 Z" fill="%2300BCD4"/></svg>');
            animation: swim 23s linear infinite;
            top: 30%;
        }

        @keyframes swim {
            0% {
                transform: translateX(-100%) translateY(0) rotate(0deg);
            }
            25% {
                transform: translateX(-50%) translateY(-20px) rotate(5deg);
            }
            50% {
                transform: translateX(0%) translateY(0) rotate(0deg);
            }
            75% {
                transform: translateX(50%) translateY(20px) rotate(-5deg);
            }
            100% {
                transform: translateX(100%) translateY(0) rotate(0deg);
            }
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, #164e63 100%);
            border: none;
        }
        
        .form-control {
            border: 1px solid #e2e8f0;
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(8, 145, 178, 0.25);
        }
        
        .input-group-text {
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, #164e63 100%);
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(8, 145, 178, 0.3);
        }
        
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        :root {
            --primary: #0891b2;
            --secondary: #06b6d4;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --dark: #0f172a;
            --light: #f8fafc;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f9ff;
            color: #1e293b;
            min-height: 100vh;
        }

        .sidebar {
            background: linear-gradient(135deg, var(--primary) 0%, #164e63 100%);
            color: white;
            height: 100vh;
            position: fixed;
            transition: all 0.3s;
            z-index: 1000;
            width: 280px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            margin-left: 200px;
            padding: 30px;
            padding-left: 90px;
            transition: all 0.3s;
            min-height: 100vh;
        }

        /* Mobile Toggle Button */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: var(--primary);
            border: none;
            color: white;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        @media (max-width: 991.98px) {
            .mobile-toggle {
                display: block;
            }

            .sidebar {
                margin-left: -280px;
            }
            .sidebar.active {
                margin-left: 0;
            }
            .main-content {
                margin-left: 0;
                padding: 20px;
                padding-top: 70px;
            }
            .main-content.active {
                margin-left: 280px;
            }
        }

        .sidebar-header {
            padding: 20px;
            margin-top: auto;
            background: rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-header img {
            width: 40px;
            margin-right: 10px;
        }

        .menu-item {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }

        .menu-item:hover, .menu-item.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 4px solid white;
        }

        .menu-item i {
            margin-right: 15px;
            font-size: 1.2rem;
        }

        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, #164e63 100%);
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(8, 145, 178, 0.3);
        }

        .form-control {
            border: 1px solid #e2e8f0;
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(8, 145, 178, 0.25);
        }

        .input-group-text {
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
        }

        /* Responsive Tables */
        .table-responsive {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        /* Responsive Cards */
        @media (max-width: 767.98px) {
            .card-deck {
                display: block;
            }
            .card {
                margin-bottom: 15px;
            }
        }

        /* Loading Spinner */
        .loading-spinner {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }

        .loading-spinner.active {
            display: block;
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
    </style>

@stack('styles')
<!-- Removed dashboard specific styles from here to move to separate file -->
</head>
<body>
    @auth
    <!-- Mobile Toggle Button -->
    <button class="mobile-toggle" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
<img src="{{ asset('storage/profile/default-profile.png') }}" alt="Logo" style="width: 90px; height: 100px; object-fit: cover;">
            <h3>Smart Aquarium</h3>
        </div>
        <div class="sidebar-menu mt-4">
            <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('sensor.data') }}" class="menu-item {{ request()->routeIs('sensor.data') ? 'active' : '' }}">
                <i class="bi bi-thermometer-half"></i>
                <span>Sensor Data</span>
            </a>
            <a href="{{ route('controls') }}" class="menu-item {{ request()->routeIs('controls') ? 'active' : '' }}">
                <i class="bi bi-toggles"></i>
                <span>Controls</span>
            </a>
            <a href="{{ route('history') }}" class="menu-item {{ request()->routeIs('history') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>History</span>
            </a>
            <a href="{{ route('schedules') }}" class="menu-item {{ request()->routeIs('schedules') ? 'active' : '' }}">
                <i class="bi bi-calendar-event"></i>
                <span>Schedules</span>
            </a>
            <a href="{{ route('settings.index') }}" class="menu-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <i class="bi bi-gear-fill"></i>
                <span>Settings</span>
            </a>
        </div>
        <div class="mt-auto text-center p-4" style="position: absolute; bottom: 0; width: 100%;">
            <small class="text-white-50">© {{ date('Y') }} Smart Aquarium</small>
        </div>
    </div>
    @endauth

    <!-- Loading Spinner -->
    <div class="loading-spinner">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container"></div>

    <!-- Main Content -->
    <div class="main-content @auth @else container @endauth">
        @yield('content')
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar Toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    mainContent.classList.toggle('active');
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth < 992) {
                    if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                        sidebar.classList.remove('active');
                        mainContent.classList.remove('active');
                    }
                }
            });

            // Show loading spinner on form submissions
            

            // Show toast notifications
            function showToast(message, type = 'success') {
                const toastContainer = document.querySelector('.toast-container');
                const toast = document.createElement('div');
                toast.className = `toast align-items-center text-white bg-${type} border-0`;
                toast.setAttribute('role', 'alert');
                toast.setAttribute('aria-live', 'assertive');
                toast.setAttribute('aria-atomic', 'true');
                
                toast.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                `;
                
                toastContainer.appendChild(toast);
                const bsToast = new bootstrap.Toast(toast);
                bsToast.show();
                
                toast.addEventListener('hidden.bs.toast', function() {
                    toast.remove();
                });
            }

            // Show success message if exists
            @if(session('success'))
                showToast('{{ session('success') }}', 'success');
            @endif

            // Show error message if exists
            @if(session('error'))
                showToast('{{ session('error') }}', 'danger');
            @endif
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom"></script>

    @stack('scripts')


    <script>
        // Set current user email for history logging
        window.currentUserEmail = '{{ auth()->user()->email ?? "anonymous" }}';
    </script>

    <script>
    // Centralized notification system
    const NotificationSystem = {
        activeNotifications: new Set(),
        
        show(type, message, options = {}) {
            const { 
                id = null,  // Optional unique ID for the notification
                duration = 3000,  // How long to show the notification
                container = 'toast-container'  // Which container to use
            } = options;
            
            // If an ID is provided and this notification is already active, don't show it again
            if (id && this.activeNotifications.has(id)) {
                return;
            }
            
            const toastContainer = document.querySelector(`.${container}`);
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type} border-0`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            
            toastContainer.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast, {
                autohide: true,
                delay: duration
            });
            
            if (id) {
                this.activeNotifications.add(id);
            }
            
            bsToast.show();
            
            toast.addEventListener('hidden.bs.toast', function() {
                if (id) {
                    NotificationSystem.activeNotifications.delete(id);
                }
                toast.remove();
            });
        }
    };

    // Make it globally available
    window.NotificationSystem = NotificationSystem;

    // Show success message if exists
    @if(session('success'))
        NotificationSystem.show('success', '{{ session('success') }}');
    @endif

    // Show error message if exists
    @if(session('error'))
        NotificationSystem.show('danger', '{{ session('error') }}');
    @endif
    </script>
</body>
</html>