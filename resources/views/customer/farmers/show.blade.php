@extends('layouts.customer')

@section('title', $farmer->name . ' — MarketLink')

@section('content')

@php
    // IDs of products this customer has favorited (pass from controller, see notes).
    $favoriteIds = $favoriteIds ?? [];

    // Resolve a product image URL from public/images first, then storage. Returns null if not found.
    $resolveImage = function ($product) {
        if (! $product->image) {
            return null;
        }

        $name = basename($product->image);

        if (file_exists(public_path('images/' . $name))) {
            return asset('images/' . $name);
        }

        if (file_exists(storage_path('app/public/products/' . $name))) {
            return asset('storage/products/' . $name);
        }

        return null;
    };
@endphp

<style>
    .farmer-hero {
        background: linear-gradient(135deg, #f1f8f2 0%, #ffffff 60%);
        border: 1px solid #dcebdd;
        border-radius: 18px;
        padding: 1.75rem;
    }

    .farmer-avatar {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 2px 10px rgba(25, 135, 84, .25);
    }

    .farmer-contact a,
    .farmer-contact span {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        margin: 0 1.25rem .35rem 0;
        color: #495057;
        text-decoration: none;
        font-size: .95rem;
    }

    .farmer-contact i {
        color: #198754;
    }

    .farmer-count {
        background: #198754;
        color: #fff;
        border-radius: 999px;
        padding: .2rem .75rem;
        font-size: .8rem;
        font-weight: 600;
    }

    .p-card {
        background: #fff;
        border: 1px solid #e6ece7;
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: box-shadow .2s ease, transform .2s ease;
    }

    .p-card:hover {
        box-shadow: 0 8px 22px rgba(0, 0, 0, .09);
        transform: translateY(-2px);
    }

    .p-card-media {
        position: relative;
        height: 200px;
        background: #f1f8f2;
    }

    .p-card-media img,
    .p-card-media .p-placeholder {
        width: 100%;
        height: 100%;
    }

    .p-card-media img {
        object-fit: cover;
    }

    .p-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #198754;
        font-size: 3rem;
    }

    .fav-btn {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 2;
        width: 38px;
        height: 38px;
        border: none;
        border-radius: 50%;
        background: rgba(255, 255, 255, .92);
        box-shadow: 0 1px 4px rgba(0, 0, 0, .18);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform .15s ease;
    }

    .fav-btn:hover {
        transform: scale(1.1);
    }

    .fav-btn:focus-visible {
        outline: 3px solid #198754;
        outline-offset: 2px;
    }

    .stock-pill {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 2;
        font-size: .75rem;
        font-weight: 600;
        padding: .25rem .6rem;
        border-radius: 999px;
        color: #fff;
        background: #198754;
    }

    .stock-pill.out {
        background: #dc3545;
    }

    .stock-pill.low {
        background: #e08a00;
    }

    .p-card-body {
        padding: 1rem 1.1rem 1.1rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .p-card-body .p-desc {
        min-height: 2.6rem;
    }

    .p-card-footer {
        margin-top: auto;
    }

    .empty-state {
        background: #fff;
        border: 1px dashed #b7d3bb;
        border-radius: 16px;
    }

    @media (prefers-reduced-motion: reduce) {
        .p-card,
        .fav-btn {
            transition: none;
        }
    }
</style>

<div class="container py-4">

    {{-- Breadcrumb --}}
    <nav class="small mb-3 breadcrumb-ml">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        /
        <a href="{{ route('customer.farmers.index') }}">Farmers</a>
        /
        <span>{{ $farmer->name }}</span>
    </nav>

    {{-- Farmer information --}}
    <div class="farmer-hero mb-5">
        <div class="row align-items-center">

            <div class="col-md-3 col-lg-2 text-center mb-3 mb-md-0">
                <img
                    src="{{ $farmer->profile_photo_url }}"
                    alt="{{ $farmer->name }}"
                    class="rounded-circle farmer-avatar"
                >
            </div>

            <div class="col-md-9 col-lg-10">

                <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                    <h2 class="mb-0">{{ $farmer->name }}</h2>
                    <span class="farmer-count">
                        {{ $products->count() }} {{ Str::plural('product', $products->count()) }}
                    </span>
                </div>

                <p class="text-muted mb-3">
                    <i class="bi bi-person-badge"></i>
                    Local farmer on MarketLink
                </p>

                <div class="farmer-contact">
                    @if ($farmer->email)
                        <a href="mailto:{{ $farmer->email }}">
                            <i class="bi bi-envelope"></i>{{ $farmer->email }}
                        </a>
                    @endif

                    @if ($farmer->phone)
                        <a href="tel:{{ $farmer->phone }}">
                            <i class="bi bi-telephone"></i>{{ $farmer->phone }}
                        </a>
                    @endif

                    @if ($farmer->address)
                        <span>
                            <i class="bi bi-geo-alt"></i>{{ $farmer->address }}
                        </span>
                    @endif
                </div>

            </div>

        </div>
    </div>

    {{-- Products header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">

        <div>
            <h4 class="mb-1">Products by {{ $farmer->name }}</h4>
            <p class="text-muted mb-0">Fresh products available from this farmer.</p>
        </div>

        <a
            href="{{ route('customer.farmers.index') }}"
            class="btn btn-outline-success btn-sm"
        >
            <i class="bi bi-arrow-left"></i> Back to farmers
        </a>

    </div>

    @if ($products->count() > 0)

        <div class="row g-4">

            @foreach ($products as $product)

                @php
                    $imageUrl    = $resolveImage($product);
                    $isFavorited = in_array($product->id, $favoriteIds);
                    $stock       = (int) $product->stock_quantity;
                @endphp

                <div class="col-sm-6 col-lg-4">

                    <div class="p-card h-100">

                        {{-- Image, favorite button, stock badge --}}
                        <div class="p-card-media">

                            @auth
                                <form
                                    action="{{ route('customer.favorites.toggle', $product) }}"
                                    method="POST"
                                >
                                    @csrf
                                    <button
                                        type="submit"
                                        class="fav-btn"
                                        title="{{ $isFavorited ? 'Remove from favorites' : 'Add to favorites' }}"
                                        aria-label="{{ $isFavorited ? 'Remove from favorites' : 'Add to favorites' }}"
                                    >
                                        <i
                                            class="bi {{ $isFavorited ? 'bi-heart-fill' : 'bi-heart' }}"
                                            style="color: {{ $isFavorited ? '#dc3545' : '#6c757d' }};"
                                        ></i>
                                    </button>
                                </form>
                            @endauth

                            @if ($imageUrl)
                                <img src="{{ $imageUrl }}" alt="{{ $product->name }}" loading="lazy">
                            @else
                                <div class="p-placeholder">
                                    <i class="bi bi-basket-fill"></i>
                                </div>
                            @endif

                            @if ($stock === 0)
                                <span class="stock-pill out">Sold out</span>
                            @elseif ($stock <= 5)
                                <span class="stock-pill low">Only {{ $stock }} left</span>
                            @else
                                <span class="stock-pill">{{ $stock }} available</span>
                            @endif

                        </div>

                        {{-- Product information --}}
                        <div class="p-card-body">

                            @if ($product->category)
                                <span class="product-category">{{ $product->category->name }}</span>
                            @endif

                            <h5 class="mt-2 mb-1">{{ $product->name }}</h5>

                            <p class="text-muted small mb-3 p-desc">
                                {{ Str::limit($product->description, 80) }}
                            </p>

                            <div class="p-card-footer">

                                <div class="product-price mb-3">
                                    Rs {{ number_format($product->price, 2) }}
                                    <small class="text-muted">/{{ $product->unit }}</small>
                                </div>

                                <a
                                    href="{{ route('customer.products.show', $product) }}"
                                    class="btn btn-success btnn btn-sm w-100"
                                >
                                    View product
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty-state text-center py-5">
            <i class="bi bi-basket fs-1 text-muted d-block mb-3"></i>
            <h5>No products yet</h5>
            <p class="text-muted mb-3">
                This farmer hasn't listed any products. Check back soon, or browse other farmers.
            </p>
            <a href="{{ route('customer.farmers.index') }}" class="btn btn-outline-success btn-sm">
                Browse farmers
            </a>
        </div>

    @endif

</div>

@endsection