@extends('layouts.admin')
@section('title', 'Reports')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Reports</h1>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header">
                <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">From Date</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from', now()->startOfMonth()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">To Date</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to', now()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-filter me-1"></i>Filter</button>
                        <a href="{{ route('admin.reports.export', request()->query()) }}" class="btn btn-outline-success"><i class="fas fa-download me-1"></i>CSV</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="info-box"><span class="info-box-icon bg-success"><i class="fas fa-dollar-sign"></i></span>
                    <div class="info-box-content"><span class="info-box-text">Revenue</span><span class="info-box-number">{{ number_format($stats['revenue'] ?? 0, 0, ',', '.') }}đ</span></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box"><span class="info-box-icon bg-info"><i class="fas fa-shopping-cart"></i></span>
                    <div class="info-box-content"><span class="info-box-text">Orders</span><span class="info-box-number">{{ $stats['order_count'] ?? 0 }}</span></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box"><span class="info-box-icon bg-primary"><i class="fas fa-check-circle"></i></span>
                    <div class="info-box-content"><span class="info-box-text">Completed</span><span class="info-box-number">{{ $stats['completed'] ?? 0 }}</span></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box"><span class="info-box-icon bg-danger"><i class="fas fa-times-circle"></i></span>
                    <div class="info-box-content"><span class="info-box-text">Cancelled</span><span class="info-box-number">{{ $stats['cancelled'] ?? 0 }}</span></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Daily Revenue</h3></div>
                    <div class="card-body"><canvas id="dailyRevenueChart" height="300"></canvas></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Revenue by Category</h3></div>
                    <div class="card-body p-0">
                        <table class="table table-sm">
                            <thead><tr><th>Category</th><th>Revenue</th></tr></thead>
                            <tbody>
                                @foreach($categoryRevenue ?? [] as $item)
                                <tr>
                                    <td>{{ $item->category_name }}</td>
                                    <td>{{ number_format($item->revenue, 0, ',', '.') }}đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Daily Revenue Table</h3></div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-striped">
                            <thead><tr><th>Date</th><th>Orders</th><th>Revenue</th></tr></thead>
                            <tbody>
                                @foreach($dailyRevenue ?? [] as $row)
                                <tr>
                                    <td>{{ $row->date }}</td>
                                    <td>{{ $row->order_count }}</td>
                                    <td>{{ number_format($row->revenue, 0, ',', '.') }}đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Top 10 Selling Products</h3></div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-striped">
                            <thead><tr><th>Product</th><th>Sold</th><th>Revenue</th></tr></thead>
                            <tbody>
                                @foreach($topProducts ?? [] as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->total_sold }}</td>
                                    <td>{{ number_format($item->revenue, 0, ',', '.') }}đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('dailyRevenueChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(collect($dailyRevenue ?? [])->pluck('date')->toArray()) !!},
                datasets: [{
                    label: 'Revenue',
                    data: {!! json_encode(collect($dailyRevenue ?? [])->pluck('revenue')->toArray()) !!},
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40,167,69,0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
        });
    }
</script>
@endpush
