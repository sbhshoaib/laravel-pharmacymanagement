@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
<!-- Add Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Welcome Header Section -->
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-md-8 p-4 p-md-5">
                            <h1 class="display-6 fw-bold mb-2">Welcome, {{ session('name') }}</h1>
                            <p class="text-muted fs-5 mb-4">Pharmacy Management Dashboard</p>
                            
                            <div class="bg-success bg-opacity-10 border-start border-4 border-success rounded-3 ps-3 py-2 mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success rounded-circle p-2 me-3 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-check text-white"></i>
                                    </div>
                                    <p class="mb-0 text-success fw-medium">You have successfully logged in!</p>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center me-4">
                                    <div class="bg-primary rounded-circle p-2 me-2" style="width: 40px; height: 40px;">
                                        <i class="fas fa-calendar-check text-white"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Today's Date</small>
                                        <span class="fw-semibold">{{ date('F d, Y') }}</span>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle p-2 me-2" style="width: 40px; height: 40px;">
                                        <i class="fas fa-clock text-white"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Login Time</small>
                                        <span class="fw-semibold">{{ date('h:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-none d-md-block bg-primary position-relative" style="clip-path: polygon(15% 0%, 100% 0%, 100% 100%, 0% 100%);">
                            <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                                <div class="bg-white rounded-circle p-3 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                                    <i class="fas fa-clinic-medical text-primary fs-1"></i>
                                </div>
                                <h4 class="fw-bold mb-0">ATS Pharmacy</h4>
                                <p class="mb-0 opacity-75">Management System</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Key Metrics Section -->
        <div class="col-12 mb-4">
            <div class="row g-3">
                <!-- Total Medicines -->
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-4">
                                    <i class="fas fa-pills text-primary fs-3"></i>
                                </div>
                                <div class="display-6 fw-bold text-primary">{{ $medicineCount }}</div>
                            </div>
                            <h5 class="mb-1 fw-bold">Total Medicines</h5>
                            <p class="text-muted mb-0">Total products in inventory</p>
                            <div class="mt-3">
                                <a href="{{ url('/medicines') }}" class="btn btn-sm btn-outline-primary rounded-3 px-3">
                                    <i class="fas fa-arrow-right me-1"></i> View All
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Total Generics -->
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-secondary bg-opacity-10 p-3 rounded-4">
                                    <i class="fas fa-flask text-secondary fs-3"></i>
                                </div>
                                <div class="display-6 fw-bold text-secondary">{{ $genericCount }}</div>
                            </div>
                            <h5 class="mb-1 fw-bold">Total Generics</h5>
                            <p class="text-muted mb-0">Generic medicine types</p>
                            <div class="mt-3">
                                <a href="{{ url('/generics') }}" class="btn btn-sm btn-outline-secondary rounded-3 px-3">
                                    <i class="fas fa-arrow-right me-1"></i> View All
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Low Stock Medicines -->
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-warning bg-opacity-10 p-3 rounded-4">
                                    <i class="fas fa-exclamation-triangle text-warning fs-3"></i>
                                </div>
                                <div class="display-6 fw-bold text-warning">{{ $lowStockCount }}</div>
                            </div>
                            <h5 class="mb-1 fw-bold">Low Stock</h5>
                            <p class="text-muted mb-0">Products requiring reorder</p>
                            <div class="mt-3">
                                <a href="{{ url('/medicines') }}?filter=low-stock" class="btn btn-sm btn-outline-warning rounded-3 px-3">
                                    <i class="fas fa-arrow-right me-1"></i> Check Stock
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Today's Sales -->
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-success bg-opacity-10 p-3 rounded-4">
                                    <i class="fas fa-cash-register text-success fs-3"></i>
                                </div>
                                <div class="display-6 fw-bold text-success">৳{{ number_format($todaySales, 2) }}</div>
                            </div>
                            <h5 class="mb-1 fw-bold">Today's Sales</h5>
                            <p class="text-muted mb-0">Revenue generated today</p>
                            <div class="mt-3">
                                <a href="{{ url('/sales') }}" class="btn btn-sm btn-outline-success rounded-3 px-3">
                                    <i class="fas fa-arrow-right me-1"></i> View Sales
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Staff Information -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-user-circle text-primary me-2"></i>
                            Staff Information
                        </h5>
                        <div class="badge bg-primary rounded-pill">Staff ID: {{ session('staff_id') }}</div>
                    </div>
                    
                    <div class="bg-light rounded-4 p-4">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Full Name</small>
                                        <span class="fw-semibold fs-5">{{ session('name') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-envelope text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Email Address</small>
                                        <span class="fw-semibold">{{ session('email') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-key text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Account Status</small>
                                        <span class="badge bg-success rounded-pill px-3 py-2">Active</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Role Information -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-id-badge text-primary me-2"></i>
                            Role & Permissions
                        </h5>
                        <div class="badge bg-secondary rounded-pill">Role ID: {{ session('role_id') }}</div>
                    </div>
                    
                    <div class="bg-light rounded-4 p-4">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-user-shield text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Role Type</small>
                                        @if(session('role_id') == 1)
                                            <span class="fw-semibold fs-5">Administrator</span>
                                        @elseif(session('role_id') == 2)
                                            <span class="fw-semibold fs-5">Pharmacist</span>
                                        @elseif(session('role_id') == 3)
                                            <span class="fw-semibold fs-5">Cashier</span>
                                        @else
                                            <span class="fw-semibold fs-5">Staff Member</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-calendar-alt text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Last Login</small>
                                        <span class="fw-semibold">{{ date('F d, Y') }} at {{ date('h:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-shield-alt text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Security Level</small>
                                        @if(session('role_id') == 1)
                                            <div class="progress" style="height: 8px; width: 150px;">
                                                <div class="progress-bar bg-success" style="width: 100%"></div>
                                            </div>
                                            <small class="text-muted">Full Access</small>
                                        @elseif(session('role_id') == 2)
                                            <div class="progress" style="height: 8px; width: 150px;">
                                                <div class="progress-bar bg-primary" style="width: 75%"></div>
                                            </div>
                                            <small class="text-muted">High Access</small>
                                        @else
                                            <div class="progress" style="height: 8px; width: 150px;">
                                                <div class="progress-bar bg-info" style="width: 50%"></div>
                                            </div>
                                            <small class="text-muted">Standard Access</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="col-12">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="fas fa-bolt text-warning me-2"></i>
                        Quick Actions
                    </h5>
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="#" class="text-decoration-none">
                                <div class="card bg-light border-0 rounded-3 h-100">
                                    <div class="card-body text-center p-4">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3">
                                            <i class="fas fa-clipboard-list text-primary fs-4"></i>
                                        </div>
                                        <h5 class="fw-semibold">Inventory</h5>
                                        <p class="text-muted mb-0 small">Manage pharmacy products</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-4">
                            <a href="#" class="text-decoration-none">
                                <div class="card bg-light border-0 rounded-3 h-100">
                                    <div class="card-body text-center p-4">
                                        <div class="bg-success bg-opacity-10 rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3">
                                            <i class="fas fa-cash-register text-success fs-4"></i>
                                        </div>
                                        <h5 class="fw-semibold">Sales</h5>
                                        <p class="text-muted mb-0 small">Process sales transactions</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-4">
                            <a href="#" class="text-decoration-none">
                                <div class="card bg-light border-0 rounded-3 h-100">
                                    <div class="card-body text-center p-4">
                                        <div class="bg-danger bg-opacity-10 rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3">
                                            <i class="fas fa-chart-line text-danger fs-4"></i>
                                        </div>
                                        <h5 class="fw-semibold">Reports</h5>
                                        <p class="text-muted mb-0 small">View business analytics</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-end">
                        <a href="{{ url('/logout') }}" class="btn btn-danger px-4 rounded-3">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
