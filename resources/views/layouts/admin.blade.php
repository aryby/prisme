<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin -SIPRISME 2026')</title>
    <link href="{{ asset('inspire.css') }}" rel="stylesheet">
    <link href="{{ asset('prisme-custom.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .admin-sidebar {
            background: #2c3e50;
            min-height: 100vh;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
        }
        .admin-main {
            margin-left: 250px;
            min-height: 100vh;
            background: #f8f9fa;
        }
        .admin-header {
            background: white;
            border-bottom: 1px solid #dee2e6;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .admin-content {
            padding: 2rem;
        }
        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid #34495e;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }
        .sidebar-nav {
            padding: 1rem 0;
        }
        .sidebar-nav a {
            display: block;
            padding: 0.75rem 1.5rem;
            color: #bdc3c7;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: #34495e;
            color: white;
        }
        .stats-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stats-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .stats-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .table-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .table-header {
            padding: 1.5rem;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-admin {
            background: #007bff;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-admin:hover {
            background: #0056b3;
            color: white;
        }
        .user-dropdown {
            position: relative;
        }
        .user-menu {
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            min-width: 150px;
            display: none;
        }
        .user-menu.show {
            display: block;
        }
        .user-menu a {
            display: block;
            padding: 0.5rem 1rem;
            color: #333;
            text-decoration: none;
        }
        .user-menu a:hover {
            background: #f8f9fa;
        }
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-active { background: #d4edda; color: #155724; }
        .status-suspended { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-brand">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none">
                    <i class="fas fa-tachometer-alt me-2"></i>PRISME Admin
                </a>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
                <a href="{{ route('admin.papers.index') }}" class="{{ request()->routeIs('admin.papers.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt me-2"></i>Papers
                </a>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i>Users
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="admin-main flex-grow-1">
            <!-- Header -->
            <header class="admin-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-outline-secondary d-md-none me-3" id="admin-mobile-menu">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="h4 mb-0">@yield('page_title', 'Dashboard')</h1>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm me-3">
                        <i class="fas fa-external-link-alt me-1"></i>View Site
                    </a>
                    <div class="user-dropdown">
                        <button class="btn btn-outline-secondary btn-sm" id="user-menu-button">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                            <i class="fas fa-chevron-down ms-1"></i>
                        </button>
                        <div class="user-menu" id="user-menu">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link text-danger w-100 text-start">
                                    <i class="fas fa-sign-out-alt me-1"></i>Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('admin-mobile-menu');
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', () => {
                    // Simple toggle for demo; real impl: slide-in drawer
                    alert('Open admin sidebar (mobile)');
                });
            }

            // User menu dropdown
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenu = document.getElementById('user-menu');
            
            if (userMenuButton && userMenu) {
                userMenuButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    userMenu.classList.toggle('show');
                });

                // Close menu when clicking outside
                document.addEventListener('click', () => {
                    userMenu.classList.remove('show');
                });
            }
        });
    </script>
</body>
</html>

