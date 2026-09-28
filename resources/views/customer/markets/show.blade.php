@extends('layouts.customer')

@section('title', $market->market_name . ' — MarketLink')

@section('content')
    <div class="ml-page-header py-4 mb-4">
        <div class="container">
            <nav class="small mb-2 breadcrumb-ml">
                <a href="{{ route('dashboard') }}">Dashboard</a> /
                <a href="{{ route('customer.markets.index') }}">Markets</a> /
                <span>{{ $market->market_name }}</span>
            </nav>
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                <div>
                    <h2 class="mb-1">{{ $market->market_name }}</h2>
                    @if ($market->address)
                        <p class="text-muted mb-1"><i class="bi bi-geo-alt-fill text-success"></i> {{ $market->address }}</p>
                    @endif
                    @if ($market->operating_days || $market->timings)
                        <p class="text-muted mb-0">
                            <i class="bi bi-clock-fill text-success"></i>
                            {{ $market->operating_days }} @if($market->operating_days && $market->timings) &middot; @endif {{ $market->timings }}
                        </p>
                    @endif
                </div>
                <a href="{{ route('customer.markets.index') }}" class="btn btnn-outline">&larr; All markets</a>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        @if ($market->latitude && $market->longitude)
            <div class="ml-map-wrap mb-4">
                <div id="market-map" style="height: 300px;"></div>
            </div>
        @endif

        <h4 class="mb-3">Farmers at this market ({{ $farmers->count() }})</h4>

        <div class="row g-4">
            @forelse ($farmers as $farmer)
                <div class="col-lg-4 col-md-6">
                    <div class="card product-card h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-1">{{ $farmer->business_name ?: $farmer->name }}</h5>
                            @if ($farmer->business_name)
                                <p class="card-text text-muted small mb-1">{{ $farmer->name }}</p>
                            @endif
                            @if ($farmer->pickup_window)
                                <p class="card-text text-muted small mb-2"><i class="bi bi-clock-fill text-success"></i> Pickup: {{ $farmer->pickup_window }}</p>
                            @endif
                            <span class="product-category">{{ $farmer->products_count }} {{ Str::plural('product', $farmer->products_count) }} available</span>

                            <div class="mt-3">
                                <a href="{{ route('customer.products.index', ['farmer_id' => $farmer->id]) }}" class="btn btn-success btnn btn-sm w-100">
                                    View Products
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="ml-empty-state">
                        <i class="bi bi-person-x d-block"></i>
                        <h5>No approved farmers yet</h5>
                        <p class="mb-0">This market doesn't have any active farmers set up yet.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@if ($market->latitude && $market->longitude)
    @push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const lat = {{ $market->latitude }};
            const lng = {{ $market->longitude }};

            const map = L.map('market-map').setView([lat, lng], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19,
            }).addTo(map);

            L.marker([lat, lng]).addTo(map)
                .bindPopup(@json($market->market_name))
                .openPopup();
        });
    </script>
    @endpush
@endif
