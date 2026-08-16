@extends('layouts.app')
@section('title', $product->name . ' - Di Hiền Building Materials')

@section('content')
<section class="py-4" style="background: linear-gradient(135deg, #1a1a2e, #16213e); color:#fff;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2" style="--bs-breadcrumb-divider-color:rgba(255,255,255,0.3);">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-white-50">Products</a></li>
                @if($product->category)
                    <li class="breadcrumb-item"><a href="{{ route('products.index', ['category_id' => $product->category->id]) }}" class="text-white-50">{{ $product->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active text-white">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</section>

<div class="container py-4">

    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="product-detail-image">
                <img id="mainImage" src="{{ asset('images/products/' . ($product->thumbnail ?? 'placeholder.jpg')) }}" alt="{{ $product->name }}">
            </div>
            @if(isset($product->images) && count($product->images) > 0)
            <div class="product-thumbnails">
                <img src="{{ asset('images/products/' . ($product->thumbnail ?? 'placeholder.jpg')) }}" alt="Thumbnail" class="active" onclick="changeImage(this)">
                @foreach($product->images as $img)
                    <img src="{{ asset('images/products/' . $img->image) }}" alt="Thumbnail" onclick="changeImage(this)">
                @endforeach
            </div>
            @endif
        </div>

        <div class="col-lg-6">
            <h1 class="fw-bold mb-2" style="color: var(--dark);">{{ $product->name }}</h1>

            <div class="d-flex align-items-center gap-3 mb-3">
                @if($product->category)
                    <span class="badge bg-primary">{{ $product->category->name }}</span>
                @endif
                @if($product->brand)
                    <span class="badge bg-secondary">{{ $product->brand->name }}</span>
                @endif
            </div>

            <div class="mb-3">
                <div class="product-price fs-3">
                    @if($product->sale_price > 0)
                        <span class="text-danger fw-bold">{{ number_format($product->sale_price) }}đ</span>
                        <span class="text-muted text-decoration-line-through fs-5 ms-2">{{ number_format($product->price) }}đ</span>
                        <span class="badge bg-danger ms-2">-{{ round((1 - $product->sale_price / $product->price) * 100) }}%</span>
                    @else
                        <span class="text-danger fw-bold">{{ number_format($product->price) }}đ</span>
                    @endif
                </div>
            </div>

            <div class="mb-3">
                @if($product->stock > 0)
                    <span class="text-success fw-semibold"><i class="bi bi-check-circle me-1"></i>In Stock ({{ $product->stock }} units)</span>
                @else
                    <span class="text-danger fw-semibold"><i class="bi bi-x-circle me-1"></i>Out of Stock</span>
                @endif
            </div>

            @if($product->description)
            <div class="mb-4">
                <p class="text-muted">{{ Str::limit(strip_tags($product->description), 200) }}</p>
            </div>
            @endif

            @if($product->stock > 0)
            <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="d-flex align-items-center gap-3">
                    <div class="quantity-input">
                        <button type="button" onclick="changeQty(-1)">-</button>
                        <input type="number" name="quantity" id="qty" value="1" min="1" max="{{ $product->stock }}" readonly>
                        <button type="button" onclick="changeQty(1)">+</button>
                    </div>
                    <button type="submit" class="btn btn-primary-custom btn-lg">
                        <i class="bi bi-cart-plus me-2"></i>Add to Cart
                    </button>
                </div>
            </form>
            @endif

            <div class="border-top pt-3">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-truck text-primary fs-4 me-2"></i>
                            <div>
                                <small class="fw-semibold d-block">Shipping</small>
                                <small class="text-muted">Fast & on-time delivery</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-shield-check text-primary fs-4 me-2"></i>
                            <div>
                                <small class="fw-semibold d-block">Warranty</small>
                                <small class="text-muted">Full policy coverage</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs mb-4" id="productTabs">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#description">Product Description</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#reviews">Reviews ({{ $product->reviews->count() }})</button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="description">
            <div class="p-4">
                {!! $product->content ?? $product->description ?? '<p class="text-muted">No detailed description available for this product.</p>' !!}
            </div>
        </div>

        <div class="tab-pane fade" id="reviews">
            <div class="p-4">
                @if($product->reviews->count() > 0)
                    @foreach($product->reviews as $review)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>{{ $review->user->fullname ?? 'Customer' }}</strong>
                                <div class="review-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <small class="text-muted">{{ $review->created_at->format('d/m/Y') }}</small>
                        </div>
                        <p class="mt-2 mb-0">{{ $review->comment }}</p>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-4">No reviews yet. Be the first to review this product!</p>
                @endif

                @if(session('nguoidung'))
                <div class="mt-4">
                    <h5>Write a Review</h5>
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <select name="rating" class="form-select" style="width:auto;" required>
                                <option value="5">5 stars</option>
                                <option value="4">4 stars</option>
                                <option value="3">3 stars</option>
                                <option value="2">2 stars</option>
                                <option value="1">1 star</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Comment</label>
                            <textarea name="comment" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary-custom">Submit Review</button>
                    </form>
                </div>
                @else
                <div class="text-center py-3 bg-light rounded mt-4">
                    <p class="mb-2">Please sign in to write a review</p>
                    <a href="{{ route('login') }}" class="btn btn-outline-primary-custom btn-sm">Sign In</a>
                </div>
                @endif
            </div>
        </div>
    </div>

    @if(isset($relatedProducts) && $relatedProducts->count())
    <section class="mt-5">
        <div class="section-title">
            <h2>Related Products</h2>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach($relatedProducts as $rp)
            <div class="col">
                <div class="product-card card">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('images/products/' . ($rp->thumbnail ?? 'placeholder.jpg')) }}" alt="{{ $rp->name }}">
                        @if($rp->sale_price > 0)
                            <span class="badge bg-danger product-badge">-{{ round((1 - $rp->sale_price / $rp->price) * 100) }}%</span>
                        @endif
                        <div class="product-actions">
                            <a href="{{ route('products.show', $rp->slug) }}" class="btn btn-sm btn-light w-100">
                                <i class="bi bi-eye me-1"></i> View Details
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($rp->category)
                            <div class="product-category">{{ $rp->category->name }}</div>
                        @endif
                        <h6 class="card-title">
                            <a href="{{ route('products.show', $rp->slug) }}" class="text-decoration-none text-dark">{{ $rp->name }}</a>
                        </h6>
                        <div class="product-price">
                            @if($rp->sale_price > 0)
                                {{ number_format($rp->sale_price) }}đ
                                <span class="original-price">{{ number_format($rp->price) }}đ</span>
                            @else
                                {{ number_format($rp->price) }}đ
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection

@push('scripts')
<script>
function changeImage(el) {
    document.getElementById('mainImage').src = el.src;
    document.querySelectorAll('.product-thumbnails img').forEach(img => img.classList.remove('active'));
    el.classList.add('active');
}

function changeQty(delta) {
    const input = document.getElementById('qty');
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > parseInt(input.max)) val = parseInt(input.max);
    input.value = val;
}
</script>
@endpush
