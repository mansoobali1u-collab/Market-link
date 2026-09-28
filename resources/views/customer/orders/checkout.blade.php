@extends('layouts.customer')

@section('title', 'Checkout — MarketLink')

@section('content')
    <div class="container py-4">
        <nav class="small mb-3 breadcrumb-ml">
            <a href="{{ route('dashboard') }}">Dashboard</a> /
            <a href="{{ route('customer.cart.index') }}">Cart</a> /
            <span>Checkout</span>
        </nav>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="contact-card">
                    <h5 class="mb-3">Pickup Details</h5>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('customer.orders.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Pickup Date</label>
                            <input type="date" name="pickup_date" value="{{ old('pickup_date') }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pickup Time</label>
                            <input type="text" name="pickup_time" value="{{ old('pickup_time') }}" placeholder="e.g. 10:00 AM - 11:00 AM" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Notes (optional)</label>
                            <textarea name="notes" rows="2" class="form-control">{{ old('notes') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success btnn px-4 w-100">Place Order</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="ml-summary-card">
                    <h5 class="mb-3">Order Summary</h5>
                    @foreach ($cartItems as $item)
                        <div class="d-flex justify-content-between small py-1">
                            <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                            <span>Rs {{ number_format($item->quantity * $item->product->price, 2) }}</span>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-between fw-bold mt-3 border-top pt-3">
                        <span>Total</span>
                        <span>Rs {{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="5AqpJvqxx6qy5e-d0XFB8";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
@endsection
