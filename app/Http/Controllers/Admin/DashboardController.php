<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Market;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $farmerCount = User::where('role', 'farmer')->count();
        $userCount = User::where('role', 'user')->count();
        $adminCount = User::where('role', 'admin')->count();

        $marketCount = Market::count();
        $orderCount = Order::count();

        $recentUsers = User::latest('created_at')->take(5)->get();

        return view('admin.dashboard', [
            'totalFarmers' => $farmerCount,
            'totalRegularUsers' => $userCount,
            'totalAdmins' => $adminCount,
            'totalMarkets' => $marketCount,
            'totalOrders' => $orderCount,
            'recentUsers' => $recentUsers,
        ]);
    }
}
