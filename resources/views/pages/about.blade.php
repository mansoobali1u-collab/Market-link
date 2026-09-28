@extends(auth()->check() && auth()->user()->role === 'user' ? 'layouts.customer' : 'layouts.public')

@section('title', 'About Us — MarketLink')

@section('content')

    <section class="products-page-header py-4">
        <div class="container">
            <nav class="small mb-2 breadcrumb-ml">
                <a href="{{ url('/') }}">Home</a> / <span>About Us</span>
            </nav>
            <h2 class="mb-1">About MarketLink</h2>
            <p class="text-muted mb-0">Farm Fresh, Just a Click Away.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <span class="section-tag">Our Story</span>
                    <h2 class="mt-2 mb-3">Bringing Farmers and Communities Closer</h2>
                    <p class="text-muted">
                        MarketLink connects local farmers-market Farmers directly with customers. Farmers list
                        their weekly stock and pricing, and customers browse, pre-order, and pick up fresh produce
                        at the market — no more wasted trips to find a stall closed or sold out.
                    </p>
                    <p class="text-muted mb-0">
                        Our platform centralizes what used to be scattered across chalkboards, flyers, and word of
                        mouth: real-time stock visibility, simple pre-ordering, and a direct line between growers
                        and the people who buy from them.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="products-section py-5">
        <div class="container">
            <div class="section-heading text-center mb-5">
                <span class="section-tag">Who It's For</span>
                <h2 class="mt-2">Built for Everyone at the Market</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="filter-card h-100 text-center">
                        <i class="bi bi-basket-fill fs-2 text-success mb-3 d-block"></i>
                        <h5>For Customers</h5>
                        <p class="text-muted small mb-0">Browse markets, place pre-orders, and pick up fresh produce on your schedule.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="filter-card h-100 text-center">
                        <i class="bi bi-flower1 fs-2 text-success mb-3 d-block"></i>
                        <h5>For Farmers</h5>
                        <p class="text-muted small mb-0">Publish weekly stock, manage pre-orders, and build lasting customer relationships.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="filter-card h-100 text-center">
                        <i class="bi bi-people-fill fs-2 text-success mb-3 d-block"></i>
                        <h5>For Communities</h5>
                        <p class="text-muted small mb-0">Strengthening the connection between local producers and the people they feed.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container text-center">
            <p class="text-muted mb-3">Have questions? We'd love to hear from you.</p>
            <a href="{{ route('contact') }}" class="btn btn-success btnn px-4">Get in Touch</a>
        </div>
    </section>

@endsection
