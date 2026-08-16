@extends('layouts.app')
@section('title', 'Cart - Di Hiền Building Materials')

@section('content')
<section class="py-4" style="background: linear-gradient(135deg, #1a1a2e, #16213e); color:#fff;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2" style="--bs-breadcrumb-divider-color:rgba(255,255,255,0.3);">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Home</a></li>
                <li class="breadcrumb-item active text-white">Cart</li>
            </ol>
        </nav>
        <h4 class="fw-bold mb-0"><i class="bi bi-cart3 me-2"></i>Shopping Cart</h4>
    </div>
</section>

<div class="container py-4">

    @if(count($cartItems) > 0)
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="table-responsive">
                    <table class="table cart-table mb-0">
                        <thead>
                            <tr>
                                <th style="width:80px;">Image</th>
                                <th>Product</th>
                                <th style="width:120px;">Unit Price</th>
                                <th style="width:140px;">Quantity</th>
                                <th style="width:120px;">Subtotal</th>
                                <th style="width:60px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                @php
                                    $product = $item['product'];
                                    $price = $product->sale_price > 0 ? $product->sale_price : $product->price;
                                    $subtotal = $item['item_total'];
                                @endphp
                                <tr>
                                    <td>
                                        <img src="{{ asset('images/products/' . ($product->thumbnail ?? 'placeholder.jpg')) }}" alt="{{ $product->name }}" style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                                    </td>
                                    <td>
                                        <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none fw-semibold">{{ $product->name }}</a>
                                    </td>
                                    <td>
                                        @if($product->sale_price > 0)
                                            <span class="text-danger fw-bold">{{ number_format($product->sale_price) }}đ</span>
                                            <br><small class="text-muted text-decoration-line-through">{{ number_format($product->price) }}đ</small>
                                        @else
                                            <span class="fw-bold">{{ number_format($product->price) }}đ</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div class="d-flex align-items-center gap-1">
                                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="var inp=this.nextElementSibling; if(parseInt(inp.value)>1){inp.value=parseInt(inp.value)-1; this.form.submit();}">-</button>
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $product->stock }}" class="form-control form-control-sm text-center" style="width:60px;" readonly>
                                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="var inp=this.previousElementSibling; if(parseInt(inp.value)<{{ $product->stock }}){inp.value=parseInt(inp.value)+1; this.form.submit();}">+</button>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-danger">{{ number_format($subtotal) }}đ</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Remove">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('products.index') }}" class="btn btn-outline-dark">
                    <i class="bi bi-arrow-left me-1"></i> Continue Shopping
                </a>
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Remove all items from cart?')">
                        <i class="bi bi-trash me-1"></i> Clear Cart
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Coupon Code</h5>
                    <form id="couponForm" class="d-flex gap-2 mb-3">
                        @csrf
                        <input type="text" name="code" class="form-control" placeholder="Enter coupon code" required>
                        <button type="submit" class="btn btn-primary">Apply</button>
                    </form>
                    <div id="couponMessage" class="mb-3"></div>

                    <h5 class="fw-bold mb-3">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span class="fw-semibold">{{ number_format($total) }}đ</span>
                    </div>
                    @if($couponDiscount > 0)
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Discount ({{ $couponCode }}):</span>
                        <span class="fw-semibold">-{{ number_format($couponDiscount) }}đ</span>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping:</span>
                        <span class="text-muted">Free</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold fs-5">Total:</span>
                        <span class="fw-bold fs-5 text-danger">{{ number_format($total - $couponDiscount) }}đ</span>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn btn-success w-100 btn-lg">
                        <i class="bi bi-credit-card me-2"></i>Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="card border-0 shadow-sm" style="border-radius:16px;">
        <div class="card-body text-center py-5 px-4">
            <div class="empty-cart-icon mb-4">
                <i class="bi bi-cart-x"></i>
            </div>
            <h4 class="fw-bold" style="color:var(--dark);">Your cart is empty</h4>
            <p class="text-muted mb-4">Add products to your cart to start shopping</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary-custom btn-lg px-4">
                <i class="bi bi-box-seam me-2"></i>Start Shopping
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.getElementById('couponForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('{{ route("coupon.apply") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        const msg = document.getElementById('couponMessage');
        if (data.success) {
            msg.innerHTML = '<div class="alert alert-success py-2">' + data.message + '</div>';
            setTimeout(() => location.reload(), 1000);
        } else {
            msg.innerHTML = '<div class="alert alert-danger py-2">' + data.message + '</div>';
        }
    })
    .catch(() => this.submit());
});
</script>
@endpush
