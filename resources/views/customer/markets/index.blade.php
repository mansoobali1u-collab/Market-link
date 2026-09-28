@extends('layouts.customer')

@section('title', 'Markets — MarketLink')

@section('content')

{{-- ===================== PAGE HEADER ===================== --}}
<section class="products-page-header py-4">
    <div class="container">

        {{-- Breadcrumb --}}
        <nav class="small mb-2 breadcrumb-ml">
            <a href="{{ route('dashboard') }}">Home</a> /
            <span>Markets</span>
        </nav>

        <div class="mb-3">
            <h2 class="mb-1">Discover Local Markets</h2>

            <p class="text-muted mb-0">
                Find nearby farmers markets and see who's selling there.
            </p>
        </div>

        {{-- Search --}}
        <form
            method="GET"
            action="{{ route('customer.markets.index') }}"
            class="input-group search-group"
            style="max-width: 420px;"
        >

            <span class="input-group-text bg-white">
                <i class="bi bi-search"></i>
            </span>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                class="form-control"
                placeholder="Search markets…"
            >

            @if (request('search'))
                <a
                    href="{{ route('customer.markets.index') }}"
                    class="btn btn-outline-secondary"
                    title="Clear search"
                >
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif

        </form>

    </div>
</section>


{{-- ===================== MAP + MARKETS ===================== --}}
<div class="container py-4 pb-5">

    <div class="row g-4 align-items-start">

        {{-- ===================== MAP ===================== --}}
        <div class="col-lg-6 col-md-12">

            <div class="card border-0 shadow-sm overflow-hidden">

                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-map text-success me-2"></i>
                        Market Locations
                    </h5>
                </div>

                <div id="markets-map" style="height: 400px;"></div>

            </div>

        </div>


        {{-- ===================== MARKETS ===================== --}}
        <div class="col-lg-6 col-md-12">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="mb-0">
                    <i class="bi bi-shop text-success me-2"></i>
                    Available Markets
                </h5>

                {{-- Back to Dashboard on RIGHT --}}
                <a
                    href="{{ route('dashboard') }}"
                    class="btn btn-outline-success btn-sm"
                >
                    <i class="bi bi-arrow-left me-1"></i>
                    Back to Dashboard
                </a>

            </div>


            <div class="row g-3">

                @forelse ($markets as $market)

                    <div class="col-12">

                        <a
                            href="{{ route('customer.markets.show', $market) }}"
                            class="text-decoration-none text-reset"
                        >

                            <div class="card product-card h-100">

                                <span class="badge-stock">
                                    {{ $market->farmers_count }}
                                    {{ Str::plural('farmer', $market->farmers_count) }}
                                </span>

                                <div class="card-body">

                                    <h5 class="card-title mb-2">
                                        {{ $market->market_name }}
                                    </h5>

                                    @if ($market->address)

                                        <p class="card-text text-muted small mb-2">
                                            <i class="bi bi-geo-alt-fill text-success me-1"></i>
                                            {{ $market->address }}
                                        </p>

                                    @endif

                                    @if ($market->operating_days || $market->timings)

                                        <p class="card-text text-muted small mb-0">
                                            <i class="bi bi-clock-fill text-success me-1"></i>

                                            {{ $market->operating_days }}

                                            @if ($market->operating_days && $market->timings)
                                                &middot;
                                            @endif

                                            {{ $market->timings }}
                                        </p>

                                    @endif

                                </div>

                            </div>

                        </a>

                    </div>

                @empty

                    <div class="col-12">

                        <div class="ml-empty-state text-center py-5">

                            <i class="bi bi-geo-alt d-block fs-1 text-muted"></i>

                            <h5>No markets yet</h5>

                            <p class="mb-0 text-muted">
                                Check back soon as markets are added.
                            </p>

                        </div>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>
```

@endsection

@push('scripts')

```
{{-- ===================== LEAFLET MAP ===================== --}}

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css"
>

<script
    src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js">
</script>


<script>

    document.addEventListener('DOMContentLoaded', function () {

        const markets = @json(
            $markets
                ->filter(fn($m) => $m->latitude && $m->longitude)
                ->values()
        );

        const map = L.map('markets-map');

        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19
            }
        ).addTo(map);


        if (markets.length > 0) {

            const markerGroup = L.featureGroup();

            markets.forEach(function (market) {

                const marketUrl =
                    "{{ url('/customer/markets') }}/" + market.id;

                const marker = L.marker([
                    parseFloat(market.latitude),
                    parseFloat(market.longitude)
                ])
                .bindPopup(

                    '<strong>' +
                    market.market_name +
                    '</strong>' +

                    (
                        market.address
                            ? '<br>' + market.address
                            : ''
                    ) +

                    '<br><br>' +

                    '<a href="' +
                    marketUrl +
                    '">' +
                    'View Market' +
                    '</a>'

                );

                markerGroup.addLayer(marker);

            });

            markerGroup.addTo(map);

            map.fitBounds(
                markerGroup.getBounds().pad(0.2)
            );

        } else {

            // Default Karachi location
            map.setView(
                [24.8607, 67.0011],
                11
            );

        }

    });

</script>


{{-- ===================== CHATBASE ===================== --}}

<script>

    (function () {

        if (
            !window.chatbase ||
            window.chatbase("getState") !== "initialized"
        ) {

            window.chatbase = (...arguments) => {

                if (!window.chatbase.q) {
                    window.chatbase.q = [];
                }

                window.chatbase.q.push(arguments);

            };

            window.chatbase = new Proxy(
                window.chatbase,
                {
                    get(target, prop) {

                        if (prop === "q") {
                            return target.q;
                        }

                        return (...args) =>
                            target(prop, ...args);

                    }
                }
            );

        }

        const onLoad = function () {

            const script =
                document.createElement("script");

            script.src =
                "https://www.chatbase.co/embed.min.js";

            script.id =
                "5AqpJvqxx6qy5e-d0XFB8";

            script.domain =
                "www.chatbase.co";

            document.body.appendChild(script);

        };

        if (document.readyState === "complete") {

            onLoad();

        } else {

            window.addEventListener(
                "load",
                onLoad
            );

        }

    })();

</script>

@endpush
