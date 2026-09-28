<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

class FarmerController extends Controller
{
    public function index(Request $request)
    {
       $query = User::where('role', 'farmer');
       
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Paginate the results
        $farmers = $query->paginate(10);

        return view('customer.farmers.index', compact('farmers'));
    }
    public function show($id)
    {
        $farmer = User::where('role', 'farmer')
            ->findOrFail($id);

        $products = Product::where('farmer_id', $farmer->id)
            ->where('is_available', true)
            ->latest()
            ->get();

        return view('customer.farmers.show', compact(
            'farmer',
            'products'
        ));
    }
}
