<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;

class NotificationController extends Controller
{
    // Show all notifications for logged-in user
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $unreadCount = Notification::where('user_id', Auth::id())
            ->where('is_read', 0)
            ->count();

        return view('notifications.notification-index', compact('notifications', 'unreadCount'));
    }

    // Mark notification as read
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($notification) {
            $notification->update(['is_read' => 1]);
            return back()->with('success', 'Notification marked as read');
        }

        return back()->with('error', 'Notification not found');
    }

    // Mark all notifications as read
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return back()->with('success', 'All notifications marked as read');
    }

    // Delete notification
    public function destroy($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($notification) {
            $notification->delete();
            return back()->with('success', 'Notification deleted');
        }

        return back()->with('error', 'Notification not found');
    }

    // Get unread count (for AJAX)
    public function getUnreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->where('is_read', 0)
            ->count();

        return response()->json(['count' => $count]);
    }
}
