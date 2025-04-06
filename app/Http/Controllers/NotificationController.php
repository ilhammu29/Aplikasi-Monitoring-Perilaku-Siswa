<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
{
    $notifications = auth()->user()->notifications()
        ->orderBy('created_at', 'desc')
        ->paginate(15);

    return view('notifications.index', ['notifications' => $notifications]);
}
    public function markRead(Notification $notification)
    {
        abort_unless(auth()->user()->id === $notification->user_id, 403);
        
        $notification->markAsRead();
        
        return back()->with('success', 'Notifikasi telah ditandai sebagai dibaca');
    }

    public function markAllRead()
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);
        
        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca');
    }
}