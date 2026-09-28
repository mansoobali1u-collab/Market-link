@extends('layouts.admin')

@section('title', 'Categories')
@section('breadcrumb', 'Categories')

@section('content')

<style>
    .categories-page {
        width: 100%;
    }

    .categories-heading {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 24px;
    }

    .categories-eyebrow {
        margin: 0 0 6px;
        color: #2e7d32;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .categories-heading h1 {
        margin: 0;
        color: #2e3e35;
        font-size: 28px;
        font-weight: 700;
    }

    .categories-subtitle {
        margin: 8px 0 0;
        color: #819088;
        font-size: 14px;
    }

    .add-category-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 18px;
        border-radius: 8px;
        background: #2e7d32;
        color: #ffffff;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
    }

    .add-category-btn:hover {
        background: #1b5e20;
    }

    .category-alert {
        margin-bottom: 20px;
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 14px;
    }

    .category-success {
        background: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #c8e6c9;
    }

    .category-error {
        background: #ffebee;
        color: #c62828;
        border: 1px solid #ffcdd2;
    }

    .categories-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e3ebe6;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(46, 125, 50, 0.06);
    }

    .categories-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 18px 20px;
        background: #fbfdfb;
        border-bottom: 1px solid #e3ebe6;
    }

    .categories-card-header h2 {
        margin: 0;
        color: #2e3e35;
        font-size: 17px;
        font-weight: 700;
    }

    .category-count {
        padding: 5px 10px;
        border-radius: 20px;
        background: #e8f5e9;
        color: #2e7d32;
        font-size: 12px;
        font-weight: 600;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .categories-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 750px;
    }

    .categories-table th {
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

    .categories-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #edf2ee;
        color: #405148;
        font-size: 14px;
        vertical-align: middle;
    }

    .categories-table tbody tr:hover {
        background: #fbfdfb;
    }

    .categories-table tbody tr:last-child td {
        border-bottom: none;
    }

    .category-name {
        color: #2e3e35;
        font-weight: 600;
    }

    .category-description {
        max-width: 300px;
        color: #819088;
    }

    .product-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 30px;
        padding: 4px 8px;
        border-radius: 6px;
        background: #f4f7f5;
        color: #50665a;
        font-size: 12px;
        font-weight: 600;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-active {
        background: #dcfce7;
        color: #166534;
    }

    .status-inactive {
        background: #f1f5f9;
        color: #64748b;
    }

    .category-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .edit-category-btn,
    .delete-category-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
    }

    .edit-category-btn {
        border: 1px solid #c8e6c9;
        background: #f1f8f2;
        color: #2e7d32;
    }

    .edit-category-btn:hover {
        background: #e8f5e9;
    }

    .delete-category-btn {
        border: 1px solid #ffcdd2;
        background: #fff5f5;
        color: #c62828;
    }

    .delete-category-btn:hover {
        background: #ffebee;
    }

    .empty-category {
        padding: 45px 20px !important;
        text-align: center;
        color: #819088 !important;
    }

    .empty-category-icon {
        width: 42px;
        height: 42px;
        margin: 0 auto 12px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f4f7f5;
        color: #819088;
    }

    .pagination-area {
        padding: 18px 20px;
        border-top: 1px solid #e3ebe6;
    }

    @media (max-width: 700px) {

        .categories-heading {
            flex-direction: column;
        }

        .add-category-btn {
            width: 100%;
            justify-content: center;
            box-sizing: border-box;
        }

        .categories-card-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .category-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .edit-category-btn,
        .delete-category-btn {
            justify-content: center;
        }
    }
</style>


<div class="categories-page">

    
    <div class="categories-heading">

        <div>
            <p class="categories-eyebrow">
                CATEGORIES MANAGEMENT
            </p>

            <h1>
                Categories
            </h1>

            <p class="categories-subtitle">
                Manage product categories used by farmers in MarketLink.
            </p>
        </div>


        <a
            href="{{ route('admin.categories.create') }}"
            class="add-category-btn"
        >
            <i data-lucide="plus" width="17" height="17"></i>
            Add Category
        </a>

    </div>


    
    @if (session('success'))

        <div class="category-alert category-success">
            {{ session('success') }}
        </div>

    @endif


    
    @if (session('error'))

        <div class="category-alert category-error">
            {{ session('error') }}
        </div>

    @endif


    
    <div class="categories-card">

        <div class="categories-card-header">

            <h2>
                All Categories
            </h2>

            <span class="category-count">
                {{ $categories->total() }} Categories
            </span>

        </div>


        <div class="table-wrapper">

            <table class="categories-table">

                <thead>

                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Products</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>

                </thead>


                <tbody>

                    @forelse ($categories as $category)

                        <tr>

                            
                            <td>
                                <span class="category-name">
                                    {{ $category->name }}
                                </span>
                            </td>


                            
                            <td>
                                <div class="category-description">
                                    {{ \Illuminate\Support\Str::limit($category->description, 60) }}
                                </div>
                            </td>


                            
                            <td>

                                <span class="product-count">
                                    {{ $category->products_count }}
                                </span>

                            </td>


                            
                            <td>

                                @if ($category->is_active)

                                    <span class="status-badge status-active">
                                        Active
                                    </span>

                                @else

                                    <span class="status-badge status-inactive">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            
                            <td>

                                <div class="category-actions">

                                    <a
                                        href="{{ route('admin.categories.edit', $category) }}"
                                        class="edit-category-btn"
                                    >
                                        <i data-lucide="pencil" width="14" height="14"></i>
                                        Edit
                                    </a>


                                    <form
                                        method="POST"
                                        action="{{ route('admin.categories.destroy', $category) }}"
                                        onsubmit="return confirm('Delete this category?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="delete-category-btn"
                                        >
                                            <i data-lucide="trash-2" width="14" height="14"></i>
                                            Delete
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="empty-category"
                            >

                                <div class="empty-category-icon">
                                    <i data-lucide="folder-open" width="22" height="22"></i>
                                </div>

                                <strong>
                                    No categories yet
                                </strong>

                                <div style="margin-top: 6px;">
                                    Farmers can't add products until at least one category exists.
                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        
        @if ($categories->hasPages())

            <div class="pagination-area">
                {{ $categories->links() }}
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
