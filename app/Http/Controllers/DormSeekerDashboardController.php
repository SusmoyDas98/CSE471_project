<?php

namespace App\Http\Controllers;

use App\Models\DormSeeker;
use Illuminate\Support\Facades\Http;

class DormSeekerDashboardController extends Controller
{
    public function index()
    {
        // Dummy current user (model handles this)
        $user = DormSeeker::current();

        $hasJoinedCommunity = $user['has_dorm'];

        // 🔹 External Calendar API (Demo integration)
        $calendarResponse = Http::get(
            'https://date.nager.at/api/v3/PublicHolidays/2024/BD'
        );

        $holidays = $calendarResponse->successful()
            ? $calendarResponse->json()
            : [];
        #$holidays = $calendarResponse->successful()
            #? collect($calendarResponse->json())->take(5)->map(function ($h) {
                #return [
                    #'name' => $h['localName'],
                    #'date' => $h['date'],
                #];
            #})->values()
            #: [];    

        return view('dorm-seeker-dashboard', [
            'userName'           => $user['name'],
            'hasJoinedCommunity' => $hasJoinedCommunity,
            'dormData'           => $hasJoinedCommunity ? DormSeeker::dorm() : null,
            'latestPost'         => $hasJoinedCommunity ? DormSeeker::latestCommunityPost() : null,

            // 🔹 Calendar data passed to Blade
            'holidays'           => $holidays,
        ]);
    }
}
