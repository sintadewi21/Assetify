<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Tandai semua notifikasi milik user yang login sebagai "Telah Dibaca"
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())->update(['is_read' => true]);

        return back()->with('success', 'All notifications marked as read.');
    }
}
