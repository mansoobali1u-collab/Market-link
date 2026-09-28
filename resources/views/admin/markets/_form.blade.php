<style>
    .market-form {
        width: 100%;
    }

    .market-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 22px;
    }

    .market-form-group {
        display: flex;
        flex-direction: column;
    }

    .market-form-group.full {
        grid-column: 1 / -1;
    }

    .market-form-group label {
        margin-bottom: 8px;
        color: #2e3e35;
        font-size: 14px;
        font-weight: 600;
    }

    .market-form-group input,
    .market-form-group textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 13px;
        border: 1px solid #d7e2db;
        border-radius: 8px;
        background: #ffffff;
        color: #2e3e35;
        font-size: 14px;
        outline: none;
        transition: 0.2s;
    }

    .market-form-group textarea {
        min-height: 105px;
        resize: vertical;
    }

    .market-form-group input:focus,
    .market-form-group textarea:focus {
        border-color: #2e7d32;
        box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.10);
    }

    .market-form-group input::placeholder,
    .market-form-group textarea::placeholder {
        color: #a0aca5;
    }

    .market-form-help {
        margin-top: 6px;
        color: #819088;
        font-size: 12px;
    }

    .market-form-error {
        margin-top: 6px;
        color: #c62828;
        font-size: 12px;
    }

    @media (max-width: 700px) {
        .market-form-grid {
            grid-template-columns: 1fr;
        }

        .market-form-group.full {
            grid-column: auto;
        }
    }
</style>

@php
    $m = $market ?? null;
@endphp

<div class="market-form">

    <div class="market-form-grid">

        
        <div class="market-form-group full">

            <label for="market_name">
                Market Name
            </label>

            <input
                type="text"
                id="market_name"
                name="market_name"
                value="{{ old('market_name', $m->market_name ?? '') }}"
                placeholder="Enter market name"
                required
            >

            @error('market_name')
                <div class="market-form-error">
                    {{ $message }}
                </div>
            @enderror

        </div>

        
        <div class="market-form-group full">

            <label for="address">
                Address
            </label>

            <textarea
                id="address"
                name="address"
                placeholder="Enter the market address"
            >{{ old('address', $m->address ?? '') }}</textarea>

            @error('address')
                <div class="market-form-error">
                    {{ $message }}
                </div>
            @enderror

        </div>

        
        <div class="market-form-group">

            <label for="operating_days">
                Operating Days
            </label>

            <input
                type="text"
                id="operating_days"
                name="operating_days"
                value="{{ old('operating_days', $m->operating_days ?? '') }}"
                placeholder="e.g. Sat, Sun"
            >

            @error('operating_days')
                <div class="market-form-error">
                    {{ $message }}
                </div>
            @enderror

        </div>

        
        <div class="market-form-group">

            <label for="timings">
                Timings
            </label>

            <input
                type="text"
                id="timings"
                name="timings"
                value="{{ old('timings', $m->timings ?? '') }}"
                placeholder="e.g. 8:00 AM - 1:00 PM"
            >

            @error('timings')
                <div class="market-form-error">
                    {{ $message }}
                </div>
            @enderror

        </div>

        
        <div class="market-form-group">

            <label for="latitude">
                Latitude
            </label>

            <input
                type="text"
                id="latitude"
                name="latitude"
                value="{{ old('latitude', $m->latitude ?? '') }}"
                placeholder="e.g. 24.8607"
            >

            <div class="market-form-help">
                Used for the market location.
            </div>

            @error('latitude')
                <div class="market-form-error">
                    {{ $message }}
                </div>
            @enderror

        </div>

        
        <div class="market-form-group">

            <label for="longitude">
                Longitude
            </label>

            <input
                type="text"
                id="longitude"
                name="longitude"
                value="{{ old('longitude', $m->longitude ?? '') }}"
                placeholder="e.g. 67.0011"
            >

            <div class="market-form-help">
                Used for the market location.
            </div>

            @error('longitude')
                <div class="market-form-error">
                    {{ $message }}
                </div>
            @enderror

        </div>

    </div>

</div>
