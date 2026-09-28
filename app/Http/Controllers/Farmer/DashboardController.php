<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $farmerId = Auth::id();

        // =========================
        // PRODUCTS
        // =========================

        $productCount = Product::where('farmer_id', $farmerId)
            ->count();

        $availableProductCount = Product::where('farmer_id', $farmerId)
            ->where('is_available', true)
            ->count();

        $recentProducts = Product::where('farmer_id', $farmerId)
            ->latest()
            ->take(5)
            ->get();


        // =========================
        // TOTAL ORDERS
        // =========================

        $totalOrders = Order::whereHas('items', function ($query) use ($farmerId) {
            $query->where('farmer_id', $farmerId);
        })->count();


        // =========================
        // PENDING ORDERS
        // =========================

        $pendingOrderCount = Order::whereHas('items', function ($query) use ($farmerId) {
            $query->where('farmer_id', $farmerId);
        })
        ->where('status', 'pending')
        ->count();

        $pendingOrders = Order::whereHas('items', function ($query) use ($farmerId) {
            $query->where('farmer_id', $farmerId);
        })
        ->where('status', 'pending')
        ->latest()
        ->take(5)
        ->get();


        // =========================
        // RECENT ORDERS
        // =========================

        $recentOrders = Order::whereHas('items', function ($query) use ($farmerId) {
            $query->where('farmer_id', $farmerId);
        })
        ->latest()
        ->take(5)
        ->get();


        // =========================
        // REVENUE
        // =========================

        $revenue = OrderItem::where('farmer_id', $farmerId)
            ->whereHas('order', function ($query) {
                $query->whereIn('status', [
                    'accepted',
                    'ready',
                    'completed'
                ]);
            })
            ->with('product')
            ->get()
            ->sum(function ($item) {
                return ($item->product->price ?? 0)
                    * ($item->quantity ?? 0);
            });


        // =========================
        // BEST SELLERS
        // =========================

        $bestSellers = OrderItem::where('farmer_id', $farmerId)
            ->selectRaw('product_id, SUM(quantity) as total_sold')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product')
            ->take(5)
            ->get();


        // =========================
        // SEND DATA TO DASHBOARD
        // =========================

        return view('farmer.dashboard', compact(
            'productCount',
            'availableProductCount',
            'recentProducts',
            'totalOrders',
            'pendingOrderCount',
            'pendingOrders',
            'recentOrders',
            'revenue',
            'bestSellers'
        ));
    }
}