@extends('layouts.customer')

@section('title', 'Order #' . $order->id . ' — MarketLink')

@section('content')
    <div class="container py-4">

        <nav class="small mb-3 breadcrumb-ml">
            <a href="{{ route('dashboard') }}">Dashboard</a> /
            <a href="{{ route('customer.orders.index') }}">My Orders</a> /
            <span>Order #{{ $order->id }}</span>
        </nav>

        <div class="contact-card">

            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Order #{{ $order->id }}</h3>

                <span class="ml-status-badge ml-status-{{ $order->status }}">
                    {{ $order->status }}
                </span>
            </div>

            
            <p class="text-muted mb-1">
                <i class="bi bi-clock-fill text-success"></i>
                Pickup:
                {{ $order->pickup_date?->format('d M Y') }}
                —
                {{ $order->pickup_time }}
            </p>

            @if ($order->notes)
                <p class="text-muted mb-0">
                    <i class="bi bi-chat-left-text text-success"></i>
                    Notes: {{ $order->notes }}
                </p>
            @endif

            
            <div class="mt-4 border-top pt-4">

                @foreach ($order->items as $item)

                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">

                        <div>

                            
                            <p class="fw-semibold mb-0">
                                {{ $item->product?->name ?? 'Product no longer available' }}
                            </p>

                            
                            <p class="text-muted small mb-0">

                                Sold by
                                {{ $item->farmer?->name ?? 'Farmer no longer available' }}

                                —
                                {{ $item->quantity }}

                                x Rs {{ number_format($item->unit_price, 2) }}

                            </p>

                        </div>

                        
                        <p class="fw-semibold mb-0">
                            Rs {{ number_format($item->subtotal, 2) }}
                        </p>

                    </div>

                @endforeach

            </div>

            
            <div class="d-flex justify-content-between fw-bold mt-4 pt-3 border-top fs-5">
                <span>Total</span>

                <span>
                    Rs {{ number_format($order->total_amount, 2) }}
                </span>
            </div>

            
            @php

                $minCutoff = $order->items->min(function ($item) {
                    return $item->farmer?->order_cutoff_hours ?? 24;
                });

                $deadline = $order->pickup_date?->copy()->subHours($minCutoff);

                $canModify =
                    $order->status === 'pending' &&
                    $deadline &&
                    now()->lessThan($deadline);

            @endphp

            
            @if ($order->status === 'pending' && !$canModify)

                <p class="text-warning mt-4 mb-0">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    The cutoff time for cancelling or modifying this order has passed.
                </p>

            @endif

            
            @if ($canModify)

                <div class="d-flex gap-3 mt-4 pt-4 border-top">

                    <a href="{{ route('customer.orders.edit', $order) }}"
                       class="btn btnn-outline px-4">
                        Modify Order
                    </a>

                    <form action="{{ route('customer.orders.cancel', $order) }}"
                          method="POST"
                          onsubmit="return confirm('Cancel this order? This cannot be undone.');">

                        @csrf

                        <button type="submit"
                                class="btn btn-outline-danger px-4">
                            Cancel Order
                        </button>

                    </form>

                </div>

            @endif

        </div>

    </div>
@endsection
