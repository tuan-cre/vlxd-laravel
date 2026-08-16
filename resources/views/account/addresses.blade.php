@extends('layouts.app')
@section('title', 'Addresses - Di Hiền Building Materials')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('account.index') }}">Account</a></li>
            <li class="breadcrumb-item active">Addresses</li>
        </ol>
    </nav>

    <h2 class="fw-bold mb-4" style="color: var(--dark);"><i class="bi bi-geo-alt me-2"></i>My Addresses</h2>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="list-group">
                <a href="{{ route('account.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-person me-2"></i>Account
                </a>
                <a href="{{ route('account.orders') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-receipt me-2"></i>Orders
                </a>
                <a href="{{ route('account.addresses') }}" class="list-group-item list-group-item-action active">
                    <i class="bi bi-geo-alt me-2"></i>Addresses
                </a>
                <a href="{{ route('account.points') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-star me-2"></i>Points
                </a>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Default Address</h5>
                    @if($user->address ?? false)
                        <div class="d-flex align-items-start">
                            <i class="bi bi-geo-alt-fill text-primary fs-4 me-3 mt-1"></i>
                            <div>
                                <p class="fw-semibold mb-1">{{ $user->fullname }}</p>
                                <p class="mb-1">{{ $user->phone_number ?? '' }}</p>
                                <p class="text-muted mb-0">{{ $user->address }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-muted mb-0">No default address set. Please update your account information.</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Add New Address</h5>
                    <form action="{{ route('account.update') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">New Address</label>
                                <input type="text" name="address" class="form-control" placeholder="Street address, city, state, zip code" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="bi bi-check-lg me-1"></i> Update Address
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
