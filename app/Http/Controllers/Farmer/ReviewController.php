<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::whereHas('product', function ($q) {
                $q->where('farmer_id', auth()->id());
            })
            ->with(['product', 'customer'])
            ->latest('review_date')
            ->paginate(10);

        return view('farmer.reviews.index', compact('reviews'));
    }

    public function respond(Request $request, Review $review)
    {
        if ($review->product->farmer_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'farmer_response' => 'required|string|max:1000',
        ]);

        $review->update([
            'farmer_response' => $request->farmer_response,
            'farmer_response_at' => now(),
        ]);

        return back()->with('success', 'Response posted.');
    }
}
