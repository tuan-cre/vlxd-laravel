@extends('layouts.app')
@section('title', 'Checkout - Di Hiền Building Materials')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Cart</a></li>
            <li class="breadcrumb-item active">Checkout</li>
        </ol>
    </nav>

    <h2 class="fw-bold mb-4" style="color: var(--dark);"><i class="bi bi-credit-card me-2"></i>Checkout</h2>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Shipping Information</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="fullname" class="form-control" value="{{ old('fullname', $customer->fullname ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" name="phone_number" class="form-control" value="{{ old('phone_number', $customer->phone_number ?? '') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Delivery Address <span class="text-danger">*</span></label>
                                <input type="text" name="address" class="form-control" value="{{ old('address', $customer->address ?? '') }}" placeholder="Street address, city, state, zip code" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Order Notes</label>
                                <textarea name="note" class="form-control" rows="3" placeholder="Special instructions (e.g., deliver during business hours)">{{ old('note') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                                <select name="payment_method" class="form-select" required>
                                    <option value="COD" {{ old('payment_method') == 'COD' ? 'selected' : '' }}>Cash on Delivery (COD)</option>
                                    <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="checkout-sidebar">
                    <h5 class="fw-bold mb-3">Your Order</h5>
                    @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                            <div class="d-flex align-items-center">
                                <div>
                                    <small class="fw-semibold d-block">{{ $item['product']->name }}</small>
                                    <small class="text-muted">x{{ $item['quantity'] }}</small>
                                </div>
                            </div>
                            <span class="fw-semibold">{{ number_format($item['item_total']) }}đ</span>
                        </div>
                    @endforeach

                    <div class="mt-3">
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
                            <span class="text-muted">Contact for quote</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-bold fs-5">Total:</span>
                            <span class="fw-bold fs-5 text-danger">{{ number_format($grandTotal) }}đ</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success-custom w-100 btn-lg">
                        <i class="bi bi-check-circle me-2"></i>Place Order
                    </button>
                    <p class="text-center text-muted small mt-2 mb-0">
                        <i class="bi bi-shield-lock me-1"></i>Your information is secure
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
