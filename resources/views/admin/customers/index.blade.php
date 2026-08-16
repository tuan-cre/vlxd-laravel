@extends('layouts.admin')
@section('title', 'Management Customers')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Customers</h1>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="{{ route('admin.customers.index') }}" class="row g-2">
                    <div class="col-md-5">
                        <input type="text" name="keyword" class="form-control" placeholder="Search by name, email, phone..." value="{{ request('keyword') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search me-1"></i>Search</button>
                    </div>
                </form>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Points</th>
                            <th>Total Spent</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->fullname }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone ?? 'N/A' }}</td>
                            <td><span class="badge bg-warning text-dark">{{ $customer->points ?? 0 }}</span></td>
                            <td>{{ number_format($customer->total_spent ?? 0, 0, ',', '.') }}đ</td>
                            <td>
                                <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted">No customers found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $customers->withQueryString()->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
