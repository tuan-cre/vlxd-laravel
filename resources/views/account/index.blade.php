@extends('layouts.app')
@section('title', 'Account - Di Hiền Building Materials')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Account</li>
        </ol>
    </nav>

    <h2 class="fw-bold mb-4" style="color: var(--dark);"><i class="bi bi-person-circle me-2"></i>My Account</h2>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        @if($user->avatar ?? false)
                            <img src="{{ asset('images/avatars/' . $user->avatar) }}" alt="Avatar" class="rounded-circle" style="width:100px;height:100px;object-fit:cover;">
                        @else
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width:100px;height:100px;font-size:2.5rem;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        @endif
                    </div>
                    <h5 class="fw-bold">{{ $user->fullname }}</h5>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    <div class="d-flex justify-content-center gap-2">
                        <span class="badge bg-primary"><i class="bi bi-star me-1"></i>{{ number_format($user->points ?? 0) }} pts</span>
                        <span class="badge bg-secondary">{{ $user->level ?? 'Bronze' }}</span>
                    </div>
                </div>
            </div>

            <div class="list-group">
                <a href="{{ route('account.index') }}" class="list-group-item list-group-item-action active">
                    <i class="bi bi-person me-2"></i>Account
                </a>
                <a href="{{ route('account.orders') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-receipt me-2"></i>Orders
                </a>
                <a href="{{ route('account.addresses') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-geo-alt me-2"></i>Addresses
                </a>
                <a href="{{ route('account.points') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-star me-2"></i>Points
                </a>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Edit Profile</h5>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="fullname" class="form-control" value="{{ $user->fullname }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" name="phone_number" class="form-control" value="{{ $user->phone_number ?? '' }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" value="{{ $user->address ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="birthday" class="form-control" value="{{ $user->birthday ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="">-- Select --</option>
                                    <option value="male" {{ ($user->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ ($user->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ ($user->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Profile Photo</label>
                                <input type="file" name="avatar" class="form-control" accept="image/*">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="bi bi-check-lg me-1"></i> Update Profile
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
