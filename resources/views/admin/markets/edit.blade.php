@extends('layouts.admin')

@section('title', 'Edit Market')
@section('breadcrumb', 'Edit Market')

@section('content')

<style>
    .market-page {
        max-width: 1050px;
    }

    .market-heading {
        margin-bottom: 24px;
    }

    .market-eyebrow {
        margin: 0 0 6px;
        color: #2e7d32;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .market-heading h1 {
        margin: 0;
        color: #2e3e35;
        font-size: 28px;
        font-weight: 700;
    }

    .market-subtitle {
        margin: 8px 0 0;
        color: #819088;
        font-size: 14px;
    }

    .market-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e3ebe6;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(46, 125, 50, 0.06);
    }

    .market-card-header {
        padding: 20px 24px;
        background: #fbfdfb;
        border-bottom: 1px solid #e3ebe6;
    }

    .market-card-header h2 {
        margin: 0;
        color: #2e3e35;
        font-size: 18px;
        font-weight: 700;
    }

    .market-card-header p {
        margin: 5px 0 0;
        color: #819088;
        font-size: 13px;
    }

    .market-card-body {
        padding: 28px 24px;
    }

    .market-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 28px;
        padding-top: 22px;
        border-top: 1px solid #e3ebe6;
    }

    .update-market-btn {
        display: inline-block;
        padding: 11px 20px;
        border: none;
        border-radius: 8px;
        background: #2e7d32;
        color: #ffffff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
    }

    .update-market-btn:hover {
        background: #1b5e20;
    }

    .cancel-market-btn {
        display: inline-block;
        padding: 10px 20px;
        border: 1px solid #d7e2db;
        border-radius: 8px;
        background: #ffffff;
        color: #50665a;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
    }

    .cancel-market-btn:hover {
        background: #f4f7f5;
        color: #2e3e35;
    }

    @media (max-width: 700px) {
        .market-card-body {
            padding: 20px;
        }

        .market-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .update-market-btn,
        .cancel-market-btn {
            width: 100%;
            box-sizing: border-box;
            text-align: center;
        }
    }
</style>

<div class="market-page">

    <div class="market-heading">

        <p class="market-eyebrow">
            MARKETS MANAGEMENT
        </p>

        <h1>
            Edit Market
        </h1>

        <p class="market-subtitle">
            Update the information for this farmers market.
        </p>

    </div>


    <div class="market-card">

        <div class="market-card-header">

            <h2>
                Edit Market Information
            </h2>

            <p>
                Change the market details below and save your updates.
            </p>

        </div>


        <div class="market-card-body">

            <form
                method="POST"
                action="{{ route('admin.markets.update', $market) }}"
            >

                @csrf
                @method('PUT')

                
                @include('admin.markets._form')


                
                <div class="market-actions">

                    <button
                        type="submit"
                        class="update-market-btn"
                    >
                        Update Market
                    </button>

                    <a
                        href="{{ route('admin.markets.index') }}"
                        class="cancel-market-btn"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
