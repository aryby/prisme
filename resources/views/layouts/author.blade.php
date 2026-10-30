<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Author Dashboard -SIPRISME 2026')</title>
    <link href="{{ asset('inspire.css') }}" rel="stylesheet">
    <link href="{{ asset('prisme-custom.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .author-sidebar {
            background: #2c3e50;
            min-height: 100vh;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
        }
        .author-main {
            margin-left: 250px;
            min-height: 100vh;
            background: #f8f9fa;
        }
        .author-header {
            background: white;
            border-bottom: 1px solid #dee2e6;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .author-content {
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
        .sidebar-nav-disabled {
            display: block;
            padding: 0.75rem 1.5rem;
            color: #7f8c8d;
            text-decoration: none;
            cursor: not-allowed;
            opacity: 0.6;
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
        .btn-author {
            background: #007bff;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-author:hover {
            background: #0056b3;
            color: white;
        }
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-under-review { background: #d1ecf1; color: #0c5460; }
        .status-accepted { background: #d4edda; color: #155724; }
        .status-rejected { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    @if(Auth::check() && !Auth::user()->isActive())
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="inactiveAccountToast" class="toast align-items-center text-white bg-warning border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        Your account is currently inactive. You will be notified once it's activated by an administrator.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var toastLiveExample = document.getElementById('inactiveAccountToast')
                var toast = new bootstrap.Toast(toastLiveExample)
                toast.show()
            });
        </script>
    @endif
    <div class="d-flex">
        <!-- Sidebar -->
        <aside class="author-sidebar">
            <div class="sidebar-brand">
                <a href="{{ route('author.dashboard') }}" class="text-white text-decoration-none">
                    <i class="fas fa-user-edit me-2"></i>Author Dashboard
                </a>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('author.dashboard') }}" class="{{ request()->routeIs('author.dashboard*') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
                @if(Auth::user()->isActive())
                    <a href="{{ route('author.papers.create') }}" class="{{ request()->routeIs('author.papers.create*') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle me-2"></i>Submit Paper
                    </a>
                @else
                    <span class="sidebar-nav-disabled" title="Account must be active to submit papers">
                        <i class="fas fa-plus-circle me-2"></i>Submit Paper
                    </span>
                @endif
                <a href="{{ route('author.papers.index') }}" class="{{ request()->routeIs('author.papers.index*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt me-2"></i>My Papers
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="author-main flex-grow-1">
            <!-- Header -->
            <header class="author-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-outline-secondary d-md-none me-3" id="author-mobile-menu">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="h4 mb-0">@yield('page_title', 'Dashboard')</h1>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm me-3">
                        <i class="fas fa-external-link-alt me-1"></i>View Site
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-1"></i>Sign out
                            </a></li>
                        </ul>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </header>

            <!-- Content -->
            <main class="author-content">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('author-mobile-menu');
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', () => {
                    // Simple toggle for demo; real impl: slide-in drawer
                    alert('Open author sidebar (mobile)');
                });
            }
        });
    </script>
</body>
</html>
