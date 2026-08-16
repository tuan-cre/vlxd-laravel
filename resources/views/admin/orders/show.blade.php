@extends('layouts.admin')
@section('title', 'Order Details #' . $order->id)

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="m-0">Order #{{ $order->id }}</h1>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Back</a>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Order Information</h3></div>
                    <div class="card-body">
                        <table class="table">
                            <tr><th>Order Code</th><td>#{{ $order->id }}</td></tr>
                            <tr><th>Order Date</th><td>{{ $order->created_at->format('d/m/Y H:i') }}</td></tr>
                            <tr>
                                <th>Status</th>
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
                            <tr><th>Customer</th><td>{{ $order->customer->fullname ?? 'N/A' }}</td></tr>
                            <tr><th>Phone</th><td>{{ $order->customer->phone ?? 'N/A' }}</td></tr>
                            <tr><th>Address</th><td>{{ $order->shipping_address ?? 'N/A' }}</td></tr>
                            <tr><th>Notes</th><td>{{ $order->note ?? 'None' }}</td></tr>
                            <tr><th>Payment</th><td>{{ $order->payment_method ?? 'N/A' }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Update Status</h3></div>
                    <div class="card-body">
                        <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="mb-3">
                                <select name="status" class="form-select">
                                    @foreach([1=>'Pending', 2=>'Confirmed', 3=>'Delivering', 4=>'Completed', 5=>'Cancelled'] as $val => $label)
                                        <option value="{{ $val }}" {{ $order->status == $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update</button>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Order Details</h3></div>
                    <div class="card-body p-0">
                        <table class="table table-sm">
                            <thead>
                                <tr><th>Product</th><th>Qty</th><th>Unit Price</th><th>Subtotal</th></tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $detail)
                                <tr>
                                    <td>{{ $detail->product->name ?? 'N/A' }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>{{ number_format($detail->unit_price, 0, ',', '.') }}đ</td>
                                    <td>{{ number_format($detail->quantity * $detail->unit_price, 0, ',', '.') }}đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr><th colspan="3">Subtotal</th><td>{{ number_format($order->subtotal ?? $order->total_amount, 0, ',', '.') }}đ</td></tr>
                                @if($order->discount_amount ?? 0 > 0)
                                <tr><th colspan="3">Discount</th><td class="text-danger">-{{ number_format($order->discount_amount, 0, ',', '.') }}đ</td></tr>
                                @endif
                                @if($order->shipping_fee ?? 0 > 0)
                                <tr><th colspan="3">Shipping Fee</th><td>{{ number_format($order->shipping_fee, 0, ',', '.') }}đ</td></tr>
                                @endif
                                <tr class="table-success"><th colspan="3"><strong>Grand Total</strong></th><td><strong>{{ number_format($order->total_amount, 0, ',', '.') }}đ</strong></td></tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
