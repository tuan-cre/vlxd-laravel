@extends('layouts.app')
@section('title', 'My Orders - Di Hiền Building Materials')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('account.index') }}">Account</a></li>
            <li class="breadcrumb-item active">Orders</li>
        </ol>
    </nav>

    <h2 class="fw-bold mb-4" style="color: var(--dark);"><i class="bi bi-receipt me-2"></i>My Orders</h2>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="list-group">
                <a href="{{ route('account.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-person me-2"></i>Account
                </a>
                <a href="{{ route('account.orders') }}" class="list-group-item list-group-item-action active">
                    <i class="bi bi-receipt me-2"></i>Orders
                </a>
                <a href="{{ route('account.addresses') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-geo-alt me-2"></i>Addresses
                </a>
                <a href="{{ route('account.points') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-star me-2"></i>Points
                </a>
            </div>
        </div>

        <div class="col-lg-8">
            @if(isset($orders) && $orders->count() > 0)
                @foreach($orders as $order)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start flex-wrap">
                            <div>
                                <h6 class="fw-bold mb-1">Order #{{ $order->id }}</h6>
                                <small class="text-muted"><i class="bi bi-calendar me-1"></i>{{ $order->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <div>
                                @php
                                    $statusLabels = [
                                        1 => ['Pending', 'badge-status-1'],
                                        2 => ['Confirmed', 'badge-status-2'],
                                        3 => ['Shipping', 'badge-status-3'],
                                        4 => ['Completed', 'badge-status-4'],
                                        5 => ['Cancelled', 'badge-status-5'],
                                    ];
                                    $status = $statusLabels[$order->status] ?? ['Unknown', 'bg-secondary'];
                                @endphp
                                <span class="badge {{ $status[1] }}">{{ $status[0] }}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            @foreach($order->orderItems as $item)
                            <div class="col-12 d-flex align-items-center mb-2">
                                <img src="{{ asset('images/products/' . ($item->product->thumbnail ?? 'placeholder.jpg')) }}" alt="" style="width:40px;height:40px;object-fit:cover;border-radius:6px;" class="me-2">
                                <div class="flex-grow-1">
                                    <small class="fw-semibold">{{ $item->product->name ?? 'Product' }}</small>
                                    <small class="text-muted d-block">x{{ $item->quantity }} - {{ number_format($item->price) }}đ</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Total:</span>
                            <span class="fw-bold text-danger">{{ number_format($order->total) }}đ</span>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-receipt-cutoff display-1 text-muted"></i>
                    <h5 class="mt-3 text-muted">No orders yet</h5>
                    <p class="text-muted">Start shopping to create your first order</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary-custom">Shop Now</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
