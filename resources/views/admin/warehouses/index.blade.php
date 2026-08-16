@extends('layouts.admin')
@section('title', 'Management Warehouses')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="m-0">Warehouses</h1>
            <a href="{{ route('admin.warehouses.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Add New</a>
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
                            <th>Warehouse Code</th>
                            <th>Warehouse Name</th>
                            <th>Address</th>
                            <th>Items Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($warehouses as $warehouse)
                        <tr>
                            <td>{{ $warehouse->id }}</td>
                            <td><span class="badge bg-secondary">{{ $warehouse->code }}</span></td>
                            <td>{{ $warehouse->name }}</td>
                            <td>{{ $warehouse->address ?? 'N/A' }}</td>
                            <td><span class="badge bg-info">{{ $warehouse->products_count ?? 0 }}</span></td>
                            <td>
                                <a href="{{ route('admin.warehouses.edit', $warehouse) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.warehouses.destroy', $warehouse) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirm delete?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted">No warehouses found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
