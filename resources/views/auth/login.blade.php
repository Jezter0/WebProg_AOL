@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4" style="width: 420px;">
        <h1 class="text-center mb-2 text-primary fw-bold">Budget Manager</h1>
        <p class="text-center text-muted mb-4">Login to your account</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success small">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password"
                       name="password"
                       required
                       class="form-control">
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input"
                       type="checkbox"
                       id="remember"
                       name="remember">
                <label class="form-check-label" for="remember">
                    Remember me
                </label>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Login
            </button>
        </form>

        <p class="text-center text-muted mt-4">
            Don't have an account?
            <a href="{{ route('register') }}" class="fw-semibold text-primary">Register here</a>
        </p>
    </div>
</div>
@endsection