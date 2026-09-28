<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom shadow p-3 fs-6 sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('images/marketlink-logo.png') }}" alt="MarketLink Logo" class="navbar-brand-logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#guestNav" aria-controls="guestNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="guestNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-success btnn px-4">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btnn-outline px-3">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-success btnn px-4 ms-3">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>
