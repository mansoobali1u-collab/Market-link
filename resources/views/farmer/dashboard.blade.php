@extends('layouts.farmer')

@section('title', 'Farmer Dashboard')

@section('content')

    @php
        $hour = (int) now()->format('G');
        $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
    @endphp

    
    <div class="mb-8">
        <p class="text-sm" style="color: var(--ink-soft);">{{ now()->format('l, j F Y') }}</p>
        <h1 class="font-display text-3xl mt-1" style="color: var(--ink);">
            {{ $greeting }}, {{ explode(' ', auth()->user()->name)[0] }}
        </h1>
        <p class="text-sm mt-1" style="color: var(--ink-soft);">Here's how your stall is doing.</p>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 mb-4">

        
        <a href="{{ route('farmer.orders.index') }}"
           class="lg:col-span-5 rounded-lg p-6 flex flex-col justify-between"
           style="background: var(--leaf-dark); min-height: 190px;">
            <div>
                <p class="text-sm" style="color: #bfe0c6;">Revenue, accepted &amp; ready orders</p>
                <p class="font-display text-4xl mt-3" style="color: #fff;">
                    Rs. {{ number_format($revenue, 0) }}
                </p>
            </div>
            <p class="text-sm mt-4" style="color: var(--leaf-light);">Full order ledger</p>
        </a>

        
        <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <a href="{{ route('farmer.products.index') }}"
               class="rounded-lg p-5 flex flex-col justify-between"
               style="background: var(--card); border: 1px solid var(--line); border-top: 3px solid var(--teal);">
                <p class="text-sm" style="color: var(--ink-soft);">Products listed</p>
                <p class="font-display text-3xl mt-3" style="color: var(--ink);">{{ $productCount }}</p>
            </a>
            <a href="{{ route('farmer.products.index') }}"
               class="rounded-lg p-5 flex flex-col justify-between"
               style="background: var(--card); border: 1px solid var(--line); border-top: 3px solid var(--leaf);">
                <p class="text-sm" style="color: var(--ink-soft);">Currently available</p>
                <p class="font-display text-3xl mt-3" style="color: var(--ink);">{{ $availableProductCount }}</p>
            </a>
            <a href="{{ route('farmer.orders.index') }}"
               class="rounded-lg p-5 flex flex-col justify-between"
               style="background: var(--card); border: 1px solid var(--line); border-top: 3px solid var(--gold);">
                <p class="text-sm" style="color: var(--ink-soft);">Orders, {{ $pendingOrders }} pending</p>
                <p class="font-display text-3xl mt-3" style="color: var(--ink);">{{ $totalOrders }}</p>
            </a>
        </div>
    </div>

    
    <div class="rounded-lg p-5 mb-8" style="background: var(--card); border: 1px solid var(--line);">
        <h2 class="font-display text-lg mb-4" style="color: var(--ink);">Quick actions</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <a href="{{ route('farmer.products.create') }}"
               class="pl-4 py-3 pr-3 rounded-md border-l-4"
               style="background: var(--leaf-pale); border-color: var(--leaf);">
                <p class="font-medium text-sm" style="color: var(--leaf-dark);">Add a product</p>
                <p class="text-xs mt-0.5" style="color: var(--ink-soft);">List something new for pre-order.</p>
            </a>
            <a href="{{ route('farmer.products.index') }}"
               class="pl-4 py-3 pr-3 rounded-md border-l-4"
               style="background: var(--teal-pale); border-color: var(--teal);">
                <p class="font-medium text-sm" style="color: var(--teal);">Manage products</p>
                <p class="text-xs mt-0.5" style="color: var(--ink-soft);">Update prices, stock and availability.</p>
            </a>
            <a href="{{ route('farmer.orders.index') }}"
               class="pl-4 py-3 pr-3 rounded-md border-l-4"
               style="background: var(--gold-pale); border-color: var(--gold);">
                <p class="font-medium text-sm" style="color: var(--gold-dark);">Manage orders</p>
                <p class="text-xs mt-0.5" style="color: var(--ink-soft);">Review incoming orders and update status.</p>
            </a>
        </div>
    </div>

    
    <div class="rounded-lg p-5 mb-6" style="background: var(--card); border: 1px solid var(--line);">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-display text-lg" style="color: var(--ink);">Recent orders</h2>
            <a href="{{ route('farmer.orders.index') }}" class="text-sm font-medium" style="color: var(--leaf);">View all</a>
        </div>

        @if($recentOrders->count() > 0)
            <div class="overflow-x-auto -mx-1">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--line);">
                            <th class="py-2 px-1 font-medium" style="color: var(--ink-soft);">Order</th>
                            <th class="py-2 px-1 font-medium" style="color: var(--ink-soft);">Customer</th>
                            <th class="py-2 px-1 font-medium" style="color: var(--ink-soft);">Pickup</th>
                            <th class="py-2 px-1 font-medium" style="color: var(--ink-soft);">Total</th>
                            <th class="py-2 px-1 font-medium" style="color: var(--ink-soft);">Status</th>
                            <th class="py-2 px-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            <tr style="border-bottom: 1px solid var(--line);">
                                <td class="py-3 px-1">
                                    <p class="font-medium" style="color: var(--ink);">#{{ $order->id }}</p>
                                    <p class="text-xs" style="color: var(--ink-soft);">{{ $order->created_at->format('d M Y') }}</p>
                                </td>
                                <td class="py-3 px-1" style="color: var(--ink-soft);">
                                    {{ $order->customer?->name ?? 'Customer' }}
                                </td>
                                <td class="py-3 px-1" style="color: var(--ink-soft);">
                                    @if($order->pickup_date)
                                        {{ $order->pickup_date->format('d M Y') }}
                                    @else
                                        Not set
                                    @endif
                                    @if($order->pickup_time)
                                        <div class="text-xs">{{ $order->pickup_time }}</div>
                                    @endif
                                </td>
                                <td class="py-3 px-1" style="color: var(--ink);">
                                    Rs. {{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="py-3 px-1">
                                    @php
                                        $statusStyles = [
                                            'pending'  => ['bg' => 'var(--gold-pale)', 'fg' => 'var(--gold-dark)'],
                                            'accepted' => ['bg' => 'var(--teal-pale)', 'fg' => 'var(--teal)'],
                                            'ready'    => ['bg' => 'var(--leaf-pale)', 'fg' => 'var(--leaf-dark)'],
                                            'declined' => ['bg' => 'var(--brick-pale)', 'fg' => 'var(--brick)'],
                                        ];
                                        $style = $statusStyles[$order->status] ?? ['bg' => 'var(--paper-tint)', 'fg' => 'var(--ink-soft)'];
                                    @endphp
                                    <span class="px-2.5 py-1 rounded text-xs font-medium"
                                          style="background: {{ $style['bg'] }}; color: {{ $style['fg'] }};">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-1 text-right">
                                    <a href="{{ route('farmer.orders.show', $order) }}" class="text-sm font-medium" style="color: var(--leaf);">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-10">
                <svg class="w-8 h-8 mx-auto mb-3" fill="none" stroke="var(--ink-soft)" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="font-medium" style="color: var(--ink);">No orders yet</p>
                <p class="text-sm mt-1" style="color: var(--ink-soft);">Orders from customers will show up here once they check out.</p>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        
        <div class="rounded-lg p-5" style="background: var(--card); border: 1px solid var(--line);">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-display text-lg" style="color: var(--ink);">Recent products</h2>
                <a href="{{ route('farmer.products.index') }}" class="text-sm font-medium" style="color: var(--leaf);">View all</a>
            </div>

            @if($recentProducts->count() > 0)
                <div class="space-y-3">
                    @foreach($recentProducts as $product)
                        <div class="flex items-center justify-between py-2" style="border-bottom: 1px solid var(--line);">
                            <div class="min-w-0">
                                <p class="font-medium text-sm truncate" style="color: var(--ink);">{{ $product->name }}</p>
                                <p class="text-xs" style="color: var(--ink-soft);">
                                    {{ $product->category?->name ?? 'No category' }} &middot; {{ $product->stock_quantity }} {{ $product->unit }}
                                </p>
                            </div>
                            <div class="text-right shrink-0 ml-3">
                                <p class="text-sm font-medium" style="color: var(--ink);">Rs. {{ number_format($product->price, 2) }}</p>
                                @if($product->is_available)
                                    <span class="text-xs font-medium" style="color: var(--leaf-dark);">Available</span>
                                @else
                                    <span class="text-xs font-medium" style="color: var(--brick);">Unavailable</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="font-medium" style="color: var(--ink);">No products yet</p>
                    <p class="text-sm mt-1" style="color: var(--ink-soft);">Add your first product to open your stall.</p>
                    <a href="{{ route('farmer.products.create') }}"
                       class="inline-block mt-4 px-4 py-2 rounded-md text-sm font-medium btn-primary">
                        Add product
                    </a>
                </div>
            @endif
        </div>

        
        <div class="rounded-lg p-5" style="background: var(--card); border: 1px solid var(--line);">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-display text-lg" style="color: var(--ink);">Best sellers</h2>
                <a href="{{ route('farmer.products.index') }}" class="text-sm font-medium" style="color: var(--leaf);">View products</a>
            </div>

            @if($bestSellers->count() > 0)
                <div class="space-y-3">
                    @foreach($bestSellers as $item)
                        <div class="flex items-center justify-between py-2" style="border-bottom: 1px solid var(--line);">
                            <div class="min-w-0">
                                <p class="font-medium text-sm truncate" style="color: var(--ink);">
                                    {{ $item->product?->name ?? 'Product unavailable' }}
                                </p>
                                <p class="text-xs" style="color: var(--ink-soft);">{{ $item->total_quantity }} units sold</p>
                            </div>
                            <p class="text-sm font-medium shrink-0 ml-3" style="color: var(--ink);">
                                Rs. {{ number_format($item->total_revenue, 2) }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="font-medium" style="color: var(--ink);">No sales yet</p>
                    <p class="text-sm mt-1" style="color: var(--ink-soft);">Best sellers will appear once orders come in.</p>
                </div>
            @endif
        </div>
    </div>

@endsection
