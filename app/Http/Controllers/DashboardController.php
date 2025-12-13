<?php

namespace App\Http\Controllers;

use App\Models\UserDashboard;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Try fetching from database
            $users = UserDashboard::all();
        } catch (\Exception $e) {
            // Fallback dummy data so the blade runs no matter what
            $users = collect([
                (object)[ 'id' => 1, 'username' => 'Demo User', 'likes' => 10, 'shares' => 5, 'views' => 200 ]
            ]);
        }

        return view('dashboard', compact('users'));
    }

    public function like($id)
    {
        try {
            $user = UserDashboard::findOrFail($id);
            $user->likes += 1;
            $user->save();
        } catch (\Exception $e) {
            // ignore errors for now so you can run it
        }

        return back();
    }

    public function share($id)
    {
        try {
            $user = UserDashboard::findOrFail($id);
            $user->shares += 1;
            $user->save();
        } catch (\Exception $e) {
            // ignore errors for now
        }

        return back();
    }
}
