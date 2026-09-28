@extends('layouts.customer')

@section('title', 'My Account — MarketLink')

@section('content')

    {{-- ===================== PAGE HEADER ===================== --}}
    <section class="products-page-header py-4">
        <div class="container">
            <nav class="small mb-2 breadcrumb-ml">
                <a href="{{ route('dashboard') }}">Home</a> / <span>My Account</span>
            </nav>
            <h2 class="mb-1">Welcome back, {{ auth()->user()->name }}!</h2>
            <p class="text-muted mb-0">Browse markets, reserve fresh produce, and track your orders — all in one place.</p>
        </div>
    </section>

    <section class="products-section py-4">
        <div class="container">
            <div class="row g-4">

                {{-- ===================== SIDEBAR NAV ===================== --}}
                <div class="col-lg-3">
                    <div class="filter-card">
                        <div class="d-flex align-items-center gap-3 mb-3 pb-3 dash-user-strip">
                            <img src="{{ auth()->user()->profile_photo_url }}" class="rounded-circle" width="50" height="50" alt="Profile picture" style="object-fit: cover;">
                            <div class="overflow-hidden">
                                <h6 class="mb-0 text-truncate">{{ auth()->user()->name }}</h6>
                                <small class="text-muted d-block text-truncate">{{ auth()->user()->email }}</small>
                            </div>
                        </div>

                        <div class="nav flex-column dash-nav">
                            <a href="{{ route('dashboard') }}" class="dash-nav-link active"><i class="bi bi-grid"></i> Overview</a>
                            <a href="{{ route('customer.orders.index') }}" class="dash-nav-link"><i class="bi bi-bag-check"></i> My Orders</a>
                            <a href="{{ route('customer.cart.index') }}" class="dash-nav-link">
                                <i class="bi bi-cart3"></i> My Cart
                                @if ($cartCount > 0)
                                    <span class="badge rounded-pill bg-success ms-auto">{{ $cartCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('notifications.index') }}" class="dash-nav-link">
                                <i class="bi bi-bell"></i> Notifications
                                @if (auth()->user()->unreadNotifications->count() > 0)
                                    <span class="badge rounded-pill bg-danger ms-auto">{{ auth()->user()->unreadNotifications->count() }}</span>
                                @endif
                            </a>
                            <a href="{{ route('profile.show') }}" class="dash-nav-link"><i class="bi bi-person"></i> Profile</a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dash-nav-link text-danger"><i class="bi bi-box-arrow-right"></i> Log Out</button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- ===================== MAIN CONTENT ===================== --}}
                <div class="col-lg-9">

                    {{-- Stats --}}
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-md-3">
                            <div class="filter-card text-center">
                                <h4 class="mb-0 text-success">{{ $orderCount }}</h4>
                                <small class="text-muted">{{ Str::plural('Order', $orderCount) }} Placed</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="filter-card text-center">
                                <h4 class="mb-0 text-success">{{ $activeOrderCount }}</h4>
                                <small class="text-muted">Active Orders</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="filter-card text-center">
                                <h4 class="mb-0 text-success">{{ $cartCount }}</h4>
                                <small class="text-muted">{{ Str::plural('Item', $cartCount) }} in Cart</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="filter-card text-center">
                                <h4 class="mb-0 text-success">{{ $productCount }}</h4>
                                <small class="text-muted">Products Available</small>
                            </div>
                        </div>
                    </div>

                    {{-- Quick links --}}
                    <div class="row g-3 mb-4">
                        <div class="col-sm-4">
                            <a href="{{ route('customer.markets.index') }}" class="ml-quick-link">
                                <div class="ml-quick-icon"><i class="bi bi-geo-alt-fill"></i></div>
                                <h5 class="mb-1">Browse Markets</h5>
                                <p class="text-muted small mb-0">{{ $marketCount }} {{ Str::plural('market', $marketCount) }} to explore — see who's selling where.</p>
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="{{ route('customer.farmers.index') }}" class="ml-quick-link">
                                <div class="ml-quick-icon"><i class="bi bi-geo-alt-fill"></i></div>
                                <h5 class="mb-1">Browse Farmers</h5>
                                <p class="text-muted small mb-0">{{ $farmerCount }} {{ Str::plural('farmer', $farmerCount) }} to explore — see who's selling where.</p>
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="{{ route('customer.products.index') }}" class="ml-quick-link">
                                <div class="ml-quick-icon"><i class="bi bi-basket-fill"></i></div>
                                <h5 class="mb-1">Browse Products</h5>
                                <p class="text-muted small mb-0">See what's fresh and in stock this week.</p>
                            </a>
                        </div>
                    </div>

                    {{-- Recent orders --}}
                    <div class="filter-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="filter-card-title mb-0">Recent Orders</h6>
                            @if ($recentOrders->isNotEmpty())
                                <a href="{{ route('customer.orders.index') }}" class="small auth-link">View all</a>
                            @endif
                        </div>

                        @if ($recentOrders->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table dash-table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Date</th>
                                            <th>Items</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentOrders as $order)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('customer.orders.show', $order) }}" class="auth-link">#{{ $order->id }}</a>
                                                </td>
                                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                <td>{{ $order->items->count() }}</td>
                                                <td>Rs {{ number_format($order->total_amount, 2) }}</td>
                                                <td>
                                                    <span class="ml-status-badge ml-status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-bag fs-2 text-success d-block mb-2"></i>
                                <p class="mb-2">You haven't placed any orders yet.</p>
                                <a href="{{ route('customer.products.index') }}" class="btn btn-success btnn btn-sm">Start Shopping</a>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="5AqpJvqxx6qy5e-d0XFB8";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
@endsection
