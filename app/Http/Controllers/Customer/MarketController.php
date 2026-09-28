<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Market;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function index(Request $request)
    {
        $markets = Market::withCount(['farmers' => function ($query) {
                $query->where('role', 'farmer')
                    ->where('is_approved', true)
                    ->where('is_active', true);
            }])
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%' . $request->search . '%';
                $query->where(function ($q) use ($term) {
                    $q->where('market_name', 'like', $term)
                        ->orWhere('address', 'like', $term);
                });
            })
            ->orderBy('market_name')
            ->get();

        return view('customer.markets.index', compact('markets'));
    }

    public function show(Market $market)
    {
        $farmers = $market->farmers()
            ->where('role', 'farmer')
            ->where('is_approved', true)
            ->where('is_active', true)
            ->withCount(['products' => function ($query) {
                $query->where('is_available', true);
            }])
            ->orderBy('business_name')
            ->orderBy('name')
            ->get();

        return view('customer.markets.show', compact('market', 'farmers'));
    }
}
