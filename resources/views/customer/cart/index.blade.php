@extends('layouts.customer')

@section('title', 'Your Cart — MarketLink')

@section('content')
    <div class="ml-page-header py-4 mb-4">
        <div class="container">
            <h2 class="mb-1">Your Cart</h2>
            <p class="text-muted mb-0">Review your items before checking out.</p>
        </div>
    </div>

    <div class="container pb-5">
        @if ($cartItems->isEmpty())
            <div class="ml-empty-state">
                <i class="bi bi-cart-x d-block"></i>
                <h5>Your cart is empty</h5>
                <p class="mb-3">Browse products and add something fresh to your cart.</p>
                <a href="{{ route('customer.products.index') }}" class="btn btn-success btnn px-4">Browse Products</a>
            </div>
        @else
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="d-flex flex-column gap-3">
                        @foreach ($cartItems as $item)
                            <div class="ml-cart-item d-flex align-items-center gap-3">
                                @if ($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}"
                                         onerror="this.onerror=null;this.replaceWith(Object.assign(document.createElement('div'), {className: 'ml-cart-thumb', innerHTML: '<i class=&quot;bi bi-basket-fill&quot;></i>'}));">
                                @else
                                    <div class="ml-cart-thumb"><i class="bi bi-basket-fill"></i></div>
                                @endif

                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $item->product->name }}</h6>
                                    <p class="text-muted small mb-1">Sold by {{ $item->product->farmer->name }}</p>
                                    <span class="product-price">Rs {{ number_format($item->product->price, 2) }} / {{ $item->product->unit }}</span>
                                </div>

                                <form method="POST" action="{{ route('customer.cart.update', $item) }}" class="d-flex align-items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                           max="{{ $item->product->stock_quantity + $item->quantity }}"
                                           class="form-control form-control-sm" style="width: 70px;">
                                    <button type="submit" class="btn btn-sm btnn-outline">Update</button>
                                </form>

                                <p class="fw-semibold mb-0" style="min-width: 90px; text-align: right;">
                                    Rs {{ number_format($item->quantity * $item->product->price, 2) }}
                                </p>

                                <form method="POST" action="{{ route('customer.cart.destroy', $item) }}"
                                      onsubmit="return confirm('Remove this item from your cart?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="ml-summary-card">
                        <h5 class="mb-3">Order Summary</h5>
                        <div class="d-flex justify-content-between text-muted small mb-2">
                            <span>{{ $cartItems->count() }} {{ Str::plural('item', $cartItems->count()) }}</span>
                            <span>Rs {{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between fw-bold border-top pt-3 mb-3">
                            <span>Total</span>
                            <span>Rs {{ number_format($total, 2) }}</span>
                        </div>
                        <a href="{{ route('customer.checkout') }}" class="btn btn-success btnn w-100">Proceed to Checkout</a>
                        <a href="{{ route('customer.products.index') }}" class="btn btnn-outline w-100 mt-2">Continue Shopping</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
     <script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="5AqpJvqxx6qy5e-d0XFB8";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
@endsection
