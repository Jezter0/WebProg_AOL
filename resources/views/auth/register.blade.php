@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4" style="width: 420px;">
        <h1 class="text-center mb-2 text-primary fw-bold">Alloc</h1>
        <p class="text-center text-muted mb-4">Create your account</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Full Name</label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name') }}" 
                       required
                       class="form-control">
            </div>

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
                <div class="form-text">Must be at least 8 characters.</div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Confirm Password</label>
                <input type="password" 
                       name="password_confirmation" 
                       required
                       class="form-control">
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">
                Create Account
            </button>
        </form>

        <p class="text-center text-muted mt-4">
            Already have an account?
            <a href="{{ route('login') }}" class="fw-semibold text-primary">
                Login here
            </a>
        </p>
    </div>
</div>
@endsection