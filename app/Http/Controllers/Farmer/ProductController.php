<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('farmer_id', auth()->id())
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('farmer.products.index', compact('products'));
    }

    public function create()
    {
        if (!auth()->user()->is_approved) {
            return redirect()
                ->route('farmer.products.index')
                ->with('error', 'Your Farmer account is pending admin approval before you can list products.');
        }

        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('farmer.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->is_approved) {
            abort(403, 'Your Farmer account is pending admin approval before you can list products.');
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'is_recurring' => 'nullable|boolean',
            'default_stock_quantity' => 'nullable|integer|min:0',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Keep the original filename
            $imageName = $image->getClientOriginalName();

            // Save the image inside public/images
            $image->move(public_path('images'), $imageName);
        }

        Product::create([
            'farmer_id' => auth()->id(),
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'unit' => $request->unit,
            'stock_quantity' => $request->stock_quantity,
            'image' => $imageName,
            'is_available' => $request->stock_quantity > 0,
            'is_recurring' => $request->has('is_recurring'),
            'default_stock_quantity' => $request->default_stock_quantity,
        ]);

        return redirect()
            ->route('farmer.products.index')
            ->with('success', 'Product added successfully.');
    }

    public function edit(Product $product)
    {
        if ($product->farmer_id !== auth()->id()) {
            abort(403);
        }

        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('farmer.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->farmer_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'is_available' => 'nullable|boolean',
            'is_recurring' => 'nullable|boolean',
            'default_stock_quantity' => 'nullable|integer|min:0',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'unit' => $request->unit,
            'stock_quantity' => $request->stock_quantity,
            'is_available' => $request->has('is_available'),
            'is_recurring' => $request->has('is_recurring'),
            'default_stock_quantity' => $request->default_stock_quantity,
        ];

        // If a new image was selected
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Keep the original filename
            $imageName = $image->getClientOriginalName();

            // Save new image inside public/images
            $image->move(public_path('images'), $imageName);

            // Save filename in database
            $data['image'] = $imageName;
        }

        $product->update($data);

        return redirect()
            ->route('farmer.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->farmer_id !== auth()->id()) {
            abort(403);
        }

        $product->delete();

        return redirect()
            ->route('farmer.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}