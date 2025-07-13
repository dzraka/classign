<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ClAssign')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Custom CSS for authenticated users -->
    <style>
        body {
            overflow-x: hidden;
            padding-top: 56px;
            background-color: #f8f9fa;
        }
        
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        
        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: 250px;
            height: calc(100vh - 56px);
            background-color: #050d1c;
            z-index: 1020;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            overflow-y: auto;
            box-shadow: 2px 0 4px rgba(0,0,0,.1);
        }
        
        .sidebar.show {
            transform: translateX(0);
        }
        
        .main-content {
            transition: margin-left 0.3s ease;
            min-height: calc(100vh - 56px);
        }
        
        .navbar-toggler {
            border: none;
            background: transparent;
            padding: 0.5rem;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
        }
        
        .navbar-toggler:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.375rem;
        }
        
        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.375rem;
        }
        
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 0.375rem;
        }
        
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1019;
            display: none;
        }
        
        .sidebar-overlay.show {
            display: block;
        }
        
        @media (min-width: 992px) {
            .sidebar {
                transform: translateX(0);
            }
            
            .sidebar.hide {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 250px;
            }
            
            .main-content.full {
                margin-left: 0;
            }
            
            .sidebar-overlay {
                display: none !important;
            }
        }
        
        @media (max-width: 991.98px) {
            .sidebar {
                width: 100%;
                max-width: 280px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #050d1c;">
        <div class="container-fluid">
            <!-- Sidebar Toggle Button -->
            <button class="btn d-lg-block me-3" type="button" id="sidebarToggle">
                <span class="navbar-toggler-icon text-white"></span>
            </button>

            <!-- Brand -->
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                ClAssign <span class="navbar-text">for education</span>
            </a>

            <!-- User Dropdown -->
            <div class="dropdown ms-auto d-none d-sm-block">
                <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-2"></i>{{ Auth::user()->display_name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile') }}">
                            <i class="bi bi-person me-2"></i>Profil
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline" data-no-loading="true">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right me-2"></i>Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar text-white" id="sidebar">
        <div class="p-3">
            <!-- User Info -->
            <div class="d-flex align-items-center mb-4 pb-3 border-bottom border-secondary">
                <div class="bg-white text-black rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div>
                    <h6 class="mb-0">{{ Auth::user()->display_name }}</h6>
                    <small class="fw-lighter">
                        {{ Auth::user()->role === 'teacher' ? 'Pengajar' : 'Siswa' }}
                    </small>
                </div>
            </div>
            
            <!-- Navigation Menu -->
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-house-fill me-3"></i>Beranda
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white {{ request()->routeIs('classes.*') ? 'active' : '' }}" href="{{ route('classes.index') }}">
                        <i class="bi bi-journal-bookmark-fill me-3"></i>Kelas
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white {{ request()->routeIs('calendar') ? 'active' : '' }}" href="{{ route('calendar') }}">
                        <i class="bi bi-calendar-week-fill me-3"></i>Kalender
                    </a>
                </li>
                
                <hr class="my-3 border-secondary">
                
                <!-- Role-specific Actions -->
                @if(Auth::user()->role === 'student')
                <li class="nav-item mb-2">
                    <a href="{{ route('classes.join') }}" class="nav-link text-white">
                        <i class="bi bi-plus-circle me-3"></i>Gabung Kelas
                    </a>
                </li>
                @else
                <li class="nav-item mb-2">
                    <a href="{{ route('classes.create') }}" class="nav-link text-white">
                        <i class="bi bi-plus-circle me-3"></i>Buat Kelas
                    </a>
                </li>
                @endif

                <!-- Mobile logout button -->
                <li class="nav-item mb-2 d-md-none position-fixed bottom-0">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline w-100" data-no-loading="true">
                        @csrf
                        <button type="submit" class="nav-link text-white bg-transparent border-0 w-100 text-start p-0" style="background: none !important;">
                            <div class="d-flex align-items-center w-100 p-2">
                                <i class="bi bi-box-arrow-right me-3"></i>Keluar
                            </div>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="container-fluid p-4">
            <!-- Alerts -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            // Toggle sidebar
            sidebarToggle.addEventListener('click', function(e) {
                e.preventDefault();
                sidebar.classList.toggle('show');
                
                // For desktop, also toggle main content margin
                if (window.innerWidth >= 992) {
                    sidebar.classList.toggle('hide');
                    mainContent.classList.toggle('full');
                } else {
                    // For mobile, show/hide overlay
                    sidebarOverlay.classList.toggle('show');
                }
            });
            
            // Close sidebar when clicking overlay
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    // Desktop view
                    sidebar.classList.add('show');
                    sidebar.classList.remove('hide');
                    mainContent.classList.remove('full');
                    sidebarOverlay.classList.remove('show');
                } else {
                    // Mobile view - hide sidebar
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                }
            });
            
            // Initial setup based on screen size
            if (window.innerWidth >= 992) {
                sidebar.classList.add('show');
            }
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth < 992) {
                    if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
                    }
                }
            });
            
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Handle logout forms specifically
            document.querySelectorAll('form[action*="logout"]').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    // Allow logout forms to submit normally without interference
                    e.stopPropagation();
                });
            });
            
            // Form submission loading states for other forms
            document.querySelectorAll('form').forEach(function(form) {
                // Skip logout forms
                if (form.action && form.action.includes('/logout')) {
                    return;
                }
                
                form.addEventListener('submit', function(e) {
                    var submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn && !form.hasAttribute('data-no-loading')) {
                        submitBtn.disabled = true;
                        var originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses...';
                        
                        // Re-enable after 10 seconds in case of error
                        setTimeout(function() {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        }, 10000);
                    }
                });
            });

            // Confirm delete actions
            document.querySelectorAll('[data-confirm]').forEach(function(element) {
                element.addEventListener('click', function(e) {
                    var message = this.getAttribute('data-confirm') || 'Apakah Anda yakin?';
                    if (!confirm(message)) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>
