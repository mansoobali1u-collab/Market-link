<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $productsQuery = Product::with(['farmer', 'category']);

        if ($request->filled('search')) {
            $productsQuery->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $productsQuery->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $productsQuery->where('is_available', $request->status === 'available');
        }

        $products = $productsQuery->latest()->paginate(15)->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function toggleAvailability(Product $product)
    {
        $product->update([
            'is_available' => ! $product->is_available,
        ]);

        return back()->with('success', 'Product availability updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Product deleted.');
    }
}
