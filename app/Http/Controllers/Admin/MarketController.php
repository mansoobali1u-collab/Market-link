<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Market;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function index()
    {
        $markets = Market::latest()->paginate(10);

        return view('admin.markets.index', compact('markets'));
    }

    public function create()
    {
        return view('admin.markets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'market_name' => 'required|string|max:191',
            'address' => 'nullable|string',
            'operating_days' => 'nullable|string|max:191',
            'timings' => 'nullable|string|max:191',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        Market::create($validated);

        return redirect()->route('admin.markets.index')->with('success', 'Market created.');
    }

    public function edit(Market $market)
    {
        return view('admin.markets.edit', compact('market'));
    }

    public function update(Request $request, Market $market)
    {
        $validated = $request->validate([
            'market_name' => 'required|string|max:191',
            'address' => 'nullable|string',
            'operating_days' => 'nullable|string|max:191',
            'timings' => 'nullable|string|max:191',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $market->update($validated);

        return redirect()->route('admin.markets.index')->with('success', 'Market updated.');
    }

    public function destroy(Market $market)
    {
        $market->delete();

        return redirect()->route('admin.markets.index')->with('success', 'Market deleted.');
    }
}
