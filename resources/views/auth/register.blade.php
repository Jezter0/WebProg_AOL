@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="d-flex justify-content-center align-items-center auth-wrapper">
    <div class="card auth-card">
        <h1 class="text-center mb-1 alloc-logo">Al<span>loc</span></h1>
        <p class="text-center text-muted mb-4">Create your account</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Full name</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    class="form-control"
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="form-control"
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input
                    type="password"
                    name="password"
                    required
                    class="form-control"
                >
                <div class="form-text small">
                    Minimum 8 characters
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    required
                    class="form-control"
                >
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">
                Create account
            </button>
        </form>

        <p class="text-center text-muted mt-4 mb-0">
            Already have an account?
            <a href="{{ route('login') }}" class="auth-link">
                Login
            </a>
        </p>
    </div>
</div>
@endsection