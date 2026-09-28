@extends('layouts.farmer')

@section('title', 'Farmer Profile')

@section('content')

    <div class="mb-8">
        <h1 class="font-display text-3xl" style="color: var(--ink);">Farmer profile</h1>
        <p class="text-sm mt-1" style="color: var(--ink-soft);">Manage your farm and business information.</p>
    </div>

    
    @if($errors->any())
        <div class="mb-6 px-5 py-4 rounded-lg text-sm" style="background: var(--brick-pale); color: var(--brick); border: 1px solid var(--line);">
            <p class="font-semibold mb-2">Please fix the following errors:</p>
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('farmer.profile.update') }}">
        @csrf
        @method('PUT')

        
        <div class="rounded-lg p-6 mb-6" style="background: var(--card); border: 1px solid var(--line);">
            <div class="mb-5">
                <h2 class="font-display text-lg" style="color: var(--ink);">Basic information</h2>
                <p class="text-sm mt-1" style="color: var(--ink-soft);">Your basic farmer account information.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--ink);">Name</label>
                    <input type="text" value="{{ $farmer->name }}" disabled
                           class="field" style="background: var(--paper-tint); color: var(--ink-soft);">
                    <p class="text-xs mt-1" style="color: var(--ink-soft);">Your account name cannot be changed here.</p>
                </div>

                
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--ink);">Email</label>
                    <input type="email" value="{{ $farmer->email }}" disabled
                           class="field" style="background: var(--paper-tint); color: var(--ink-soft);">
                </div>

                
                <div>
                    <label for="phone" class="block text-sm font-medium mb-2" style="color: var(--ink);">Phone number</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $farmer->phone) }}"
                           placeholder="Enter your phone number" class="field">
                </div>

                
                <div>
                    <label for="address" class="block text-sm font-medium mb-2" style="color: var(--ink);">Address</label>
                    <input type="text" id="address" name="address" value="{{ old('address', $farmer->address) }}"
                           placeholder="Enter your farm address" class="field">
                </div>
            </div>
        </div>

        
        <div class="rounded-lg p-6 mb-6" style="background: var(--card); border: 1px solid var(--line);">
            <div class="mb-5">
                <h2 class="font-display text-lg" style="color: var(--ink);">Farm &amp; business information</h2>
                <p class="text-sm mt-1" style="color: var(--ink-soft);">Add information about your farm or business.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                
                <div>
                    <label for="business_name" class="block text-sm font-medium mb-2" style="color: var(--ink);">Business / farm name</label>
                    <input type="text" id="business_name" name="business_name"
                           value="{{ old('business_name', $farmer->business_name) }}"
                           placeholder="Enter business or farm name" class="field">
                </div>

                
                <div>
                    <label for="market_id" class="block text-sm font-medium mb-2" style="color: var(--ink);">Market</label>
                    <select id="market_id" name="market_id" class="field">
                        <option value="">-- Select a market --</option>
                        @foreach ($markets as $market)
                            <option value="{{ $market->id }}" @selected(old('market_id', $farmer->market_id) == $market->id)>
                                {{ $market->market_name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs mt-1" style="color: var(--ink-soft);">
                        Select the market where your stall operates. Don't see your market? Contact an admin to add it.
                    </p>
                </div>

                
                <div>
                    <label for="operating_days" class="block text-sm font-medium mb-2" style="color: var(--ink);">Operating days</label>
                    <input type="text" id="operating_days" name="operating_days"
                           value="{{ old('operating_days', $farmer->operating_days) }}"
                           placeholder="Example: Monday, Wednesday, Saturday" class="field">
                    <p class="text-xs mt-1" style="color: var(--ink-soft);">Enter the days when your stall is available.</p>
                </div>

                
                <div>
                    <label for="pickup_window" class="block text-sm font-medium mb-2" style="color: var(--ink);">Pickup window</label>
                    <input type="text" id="pickup_window" name="pickup_window"
                           value="{{ old('pickup_window', $farmer->pickup_window) }}"
                           placeholder="Example: 10:00 AM - 2:00 PM" class="field">
                    <p class="text-xs mt-1" style="color: var(--ink-soft);">Specify the time window for order pickups.</p>
                </div>

                
                <div>
                    <label for="order_cutoff_hours" class="block text-sm font-medium mb-2" style="color: var(--ink);">Order cutoff (hours before pickup)</label>
                    <input type="number" id="order_cutoff_hours" name="order_cutoff_hours"
                           value="{{ old('order_cutoff_hours', $farmer->order_cutoff_hours) }}"
                           min="1" max="168" class="field">
                    <p class="text-xs mt-1" style="color: var(--ink-soft);">
                        Specify the number of hours before pickup when orders cannot be modified.
                    </p>
                </div>
            </div>
        </div>

        
        <div class="rounded-lg p-6 mb-6" style="background: var(--card); border: 1px solid var(--line);">
            <div class="mb-5">
                <h2 class="font-display text-lg" style="color: var(--ink);">Location</h2>
                <p class="text-sm mt-1" style="color: var(--ink-soft);">Add the location of your farm or market stall.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div>
                    <label for="latitude" class="block text-sm font-medium mb-2" style="color: var(--ink);">Latitude</label>
                    <input type="text" id="latitude" name="latitude" value="{{ old('latitude', $farmer->latitude) }}"
                           placeholder="Example: 31.5204" class="field">
                </div>

                
                <div>
                    <label for="longitude" class="block text-sm font-medium mb-2" style="color: var(--ink);">Longitude</label>
                    <input type="text" id="longitude" name="longitude" value="{{ old('longitude', $farmer->longitude) }}"
                           placeholder="Example: 74.3587" class="field">
                </div>
            </div>

            
            <div class="mt-5 rounded-lg p-4" style="background: var(--teal-pale);">
                <p class="text-sm" style="color: var(--teal);">
                    You can enter the latitude and longitude of your farm or market location.
                    These values can be used later for map integration.
                </p>
            </div>
        </div>

        
        <div class="rounded-lg p-6" style="background: var(--card); border: 1px solid var(--line);">
            <div class="flex flex-col sm:flex-row gap-3 justify-end">
                <a href="{{ route('farmer.dashboard') }}"
                   class="px-5 py-2 text-center rounded-lg"
                   style="border: 1px solid var(--line); color: var(--ink-soft);">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2 rounded-lg btn-primary">
                    Save profile
                </button>
            </div>
        </div>

    </form>

@endsection
