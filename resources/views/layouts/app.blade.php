<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'ATS Pharmacy')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom styles -->
    @yield('styles')
    
    <style>

@media print {
  .sidebar {
    display: none !important;
  }
}

.bg-primary {
    background: inherit !important;
}

        :root {
            --primary-color: #4361ee;
            --primary-dark: #3a56d4;
            --secondary-color: #7209b7;
            --success-color: #2ec4b6;
            --warning-color: #ff9e00;
            --danger-color: #e63946;
            --dark-color: #2b2d42;
            --light-color: #f8f9fa;
            --gray-color: #6c757d;
            --text-color: #2b2d42;
            --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 70px;
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f5f7ff;
            color: var(--text-color);
        }
        
        /* Override Bootstrap colors */
        .bg-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)) !important;
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
        }
        
        /* Navbar styling */
        .navbar {
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
            letter-spacing: 0.5px;
        }
        
        .nav-link {
            font-weight: 500;
            transition: var(--transition);
            border-radius: 6px;
            padding: 8px 16px !important;
            margin: 0 4px;
        }
        
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }
        
        /* Card styling */
        .card {
            transition: var(--transition);
            border: none;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-shadow);
        }
        
        /* Button styling */
        .btn {
            transition: var(--transition);
            border-radius: 6px;
            font-weight: 500;
            padding: 10px 20px;
        }
        
        .btn-lg {
            padding: 12px 24px;
            font-weight: 600;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }
        
        /* Form controls */
        .form-control {
            border: 1px solid #e0e0e0;
            transition: var(--transition);
            padding: 12px;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }
        
        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            height: calc(100vh - 70px);
            position: sticky;
            top: 70px;
            left: 0;
            overflow-y: auto;
            transition: var(--transition);
            z-index: 999;
        }
        
        .sidebar .nav-link {
            padding: 12px 20px;
            color: var(--dark-color);
            border-radius: 0;
            margin: 2px 0;
            transition: var(--transition);
        }
        
        .sidebar .nav-link:hover {
            background-color: rgba(67, 97, 238, 0.05);
            transform: translateX(5px);
            color: var(--primary-color);
        }
        
        .sidebar .nav-link.active {
            background-color: rgba(67, 97, 238, 0.1);
            border-left: 4px solid var(--primary-color);
        }
        
        /* Layout */
        main {
            flex: 1;
            min-height: calc(100vh - 70px);
        }
        
        main.with-sidebar {
            margin-left: 0;
            width: calc(100% - var(--sidebar-width));
        }
        
        footer {
            margin-top: auto;
            background: white !important;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
        }
        
        /* Dropdown menu styling */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 0.5rem 0;
        }
        
        .dropdown-item {
            padding: 0.5rem 1.5rem;
            transition: var(--transition);
        }
        
        .dropdown-item:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <div class="bg-white rounded-circle p-2 me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-clinic-medical text-primary"></i>
                </div>
                <span>ATS Pharmacy</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if(!session('staff_id'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">
                                <i class="fas fa-sign-in-alt me-2"></i> Login
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-2"></i> {{ session('name') }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2 text-primary"></i> Dashboard
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="{{ url('/logout') }}">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        @if(session('staff_id'))
            <!-- Sidebar -->
            <div class="sidebar bg-white shadow-sm border-end" id="sidebar">
                <div class="sidebar-header bg-light p-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-th-large me-2"></i> Menu
                    </h5>
                </div>
                <ul class="nav flex-column pt-3">
                    <li class="nav-item">
                        <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active text-primary fw-bold' : 'text-dark' }}">
                            <i class="fas fa-tachometer-alt me-3"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/medicines') }}" class="nav-link {{ request()->is('medicines*') ? 'active text-primary fw-bold' : 'text-dark' }}">
                            <i class="fas fa-pills me-3"></i>
                            <span>Medicines</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/generics') }}" class="nav-link {{ request()->is('generics*') ? 'active text-primary fw-bold' : 'text-dark' }}">
                            <i class="fas fa-flask me-3"></i>
                            <span>Generics</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/pharmaceuticals') }}" class="nav-link {{ request()->is('pharmaceuticals*') ? 'active text-primary fw-bold' : 'text-dark' }}">
                            <i class="fas fa-industry me-3"></i>
                            <span>Pharmaceuticals</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/dosages') }}" class="nav-link {{ request()->is('dosages*') ? 'active text-primary fw-bold' : 'text-dark' }}">
                            <i class="fas fa-tablets me-3"></i>
                            <span>Dosages</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/categories') }}" class="nav-link {{ request()->is('categories*') ? 'active text-primary fw-bold' : 'text-dark' }}">
                            <i class="fas fa-tags me-3"></i>
                            <span>Categories</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/suppliers') }}" class="nav-link {{ request()->is('suppliers*') ? 'active text-primary fw-bold' : 'text-dark' }}">
                            <i class="fas fa-truck me-3"></i>
                            <span>Suppliers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/purchases') }}" class="nav-link {{ request()->is('purchases*') ? 'active text-primary fw-bold' : 'text-dark' }}">
                            <i class="fas fa-shopping-cart me-3"></i>
                            <span>Purchases</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/sales') }}" class="nav-link {{ request()->is('sales*') ? 'active text-primary fw-bold' : 'text-dark' }}">
                            <i class="fas fa-cash-register me-3"></i>
                            <span>Sales</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/customers') }}" class="nav-link {{ request()->is('customers*') ? 'active text-primary fw-bold' : 'text-dark' }}">
                            <i class="fas fa-users me-3"></i>
                            <span>Customers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('bmdc.index') }}" class="nav-link {{ request()->is('bmdc-verification*') ? 'active text-primary fw-bold' : 'text-dark' }}">
                            <i class="fas fa-id-card me-3"></i>
                            <span>BMDC Verification</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('staff.index') }}" class="nav-link {{ request()->is('staff*') ? 'active text-primary fw-bold' : 'text-dark' }}">
                            <i class="fas fa-user-shield me-3"></i>
                            <span>Staff Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('ai-suggest.index') }}" class="nav-link {{ request()->is('ai-suggest*') ? 'active text-primary fw-bold' : 'text-dark' }}">
                            <i class="fas fa-robot me-3"></i>
                            <span>AI Suggest</span>
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <a href="{{ url('/settings') }}" class="nav-link {{ request()->is('settings*') ? 'active text-primary fw-bold' : 'text-dark' }}">
                            <i class="fas fa-cog me-3"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
        @endif

        <!-- Main Content -->
        <main class="{{ session('staff_id') ? 'with-sidebar' : 'w-100' }}">
            @yield('content')
        </main>
    </div>

    <footer class="py-4 mt-auto shadow-sm border-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <div class="bg-primary rounded-circle p-2 me-2 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                            <i class="fas fa-clinic-medical text-white small"></i>
                        </div>
                        <p class="mb-0 fw-bold">ATS Pharmacy</p>
                    </div>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <p class="mb-0 text-muted">&copy; {{ date('Y') }} All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>
