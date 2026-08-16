@extends('layouts.admin')
@section('title', 'Import Bill Details #' . $importBill->id)

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="m-0">Import Bill #{{ $importBill->id }}</h1>
            <a href="{{ route('admin.import-bills.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Back</a>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Import Bill Information</h3></div>
                    <div class="card-body">
                        <table class="table">
                            <tr><th>Bill Code</th><td>#{{ $importBill->id }}</td></tr>
                            <tr><th>Supplier</th><td>{{ $importBill->supplier->name ?? 'N/A' }}</td></tr>
                            <tr><th>Warehouse</th><td>{{ $importBill->warehouse->name ?? 'N/A' }}</td></tr>
                            <tr><th>Import Date</th><td>{{ $importBill->import_date ? \Carbon\Carbon::parse($importBill->import_date)->format('d/m/Y') : 'N/A' }}</td></tr>
                            <tr><th>Notes</th><td>{{ $importBill->note ?? 'None' }}</td></tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($importBill->status == 'pending')
                                        <span class="badge bg-warning">Pending Approval</span>
                                    @elseif($importBill->status == 'completed')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Cancelled</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Import Details</h3>
                        @if($importBill->status == 'pending')
                            <form action="{{ route('admin.import-bills.approve', $importBill->id) }}" method="POST" class="ms-auto">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Confirm approval and update stock?')">
                                    <i class="fas fa-check me-1"></i>Approve & Update Stock
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm">
                            <thead>
                                <tr><th>Product</th><th>Qty</th><th>Unit Price</th><th>Subtotal</th></tr>
                            </thead>
                            <tbody>
                                @foreach($importBill->details as $detail)
                                <tr>
                                    <td>{{ $detail->product->name ?? 'N/A' }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>{{ number_format($detail->import_price, 0, ',', '.') }}đ</td>
                                    <td>{{ number_format($detail->quantity * $detail->import_price, 0, ',', '.') }}đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-success">
                                    <th colspan="3"><strong>Grand Total</strong></th>
                                    <td><strong>{{ number_format($importBill->total_money ?? 0, 0, ',', '.') }}đ</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
