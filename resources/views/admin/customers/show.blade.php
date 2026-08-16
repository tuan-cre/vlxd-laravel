@extends('layouts.admin')
@section('title', 'Customer Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="m-0">Customer: {{ $customer->fullname }}</h1>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Back</a>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Personal Information</h5>
                        <table class="table table-sm">
                            <tr><th>Full Name</th><td>{{ $customer->fullname }}</td></tr>
                            <tr><th>Email</th><td>{{ $customer->email }}</td></tr>
                            <tr><th>Phone</th><td>{{ $customer->phone ?? 'N/A' }}</td></tr>
                            <tr><th>Address</th><td>{{ $customer->address ?? 'N/A' }}</td></tr>
                            <tr><th>Join Date</th><td>{{ $customer->created_at->format('d/m/Y') }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-shopping-bag"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Orders</span>
                                <span class="info-box-number">{{ $customer->orders_count ?? $customer->orders->count() }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-dollar-sign"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Spent</span>
                                <span class="info-box-number">{{ number_format($customer->total_spent ?? 0, 0, ',', '.') }}đ</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fas fa-star"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Points</span>
                                <span class="info-box-number">{{ $customer->points ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary"><i class="fas fa-crown"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Member Level</span>
                                <span class="info-box-number text-capitalize">{{ $customer->member_level ?? 'bronze' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Recent Orders</h3></div>
                    <div class="card-body p-0">
                        <table class="table table-hover">
                            <thead><tr><th>Order Code</th><th>Date</th><th>Total Amount</th><th>Status</th></tr></thead>
                            <tbody>
                                @forelse($customer->orders->take(10) as $order)
                                <tr>
                                    <td><a href="{{ route('admin.orders.show', $order) }}">#{{ $order->id }}</a></td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                                    <td>
                                        @php
                                            $statusColors = [1=>'warning', 2=>'info', 3=>'primary', 4=>'success', 5=>'danger'];
                                            $statusNames = [1=>'Pending', 2=>'Confirmed', 3=>'Delivering', 4=>'Completed', 5=>'Cancelled'];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">{{ $statusNames[$order->status] ?? 'N/A' }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center text-muted">No orders yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
