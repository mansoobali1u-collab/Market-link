@php
    $footerIsCustomer = auth()->check() && auth()->user()->role === 'user';
    $footerCategories = $footerIsCustomer
        ? \App\Models\Category::where('is_active', true)->orderBy('name')->take(5)->get()
        : collect();
@endphp

<footer class="ml-footer">
    <div class="container py-5">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6">
                <img src="{{ asset('images/marketlink-logo.png') }}" alt="MarketLink Logo" class="footer-logo mb-3">
                <p class="footer-text">Connecting local farmers with customers. Fresh produce, weekly stock, and easy pickup pre-orders — Farm Fresh, Just a Click Away.</p>
            </div>

            <div class="col-lg-2 col-md-6">
                <h6 class="footer-heading">Quick Links</h6>
                <ul class="footer-links">
                    @if ($footerIsCustomer)
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('customer.markets.index') }}">Markets</a></li>
                        <li><a href="{{ route('customer.products.index') }}">Products</a></li>
                        <li><a href="{{ route('customer.orders.index') }}">My Orders</a></li>
                    @elseif (auth()->check())
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @endif
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>

            @if ($footerCategories->isNotEmpty())
                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-heading">Categories</h6>
                    <ul class="footer-links">
                        @foreach ($footerCategories as $footerCategory)
                            <li><a href="{{ route('customer.products.index', ['category_id' => $footerCategory->id]) }}">{{ $footerCategory->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="{{ $footerCategories->isNotEmpty() ? 'col-lg-3' : 'col-lg-3 offset-lg-3' }} col-md-6">
                <h6 class="footer-heading">Contact Us</h6>
                <ul class="footer-links">
                    <li><i class="bi bi-geo-alt"></i> Karachi, Pakistan</li>
                    <li><i class="bi bi-envelope"></i> support@marketlink.example</li>
                    <li><i class="bi bi-telephone"></i> +92 300 0000000</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-bottom text-center py-3">
        <p class="mb-0">&copy; {{ date('Y') }} MarketLink. All rights reserved.</p>
    </div>
</footer>
