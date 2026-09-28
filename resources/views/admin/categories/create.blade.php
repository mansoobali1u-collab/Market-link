@extends('layouts.admin')

@section('title', 'Add Category')
@section('breadcrumb', 'Add Category')

@section('content')

<style>
    .create-category-page {
        max-width: 1050px;
    }

    .create-category-heading {
        margin-bottom: 24px;
    }

    .create-category-eyebrow {
        margin: 0 0 6px;
        color: #2e7d32;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .create-category-heading h1 {
        margin: 0;
        color: #2e3e35;
        font-size: 28px;
        font-weight: 700;
    }

    .create-category-subtitle {
        margin: 8px 0 0;
        color: #819088;
        font-size: 14px;
    }

    .create-category-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e3ebe6;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(46, 125, 50, 0.06);
    }

    .create-category-card-header {
        padding: 20px 24px;
        background: #fbfdfb;
        border-bottom: 1px solid #e3ebe6;
    }

    .create-category-card-header h2 {
        margin: 0;
        color: #2e3e35;
        font-size: 18px;
        font-weight: 700;
    }

    .create-category-card-header p {
        margin: 5px 0 0;
        color: #819088;
        font-size: 13px;
    }

    .create-category-card-body {
        padding: 28px 24px;
    }

    .category-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 28px;
        padding-top: 22px;
        border-top: 1px solid #e3ebe6;
    }

    .create-category-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 11px 20px;
        border: none;
        border-radius: 8px;
        background: #2e7d32;
        color: #ffffff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }

    .create-category-btn:hover {
        background: #1b5e20;
    }

    .cancel-category-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 10px 20px;
        border: 1px solid #d7e2db;
        border-radius: 8px;
        background: #ffffff;
        color: #50665a;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
    }

    .cancel-category-btn:hover {
        background: #f4f7f5;
        color: #2e3e35;
    }

    @media (max-width: 700px) {

        .create-category-card-body {
            padding: 20px;
        }

        .category-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .create-category-btn,
        .cancel-category-btn {
            width: 100%;
            box-sizing: border-box;
        }
    }
</style>


<div class="create-category-page">

    
    <div class="create-category-heading">

        <p class="create-category-eyebrow">
            CATEGORIES MANAGEMENT
        </p>

        <h1>
            Add Category
        </h1>

        <p class="create-category-subtitle">
            Add a new product category for farmers to use in MarketLink.
        </p>

    </div>


    
    <div class="create-category-card">

        <div class="create-category-card-header">

            <h2>
                Category Information
            </h2>

            <p>
                Enter the details of the new category below.
            </p>

        </div>


        <div class="create-category-card-body">

            <form
                method="POST"
                action="{{ route('admin.categories.store') }}"
            >

                @csrf

                
                @include('admin.categories._form')


                
                <div class="category-actions">

                    <button
                        type="submit"
                        class="create-category-btn"
                    >
                        <i data-lucide="plus" width="16" height="16"></i>
                        Create Category
                    </button>


                    <a
                        href="{{ route('admin.categories.index') }}"
                        class="cancel-category-btn"
                    >
                        <i data-lucide="arrow-left" width="16" height="16"></i>
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>


@push('scripts')

<script>
    lucide.createIcons();
</script>

@endpush

@endsection
