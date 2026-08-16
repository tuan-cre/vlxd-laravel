<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Di Hiền Building Materials - Premium quality construction materials supplier">
    <title>@yield('title', 'Di Hiền Building Materials')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="top-bar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="top-bar-left">
                    <span class="me-3"><i class="bi bi-telephone-fill"></i> Hotline: <strong>0343 935 042</strong></span>
                    <span><i class="bi bi-envelope-fill"></i> lhtuan7924@gmail.com</span>
                </div>
                <div class="top-bar-right d-none d-md-block">
                    <span><i class="bi bi-clock"></i> Mon - Sat: 7:00 AM - 5:00 PM</span>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-nav sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}">
                <i class="bi bi-building me-2 fs-4"></i>
                <span class="brand-text">Di Hiền Building Materials</span>
            </a>
            @php
                $cartCount = 0;
                if(session('giohang')) {
                    $cartCount = array_sum(session('giohang'));
                }
            @endphp
            <div class="d-flex align-items-center gap-1 order-lg-last">
                <a class="btn btn-sm position-relative icon-btn" href="{{ route('account.orders') }}" title="My Orders" style="color:rgba(255,255,255,0.85);">
                    <i class="bi bi-receipt fs-5"></i>
                </a>
                <a class="btn btn-sm position-relative icon-btn" href="{{ route('cart.index') }}" title="Cart" style="color:rgba(255,255,255,0.85);">
                    <i class="bi bi-cart3 fs-5"></i>
                    @if($cartCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.55rem;">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" style="padding:0.35rem 0.65rem;">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto ms-lg-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house-door me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="bi bi-box-seam me-1"></i> Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}" href="{{ route('news.index') }}">
                            <i class="bi bi-newspaper me-1"></i> News
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-envelope me-1"></i> Contact
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @php $user = session('nguoidung'); @endphp
                    @if($user)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> Welcome, {{ $user['fullname'] ?? $user['email'] }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('account.index') }}"><i class="bi bi-person me-2"></i>Account</a></li>
                                <li><a class="dropdown-item" href="{{ route('account.orders') }}"><i class="bi bi-receipt me-2"></i>Orders</a></li>
                                <li><a class="dropdown-item" href="{{ route('account.points') }}"><i class="bi bi-star me-2"></i>Points</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="bi bi-person-plus me-1"></i> Register
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{!! session('success') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        <h5 class="text-white fw-bold mb-3">
                            <i class="bi bi-building me-2"></i>Di Hiền Building Materials
                        </h5>
                        <p class="text-light opacity-75">Premium quality construction materials. Trusted - Quality - Competitive Prices.</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="text-white fw-bold mb-3">Quick Links</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('products.index') }}">Products</a></li>
                        <li><a href="{{ route('news.index') }}">News</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white fw-bold mb-3">Customer Support</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="#">Return Policy</a></li>
                        <li><a href="#">Shopping Guide</a></li>
                        <li><a href="#">Warranty Policy</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white fw-bold mb-3">Contact Us</h6>
                    <ul class="list-unstyled footer-contact">
                        <li><i class="bi bi-geo-alt-fill me-2"></i>Tan Duc, Co To, An Giang</li>
                        <li><i class="bi bi-telephone-fill me-2"></i>0343 935 042</li>
                        <li><i class="bi bi-envelope-fill me-2"></i>lhtuan7924@gmail.com</li>
                        <li><i class="bi bi-clock-fill me-2"></i>Mon - Sat: 7:00 AM - 5:00 PM</li>
                    </ul>
                </div>
            </div>
            <hr class="footer-divider my-4">
            <div class="text-center text-light opacity-75">
                <p class="mb-0">&copy; {{ date('Y') }} Di Hiền Building Materials. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
