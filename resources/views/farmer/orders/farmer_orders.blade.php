@extends('layouts.farmer')

@section('title', 'Orders')

@section('content')

    <div class="mb-8">
        <h1 class="font-display text-3xl" style="color: var(--ink);">Orders</h1>
        <p class="text-sm mt-1" style="color: var(--ink-soft);">View and manage your customer orders.</p>
    </div>

    
    <div class="rounded-lg p-6" style="background: var(--card); border: 1px solid var(--line);">

        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="font-display text-lg" style="color: var(--ink);">Customer orders</h2>
                <p class="text-sm mt-1" style="color: var(--ink-soft);">Orders containing your products.</p>
            </div>
            <p class="text-sm" style="color: var(--ink-soft);">{{ $orders->total() }} orders</p>
        </div>

        @if($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--line);">
                            <th class="py-3 px-2 font-medium" style="color: var(--ink-soft);">Order</th>
                            <th class="py-3 px-2 font-medium" style="color: var(--ink-soft);">Customer</th>
                            <th class="py-3 px-2 font-medium" style="color: var(--ink-soft);">Products</th>
                            <th class="py-3 px-2 font-medium" style="color: var(--ink-soft);">Pickup</th>
                            <th class="py-3 px-2 font-medium" style="color: var(--ink-soft);">Total</th>
                            <th class="py-3 px-2 font-medium" style="color: var(--ink-soft);">Status</th>
                            <th class="py-3 px-2 font-medium" style="color: var(--ink-soft);">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr style="border-bottom: 1px solid var(--line);">
                                
                                <td class="py-4 px-2">
                                    <p class="font-medium" style="color: var(--ink);">#{{ $order->id }}</p>
                                    <p class="text-xs mt-1" style="color: var(--ink-soft);">{{ $order->created_at->format('d M Y') }}</p>
                                </td>

                                
                                <td class="py-4 px-2">
                                    <p class="font-medium" style="color: var(--ink);">{{ $order->customer->name ?? 'Customer' }}</p>
                                    @if($order->customer)
                                        <p class="text-xs mt-1" style="color: var(--ink-soft);">{{ $order->customer->email }}</p>
                                    @endif
                                </td>

                                
                                <td class="py-4 px-2">
                                    @foreach($order->items as $item)
                                        <div class="text-sm" style="color: var(--ink);">
                                            {{ $item->product->name ?? 'Product' }}
                                            <span style="color: var(--ink-soft);">x {{ $item->quantity }}</span>
                                        </div>
                                    @endforeach
                                </td>

                                
                                <td class="py-4 px-2" style="color: var(--ink-soft);">
                                    @if($order->pickup_date)
                                        {{ $order->pickup_date->format('d M Y') }}
                                    @else
                                        Not set
                                    @endif
                                    @if($order->pickup_time)
                                        <div class="text-xs mt-1">{{ $order->pickup_time }}</div>
                                    @endif
                                </td>

                                
                                <td class="py-4 px-2">
                                    <p class="font-medium" style="color: var(--ink);">Rs. {{ number_format($order->total_amount, 2) }}</p>
                                </td>

                                
                                <td class="py-4 px-2">
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

                                
                                <td class="py-4 px-2">
                                    <a href="{{ route('farmer.orders.show', $order) }}" class="text-sm font-medium" style="color: var(--leaf);">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            
            <div class="mt-6">
                {{ $orders->links() }}
            </div>

        @else
            <div class="text-center py-12">
                <svg class="w-10 h-10 mx-auto mb-4" fill="none" stroke="var(--ink-soft)" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="font-display text-lg" style="color: var(--ink);">No orders yet</h3>
                <p class="text-sm mt-2" style="color: var(--ink-soft);">Customer orders containing your products will appear here.</p>
            </div>
        @endif

    </div>

@endsection
