<!doctype html>
<html lang="en" data-bs-theme="light">
    <head>
        <title>@yield('title', 'MarketLink')</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Arvo:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

        <link href="{{ asset('css/marketlink-theme.css') }}" rel="stylesheet" />

        @stack('styles')
    </head>
    <body>

        @php
            $navCartCount = auth()->user()->cartItems()->sum('quantity');
            $navUnreadCount = auth()->user()->unreadNotifications()->count();
        @endphp

        <header>
            <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom shadow p-3 fs-6 sticky-top">
                <div class="container-fluid px-3 px-lg-4">
                    <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/marketlink-logo.png') }}" alt="MarketLink" class="navbar-brand-logo">
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#customerNav" aria-controls="customerNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="customerNav">
                        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('customer.products.*') ? 'active' : '' }}" href="{{ route('customer.products.index') }}">Products</a>
                            </li>    
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('customer.farmers.index') ? 'active' : '' }}" href="{{ route('customer.farmers.index') }}">Farmers</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('customer.markets.*') ? 'active' : '' }}" href="{{ route('customer.markets.index') }}">Markets</a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('customer.orders.*', 'customer.checkout') ? 'active' : '' }}" href="{{ route('customer.orders.index') }}">My Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('customer.favorites.*') ? 'active' : '' }}" href="{{ route('customer.favorites.index') }}">Favorites</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                            </li>
                        </ul>

                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('notifications.index') }}" class="btn btnn-outline px-3 position-relative {{ request()->routeIs('notifications.*') ? 'border-success text-success' : '' }}" title="Notifications">
                                <i class="bi bi-bell"></i>
                                @if ($navUnreadCount > 0)
                                    <span class="badge rounded-pill bg-danger ml-nav-badge">{{ $navUnreadCount }}</span>
                                @endif
                            </a>

                            <a href="{{ route('customer.cart.index') }}" class="btn btnn-outline px-3 position-relative {{ request()->routeIs('customer.cart.*') ? 'border-success text-success' : '' }}" title="Cart">
                                <i class="bi bi-cart3"></i>
                                @if ($navCartCount > 0)
                                    <span class="badge rounded-pill bg-success ml-nav-badge">{{ $navCartCount }}</span>
                                @endif
                            </a>

                            <div class="dropdown">
                                <button class="btn btnn-outline px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle"></i> {{ \Illuminate\Support\Str::limit(auth()->user()->name, 16) }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-grid me-2"></i>My Account</a></li>
                                    <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Log Out</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        @if (session('success'))
            <div class="container-fluid px-3 px-lg-4 mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="container-fluid px-3 px-lg-4 mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <main class="ml-main">
            @yield('content')
        </main>

        @include('partials.footer')

        <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

        @stack('scripts')
    </body>
</html>
