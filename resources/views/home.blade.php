@extends('layouts.app')
@section('title', 'Home - Di Hiền Building Materials')

@section('content')
<section class="hero-section" style="background: linear-gradient(rgba(26,26,46,0.7), rgba(22,33,62,0.8)), url('{{ asset('images/banners/hero-banner.jpg') }}') center/cover no-repeat;">
    <div class="container position-relative" style="z-index:1;">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-7">
                <span class="badge bg-warning text-dark px-3 py-2 mb-3 fw-semibold"><i class="bi bi-shield-check me-1"></i> Trusted Quality</span>
                <h1 class="display-4 fw-bold mb-3">Building Materials<br><span class="text-warning">Di Hiền</span></h1>
                <p class="lead mb-4">Premium quality construction materials. Best Prices - Fast Delivery - Trusted Quality.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('products.index') }}" class="btn btn-warning btn-lg px-4 py-2 fw-semibold text-dark">
                        <i class="bi bi-box-seam me-2"></i>Browse Products
                    </a>
                    <a href="#" class="btn btn-outline-light btn-lg px-4 py-2">
                        <i class="bi bi-telephone me-2"></i>0343 935 042
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block text-end">
                <div class="hero-stats">
                    <div class="hero-stat">
                        <span class="hero-stat-number">500+</span>
                        <span class="hero-stat-label">Products</span>
                    </div>
                    <div class="hero-stat">
                        <span class="hero-stat-number">1000+</span>
                        <span class="hero-stat-label">Customers</span>
                    </div>
                    <div class="hero-stat">
                        <span class="hero-stat-number">10+</span>
                        <span class="hero-stat-label">Years Experience</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="trust-bar py-4 bg-white shadow-sm">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-truck text-primary fs-3"></i>
                    <div class="text-start">
                        <div class="fw-bold small">Fast Delivery</div>
                        <div class="text-muted" style="font-size:0.75rem;">Nationwide</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-shield-check text-primary fs-3"></i>
                    <div class="text-start">
                        <div class="fw-bold small">Quality Guaranteed</div>
                        <div class="text-muted" style="font-size:0.75rem;">100% Genuine</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-headset text-primary fs-3"></i>
                    <div class="text-start">
                        <div class="fw-bold small">24/7 Support</div>
                        <div class="text-muted" style="font-size:0.75rem;">Free Consultation</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-arrow-return-left text-primary fs-3"></i>
                    <div class="text-start">
                        <div class="fw-bold small">Easy Returns</div>
                        <div class="text-muted" style="font-size:0.75rem;">Within 7 Days</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if(isset($categories) && $categories->count())
<section class="py-5">
    <div class="container">
        <div class="section-title">
            <h2>Product Categories</h2>
            <p>Explore our range of construction materials</p>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($categories as $category)
            <div class="col">
                <a href="{{ route('products.index', ['category_id' => $category->id]) }}" class="text-decoration-none">
                    <div class="category-showcase">
                        <div class="category-showcase-img">
                            @if($category->thumbnail)
                                <img src="{{ asset('images/' . $category->thumbnail) }}" alt="{{ $category->name }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <i class="bi bi-box-seam display-3 text-white-50"></i>
                                </div>
                            @endif
                            <div class="category-showcase-overlay">
                                <h5 class="fw-bold text-white mb-1">{{ $category->name }}</h5>
                                <span class="text-white-50">View Products <i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if(isset($featured) && $featured->count())
<section class="py-5 bg-section-alt">
    <div class="container">
        <div class="section-title">
            <h2>Featured Products</h2>
            <p>Handpicked products we highly recommend</p>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach($featured as $product)
            <div class="col">
                <div class="product-card card">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('images/products/' . ($product->thumbnail ?? 'placeholder.jpg')) }}" alt="{{ $product->name }}">
                        @if($product->sale_price > 0)
                            <span class="badge bg-danger product-badge">-{{ round((1 - $product->sale_price / $product->price) * 100) }}%</span>
                        @endif
                        <div class="product-actions">
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-light w-100">
                                <i class="bi bi-eye me-1"></i> View Details
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($product->category)
                            <div class="product-category">{{ $product->category->name }}</div>
                        @endif
                        <h6 class="card-title">
                            <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark">{{ $product->name }}</a>
                        </h6>
                        <div class="product-price">
                            @if($product->sale_price > 0)
                                {{ number_format($product->sale_price) }}đ
                                <span class="original-price">{{ number_format($product->price) }}đ</span>
                            @else
                                {{ number_format($product->price) }}đ
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary-custom btn-sm w-100">
                                <i class="bi bi-cart-plus me-1"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-outline-dark px-4">View All Products <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
    </div>
</section>
@endif

@if(isset($bestSelling) && $bestSelling->count())
<section class="py-5">
    <div class="container">
        <div class="section-title">
            <h2>Best Sellers</h2>
            <p>Most popular products trusted by our customers</p>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach($bestSelling as $product)
            <div class="col">
                <div class="product-card card">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('images/products/' . ($product->thumbnail ?? 'placeholder.jpg')) }}" alt="{{ $product->name }}">
                        <span class="badge bg-warning text-dark product-badge"><i class="bi bi-fire me-1"></i>Best Seller</span>
                        <div class="product-actions">
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-light w-100">
                                <i class="bi bi-eye me-1"></i> View Details
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($product->category)
                            <div class="product-category">{{ $product->category->name }}</div>
                        @endif
                        <h6 class="card-title">
                            <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark">{{ $product->name }}</a>
                        </h6>
                        <div class="product-price">
                            @if($product->sale_price > 0)
                                {{ number_format($product->sale_price) }}đ
                                <span class="original-price">{{ number_format($product->price) }}đ</span>
                            @else
                                {{ number_format($product->price) }}đ
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary-custom btn-sm w-100">
                                <i class="bi bi-cart-plus me-1"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if(isset($mostViewed) && $mostViewed->count())
<section class="py-5 bg-section-alt">
    <div class="container">
        <div class="section-title">
            <h2>Most Viewed</h2>
            <p>Products that attract the most customer interest</p>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach($mostViewed as $product)
            <div class="col">
                <div class="product-card card">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('images/products/' . ($product->thumbnail ?? 'placeholder.jpg')) }}" alt="{{ $product->name }}">
                        @if($product->sale_price > 0)
                            <span class="badge bg-danger product-badge">-{{ round((1 - $product->sale_price / $product->price) * 100) }}%</span>
                        @endif
                        <div class="product-actions">
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-light w-100">
                                <i class="bi bi-eye me-1"></i> View Details
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($product->category)
                            <div class="product-category">{{ $product->category->name }}</div>
                        @endif
                        <h6 class="card-title">
                            <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark">{{ $product->name }}</a>
                        </h6>
                        <div class="product-price">
                            @if($product->sale_price > 0)
                                {{ number_format($product->sale_price) }}đ
                                <span class="original-price">{{ number_format($product->price) }}đ</span>
                            @else
                                {{ number_format($product->price) }}đ
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary-custom btn-sm w-100">
                                <i class="bi bi-cart-plus me-1"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="py-5" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);">
    <div class="container text-center text-white">
        <h3 class="fw-bold mb-3">Need Construction Material Advice?</h3>
        <p class="text-white-50 mb-4">Our experienced team is ready to assist you 24/7</p>
        <a href="#" class="btn btn-warning btn-lg px-5 fw-semibold text-dark">
            <i class="bi bi-telephone me-2"></i>Contact Us Now
        </a>
    </div>
</section>
@endsection
