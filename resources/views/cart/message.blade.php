@extends('layouts.app')
@section('title', 'Order Placed - Di Hiền Building Materials')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <div class="success-icon fade-in-up">
                <i class="bi bi-check-lg"></i>
            </div>
            <h2 class="fw-bold mb-3" style="color: var(--dark);">Order Placed Successfully!</h2>
            <p class="text-muted mb-4">Thank you for shopping with Di Hiền Building Materials. We will contact you shortly.</p>

            @if(isset($order))
            <div class="card mb-4 text-start">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Order Information</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Order ID:</span>
                        <span class="fw-bold">#{{ $order->id }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total:</span>
                        <span class="fw-bold text-danger">{{ number_format($order->total) }}đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Items:</span>
                        <span>{{ $order->items_count ?? $order->orderItems->count() }} items</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Status:</span>
                        <span class="badge badge-status-1">Pending</span>
                    </div>
                </div>
            </div>
            @endif

            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('home') }}" class="btn btn-primary-custom btn-lg">
                    <i class="bi bi-house me-2"></i>Continue Shopping
                </a>
                @if(session('nguoidung'))
                    <a href="{{ route('account.orders') }}" class="btn btn-outline-primary-custom btn-lg">
                        <i class="bi bi-receipt me-2"></i>View Orders
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
