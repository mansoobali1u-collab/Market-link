@extends('layouts.admin')

@section('title', 'Edit Category')
@section('breadcrumb', 'Edit Category')

@section('content')

<style>
    .edit-category-page {
        max-width: 1050px;
    }

    .edit-category-heading {
        margin-bottom: 24px;
    }

    .edit-category-eyebrow {
        margin: 0 0 6px;
        color: #2e7d32;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .edit-category-heading h1 {
        margin: 0;
        color: #2e3e35;
        font-size: 28px;
        font-weight: 700;
    }

    .edit-category-subtitle {
        margin: 8px 0 0;
        color: #819088;
        font-size: 14px;
    }

    .edit-category-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e3ebe6;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(46, 125, 50, 0.06);
    }

    .edit-category-card-header {
        padding: 20px 24px;
        background: #fbfdfb;
        border-bottom: 1px solid #e3ebe6;
    }

    .edit-category-card-header h2 {
        margin: 0;
        color: #2e3e35;
        font-size: 18px;
        font-weight: 700;
    }

    .edit-category-card-header p {
        margin: 5px 0 0;
        color: #819088;
        font-size: 13px;
    }

    .edit-category-card-body {
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

    .update-category-btn {
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

    .update-category-btn:hover {
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

        .edit-category-card-body {
            padding: 20px;
        }

        .category-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .update-category-btn,
        .cancel-category-btn {
            width: 100%;
            box-sizing: border-box;
        }
    }
</style>


<div class="edit-category-page">

    
    <div class="edit-category-heading">

        <p class="edit-category-eyebrow">
            CATEGORIES MANAGEMENT
        </p>

        <h1>
            Edit Category
        </h1>

        <p class="edit-category-subtitle">
            Update the information for this product category.
        </p>

    </div>


    
    <div class="edit-category-card">

        <div class="edit-category-card-header">

            <h2>
                Category Information
            </h2>

            <p>
                Change the category details below and save your updates.
            </p>

        </div>


        <div class="edit-category-card-body">

            <form
                method="POST"
                action="{{ route('admin.categories.update', $category) }}"
            >

                @csrf
                @method('PUT')

                
                @include('admin.categories._form')


                
                <div class="category-actions">

                    <button
                        type="submit"
                        class="update-category-btn"
                    >
                        <i data-lucide="save" width="16" height="16"></i>
                        Update Category
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
