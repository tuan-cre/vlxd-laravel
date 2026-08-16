@extends('layouts.admin')
@section('title', 'Management Import Bills')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="m-0">Import Bills</h1>
            <a href="{{ route('admin.import-bills.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Add New</a>
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
                            <th>Supplier</th>
                            <th>Warehouse</th>
                            <th>Import Date</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($importBills as $import)
                        <tr>
                            <td>{{ $import->id }}</td>
                            <td>{{ $import->supplier->name ?? 'N/A' }}</td>
                            <td>{{ $import->warehouse->name ?? 'N/A' }}</td>
                            <td>{{ $import->import_date ? \Carbon\Carbon::parse($import->import_date)->format('d/m/Y') : 'N/A' }}</td>
                            <td>{{ number_format($import->total_money ?? 0, 0, ',', '.') }}đ</td>
                            <td>
                                @if($import->status == 'pending')
                                    <span class="badge bg-warning">Pending Approval</span>
                                @elseif($import->status == 'completed')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.import-bills.show', $import) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted">No import bills found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $importBills->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
