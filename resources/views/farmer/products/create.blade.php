@extends('layouts.farmer')

@section('title', 'Add Product')

@section('content')

    <div class="mb-8">
        <h1 class="font-display text-3xl" style="color: var(--ink);">Add product</h1>
        <p class="text-sm mt-1" style="color: var(--ink-soft);">Add a new product to your MarketLink inventory.</p>
    </div>

    <div class="max-w-3xl">
        <div class="rounded-lg p-6" style="background: var(--card); border: 1px solid var(--line);">

            
            @if ($errors->any())
                <div class="mb-6 px-5 py-4 rounded-lg text-sm" style="background: var(--brick-pale); color: var(--brick); border: 1px solid var(--line);">
                    <p class="font-semibold mb-2">Please fix the following errors:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('farmer.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                
                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium mb-2" style="color: var(--ink);">Product name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           placeholder="e.g. Fresh Tomatoes" required class="field">
                </div>

                
                <div class="mb-5">
                    <label for="category_id" class="block text-sm font-medium mb-2" style="color: var(--ink);">Category</label>
                    <select id="category_id" name="category_id" required class="field">
                        <option value="">Select category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @if($categories->count() === 0)
                        <p class="text-sm mt-2" style="color: var(--brick);">
                            No active categories are available. Please ask the administrator to add a category.
                        </p>
                    @endif
                </div>

                
                <div class="mb-5">
                    <label for="description" class="block text-sm font-medium mb-2" style="color: var(--ink);">Description</label>
                    <textarea id="description" name="description" rows="4"
                              placeholder="Describe your product..." class="field">{{ old('description') }}</textarea>
                </div>

                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label for="price" class="block text-sm font-medium mb-2" style="color: var(--ink);">Price</label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}"
                               min="0" step="0.01" placeholder="e.g. 250" required class="field">
                    </div>

                    <div>
                        <label for="unit" class="block text-sm font-medium mb-2" style="color: var(--ink);">Unit</label>
                        <select id="unit" name="unit" required class="field">
                            <option value="">Select unit</option>
                            <option value="piece" {{ old('unit') == 'piece' ? 'selected' : '' }}>Piece</option>
                            <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                            <option value="gram" {{ old('unit') == 'gram' ? 'selected' : '' }}>Gram</option>
                            <option value="dozen" {{ old('unit') == 'dozen' ? 'selected' : '' }}>Dozen</option>
                            <option value="liter" {{ old('unit') == 'liter' ? 'selected' : '' }}>Liter</option>
                            <option value="pack" {{ old('unit') == 'pack' ? 'selected' : '' }}>Pack</option>
                        </select>
                    </div>
                </div>

                
                <div class="mb-5">
                    <label for="stock_quantity" class="block text-sm font-medium mb-2" style="color: var(--ink);">Stock quantity</label>
                    <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}"
                           min="0" required class="field">
                    <p class="text-xs mt-1" style="color: var(--ink-soft);">Enter the quantity currently available.</p>
                </div>

                
                <div class="mb-5">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" id="is_recurring" name="is_recurring" value="1" {{ old('is_recurring') ? 'checked' : '' }}
                               style="accent-color: var(--leaf);">
                        <span class="text-sm font-medium" style="color: var(--ink);">Recurring weekly item</span>
                    </label>
                    <p class="text-xs mt-1" style="color: var(--ink-soft);">Check this if stock should automatically reset every week.</p>
                </div>

                
                <div class="mb-6">
                    <label for="default_stock_quantity" class="block text-sm font-medium mb-2" style="color: var(--ink);">Default weekly quantity</label>
                    <input type="number" id="default_stock_quantity" name="default_stock_quantity"
                           value="{{ old('default_stock_quantity') }}" min="0" class="field">
                    <p class="text-xs mt-1" style="color: var(--ink-soft);">
                        Stock will reset to this amount each week, for recurring items only.
                    </p>
                </div>

                
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium mb-2" style="color: var(--ink);">Product image</label>
                    <input type="file" id="image" name="image" accept="image/*"
                           class="w-full rounded-lg p-2" style="border: 1px solid var(--line);">
                    <p class="text-xs mt-1" style="color: var(--ink-soft);">Maximum file size: 2MB.</p>
                </div>

                
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('farmer.products.index') }}" class="px-5 py-2.5 rounded-lg"
                       style="border: 1px solid var(--line); color: var(--ink-soft);">
                        Cancel
                    </a>
                    <button type="submit" class="px-5 py-2.5 rounded-lg btn-primary">
                        Save product
                    </button>
                </div>

            </form>

        </div>
    </div>

@endsection
