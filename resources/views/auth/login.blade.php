@extends('layouts.app')
@section('title', 'Sign In - Di Hiền Building Materials')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-sm" style="border-radius:16px;">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="auth-icon-circle">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <h4 class="fw-bold" style="color:var(--dark);">Sign In</h4>
                        <p class="text-muted small mb-0">Welcome back! Please sign in to your account.</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger py-2">
                            <ul class="mb-0 small">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="example@email.com" value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-custom w-100 btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <span class="text-muted small">Don't have an account?</span>
                        <a href="{{ route('register') }}" class="text-decoration-none fw-semibold small"> Register now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
