@php
    $c = $category ?? null;
@endphp

<style>
    .ml-category-form {
        width: 100%;
    }

    .ml-category-field {
        width: 100%;
        margin-bottom: 22px;
    }

    .ml-category-field label {
        display: block;
        margin-bottom: 8px;
        color: #2e3e35;
        font-size: 14px;
        font-weight: 600;
    }

    .ml-category-field input[type="text"],
    .ml-category-field textarea {
        display: block;
        width: 100%;
        box-sizing: border-box;

        padding: 11px 13px;

        border: 1px solid #cfdcd3;
        border-radius: 8px;

        background: #ffffff;
        color: #2e3e35;

        font-family: Arial, sans-serif;
        font-size: 14px;

        outline: none;
    }

    .ml-category-field input[type="text"] {
        min-height: 44px;
    }

    .ml-category-field textarea {
        min-height: 120px;
        resize: vertical;
    }

    .ml-category-field input[type="text"]:focus,
    .ml-category-field textarea:focus {
        border-color: #2e7d32;
        box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.12);
    }

    .ml-category-field input::placeholder,
    .ml-category-field textarea::placeholder {
        color: #9aa69f;
    }

    .ml-category-help {
        display: block;
        margin-top: 7px;
        color: #819088;
        font-size: 12px;
        line-height: 1.5;
    }

    .ml-category-error {
        display: block;
        margin-top: 6px;
        color: #c62828;
        font-size: 12px;
    }

    .ml-category-checkbox {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 14px 16px;

        border: 1px solid #e3ebe6;
        border-radius: 8px;

        background: #fbfdfb;
    }

    .ml-category-checkbox input[type="checkbox"] {
        width: 17px;
        height: 17px;
        margin: 1px 0 0;

        accent-color: #2e7d32;

        cursor: pointer;
    }

    .ml-category-checkbox-content {
        flex: 1;
    }

    .ml-category-checkbox-label {
        display: block;
        margin: 0;
        color: #2e3e35;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }

    .ml-category-checkbox-help {
        display: block;
        margin-top: 4px;
        color: #819088;
        font-size: 12px;
        line-height: 1.5;
    }
</style>


<div class="ml-category-form">

    
    <div class="ml-category-field">

        <label for="category_name">
            Category Name
        </label>

        <input
            type="text"
            id="category_name"
            name="name"
            value="{{ old('name', $c->name ?? '') }}"
            placeholder="Enter category name"
            required
        >

        @error('name')
            <span class="ml-category-error">
                {{ $message }}
            </span>
        @enderror

    </div>


    
    <div class="ml-category-field">

        <label for="category_description">
            Description
        </label>

        <textarea
            id="category_description"
            name="description"
            placeholder="Enter a short description for this category"
        >{{ old('description', $c->description ?? '') }}</textarea>

        @error('description')
            <span class="ml-category-error">
                {{ $message }}
            </span>
        @enderror

    </div>


    
    <div class="ml-category-field">

        <div class="ml-category-checkbox">

            <input
                type="checkbox"
                id="category_active"
                name="is_active"
                value="1"
                {{ old('is_active', $c->is_active ?? true) ? 'checked' : '' }}
            >

            <div class="ml-category-checkbox-content">

                <label
                    for="category_active"
                    class="ml-category-checkbox-label"
                >
                    Active
                </label>

                <span class="ml-category-checkbox-help">
                    Active categories are visible to farmers when they add products.
                </span>

            </div>

        </div>

        @error('is_active')
            <span class="ml-category-error">
                {{ $message }}
            </span>
        @enderror

    </div>

</div>
