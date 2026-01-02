<?php

namespace App\Http\Controllers;

use App\Models\DormSeeker;
use Illuminate\Support\Facades\Http;

class DormSeekerDashboardController extends Controller
{
    public function index()
    {
        /**
         * AUTH-READY USER RESOLUTION
         *
         * Later:
         *   $user = auth()->user();
         *
         * Now:
         *   Dummy model data
         */
        $user = DormSeeker::current();

        /**
         * Community membership flag
         * (kept array-based for now)
         */
        $hasJoinedCommunity = $user->has_dorm;

        /**
         * 🔹 External Calendar API 
         */
        $calendarResponse = Http::get(
            'https://date.nager.at/api/v3/PublicHolidays/2025/US'
        );

        $holidays = $calendarResponse->successful()
            ? collect($calendarResponse->json())
                ->take(10)
                ->map(function ($h) {
                    return [
                        'name' => $h['localName'],
                        'date' => $h['date'],
                    ];
                })
                ->values()
            : [];

        /**
         * View response
         */
        return view('dorm-seeker-dashboard', [
            'userName'           => $user->name,
            'hasJoinedCommunity' => $hasJoinedCommunity,
            'dormData'           => $hasJoinedCommunity ? DormSeeker::dorm($user->id) : null,
            'latestPost'         => $hasJoinedCommunity ? DormSeeker::latestCommunityPost() : null,
            'holidays'           => $holidays,
        ]);
    }
}
