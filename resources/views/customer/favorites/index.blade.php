@extends('layouts.customer')

@section('title', 'My Favorites — MarketLink')

@section('content')

```
<section class="products-page-header py-4">

    <div class="container">

        <nav class="small mb-2 breadcrumb-ml">

            <a href="{{ route('dashboard') }}">
                Home
            </a>

            /
            <span>
                Favorites
            </span>

        </nav>

        <h2 class="mb-1">
            My Favorites
        </h2>

        <p class="text-muted mb-0">
            Products you've saved for later.
        </p>

    </div>

</section>


<section class="products-section py-4">

    <div class="container">

        @if (session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif


        <div class="row g-4">

            @forelse ($favorites as $favorite)

                @php
                    $product = $favorite->product;
                @endphp


                @if ($product)

                    <div class="col-lg-4 col-md-6">

                        <div
                            class="card product-card h-100"
                            style="position: relative;"
                        >

                            {{-- Stock Badge --}}
                            <span
                                class="badge-stock {{ $product->stock_quantity == 0 ? 'low' : '' }}"
                            >

                                {{
                                    $product->stock_quantity == 0
                                        ? 'Sold Out'
                                        : (
                                            $product->stock_quantity <= 5
                                                ? 'Only ' . $product->stock_quantity . ' left'
                                                : 'In Stock'
                                        )
                                }}

                            </span>


                            {{-- Remove Favorite --}}
                            <form
                                action="{{ route('customer.favorites.destroy', $product) }}"
                                method="POST"
                                style="
                                    position: absolute;
                                    top: 10px;
                                    left: 10px;
                                    z-index: 2;
                                "
                            >

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    title="Remove from favorites"
                                    style="
                                        width: 34px;
                                        height: 34px;
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
                                        class="bi bi-heart-fill"
                                        style="color: #dc3545;"
                                    ></i>

                                </button>

                            </form>


                            {{-- Product Image --}}
                            @if ($product->image)

                                <img
                                    src="{{ asset('images/' . basename($product->image)) }}"
                                    class="card-img-top"
                                    alt="{{ $product->name }}"
                                    onerror="this.onerror=null; this.replaceWith(Object.assign(document.createElement('div'), {
                                        className: 'ml-img-placeholder',
                                        innerHTML: '<i class=&quot;bi bi-basket&quot;></i>'
                                    }));"
                                >

                            @else

                                <div class="ml-img-placeholder">

                                    <i class="bi bi-basket"></i>

                                </div>

                            @endif


                            {{-- Product Details --}}
                            <div class="card-body">

                                {{-- Category --}}
                                @if ($product->category)

                                    <span class="product-category">
                                        {{ $product->category->name }}
                                    </span>

                                @endif


                                {{-- Product Name --}}
                                <h5 class="card-title mb-1">

                                    {{ $product->name }}

                                </h5>


                                {{-- Farmer --}}
                                <p class="card-text text-muted small mb-2">

                                    Sold by
                                    {{ $product->farmer->name ?? 'Unknown' }}

                                </p>


                                {{-- Price --}}
                                <div
                                    class="d-flex justify-content-between align-items-center"
                                >

                                    <span class="product-price">

                                        Rs
                                        {{ number_format($product->price, 2) }}

                                        <span class="fw-normal text-muted">
                                            /{{ $product->unit }}
                                        </span>

                                    </span>

                                </div>


                                {{-- View Details --}}
                                <a
                                    href="{{ route('customer.products.show', $product) }}"
                                    class="btn btnn-outline btn-sm w-100 mt-3"
                                >

                                    View Details

                                </a>

                            </div>

                        </div>

                    </div>

                @endif

            @empty

                {{-- No Favorites --}}
                <div class="col-12">

                    <div class="products-empty text-center py-5">

                        <i class="bi bi-heart"></i>

                        <h5 class="mt-3">
                            No Favorites Yet
                        </h5>

                        <p class="text-muted">
                            Tap the heart icon on any product to save it here.
                        </p>

                        <a
                            href="{{ route('customer.products.index') }}"
                            class="btn btn-success btnn"
                        >
                            Browse Products
                        </a>

                    </div>

                </div>

            @endforelse

        </div>


        {{-- Pagination --}}
        <div class="mt-4">

            {{ $favorites->links() }}

        </div>

    </div>

</section>
```

@endsection
