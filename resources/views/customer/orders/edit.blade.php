@extends('layouts.customer')

@section('title', 'Modify Order #' . $order->id . ' — MarketLink')

@section('content')
    <div class="container py-4">
        <nav class="small mb-3 breadcrumb-ml">
            <a href="{{ route('dashboard') }}">Dashboard</a> /
            <a href="{{ route('customer.orders.show', $order) }}">Order #{{ $order->id }}</a> /
            <span>Modify</span>
        </nav>

        <div class="contact-card">
            <h3 class="mb-4">Modify Order #{{ $order->id }}</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('customer.orders.update', $order) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Pickup Date</label>
                        <input type="date" name="pickup_date"
                               value="{{ old('pickup_date', $order->pickup_date?->format('Y-m-d')) }}"
                               min="{{ now()->format('Y-m-d') }}"
                               class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pickup Time</label>
                        <input type="text" name="pickup_time" value="{{ old('pickup_time', $order->pickup_time) }}" class="form-control" required>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" rows="2" class="form-control">{{ old('notes', $order->notes) }}</textarea>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <h6 class="fw-bold mb-3">Items</h6>

                    @foreach ($order->items as $item)
                        @php
                            $available = $item->product->stock_quantity + $item->quantity;
                        @endphp
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div>
                                <p class="fw-semibold mb-0">{{ $item->product->name }}</p>
                                <p class="text-muted small mb-0">Sold by {{ $item->farmer->name }} — Rs {{ $item->unit_price }} each</p>
                                <p class="text-muted small mb-0">Max available: {{ $available }}</p>
                            </div>

                            <input type="number" name="quantities[{{ $item->id }}]"
                                   value="{{ old('quantities.' . $item->id, $item->quantity) }}"
                                   min="1" max="{{ $available }}"
                                   class="form-control text-center" style="width: 90px;" required>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-end gap-3 mt-4">
                    <a href="{{ route('customer.orders.show', $order) }}" class="btn btnn-outline px-4">Cancel</a>
                    <button type="submit" class="btn btn-success btnn px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection
