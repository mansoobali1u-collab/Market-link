<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with('product.category', 'product.farmer')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(12);

        return view('customer.favorites.index', compact('favorites'));
    }

    public function toggle(Request $request, Product $product)
    {
        $userId = auth()->id();

        $favorite = Favorite::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $isFavorited = false;
            $message = 'Removed from favorites.';
        } else {
            Favorite::create([
                'user_id' => $userId,
                'product_id' => $product->id,
            ]);
            $isFavorited = true;
            $message = 'Added to favorites.';
        }

        if ($request->wantsJson()) {
            return response()->json([
                'favorited' => $isFavorited,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }

    public function destroy(Product $product)
    {
        Favorite::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->delete();

        return back()->with('success', 'Removed from favorites.');
    }
}
