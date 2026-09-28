@extends('layouts.customer')

@section('title', 'Markets — MarketLink')

@section('content')
    {{-- ===================== PAGE HEADER ===================== --}}
    <section class="products-page-header py-4">
        <div class="container">
            <nav class="small mb-2 breadcrumb-ml">
                <a href="{{ route('dashboard') }}">Home</a> / <span>Markets</span>
            </nav>
            <div class="mb-3">
                <h2 class="mb-1">Discover Local Markets</h2>
                <p class="text-muted mb-0">Find nearby farmers markets and see who's selling there.</p>
            </div>
            <form method="GET" action="{{ route('customer.markets.index') }}" class="input-group search-group" style="max-width: 420px;">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search markets…">
                @if (request('search'))
                    <a href="{{ route('customer.markets.index') }}" class="btn btnn-outline" title="Clear search"><i class="bi bi-x-lg"></i></a>
                @endif
            </form>
        </div>
    </section>

    <div class="container py-4 pb-5">
        <div class="ml-map-wrap mb-4">
            <div id="markets-map" style="height: 380px;"></div>
        </div>

        <div class="row g-4">
            @forelse ($markets as $market)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('customer.markets.show', $market) }}" class="text-decoration-none text-reset">
                        <div class="card product-card h-100">
                            <span class="badge-stock">{{ $market->farmers_count }} {{ Str::plural('farmer', $market->farmers_count) }}</span>
                            <div class="card-body">
                                <h5 class="card-title mb-1">{{ $market->market_name }}</h5>
                                @if ($market->address)
                                    <p class="card-text text-muted small mb-1"><i class="bi bi-geo-alt-fill text-success"></i> {{ $market->address }}</p>
                                @endif
                                @if ($market->operating_days || $market->timings)
                                    <p class="card-text text-muted small mb-0">
                                        <i class="bi bi-clock-fill text-success"></i>
                                        {{ $market->operating_days }} @if($market->operating_days && $market->timings) &middot; @endif {{ $market->timings }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="ml-empty-state">
                        <i class="bi bi-geo-alt d-block"></i>
                        <h5>No markets yet</h5>
                        <p class="mb-0">Check back soon as markets are added.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const markets = @json($markets->filter(fn($m) => $m->latitude && $m->longitude)->values());

        const map = L.map('markets-map');
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19,
        }).addTo(map);

        if (markets.length > 0) {
            const markerGroup = L.featureGroup();

            markets.forEach(function (market) {
                const marker = L.marker([market.latitude, market.longitude])
                    .bindPopup(
                        '<strong>' + market.market_name + '</strong>' +
                        (market.address ? '<br>' + market.address : '') +
                        '<br><a href="/customer/markets/' + market.id + '">View market</a>'
                    );
                markerGroup.addLayer(marker);
            });

            markerGroup.addTo(map);
            map.fitBounds(markerGroup.getBounds().pad(0.2));
        } else {
            map.setView([24.8607, 67.0011], 11);
        }
    });
</script>
 <script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="5AqpJvqxx6qy5e-d0XFB8";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
@endpush
