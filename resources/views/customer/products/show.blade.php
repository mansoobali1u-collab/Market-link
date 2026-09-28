@extends('layouts.customer')

@section('title', $product->name . ' — MarketLink')

@section('content')

    <div class="container py-4">

        {{-- ===================== BREADCRUMB ===================== --}}
        <nav class="small mb-3 breadcrumb-ml">

            <a href="{{ route('dashboard') }}">
                Dashboard
            </a>

            /

            <a href="{{ route('customer.products.index') }}">
                Products
            </a>

            /

            <span>
                {{ $product->name }}
            </span>

        </nav>


        {{-- ===================== PRODUCT DETAILS ===================== --}}
        <div class="row g-4">


            {{-- ===================== PRODUCT IMAGE ===================== --}}
            <div class="col-md-5" style="position: relative;">

                {{-- Favorite button --}}
                <form
                    action="{{ route('customer.favorites.toggle', $product) }}"
                    method="POST"
                    style="
                        position: absolute;
                        top: 10px;
                        left: 10px;
                        z-index: 2;
                    "
                >

                    @csrf

                    <button
                        type="submit"
                        title="{{ $isFavorited ? 'Remove from favorites' : 'Add to favorites' }}"
                        style="
                            width: 38px;
                            height: 38px;
                            border-radius: 50%;
                            border: none;
                            background: rgba(255,255,255,0.9);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            box-shadow: 0 1px 4px rgba(0,0,0,0.15);
                            cursor: pointer;
                        "
                    >

                        <i
                            class="bi {{ $isFavorited ? 'bi-heart-fill' : 'bi-heart' }}"
                            style="
                                color: {{ $isFavorited ? '#dc3545' : '#6c757d' }};
                            "
                        ></i>

                    </button>

                </form>


                {{-- ===================== PRODUCT IMAGE ===================== --}}

                @if ($product->image)

                    @php

                        // Get only the filename
                        $imageName = basename($product->image);

                        // New image location
                        $publicImage = public_path('images/' . $imageName);

                        // Old image location
                        $storageImage = storage_path('app/public/products/' . $imageName);

                    @endphp


                    {{-- New images saved in public/images --}}
                    @if (file_exists($publicImage))

                        <img
                            src="{{ asset('images/' . $imageName) }}"
                            alt="{{ $product->name }}"
                            class="img-fluid rounded product-detail-img w-100"
                            style="
                                height: 260px;
                                object-fit: cover;
                            "
                        >


                    {{-- Old images saved in storage --}}
                    @elseif (file_exists($storageImage))

                        <img
                            src="{{ asset('storage/products/' . $imageName) }}"
                            alt="{{ $product->name }}"
                            class="img-fluid rounded product-detail-img w-100"
                            style="
                                height: 260px;
                                object-fit: cover;
                            "
                        >


                    {{-- Image does not exist --}}
                    @else

                        <div
                            class="ml-cart-thumb w-100"
                            style="
                                height: 260px;
                                border-radius: 14px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            "
                        >

                            <i
                                class="bi bi-basket-fill"
                                style="font-size: 3rem;"
                            ></i>

                        </div>

                    @endif


                @else

                    {{-- No image saved --}}
                    <div
                        class="ml-cart-thumb w-100"
                        style="
                            height: 260px;
                            border-radius: 14px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        "
                    >

                        <i
                            class="bi bi-basket-fill"
                            style="font-size: 3rem;"
                        ></i>

                    </div>

                @endif

            </div>


            {{-- ===================== PRODUCT INFORMATION ===================== --}}
            <div class="col-md-7">


                {{-- Category --}}
                @if ($product->category)

                    <span class="product-category">
                        {{ $product->category->name }}
                    </span>

                @endif


                {{-- Product name --}}
                <h2 class="mt-1 mb-1">
                    {{ $product->name }}
                </h2>


                {{-- Farmer --}}
                <p class="text-muted mb-2">

                    Sold by

                    {{ $product->farmer->name }}

                </p>


                {{-- Price + stock --}}
                <div class="d-flex align-items-center justify-content-between mb-3">

                    <span class="product-price fs-4">

                        Rs {{ number_format($product->price, 2) }}

                        <span class="fw-normal text-muted">
                            /{{ $product->unit }}
                        </span>

                    </span>


                    <span
                        class="badge-stock-inline {{ $product->stock_quantity == 0 ? 'low' : '' }}"
                    >

                        @if ($product->stock_quantity == 0)

                            Sold Out

                        @else

                            {{ $product->stock_quantity }} available

                        @endif

                    </span>

                </div>


                {{-- Description --}}
                @if ($product->description)

                    <p class="mb-4">
                        {{ $product->description }}
                    </p>

                @endif


                {{-- ===================== ADD TO CART ===================== --}}
                @auth

                    @if ($product->stock_quantity > 0)

                        <form
                            method="POST"
                            action="{{ route('customer.cart.store', $product->id) }}"
                            class="d-flex align-items-center gap-2"
                        >

                            @csrf


                            <input
                                type="number"
                                name="quantity"
                                value="1"
                                min="1"
                                max="{{ $product->stock_quantity }}"
                                class="form-control"
                                style="width: 90px;"
                            >


                            <button
                                type="submit"
                                class="btn btn-success btnn px-4"
                            >
                                Add to Cart
                            </button>

                        </form>

                    @else

                        <button
                            class="btn btn-success btnn px-4"
                            disabled
                        >
                            Sold Out
                        </button>

                    @endif

                @endauth

            </div>

        </div>


        {{-- ===================== LEAVE A REVIEW ===================== --}}
        @auth

            <div class="contact-card mt-5">

                <h5 class="mb-3">
                    Leave a Review
                </h5>


                <form
                    method="POST"
                    action="{{ route('customer.reviews.store', $product->id) }}"
                >

                    @csrf


                    {{-- Rating --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Rating
                        </label>


                        <select
                            name="rating"
                            class="form-select"
                            style="max-width: 200px;"
                            required
                        >

                            <option value="">
                                Select
                            </option>


                            @for ($i = 1; $i <= 5; $i++)

                                <option value="{{ $i }}">
                                    {{ $i }} ⭐
                                </option>

                            @endfor

                        </select>

                    </div>


                    {{-- Comment --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Comment
                        </label>


                        <textarea
                            name="comment"
                            rows="2"
                            class="form-control"
                            placeholder="Optional comment..."
                        ></textarea>

                    </div>


                    <button
                        type="submit"
                        class="btn btn-success btnn px-4"
                    >
                        Submit Review
                    </button>

                </form>

            </div>

        @endauth


        {{-- ===================== REVIEWS ===================== --}}
        <div class="mt-5">

            <h5 class="mb-3">
                Reviews
            </h5>


            @forelse ($product->reviews as $review)

                <div class="border-bottom pb-3 mb-3">


                    <div class="d-flex justify-content-between">

                        <span class="fw-semibold">
                            {{ $review->customer->name }}
                        </span>


                        <span class="ml-stars">
                            {{ str_repeat('⭐', $review->rating) }}
                        </span>

                    </div>


                    {{-- Review comment --}}
                    @if ($review->comment)

                        <p class="mb-0">
                            {{ $review->comment }}
                        </p>

                    @endif


                    {{-- Farmer response --}}
                    @if ($review->farmer_response)

                        <div
                            class="mt-2 ps-3 border-start border-success border-3 small"
                        >

                            <strong>
                                Farmer's response:
                            </strong>

                            {{ $review->farmer_response }}

                        </div>

                    @endif

                </div>


            @empty

                <p class="text-muted">
                    No reviews yet.
                </p>

            @endforelse

        </div>

    </div>


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


                window.chatbase = new Proxy(window.chatbase, {

                    get(target, prop) {

                        if (prop === "q") {
                            return target.q;
                        }

                        return (...args) => target(prop, ...args);

                    }

                });

            }


            const onLoad = function () {

                const script = document.createElement("script");

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

                window.addEventListener("load", onLoad);

            }

        })();

    </script>

@endsection