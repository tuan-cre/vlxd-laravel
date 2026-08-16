@extends('layouts.admin')
@section('title', 'Management Orders')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Orders</h1>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-2">
                    <div class="col-md-3">
                        <input type="text" name="keyword" class="form-control" placeholder="Search by order code, phone..." value="{{ request('keyword') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Pending</option>
                            <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>Confirmed</option>
                            <option value="3" {{ request('status') == 3 ? 'selected' : '' }}>Delivering</option>
                            <option value="4" {{ request('status') == 4 ? 'selected' : '' }}>Completed</option>
                            <option value="5" {{ request('status') == 5 ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search me-1"></i>Filter</button>
                    </div>
                </form>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Order Date</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->customer->fullname ?? 'N/A' }}</td>
                            <td>{{ $order->customer->phone ?? 'N/A' }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                            <td>
                                @php
                                    $statusColors = [1=>'warning', 2=>'info', 3=>'primary', 4=>'success', 5=>'danger'];
                                    $statusNames = [1=>'Pending', 2=>'Confirmed', 3=>'Delivering', 4=>'Completed', 5=>'Cancelled'];
                                @endphp
                                <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                    {{ $statusNames[$order->status] ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted">No orders found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $orders->withQueryString()->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
