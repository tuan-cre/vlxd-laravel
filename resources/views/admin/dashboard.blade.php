@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Dashboard</h1>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ number_format($totalRevenue ?? 0, 0, ',', '.') }}đ</h3>
                        <p>Total Revenue</p>
                    </div>
                    <div class="icon"><i class="fas fa-dollar-sign"></i></div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalOrders ?? 0 }}</h3>
                        <p>Total Orders</p>
                    </div>
                    <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $pendingOrders ?? 0 }}</h3>
                        <p>Pending Orders</p>
                    </div>
                    <div class="icon"><i class="fas fa-clock"></i></div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $activeProducts ?? 0 }}</h3>
                        <p>Active Products</p>
                    </div>
                    <div class="icon"><i class="fas fa-box"></i></div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{ $totalCustomers ?? 0 }}</h3>
                        <p>Customers</p>
                    </div>
                    <div class="icon"><i class="fas fa-users"></i></div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $todayOrders ?? 0 }}</h3>
                        <p>Today's Orders</p>
                    </div>
                    <div class="icon"><i class="fas fa-calendar-day"></i></div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ number_format($todayRevenue ?? 0, 0, ',', '.') }}đ</h3>
                        <p>Today's Revenue</p>
                    </div>
                    <div class="icon"><i class="fas fa-chart-line"></i></div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 d-none d-lg-block">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>—</h3>
                        <p>Reserved</p>
                    </div>
                    <div class="icon"><i class="fas fa-plus-circle"></i></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Revenue Trend (7 days)</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" style="height:260px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Low Stock</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive-wrapper">
                            <table class="table table-sm mb-0">
                                <thead><tr><th>Product</th><th class="text-end">Stock</th></tr></thead>
                                <tbody>
                                    @foreach($lowStockProducts ?? [] as $product)
                                    <tr>
                                        <td class="text-truncate" style="max-width:200px;">{{ $product->name }}</td>
                                        <td class="text-end"><span class="badge bg-danger">{{ $product->stock }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Orders</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive-wrapper">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr><th>#</th><th>Customer</th><th>Date</th><th>Total</th><th>Status</th></tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders ?? [] as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->customer->fullname ?? 'N/A' }}</td>
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
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('revenueChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($revenueTrend['labels'] ?? []) !!},
                datasets: [{
                    label: 'Revenue',
                    data: {!! json_encode($revenueTrend['data'] ?? []) !!},
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0,123,255,0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });
    }
</script>
@endpush
