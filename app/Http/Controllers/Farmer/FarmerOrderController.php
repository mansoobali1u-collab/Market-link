<?php

namespace App\Http\Controllers\Farmer;

use App\Notifications\OrderReadyNotification;
use App\Notifications\OrderDeclinedNotification;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class FarmerOrderController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'farmer') {
            abort(403);
        }

        $farmerId = auth()->id();

        $orders = Order::whereHas('items', function ($query) use ($farmerId) {
                $query->where('farmer_id', $farmerId);
            })
            ->with([
                'customer',
                'items' => function ($query) use ($farmerId) {
                    $query->where('farmer_id', $farmerId)->with('product');
                },
            ])
            ->latest()
            ->paginate(10);

        return view('farmer.orders.farmer_orders', compact('orders'));
    }

    public function show(Order $order)
    {
        if (auth()->user()->role !== 'farmer') {
            abort(403);
        }

        $farmerId = auth()->id();

        $hasFarmerItems = $order->items()->where('farmer_id', $farmerId)->exists();
        if (! $hasFarmerItems) {
            abort(403);
        }

        $order->load([
            'customer',
            'items' => function ($query) use ($farmerId) {
                $query->where('farmer_id', $farmerId)->with('product');
            },
        ]);

        return view('farmer.orders.farmer_order_details', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        if (auth()->user()->role !== 'farmer') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:accepted,declined,ready',
        ]);

        $farmerId = auth()->id();

        $hasFarmerItems = $order->items()->where('farmer_id', $farmerId)->exists();
        if (! $hasFarmerItems) {
            abort(403);
        }

        $order->update([
            'status' => $request->status,
        ]);

        if ($request->status === 'ready') {
            $order->customer->notify(new OrderReadyNotification($order));
        }

        if ($request->status === 'declined') {
            $order->customer->notify(new OrderDeclinedNotification($order));
        }

        return redirect()->route('farmer.orders.show', $order)->with('success', 'Order status updated successfully.');
    }
}
