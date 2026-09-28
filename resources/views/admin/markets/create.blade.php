@extends('layouts.admin')

@section('title', 'Add Market')
@section('breadcrumb', 'Add Market')

@section('content')

<style>
    .create-market-page {
        max-width: 1050px;
    }

    .create-market-heading {
        margin-bottom: 24px;
    }

    .create-market-eyebrow {
        margin: 0 0 6px;
        color: #2e7d32;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .create-market-heading h1 {
        margin: 0;
        color: #2e3e35;
        font-size: 28px;
        font-weight: 700;
    }

    .create-market-subtitle {
        margin: 8px 0 0;
        color: #819088;
        font-size: 14px;
    }

    .create-market-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e3ebe6;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(46, 125, 50, 0.06);
    }

    .create-market-card-header {
        padding: 20px 24px;
        background: #fbfdfb;
        border-bottom: 1px solid #e3ebe6;
    }

    .create-market-card-header h2 {
        margin: 0;
        color: #2e3e35;
        font-size: 18px;
        font-weight: 700;
    }

    .create-market-card-header p {
        margin: 5px 0 0;
        color: #819088;
        font-size: 13px;
    }

    .create-market-card-body {
        padding: 28px 24px;
    }

    .create-market-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 28px;
        padding-top: 22px;
        border-top: 1px solid #e3ebe6;
    }

    .save-market-btn {
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

    .save-market-btn:hover {
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
        .create-market-card-body {
            padding: 20px;
        }

        .create-market-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .save-market-btn,
        .cancel-market-btn {
            width: 100%;
            box-sizing: border-box;
            text-align: center;
        }
    }
</style>

<div class="create-market-page">

    <div class="create-market-heading">

        <p class="create-market-eyebrow">
            MARKETS MANAGEMENT
        </p>

        <h1>
            Add Market
        </h1>

        <p class="create-market-subtitle">
            Add a new farmers market to MarketLink.
        </p>

    </div>


    <div class="create-market-card">

        <div class="create-market-card-header">

            <h2>
                Market Information
            </h2>

            <p>
                Enter the details of the new farmers market below.
            </p>

        </div>


        <div class="create-market-card-body">

            <form
                method="POST"
                action="{{ route('admin.markets.store') }}"
            >

                @csrf

                
                @include('admin.markets._form')


                
                <div class="create-market-actions">

                    <button
                        type="submit"
                        class="save-market-btn"
                    >
                        Save Market
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
