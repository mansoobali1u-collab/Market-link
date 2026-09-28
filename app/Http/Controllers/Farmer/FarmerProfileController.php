<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Market;
use App\Models\User;
use Illuminate\Http\Request;

class FarmerProfileController extends Controller
{
    public function edit()
    {
        if (auth()->user()->role !== 'farmer') {
            abort(403);
        }

        $farmer = User::findOrFail(auth()->id());
        $markets = Market::orderBy('market_name')->get();

        return view('farmer.farmer_profile', compact('farmer', 'markets'));
    }

    public function update(Request $request)
    {
        if (auth()->user()->role !== 'farmer') {
            abort(403);
        }

        $request->validate([
            'business_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'market_id' => 'nullable|exists:markets,id',
            'operating_days' => 'nullable|string|max:255',
            'pickup_window' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'order_cutoff_hours' => 'required|integer|min:1|max:168',
        ]);

        $farmer = User::findOrFail(auth()->id());

        $farmer->business_name = $request->business_name;
        $farmer->phone = $request->phone;
        $farmer->address = $request->address;
        $farmer->market_id = $request->market_id;
        $farmer->operating_days = $request->operating_days;
        $farmer->pickup_window = $request->pickup_window;
        $farmer->latitude = $request->latitude;
        $farmer->longitude = $request->longitude;
        $farmer->order_cutoff_hours = $request->order_cutoff_hours;

        $farmer->save();

        return redirect()->route('farmer.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
