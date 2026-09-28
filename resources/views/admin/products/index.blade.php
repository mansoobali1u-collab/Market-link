@extends('layouts.admin')

@section('title', 'Products')
@section('breadcrumb', 'Products')

@section('content')

<style>
    .products-page { width: 100%; }

    .products-heading {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .products-eyebrow { margin: 0 0 6px; color: #2e7d32; font-size: 12px; font-weight: 700; letter-spacing: 1px; }
    .products-heading h1 { margin: 0; color: #2e3e35; font-size: 28px; font-weight: 700; }
    .products-subtitle { margin: 8px 0 0; color: #819088; font-size: 14px; }

    .products-filter-form { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px; }
    .products-filter-form input,
    .products-filter-form select {
        padding: 9px 12px;
        border: 1px solid #e3ebe6;
        border-radius: 8px;
        font-size: 13px;
        color: #2e3e35;
    }
    .products-filter-form button {
        padding: 9px 16px;
        border: none;
        border-radius: 8px;
        background: #2e7d32;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }
    .products-filter-form button:hover { background: #1b5e20; }
    .products-filter-clear {
        padding: 9px 16px;
        border: 1px solid #e3ebe6;
        border-radius: 8px;
        background: #fff;
        color: #50665a;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
    }

    .product-alert { margin-bottom: 20px; padding: 12px 16px; border-radius: 8px; font-size: 14px; }
    .product-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
    .product-error { background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }

    .products-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e3ebe6;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(46, 125, 50, 0.06);
    }

    .products-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 18px 20px;
        background: #fbfdfb;
        border-bottom: 1px solid #e3ebe6;
    }

    .products-card-header h2 { margin: 0; color: #2e3e35; font-size: 17px; font-weight: 700; }

    .product-count {
        padding: 5px 10px;
        border-radius: 20px;
        background: #e8f5e9;
        color: #2e7d32;
        font-size: 12px;
        font-weight: 600;
    }

    .table-wrapper { width: 100%; overflow-x: auto; }
    .products-table { width: 100%; border-collapse: collapse; min-width: 800px; }

    .products-table th {
        padding: 14px 20px;
        background: #f8faf9;
        border-bottom: 1px solid #e3ebe6;
        color: #64756b;
        font-size: 12px;
        font-weight: 700;
        text-align: left;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .products-table td {
        padding: 14px 20px;
        border-bottom: 1px solid #edf2ee;
        color: #405148;
        font-size: 14px;
        vertical-align: middle;
    }

    .products-table tbody tr:hover { background: #fbfdfb; }
    .products-table tbody tr:last-child td { border-bottom: none; }

    .product-thumb-cell { display: flex; align-items: center; gap: 12px; }
    .product-thumb {
        width: 42px;
        height: 42px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
        border: 1px solid #e3ebe6;
    }
    .product-thumb-placeholder {
        width: 42px;
        height: 42px;
        border-radius: 8px;
        background: #f4f7f5;
        color: #819088;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .product-name { color: #2e3e35; font-weight: 600; }
    .product-farmer { color: #819088; font-size: 12px; }

    .status-badge { display: inline-block; padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .status-active { background: #dcfce7; color: #166534; }
    .status-inactive { background: #f1f5f9; color: #64748b; }

    .product-actions { display: flex; align-items: center; gap: 8px; }

    .toggle-product-btn,
    .delete-product-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
    }

    .toggle-product-btn { border: 1px solid #c8e6c9; background: #f1f8f2; color: #2e7d32; }
    .toggle-product-btn:hover { background: #e8f5e9; }

    .delete-product-btn { border: 1px solid #ffcdd2; background: #fff5f5; color: #c62828; }
    .delete-product-btn:hover { background: #ffebee; }

    .empty-product { padding: 45px 20px !important; text-align: center; color: #819088 !important; }
    .empty-product-icon {
        width: 42px; height: 42px; margin: 0 auto 12px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: #f4f7f5; color: #819088;
    }

    /* ---------- Pagination (Bootstrap markup, styled without Bootstrap CSS) ---------- */
    .pagination-area { padding: 18px 20px; border-top: 1px solid #e3ebe6; }

    .pagination-area nav {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    /* Hide the duplicate mobile-only Previous/Next block */
    .pagination-area nav > .d-sm-none { display: none; }

    /* Desktop block: "Showing x to y of z" + page buttons */
    .pagination-area nav > .d-none {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .pagination-area p {
        margin: 0;
        color: #819088;
        font-size: 13px;
    }
    .pagination-area p span { font-weight: 700; color: #2e3e35; }

    .pagination-area .pagination {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .pagination-area .page-link {
        display: block;
        min-width: 36px;
        padding: 7px 12px;
        border: 1px solid #e3ebe6;
        border-radius: 8px;
        background: #ffffff;
        color: #2e7d32;
        font-size: 13px;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
    }
    .pagination-area a.page-link:hover { background: #e8f5e9; }

    .pagination-area .page-item.active .page-link {
        background: #2e7d32;
        border-color: #2e7d32;
        color: #ffffff;
    }

    .pagination-area .page-item.disabled .page-link {
        background: #f4f7f5;
        color: #a5b3aa;
        cursor: not-allowed;
    }

    @media (max-width: 700px) {
        .products-heading { flex-direction: column; }
        .products-card-header { align-items: flex-start; flex-direction: column; }
        .product-actions { flex-direction: column; align-items: stretch; }
        .pagination-area nav > .d-none { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="products-page">

    <div class="products-heading">
        <div>
            <p class="products-eyebrow">PRODUCTS MANAGEMENT</p>
            <h1>Products</h1>
            <p class="products-subtitle">View and moderate every product listed by farmers on MarketLink.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="product-alert product-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="product-alert product-error">{{ session('error') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.products.index') }}" class="products-filter-form">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by product name...">

        <select name="category_id">
            <option value="">All Categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ (string) request('category_id') === (string) $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <select name="status">
            <option value="">All Statuses</option>
            <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
            <option value="unavailable" {{ request('status') === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
        </select>

        <button type="submit">Filter</button>
        <a href="{{ route('admin.products.index') }}" class="products-filter-clear">Reset</a>
    </form>

    <div class="products-card">

        <div class="products-card-header">
            <h2>All Products</h2>
            <span class="product-count">{{ $products->total() }} Products</span>
        </div>

        <div class="table-wrapper">
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>
                                <div class="product-thumb-cell">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-thumb"
                                             onerror="this.onerror=null;this.replaceWith(Object.assign(document.createElement('div'), {className: 'product-thumb-placeholder', innerHTML: '<i data-lucide=&quot;image-off&quot; width=&quot;16&quot; height=&quot;16&quot;></i>'})); if(window.lucide){lucide.createIcons();}">
                                    @else
                                        <div class="product-thumb-placeholder">
                                            <i data-lucide="image-off" width="16" height="16"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="product-name">{{ $product->name }}</div>
                                        <div class="product-farmer">Sold by {{ $product->farmer->name ?? 'Unknown' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $product->category->name ?? '—' }}</td>
                            <td>Rs {{ number_format($product->price, 2) }}/{{ $product->unit }}</td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td>
                                @if ($product->is_available)
                                    <span class="status-badge status-active">Available</span>
                                @else
                                    <span class="status-badge status-inactive">Unavailable</span>
                                @endif
                            </td>
                            <td>
                                <div class="product-actions">
                                    <form method="POST" action="{{ route('admin.products.toggle-availability', $product) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="toggle-product-btn">
                                            <i data-lucide="{{ $product->is_available ? 'eye-off' : 'eye' }}" width="14" height="14"></i>
                                            {{ $product->is_available ? 'Disable' : 'Enable' }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-product-btn">
                                            <i data-lucide="trash-2" width="14" height="14"></i>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-product">
                                <div class="empty-product-icon">
                                    <i data-lucide="package-search" width="22" height="22"></i>
                                </div>
                                <strong>No products found</strong>
                                <div style="margin-top: 6px;">Try adjusting your filters.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($products->hasPages())
            <div class="pagination-area">
                {{ $products->links() }}
            </div>
        @endif

    </div>

</div>

@push('scripts')
<script>
    lucide.createIcons();
</script>
@endpush

@endsection