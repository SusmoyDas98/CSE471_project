<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DormSearchController extends Controller
{
    public function index()
    {
        $locations = DB::table('dorms')
            ->select('location')
            ->distinct()
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->pluck('location')
            ->sort()
            ->values();

        $roomTypes = DB::table('dorms')
            ->whereNotNull('room_types')
            ->pluck('room_types')
            ->flatMap(function ($value) {
                return json_decode($value, true) ?? [];
            })
            ->unique()
            ->sort()
            ->values();

        $genderPreferences = DB::table('dorms')
            ->whereNotNull('gender_preference')
            ->where('gender_preference', '!=', '')
            ->pluck('gender_preference')
            ->unique()
            ->sort()
            ->values();


        $facilities = DB::table('dorms')
            ->whereNotNull('facilities')
            ->pluck('facilities')
            ->flatMap(function ($value) {
                return json_decode($value, true) ?? [];
            })
            ->unique()
            ->sort()
            ->values();

        return view('dorms.search', compact(
            'locations',
            'roomTypes',
            'genderPreferences',
            'facilities'
        ));
    }


    // ================= MANUAL SEARCH =================
    public function manualSearch(Request $request)
    {
        $dorms = DB::table('dorms')
            ->where('status', 'Running')
            ->select('dorms.*', 'dorm_rating as avg_rating')
            ->get();

        $filtered = $dorms->filter(function ($dorm) use ($request) {

            // Dorm name
            if ($request->filled('dorm_name') &&
                !str_contains(strtolower($dorm->name), strtolower($request->dorm_name))) {
                return false;
            }

            // Location
            if ($request->filled('location') && $dorm->location !== $request->location) {
                return false;
            }

            // Price range filter
            $dormRent = (float) ($dorm->rent ?? 0);
            
            if ($request->filled('price_min')) {
                $priceMin = (float) $request->price_min;
                if ($dormRent < $priceMin) {
                    return false;
                }
            }

            if ($request->filled('price_max')) {
                $priceMax = (float) $request->price_max;
                if ($dormRent > $priceMax) {
                    return false;
                }
            }

            // Room types (JSON)
            if ($request->filled('room_types')) {
                $roomTypes = json_decode($dorm->room_types, true) ?? [];
                if (!array_intersect($request->room_types, $roomTypes)) {
                    return false;
                }
            }

            // Gender preference (enum, supports multiple selections)
            if ($request->filled('gender_preference')) {
                $selectedGenders = is_array($request->gender_preference) ? $request->gender_preference : [$request->gender_preference];
                if (!in_array($dorm->gender_preference, $selectedGenders, true)) {
                    return false;
                }
            }


            // Facilities (JSON)
            if ($request->filled('facilities')) {
                $facilities = json_decode($dorm->facilities, true) ?? [];
                if (!array_intersect($request->facilities, $facilities)) {
                    return false;
                }
            }

            return true;
        })->values();

        return response()->json([
            'success' => true,
            'dorms' => $filtered,
            'search_type' => 'manual'
        ]);
    }


    // ================= AI SEARCH =================
    public function aiSearch()
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Login required'], 401);
        }

        // Fetch user profile
        $profile = DB::table('user_profile_details')
            ->where('user_id', Auth::id())
            ->first();

        if (!$profile || !$profile->gender || !$profile->marital_status || !$profile->student) {
            return response()->json(['success' => false, 'message' => 'Complete profile first'], 400);
        }

        // Total possible score = 3 (gender + marital_status + student)
        $totalPossibleScore = 3;

        // Get all running dorms
        $dorms = DB::table('dorms')
            ->where('status', 'Running')
            ->select('dorms.*', 'dorm_rating as avg_rating')
            ->get();

        // Calculate match_percentage for each dorm
        $dorms->each(function ($dorm) use ($profile, $totalPossibleScore) {

            $matchingScore = 0;

            // Compare gender
            if (strtolower($dorm->gender_preference) === strtolower($profile->gender)) {
                $matchingScore += 1;
            }

            // Compare expected marital status
            if (strtolower($dorm->expected_marital_status) === strtolower($profile->marital_status)) {
                $matchingScore += 1;
            }

            // Compare student_only
            if (strtolower($dorm->student_only) === strtolower($profile->student)) {
                $matchingScore += 1;
            }

            // Calculate match percentage
            $dorm->match_percentage = (int) round(($matchingScore * 100) / $totalPossibleScore);
        });

        // Return all dorms with match_percentage, sorted by match_percentage descending
        $result = $dorms->sortByDesc('match_percentage')->values();

        return response()->json([
            'success' => true,
            'dorms' => $result,
            'search_type' => 'ai'
        ]);
    }
}
