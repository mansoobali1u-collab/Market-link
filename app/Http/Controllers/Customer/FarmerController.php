<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
}
