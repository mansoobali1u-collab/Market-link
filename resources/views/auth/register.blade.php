@extends('layouts.public')

@section('title', 'Create Account — MarketLink')

@section('content')

    <section class="auth-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="auth-card">
                        <div class="text-center mb-4">
                            <span class="hero-badge">Join MarketLink</span>
                            <h2 class="mt-2 mb-1">Create Your Account</h2>
                            <p class="text-muted mb-0">Join as a customer to pre-order fresh produce, or as a farmer to sell it.</p>
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

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Your full name" required autofocus autocomplete="name">
                                </div>

                                <div class="col-md-6">
                                    <label for="role" class="form-label">Register As</label>
                                    <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                                        <option value="user" {{ old('role', 'user') === 'user' ? 'selected' : '' }}>Customer</option>
                                        <option value="farmer" {{ old('role') === 'farmer' ? 'selected' : '' }}>Farmer</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                                           class="form-control @error('email') is-invalid @enderror"
                                           placeholder="you@example.com" required autocomplete="username">
                                </div>

                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <input id="password" type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Create a password" required autocomplete="new-password">
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation"
                                           class="form-control"
                                           placeholder="Re-enter password" required autocomplete="new-password">
                                </div>

                                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" name="terms" id="terms" required>
                                            <label class="form-check-label small" for="terms">
                                                I agree to the
                                                <a target="_blank" href="{{ route('terms.show') }}" class="auth-link">Terms of Service</a>
                                                and
                                                <a target="_blank" href="{{ route('policy.show') }}" class="auth-link">Privacy Policy</a>
                                            </label>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-12">
                                    <button type="submit" class="btn btn-success btnn w-100">Create Account</button>
                                </div>
                            </div>
                        </form>

                        <p class="text-center text-muted small mt-4 mb-0">
                            Already have an account?
                            <a href="{{ route('login') }}" class="auth-link fw-medium">Log in</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
