@extends('layouts.farmer')

@section('title', 'Order Details')

@section('content')

    
    <div class="mb-6">
        <a href="{{ route('farmer.orders.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium"
           style="background: var(--card); border: 1px solid var(--line); color: var(--ink-soft);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to orders
        </a>
    </div>

    @php
        $statusStyles = [
            'pending'  => ['bg' => 'var(--gold-pale)', 'fg' => 'var(--gold-dark)'],
            'accepted' => ['bg' => 'var(--teal-pale)', 'fg' => 'var(--teal)'],
            'ready'    => ['bg' => 'var(--leaf-pale)', 'fg' => 'var(--leaf-dark)'],
            'declined' => ['bg' => 'var(--brick-pale)', 'fg' => 'var(--brick)'],
        ];
        $style = $statusStyles[$order->status] ?? ['bg' => 'var(--paper-tint)', 'fg' => 'var(--ink-soft)'];
    @endphp

    
    <div class="rounded-lg p-6 mb-6" style="background: var(--card); border: 1px solid var(--line);">
        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
            <div>
                <h1 class="font-display text-2xl" style="color: var(--ink);">Order #{{ $order->id }}</h1>
                <p class="text-sm mt-1" style="color: var(--ink-soft);">Customer order information</p>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-medium" style="background: {{ $style['bg'] }}; color: {{ $style['fg'] }};">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <div class="rounded-lg p-5" style="background: var(--paper-tint);">
                <h3 class="font-display text-base mb-4" style="color: var(--ink);">Customer information</h3>
                <p class="text-sm" style="color: var(--ink-soft);">
                    <span class="font-medium" style="color: var(--ink);">Name:</span>
                    {{ $order->customer->name ?? 'N/A' }}
                </p>
                <p class="text-sm mt-2" style="color: var(--ink-soft);">
                    <span class="font-medium" style="color: var(--ink);">Email:</span>
                    {{ $order->customer->email ?? 'N/A' }}
                </p>
            </div>

            <div class="rounded-lg p-5" style="background: var(--paper-tint);">
                <h3 class="font-display text-base mb-4" style="color: var(--ink);">Pickup information</h3>
                <p class="text-sm" style="color: var(--ink-soft);">
                    <span class="font-medium" style="color: var(--ink);">Date:</span>
                    {{ $order->pickup_date ? $order->pickup_date->format('d M Y') : 'N/A' }}
                </p>
                <p class="text-sm mt-2" style="color: var(--ink-soft);">
                    <span class="font-medium" style="color: var(--ink);">Time:</span>
                    {{ $order->pickup_time ?? 'N/A' }}
                </p>
            </div>
        </div>
    </div>

    
    <div class="rounded-lg overflow-hidden mb-6" style="background: var(--card); border: 1px solid var(--line);">
        <div class="p-6" style="border-bottom: 1px solid var(--line);">
            <h2 class="font-display text-lg" style="color: var(--ink);">Ordered products</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead style="background: var(--paper-tint);">
                    <tr>
                        <th class="px-6 py-3 font-medium" style="color: var(--ink-soft);">Product</th>
                        <th class="px-6 py-3 font-medium" style="color: var(--ink-soft);">Quantity</th>
                        <th class="px-6 py-3 font-medium" style="color: var(--ink-soft);">Unit price</th>
                        <th class="px-6 py-3 font-medium" style="color: var(--ink-soft);">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->items as $item)
                        <tr style="border-top: 1px solid var(--line);">
                            <td class="px-6 py-4">
                                <div class="font-medium" style="color: var(--ink);">{{ $item->product->name ?? 'Product deleted' }}</div>
                                @if($item->product && $item->product->category)
                                    <div class="text-xs mt-0.5" style="color: var(--ink-soft);">{{ $item->product->category->name }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4" style="color: var(--ink-soft);">{{ $item->quantity }}</td>
                            <td class="px-6 py-4" style="color: var(--ink-soft);">Rs. {{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-6 py-4 font-medium" style="color: var(--ink);">Rs. {{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center" style="color: var(--ink-soft);">
                                No products found for this order.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        
        <div class="flex justify-end p-6" style="border-top: 1px solid var(--line);">
            <div class="text-right">
                <p class="text-sm" style="color: var(--ink-soft);">Order total</p>
                <p class="font-display text-2xl" style="color: var(--leaf-dark);">Rs. {{ number_format($order->total_amount, 2) }}</p>
            </div>
        </div>
    </div>

    
    @if($order->notes)
        <div class="rounded-lg p-6 mb-6" style="background: var(--card); border: 1px solid var(--line);">
            <h2 class="font-display text-lg mb-3" style="color: var(--ink);">Customer notes</h2>
            <p style="color: var(--ink-soft);">{{ $order->notes }}</p>
        </div>
    @endif

    
    <div class="rounded-lg p-6" style="background: var(--card); border: 1px solid var(--line);">
        <h2 class="font-display text-lg mb-4" style="color: var(--ink);">Order actions</h2>

        <div class="flex flex-wrap gap-3">
            @if($order->status === 'pending')
                <form method="POST" action="{{ route('farmer.orders.status', $order) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="accepted">
                    <button type="submit" class="px-5 py-2 rounded-lg text-sm font-medium" style="background: var(--teal); color: #fff;">
                        Accept order
                    </button>
                </form>

                <form method="POST" action="{{ route('farmer.orders.status', $order) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="declined">
                    <button type="submit" class="px-5 py-2 rounded-lg text-sm font-medium" style="background: var(--brick); color: #fff;">
                        Decline order
                    </button>
                </form>

            @elseif($order->status === 'accepted')
                <form method="POST" action="{{ route('farmer.orders.status', $order) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="ready">
                    <button type="submit" class="px-5 py-2 rounded-lg text-sm font-medium btn-primary">
                        Mark ready
                    </button>
                </form>

            @elseif($order->status === 'ready')
                <span class="px-4 py-2 rounded-lg text-sm font-medium" style="background: var(--leaf-pale); color: var(--leaf-dark);">
                    Order is ready for pickup
                </span>

            @elseif($order->status === 'declined')
                <span class="px-4 py-2 rounded-lg text-sm font-medium" style="background: var(--brick-pale); color: var(--brick);">
                    Order declined
                </span>
            @endif
        </div>
    </div>

@endsection
