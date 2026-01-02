<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead(Notification $notification)
    {
        // Ensure the notification belongs to the authenticated user
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to mark this notification as read.');
        }

        $notification->update(['is_read' => true]);

        return back()->with('status', 'Notification marked as read.');
    }
}
