<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - VLXD Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Responsive fixes */
        .content-wrapper { padding: 0.5rem; }
        @media (min-width: 768px) { .content-wrapper { padding: 1rem 1.5rem; } }

        /* Stat boxes responsive */
        .info-box { padding: 0.5rem; }
        @media (min-width: 768px) { .info-box { padding: 1rem; } }
        .info-box-content { flex: 1; min-width: 0; }
        .info-box h3 { font-size: 1.3rem; line-height: 1.2; }
        @media (min-width: 768px) { .info-box h3 { font-size: 1.6rem; } }
        .info-box p { font-size: 0.75rem; margin: 0; }
        @media (min-width: 768px) { .info-box p { font-size: 0.85rem; } }

        /* Small box responsive */
        .small-box { border-radius: 0.5rem; }
        .small-box .inner { padding: 0.6rem; }
        @media (min-width: 768px) { .small-box .inner { padding: 1rem; } }
        .small-box .inner h3 { font-size: 1.4rem; }
        @media (min-width: 768px) { .small-box .inner h3 { font-size: 1.8rem; } }
        .small-box .inner p { font-size: 0.75rem; }
        @media (min-width: 768px) { .small-box .inner p { font-size: 0.9rem; } }
        .small-box .icon { font-size: 2.5rem; }
        @media (min-width: 768px) { .small-box .icon { font-size: 3.5rem; } }

        /* Tables responsive */
        .table-responsive-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }

        /* Card responsive */
        .card { border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-radius: 0.5rem; }
        .card-header { padding: 0.6rem 0.8rem; }
        @media (min-width: 768px) { .card-header { padding: 0.75rem 1rem; } }
        .card-body { padding: 0.6rem; }
        @media (min-width: 768px) { .card-body { padding: 1rem; } }

        /* Row spacing */
        .row > [class*="col-"] { padding-left: 0.3rem; padding-right: 0.3rem; margin-bottom: 0.5rem; }
        @media (min-width: 768px) { .row > [class*="col-"] { padding-left: 0.75rem; padding-right: 0.75rem; margin-bottom: 0; } }

        /* Sidebar brand */
        .brand-link { padding: 0.6rem 0.5rem !important; }

        /* Navbar mobile */
        .main-header.navbar { padding: 0 0.5rem; }
        @media (min-width: 768px) { .main-header.navbar { padding: 0 1rem; } }
    </style>
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    <i class="fas fa-user-circle me-1"></i>
                    {{ session('nguoidung')->fullname ?? 'Admin' }}
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('admin.dashboard') }}" class="brand-link text-center">
            <span class="brand-text font-weight-light"><b>VLXD</b> Admin</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    @php
                        $currentRoute = request()->route()->getName();
                    @endphp
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ $currentRoute === 'admin.dashboard' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.products.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'admin.products') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Products</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'admin.categories') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Categories</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.brands.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'admin.brands') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-award"></i>
                            <p>Brands</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'admin.orders') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.customers.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'admin.customers') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Customers</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'admin.coupons') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-ticket-alt"></i>
                            <p>Coupons</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.news.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'admin.news') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p>News</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.warehouses.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'admin.warehouses') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p>Warehouses</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.import-bills.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'admin.import-bills') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-truck-loading"></i>
                            <p>Import Bills</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.reports.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'admin.reports') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>Reports</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content -->
    <div class="content-wrapper">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>

    <footer class="main-footer text-center">
        <strong>&copy; {{ date('Y') }} Di Hiền Building Materials.</strong>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@stack('scripts')
</body>
</html>
