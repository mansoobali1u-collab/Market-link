@extends('layouts.admin')

@section('title', 'Markets Management')
@section('breadcrumb', 'Markets Management')

@section('content')

<style>
    .markets-page {
        max-width: 1200px;
    }

    .page-heading {
        margin-bottom: 24px;
    }

    .eyebrow {
        margin: 0 0 6px;
        color: #2e7d32;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .page-heading h1 {
        margin: 0;
        color: #2e3e35;
        font-size: 28px;
        font-weight: 700;
    }

    .heading-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
    }

    .heading-sub {
        margin: 8px 0 0;
        color: #819088;
        font-size: 14px;
    }

    .add-market-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 16px;
        border-radius: 8px;
        background: #2e7d32;
        color: white;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: 0.2s;
        white-space: nowrap;
    }

    .add-market-btn:hover {
        background: #1b5e20;
    }

    .success-message {
        margin-bottom: 20px;
        padding: 12px 16px;
        border: 1px solid #bbdfc0;
        border-radius: 8px;
        background: #f0faf2;
        color: #287331;
        font-size: 14px;
    }

    .markets-card {
        overflow: hidden;
        background: white;
        border: 1px solid #e3ebe6;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(46, 125, 50, 0.06);
    }

    .card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        border-bottom: 1px solid #e3ebe6;
        background: #fbfdfb;
    }

    .card-top h2 {
        margin: 0;
        color: #2e3e35;
        font-size: 17px;
        font-weight: 700;
    }

    .card-top p {
        margin: 4px 0 0;
        color: #819088;
        font-size: 13px;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .markets-table {
        width: 100%;
        border-collapse: collapse;
    }

    .markets-table th {
        padding: 14px 18px;
        background: #f7faf8;
        border-bottom: 1px solid #e3ebe6;
        color: #617067;
        font-size: 12px;
        font-weight: 700;
        text-align: left;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .markets-table td {
        padding: 16px 18px;
        border-bottom: 1px solid #edf2ee;
        color: #506057;
        font-size: 14px;
        vertical-align: middle;
    }

    .markets-table tbody tr:hover {
        background: #fbfdfb;
    }

    .markets-table tbody tr:last-child td {
        border-bottom: none;
    }

    .market-name {
        color: #2e3e35;
        font-weight: 600;
    }

    .market-address {
        max-width: 260px;
        color: #6f7e75;
        line-height: 1.5;
    }

    .days-badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 6px;
        background: #e8f5e9;
        color: #2e7d32;
        font-size: 12px;
        font-weight: 600;
    }

    .timing-text {
        color: #506057;
        white-space: nowrap;
    }

    .actions {
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .edit-btn {
        display: inline-block;
        padding: 7px 11px;
        border: 1px solid #cfe0d4;
        border-radius: 7px;
        background: #f7faf8;
        color: #2e7d32;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: 0.2s;
    }

    .edit-btn:hover {
        background: #e8f5e9;
        border-color: #b8d4bd;
    }

    .delete-btn {
        padding: 7px 11px;
        border: 1px solid #f0c8c8;
        border-radius: 7px;
        background: #fff8f8;
        color: #c62828;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .delete-btn:hover {
        background: #ffebee;
    }

    .empty-state {
        padding: 50px 20px !important;
        text-align: center;
        color: #819088 !important;
    }

    .empty-icon {
        margin-bottom: 10px;
        font-size: 30px;
    }

    .pagination-area {
        padding: 18px 24px;
        border-top: 1px solid #e3ebe6;
    }

    
    .pagination-area nav {
        display: flex;
        justify-content: center;
    }

    @media (max-width: 800px) {
        .heading-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .add-market-btn {
            width: fit-content;
        }

        .markets-card {
            border-radius: 10px;
        }
    }
</style>

<div class="markets-page">

    <div class="heading-row">

        <div class="page-heading">
            <p class="eyebrow">MARKETS MANAGEMENT</p>

            <h1>Markets</h1>

            <p class="heading-sub">
                Manage farmers markets available on MarketLink.
            </p>
        </div>

        <a
            href="{{ route('admin.markets.create') }}"
            class="add-market-btn"
        >
            <i data-lucide="plus" style="width:16px;height:16px;"></i>
            Add Market
        </a>

    </div>

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <div class="markets-card">

        <div class="card-top">
            <div>
                <h2>All Markets</h2>
                <p>View, edit or remove farmers markets.</p>
            </div>
        </div>

        <div class="table-wrapper">

            <table class="markets-table">

                <thead>
                    <tr>
                        <th>Market Name</th>
                        <th>Address</th>
                        <th>Operating Days</th>
                        <th>Timings</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($markets as $market)

                        <tr>

                            <td>
                                <div class="market-name">
                                    {{ $market->market_name }}
                                </div>
                            </td>

                            <td>
                                <div class="market-address">
                                    {{ $market->address }}
                                </div>
                            </td>

                            <td>
                                <span class="days-badge">
                                    {{ $market->operating_days }}
                                </span>
                            </td>

                            <td>
                                <span class="timing-text">
                                    {{ $market->timings }}
                                </span>
                            </td>

                            <td>

                                <div class="actions">

                                    <a
                                        href="{{ route('admin.markets.edit', $market) }}"
                                        class="edit-btn"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.markets.destroy', $market) }}"
                                        onsubmit="return confirm('Delete this market?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="delete-btn"
                                        >
                                            Delete
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="empty-state">
                                <div class="empty-icon">
                                    <i data-lucide="store"></i>
                                </div>

                                <strong>No markets yet.</strong>

                                <div style="margin-top: 5px;">
                                    Add your first farmers market using the button above.
                                </div>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($markets->hasPages())
            <div class="pagination-area">
                {{ $markets->links() }}
            </div>
        @endif

    </div>

</div>

@push('scripts')
<script>
    lucide.createIcons();
</script>
@endpush

@endsection
