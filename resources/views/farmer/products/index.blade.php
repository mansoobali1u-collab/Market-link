@extends('layouts.farmer')

@section('title', 'My Products')

@section('content')

    <div class="flex items-center justify-between flex-wrap gap-3 mb-8">
        <div>
            <h1 class="font-display text-3xl" style="color: var(--ink);">My products</h1>
            <p class="text-sm mt-1" style="color: var(--ink-soft);">Manage your farm products and inventory.</p>
        </div>
        <a href="{{ route('farmer.products.create') }}" class="px-5 py-2 rounded-lg text-sm font-medium btn-primary">
            Add product
        </a>
    </div>

    
    <div class="rounded-lg p-6" style="background: var(--card); border: 1px solid var(--line);">

        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="font-display text-lg" style="color: var(--ink);">Product list</h2>
                <p class="text-sm mt-1" style="color: var(--ink-soft);">Your products currently listed on MarketLink.</p>
            </div>
            <p class="text-sm" style="color: var(--ink-soft);">{{ $products->total() }} products</p>
        </div>

        @if($products->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--line);">
                            <th class="py-3 px-2 font-medium" style="color: var(--ink-soft);">Product</th>
                            <th class="py-3 px-2 font-medium" style="color: var(--ink-soft);">Category</th>
                            <th class="py-3 px-2 font-medium" style="color: var(--ink-soft);">Price</th>
                            <th class="py-3 px-2 font-medium" style="color: var(--ink-soft);">Stock</th>
                            <th class="py-3 px-2 font-medium" style="color: var(--ink-soft);">Status</th>
                            <th class="py-3 px-2 font-medium" style="color: var(--ink-soft);">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr style="border-bottom: 1px solid var(--line);">
                                
                                <td class="py-4 px-2">
                                    <div class="flex items-center gap-3">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                                 class="w-12 h-12 object-cover rounded-lg"
                                                 onerror="this.onerror=null;this.replaceWith(Object.assign(document.createElement('div'), {className: 'w-12 h-12 rounded-lg flex items-center justify-center', style: 'background: var(--leaf-pale);', innerHTML: '<svg class=&quot;w-6 h-6&quot; fill=&quot;none&quot; stroke=&quot;var(--leaf)&quot; viewBox=&quot;0 0 24 24&quot; stroke-width=&quot;1.6&quot;><path stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; d=&quot;M12 3c3 2 5 5 5 9a5 5 0 01-10 0c0-4 2-7 5-9z&quot; /></svg>'}));">
                                        @else
                                            <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background: var(--leaf-pale);">
                                                <svg class="w-6 h-6" fill="none" stroke="var(--leaf)" viewBox="0 0 24 24" stroke-width="1.6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c3 2 5 5 5 9a5 5 0 01-10 0c0-4 2-7 5-9z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-medium" style="color: var(--ink);">{{ $product->name }}</p>
                                            <p class="text-xs mt-1" style="color: var(--ink-soft);">Added {{ $product->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </td>

                                
                                <td class="py-4 px-2" style="color: var(--ink-soft);">
                                    {{ $product->category->name ?? 'No category' }}
                                </td>

                                
                                <td class="py-4 px-2">
                                    <p class="font-medium" style="color: var(--ink);">Rs. {{ number_format($product->price, 2) }}</p>
                                    <p class="text-xs" style="color: var(--ink-soft);">per {{ $product->unit }}</p>
                                </td>

                                
                                <td class="py-4 px-2" style="color: var(--ink-soft);">
                                    {{ $product->stock_quantity }} {{ $product->unit }}
                                </td>

                                
                                <td class="py-4 px-2">
                                    @if($product->is_available)
                                        <span class="px-2.5 py-1 rounded text-xs font-medium" style="background: var(--leaf-pale); color: var(--leaf-dark);">
                                            Available
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded text-xs font-medium" style="background: var(--brick-pale); color: var(--brick);">
                                            Unavailable
                                        </span>
                                    @endif
                                </td>

                                
                                <td class="py-4 px-2">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('farmer.products.edit', $product) }}" class="text-sm font-medium" style="color: var(--teal);">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('farmer.products.destroy', $product) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this product?')"
                                                    class="text-sm font-medium" style="color: var(--brick);">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            
            <div class="mt-6">
                {{ $products->links() }}
            </div>

        @else
            <div class="text-center py-12">
                <div class="w-12 h-12 mx-auto mb-4 rounded-full flex items-center justify-center" style="background: var(--leaf-pale);">
                    <svg class="w-6 h-6" fill="none" stroke="var(--leaf)" viewBox="0 0 24 24" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c3 2 5 5 5 9a5 5 0 01-10 0c0-4 2-7 5-9z" />
                    </svg>
                </div>
                <h3 class="font-display text-lg" style="color: var(--ink);">No products yet</h3>
                <p class="text-sm mt-2" style="color: var(--ink-soft);">Start by adding your first product to MarketLink.</p>
                <a href="{{ route('farmer.products.create') }}" class="inline-block mt-5 px-5 py-2 rounded-lg text-sm font-medium btn-primary">
                    Add your first product
                </a>
            </div>
        @endif

    </div>

@endsection
