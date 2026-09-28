@extends('layouts.customer')

@section('title', 'My Orders — MarketLink')

@section('content')
    <div class="ml-page-header py-4 mb-4">
        <div class="container">
            <nav class="small mb-2 breadcrumb-ml">
                <a href="{{ route('dashboard') }}">Dashboard</a> / <span>My Orders</span>
            </nav>
            <h2 class="mb-1">My Orders</h2>
            <p class="text-muted mb-0">Track the status of every order you've placed.</p>
        </div>
    </div>

    <div class="container pb-5">
        @forelse ($orders as $order)
            <a href="{{ route('customer.orders.show', $order->id) }}" class="text-decoration-none text-reset">
                <div class="ml-cart-item d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-1">Order #{{ $order->id }}</h6>
                        <p class="text-muted small mb-0">{{ $order->items->count() }} item(s) &middot; Rs {{ number_format($order->total_amount, 2) }}</p>
                        <p class="text-muted small mb-0">Pickup: {{ $order->pickup_date?->format('d M Y') }} {{ $order->pickup_time }}</p>
                    </div>
                    <span class="ml-status-badge ml-status-{{ $order->status }}">{{ $order->status }}</span>
                </div>
            </a>
        @empty
            <div class="ml-empty-state">
                <i class="bi bi-receipt d-block"></i>
                <h5>No orders yet</h5>
                <p class="mb-3">Once you place an order, it'll show up here.</p>
                <a href="{{ route('customer.products.index') }}" class="btn btn-success btnn px-4">Browse Products</a>
            </div>
        @endforelse

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
     <script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="5AqpJvqxx6qy5e-d0XFB8";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
@endsection
