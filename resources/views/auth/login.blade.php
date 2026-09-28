@extends('layouts.public')

@section('title', 'Log In — MarketLink')

@section('content')

    <section class="auth-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="auth-card">
                        <div class="text-center mb-4">
                            <span class="hero-badge">Welcome Back</span>
                            <h2 class="mt-2 mb-1">Log In to MarketLink</h2>
                            <p class="text-muted mb-0">Access your orders, cart, and notifications.</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger small">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @session('status')
                            <div class="alert alert-success small">{{ $value }}</div>
                        @endsession

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="you@example.com" required autofocus autocomplete="username">
                            </div>

                            <div class="mb-2">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password" name="password"
                                       class="form-control"
                                       placeholder="Enter your password" required autocomplete="current-password">
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                    <label class="form-check-label small" for="remember_me">Remember me</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="small auth-link">Forgot password?</a>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-success btnn w-100 mb-3">Log In</button>
                        </form>

                        @if (Route::has('register'))
                            <p class="text-center text-muted small mb-0">
                                New to MarketLink?
                                <a href="{{ route('register') }}" class="auth-link fw-medium">Create an account</a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
