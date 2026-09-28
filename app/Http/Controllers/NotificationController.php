<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->latest()->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    public function read($id)
    {
        $user = auth()->user();

        $notification = $user->notifications()->where('id', $id)->firstOrFail();

        $notification->markAsRead();

        return redirect()->route('notifications.index');
    }

    public function markAllAsRead()
    {
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }
}
