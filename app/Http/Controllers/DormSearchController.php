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
            ->flatMap(fn($v) => array_map('trim', explode(',', $v)))
            ->unique()
            ->sort()
            ->values();

        $genderPreferences = DB::table('dorms')
            ->whereNotNull('gender_preference')
            ->pluck('gender_preference')
            ->flatMap(fn($v) => array_map('trim', explode(',', $v)))
            ->unique()
            ->sort()
            ->values();

        $facilities = DB::table('dorms')
            ->whereNotNull('facilities')
            ->pluck('facilities')
            ->flatMap(fn($v) => array_map('trim', explode(',', $v)))
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
        $query = DB::table('dorms')
            ->where('status', 'Approved');

        if ($request->filled('dorm_name')) {
            $query->where('name', 'LIKE', '%' . $request->dorm_name . '%');
        }

        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        if ($request->filled('price_min')) {
            $query->where('rent', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('rent', '<=', $request->price_max);
        }

        if ($request->filled('room_types')) {
            // require all selected room types to be present (match tokens, not substrings)
            $query->where(function ($q) use ($request) {
                $first = true;
                foreach ($request->room_types as $type) {
                    $t = strtolower(trim($type));
                    $token = str_replace(' ', '', $t);
                    if ($first) {
                        $q->whereRaw('FIND_IN_SET(?, REPLACE(LOWER(room_types), " ", ""))', [$token]);
                        $first = false;
                    } else {
                        $q->orWhereRaw('FIND_IN_SET(?, REPLACE(LOWER(room_types), " ", ""))', [$token]);
                    }
                }
            });
        }

        if ($request->filled('gender_preference')) {
            $query->where(function ($q) use ($request) {
                $first = true;
                foreach ($request->gender_preference as $gender) {
                    $g = strtolower(trim($gender));
                    $token = str_replace(' ', '', $g);
                    if ($first) {
                        $q->whereRaw('FIND_IN_SET(?, REPLACE(LOWER(gender_preference), " ", ""))', [$token]);
                        $first = false;
                    } else {
                        $q->orWhereRaw('FIND_IN_SET(?, REPLACE(LOWER(gender_preference), " ", ""))', [$token]);
                    }
                }
            });
        }

        if ($request->filled('facilities')) {
            $query->where(function ($q) use ($request) {
                $first = true;
                foreach ($request->facilities as $facility) {
                    $f = strtolower(trim($facility));
                    $token = str_replace(' ', '', $f);
                    if ($first) {
                        $q->whereRaw('FIND_IN_SET(?, REPLACE(LOWER(facilities), " ", ""))', [$token]);
                        $first = false;
                    } else {
                        $q->orWhereRaw('FIND_IN_SET(?, REPLACE(LOWER(facilities), " ", ""))', [$token]);
                    }
                }
            });
        }

        $dorms = $query
            ->select('dorms.*', 'dorm_rating as avg_rating')
            ->orderByDesc('avg_rating')
            ->get();

        return response()->json([
            'success' => true,
            'dorms' => $dorms,
            'search_type' => 'manual'
        ]);
    }

    // ================= AI SEARCH =================
    public function aiSearch()
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Login required'], 401);
        }

        $profile = DB::table('user_profile_details')
            ->where('user_id', Auth::id())
            ->first();

        if (!$profile || !$profile->gender || !$profile->marital_status || !$profile->profession) {
            return response()->json(['success' => false, 'message' => 'Complete profile first'], 400);
        }

        $userProfessions = array_filter(array_map(fn($p) => strtolower(trim($p)), explode(',', $profile->profession)));
        $totalPossibleScore = 1 + 1 + count($userProfessions);

        $dorms = DB::table('dorms')
            ->where('status', 'Approved')
            ->select('dorms.*', 'dorm_rating as avg_rating')
            ->get();

        $dorms->each(function ($dorms) use ($profile, $userProfessions, $totalPossibleScore) {
            $matchingScore = 0;

            $userGender = strtolower(trim($profile->gender));
            $userMarital = strtolower(trim($profile->marital_status));

            $dormGenderPrefs = array_filter(array_map(fn($g) => strtolower(trim($g)), explode(',', $dorms->gender_preference ?? '')));
            if (!empty($dormGenderPrefs) && in_array($userGender, $dormGenderPrefs, true)) {
                $matchingScore += 1;
            }

            $dormMaritalPrefs = array_filter(array_map(fn($m) => strtolower(trim($m)), explode(',', $dorms->marital_status ?? '')));
            if (!empty($dormMaritalPrefs) && in_array($userMarital, $dormMaritalPrefs, true)) {
                $matchingScore += 1;
            }

            $dormProfessions = array_filter(array_map(fn($p) => strtolower(trim($p)), explode(',', $dorms->profession ?? '')));
            $matches = array_intersect($userProfessions, $dormProfessions);
            $matchingScore += count($matches);

            $dorms->match_percentage = $totalPossibleScore > 0 ? (int) round(($matchingScore * 100) / $totalPossibleScore) : 0;
        });

        // Decide results based on counts of matching tiers (>=80, >=50).
        $highMatches = $dorms->where('match_percentage', '>=', 80)->sortByDesc('match_percentage');
        $midMatches = $dorms->where('match_percentage', '>=', 50)->sortByDesc('match_percentage');
        $anyMatches = $dorms->where('match_percentage', '>', 0)->sortByDesc('match_percentage');

        if ($highMatches->count() >= 3) {
            // plenty of high matches -> show best 3 high matches
            $result = $highMatches->take(3)->values();
        } elseif ($midMatches->count() >= 6) {
            // enough mid-range matches -> show best 6 among >=50%
            $result = $midMatches->take(6)->values();
        } elseif ($anyMatches->count() > 0) {
            // some matches exist but not enough for the above thresholds -> show top 10 by match
            $result = $anyMatches->take(10)->values();
        } else {
            // no matches at all -> fall back to top rated dorms
            $result = $dorms->sortByDesc('avg_rating')->take(10)->values();
        }

        return response()->json([
            'success' => true,
            'dorms' => $result,
            'search_type' => 'ai'
        ]);
    }
}
