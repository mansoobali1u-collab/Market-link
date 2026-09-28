@php
    $role = auth()->user()->role;
    $notifLayout = $role === 'admin' ? 'layouts.admin' : ($role === 'farmer' ? 'layouts.farmer' : 'layouts.customer');
    $backRoute = $role === 'admin' ? 'admin.dashboard' : ($role === 'farmer' ? 'farmer.orders.index' : 'customer.orders.index');
@endphp

@extends($notifLayout)

@section('title', 'Notifications — MarketLink')
@section('breadcrumb', 'Notifications')

@push('styles')
    @if($role !== 'user')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @endif
@endpush

@section('content')

<style>
    .ml-notif-wrap { max-width: 760px; margin: 0 auto; }
    .ml-notif-header { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; }
    .ml-notif-header h2 { margin: 0; font-size: 22px; font-weight: 700; color: #2e3e35; }
    .ml-notif-mark-all { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 8px; border: 1px solid #c8e6c9; background: #f1f8f2; color: #2e7d32; font-size: 13px; font-weight: 600; cursor: pointer; }
    .ml-notif-mark-all:hover { background: #e8f5e9; }
    .ml-notif-item { display: flex; gap: 14px; align-items: flex-start; padding: 16px; margin-bottom: 12px; background: #fff; border: 1px solid #e3ebe6; border-radius: 12px; }
    .ml-notif-item.unread { background: #f7fdf8; border-color: #c8e6c9; }
    .ml-notif-icon { width: 40px; height: 40px; border-radius: 50%; background: #e8f5e9; color: #2e7d32; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 18px; }
    .ml-notif-title { font-weight: 600; color: #2e3e35; margin: 0 0 4px; font-size: 14px; }
    .ml-notif-badge { display: inline-block; padding: 2px 8px; border-radius: 20px; background: #2e7d32; color: #fff; font-size: 10px; font-weight: 700; margin-left: 8px; vertical-align: middle; }
    .ml-notif-message { color: #50665a; font-size: 13px; margin: 0 0 4px; }
    .ml-notif-time { color: #819088; font-size: 12px; }
    .ml-notif-read-btn { align-self: center; padding: 6px 12px; border-radius: 6px; border: 1px solid #c8e6c9; background: #f1f8f2; color: #2e7d32; font-size: 12px; font-weight: 600; text-decoration: none; white-space: nowrap; }
    .ml-notif-read-btn:hover { background: #e8f5e9; }
    .ml-notif-empty { text-align: center; padding: 50px 20px; background: #fff; border: 1px solid #e3ebe6; border-radius: 12px; color: #819088; }
    .ml-notif-empty i { font-size: 32px; color: #c8d8ce; margin-bottom: 12px; display: block; }
    .ml-notif-cta { display: inline-block; margin-top: 14px; padding: 10px 18px; border-radius: 8px; background: #2e7d32; color: #fff; text-decoration: none; font-size: 13px; font-weight: 600; }
    .ml-notif-cta:hover { background: #1b5e20; }
</style>

<div class="ml-notif-wrap">

    <div class="ml-notif-header">
        <h2>Notifications</h2>

        @if(auth()->user()->unreadNotifications->count() > 0)
            <form action="{{ route('notifications.readAll') }}" method="POST">
                @csrf
                <button type="submit" class="ml-notif-mark-all">
                    <i class="bi bi-check2-all"></i> Mark all as read
                </button>
            </form>
        @endif
    </div>

    @if (session('success'))
        <div style="margin-bottom: 16px; padding: 12px 16px; border-radius: 8px; background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    @forelse($notifications as $notification)
        @php
            $title = $notification->data['title'] ?? 'Notification';
            $icon = 'bi-bell-fill';
            if (str_contains(strtolower($title), 'ready')) { $icon = 'bi-bag-check-fill'; }
            elseif (str_contains(strtolower($title), 'declined')) { $icon = 'bi-x-circle-fill'; }
            elseif (str_contains(strtolower($title), 'new order')) { $icon = 'bi-receipt'; }
            elseif (str_contains(strtolower($title), 'farmer')) { $icon = 'bi-person-plus-fill'; }
        @endphp

        <div class="ml-notif-item {{ $notification->read_at ? '' : 'unread' }}">
            <div class="ml-notif-icon"><i class="bi {{ $icon }}"></i></div>

            <div style="flex: 1; min-width: 0;">
                <p class="ml-notif-title">
                    {{ $title }}
                    @if(!$notification->read_at)
                        <span class="ml-notif-badge">New</span>
                    @endif
                </p>
                <p class="ml-notif-message">{{ $notification->data['message'] ?? '' }}</p>
                <span class="ml-notif-time"><i class="bi bi-clock"></i> {{ $notification->created_at->diffForHumans() }}</span>
            </div>

            @if(!$notification->read_at)
                <a href="{{ route('notifications.read', $notification->id) }}" class="ml-notif-read-btn">Mark as read</a>
            @endif
        </div>

    @empty
        <div class="ml-notif-empty">
            <i class="bi bi-bell-slash"></i>
            <strong>No Notifications</strong>
            <p style="margin: 6px 0 0;">You don't have any notifications yet.</p>
            <a href="{{ route($backRoute) }}" class="ml-notif-cta">Back to Dashboard</a>
        </div>
    @endforelse

    @if($notifications->hasPages())
        <div style="margin-top: 20px;">
            {{ $notifications->links() }}
        </div>
    @endif

</div>

@endsection
