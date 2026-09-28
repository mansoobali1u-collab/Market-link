@extends('layouts.customer')

@section('title', 'Products — MarketLink')

@section('content')

<div class="container py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">Products</h2>

            <p class="text-muted mb-0">
                Browse fresh products from our farmers.
            </p>
        </div>

        <a href="{{ route('dashboard') }}" class="btn btn-outline-success">
            <i class="bi bi-arrow-left"></i>
            Dashboard
        </a>

    </div>


    {{-- Search and Filters --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <form method="GET" action="{{ route('customer.products.index') }}">

                <div class="row g-3">

                    {{-- Search --}}
                    <div class="col-md-5">

                        <label class="form-label fw-semibold">
                            Search Products
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-white">
                                <i class="bi bi-search"></i>
                            </span>

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                placeholder="Search products..."
                            >

                        </div>

                    </div>


                    {{-- Category --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Category
                        </label>

                        <select name="category_id" class="form-select">

                            <option value="">
                                All Categories
                            </option>

                            @foreach ($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Search Button --}}
                    <div class="col-md-3 d-flex align-items-end">

                        <button
                            type="submit"
                            class="btn btn-success w-100"
                        >
                            <i class="bi bi-search"></i>
                            Search
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Products --}}
    <div class="row g-4">

        @forelse ($products as $product)

            <div class="col-sm-6 col-lg-4">

                <div class="card h-100 border-0 shadow-sm product-card">

                    {{-- Product Image --}}
                    <div class="product-image">

                        @if ($product->image)

                            <img
                                src="{{ asset('images/' . basename($product->image)) }}"
                                alt="{{ $product->name }}"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            >

                            <div class="image-placeholder">

                                <i class="bi bi-basket3 fs-1 text-muted"></i>

                            </div>

                        @else

                            <div class="image-placeholder show-placeholder">

                                <i class="bi bi-basket3 fs-1 text-muted"></i>

                            </div>

                        @endif

                    </div>


                    {{-- Product Information --}}
                    <div class="card-body d-flex flex-column">

                        {{-- Category --}}
                        @if ($product->category)

                            <div class="mb-2">

                                <span class="badge bg-light text-success">
                                    {{ $product->category->name }}
                                </span>

                            </div>

                        @endif


                        {{-- Product Name --}}
                        <h5 class="fw-bold mb-1">
                            {{ $product->name }}
                        </h5>


                        {{-- Description --}}
                        @if ($product->description)

                            <p class="text-muted small mb-2">
                                {{ Str::limit($product->description, 80) }}
                            </p>

                        @endif


                        {{-- Farmer --}}
                        @if ($product->farmer)

                            <p class="text-muted small mb-3">

                                <i class="bi bi-person"></i>

                                Sold by

                                <strong>
                                    {{ $product->farmer->name }}
                                </strong>

                            </p>

                        @endif


                        {{-- Price --}}
                        <div class="mb-3">

                            <span class="fw-bold text-success fs-5">
                                Rs {{ number_format($product->price, 2) }}
                            </span>

                            @if ($product->unit)

                                <span class="text-muted">
                                    / {{ $product->unit }}
                                </span>

                            @endif

                        </div>


                        {{-- Stock --}}
                        <div class="mb-3">

                            @if ($product->stock_quantity > 0)

                                <span class="badge bg-success">

                                    <i class="bi bi-check-circle"></i>

                                    {{ $product->stock_quantity }} available

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    <i class="bi bi-x-circle"></i>

                                    Sold Out

                                </span>

                            @endif

                        </div>


                        {{-- View Details --}}
                        <div class="mt-auto">

                            <a
                                href="{{ route('customer.products.show', $product->id) }}"
                                class="btn btn-success w-100"
                            >

                                View Details

                                <i class="bi bi-arrow-right"></i>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            {{-- No Products --}}
            <div class="col-12">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center py-5">

                        <i class="bi bi-basket3 display-3 text-muted"></i>

                        <h4 class="fw-bold mt-3">
                            No products found
                        </h4>

                        <p class="text-muted mb-0">
                            Try searching for another product or category.
                        </p>

                    </div>

                </div>

            </div>

        @endforelse

    </div>


    {{-- Pagination --}}
    @if ($products->hasPages())

        <div class="products-pagination">

            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}

        </div>

    @endif


</div>


<style>

/* ==============================
   PRODUCT CARD
============================== */

.product-card {
    border-radius: 12px;
    overflow: hidden;
    transition: 0.2s ease;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.10) !important;
}


/* ==============================
   PRODUCT IMAGE
============================== */

.product-image {
    width: 100%;
    height: 220px;
    background: #f1f3f2;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    display: block;
}


/* ==============================
   IMAGE PLACEHOLDER
============================== */

.image-placeholder {
    width: 100%;
    height: 220px;
    display: none;
    align-items: center;
    justify-content: center;
    background: #f1f3f2;
}

.image-placeholder.show-placeholder {
    display: flex;
}


/* ==============================
   PAGINATION
============================== */

.products-pagination {
    margin-top: 40px;
    margin-bottom: 20px;

    display: flex;
    justify-content: center;
    align-items: center;

    width: 100%;
}

.products-pagination svg {
    width: 1em !important;
    height: 1em !important;
    vertical-align: middle;
}

/* Laravel pagination list */

.products-pagination .pagination {
    margin: 0;

    display: flex;
    justify-content: center;
    align-items: center;

    gap: 5px;
}


/* Pagination buttons */

.products-pagination .page-link {
    color: #198754;

    border: 1px solid #dee2e6;

    border-radius: 6px !important;

    padding: 7px 12px;

    text-decoration: none;

    background: white;
}


/* Hover */

.products-pagination .page-link:hover {
    background: #198754;
    border-color: #198754;
    color: white;
}


/* Current page */

.products-pagination .page-item.active .page-link {
    background: #198754;
    border-color: #198754;
    color: white;
}


/* Disabled */

.products-pagination .page-item.disabled .page-link {
    background: #f8f9fa;
    color: #999;
}


/* ==============================
   MOBILE
============================== */

@media (max-width: 576px) {

    .products-pagination {
        margin-top: 30px;
    }

    .products-pagination .page-link {
        padding: 6px 9px;
        font-size: 14px;
    }

}

</style>

@endsection