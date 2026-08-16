@extends('layouts.app')
@section('title', 'Register - Di Hiền Building Materials')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-sm" style="border-radius:16px;">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="auth-icon-circle">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                        <h4 class="fw-bold" style="color:var(--dark);">Register</h4>
                        <p class="text-muted small mb-0">Create a new account</p>
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

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="fullname" class="form-control" placeholder="John Doe" value="{{ old('fullname') }}" required autofocus>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="example@email.com" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter your password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-custom w-100 btn-lg">
                            <i class="bi bi-person-plus me-2"></i>Register
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <span class="text-muted small">Already have an account?</span>
                        <a href="{{ route('login') }}" class="text-decoration-none fw-semibold small"> Sign In</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
