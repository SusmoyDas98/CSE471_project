<?php

namespace App\Http\Controllers;

use App\Models\DormSeeker;

class DormSeekerDashboardController extends Controller
{
    public function index()
    {
        $user = DormSeeker::current();

        $hasJoinedCommunity = $user['has_dorm'];

        return view('dorm-seeker-dashboard', [
            'userName' => $user['name'],
            'hasJoinedCommunity' => $hasJoinedCommunity,
            'dormData' => $hasJoinedCommunity ? DormSeeker::dorm() : null,
            'latestPost' => $hasJoinedCommunity ? DormSeeker::latestCommunityPost() : null,
        ]);
    }
}
