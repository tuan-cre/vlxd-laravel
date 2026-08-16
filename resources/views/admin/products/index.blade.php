@extends('layouts.admin')
@section('title', 'Management Products')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="m-0">Products</h1>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Add New</a>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="{{ route('admin.products.index') }}" class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="keyword" class="form-control" placeholder="Search..." value="{{ request('keyword') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ request('status') == 0 ? 'selected' : '' }}>Hidden</option>
                        </select>
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
                            <th width="50">ID</th>
                            <th width="80">Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if($product->thumbnail)
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="" width="50" height="50" class="rounded">
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td>{{ $product->brand->name ?? 'N/A' }}</td>
                            <td>{{ number_format($product->price, 0, ',', '.') }}đ</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                @if($product->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Hidden</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirm hide product?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-center text-muted">No products found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
