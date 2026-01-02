<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeekerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get application statistics
        $stats = [
            'total' => Application::where('user_id', $user->id)->count(),
            'accepted' => Application::where('user_id', $user->id)->where('status', 'accepted')->count(),
            'rejected' => Application::where('user_id', $user->id)->where('status', 'rejected')->count(),
            'pending' => Application::where('user_id', $user->id)->whereIn('status', ['submitted', 'reviewing'])->count(),
            'waitlisted' => Application::where('user_id', $user->id)->where('status', 'waitlisted')->count(),
        ];

        // Get recent rejections (last 7 days)
        $recentRejections = Application::where('user_id', $user->id)
            ->where('status', 'rejected')
            ->where('updated_at', '>', now()->subDays(7))
            ->with(['vacancy.room.dorm'])
            ->latest('updated_at')
            ->limit(5)
            ->get();

        // Get recent acceptances (last 7 days)
        $recentAcceptances = Application::where('user_id', $user->id)
            ->where('status', 'accepted')
            ->where('updated_at', '>', now()->subDays(7))
            ->with(['vacancy.room.dorm'])
            ->latest('updated_at')
            ->limit(5)
            ->get();

        // Get pending applications
        $pendingApplications = Application::where('user_id', $user->id)
            ->whereIn('status', ['submitted', 'reviewing'])
            ->with(['vacancy.room.dorm'])
            ->latest()
            ->limit(5)
            ->get();

        return view('seeker.dashboard', compact('stats', 'recentRejections', 'recentAcceptances', 'pendingApplications'));
    }
}

