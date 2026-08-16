@extends('layouts.admin')
@section('title', 'Management Coupons')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="m-0">Coupons</h1>
            <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Add New</a>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Code</th>
                            <th>Discount Type</th>
                            <th>Value</th>
                            <th>Min Order</th>
                            <th>Expiry</th>
                            <th>Uses Left</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $coupon)
                        <tr>
                            <td>{{ $coupon->id }}</td>
                            <td><span class="badge bg-primary">{{ $coupon->code }}</span></td>
                            <td>{{ $coupon->discount_type == 'percent' ? 'Percent' : 'Fixed' }}</td>
                            <td>
                                @if($coupon->discount_type == 'percent')
                                    {{ $coupon->discount_value }}%
                                @else
                                    {{ number_format($coupon->discount_value, 0, ',', '.') }}đ
                                @endif
                            </td>
                            <td>{{ number_format($coupon->min_order_value ?? 0, 0, ',', '.') }}đ</td>
                            <td>{{ $coupon->end_date ? \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y') : 'N/A' }}</td>
                            <td>
                                @if($coupon->usage_limit)
                                    <span class="badge bg-info">{{ $coupon->usage_limit - ($coupon->used_count ?? 0) }}</span>
                                @else
                                    <span class="badge bg-success">Unlimited</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirm delete?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center text-muted">No coupons found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
