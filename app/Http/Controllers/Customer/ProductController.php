<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $productsQuery = Product::with(['farmer', 'category'])
            ->where('is_available', true);

        if ($request->filled('category_id')) {
            $productsQuery->where('category_id', $request->category_id);
        }

        if ($request->filled('farmer_id')) {
            $productsQuery->where('farmer_id', $request->farmer_id);
        }

        if ($request->filled('search')) {
            $productsQuery->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('min_price') && is_numeric($request->min_price)) {
            $productsQuery->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price') && is_numeric($request->max_price)) {
            $productsQuery->where('price', '<=', $request->max_price);
        }

        if ($request->boolean('in_stock')) {
            $productsQuery->where('stock_quantity', '>', 0);
        }

        match ($request->input('sort')) {
            'price_asc' => $productsQuery->orderBy('price', 'asc'),
            'price_desc' => $productsQuery->orderBy('price', 'desc'),
            'name' => $productsQuery->orderBy('name', 'asc'),
            default => $productsQuery->latest(),
        };

        $products = $productsQuery->paginate(12)->withQueryString();

        $categories = Category::where('is_active', true)->orderBy('name')->get();

        $selectedFarmer = null;
        if ($request->filled('farmer_id')) {
            $selectedFarmer = User::find($request->farmer_id);
        }

        $favoritedProductIds = auth()->user()->favorites()
            ->pluck('product_id')
            ->toArray();

        return view('customer.products.index', compact('products', 'categories', 'selectedFarmer', 'favoritedProductIds'));
    }

    public function show(Product $product)
    {
        $product->load(['farmer', 'category', 'reviews.customer']);

        $isFavorited = auth()->user()->hasFavorited($product->id);

        return view('customer.products.show', compact('product', 'isFavorited'));
    }
}
