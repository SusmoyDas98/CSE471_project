<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User_Preferences;
use App\Models\User;

class auto_suggestion_controller_api extends Controller
{
    public function fetch_auto_dorm_mate(Request $request, $user_id)
    {
        $all_user_except_mine_infos = User_Preferences::where("user_id", "!=", $user_id)->get();
        $mine_user = User_Preferences::where("user_id", $user_id)->first();

        if (!$mine_user) {
            return response()->json([
                'status' => false,
                'message' => "No such user found"
            ], 400);
        }

        $mine_preferences = [
            'preferences' => json_decode($mine_user->preferences ?? '[]', true),
            'hobbies' => json_decode($mine_user->hobbies ?? '[]', true),
            'study_level' => $mine_user->study_level ?? "",
            'gender' => $mine_user->gender ?? "",
            'age' => $mine_user->age ?? null
        ];

        $total_possible_score = count($mine_preferences['preferences'] ?? [])
                              + count($mine_preferences['hobbies'] ?? [])
                              + 1
                              + 1
                              + 1;

        $best_matches = $all_user_except_mine_infos->map(function ($other_user) use ($mine_preferences, $total_possible_score) {
            $matching_score = 0;

            $other_user_preferences = json_decode($other_user->preferences ?? '[]', true);
            $other_user_hobbies = json_decode($other_user->hobbies ?? '[]', true);

            $common_preferences = array_intersect($mine_preferences['preferences'] ?? [], $other_user_preferences);
            $matching_score += count($common_preferences);

            $common_hobbies = array_intersect($mine_preferences['hobbies'] ?? [], $other_user_hobbies);
            $matching_score += count($common_hobbies);

            if (($mine_preferences['study_level'] ?? "") === ($other_user->study_level ?? "")) {
                $matching_score += 1;
            }

            if (($mine_preferences['gender'] ?? "") === ($other_user->gender ?? "")) {
                $matching_score += 1;
            }

            $my_age = $mine_preferences['age'];
            $other_age = $other_user->age ?? null;
            if ($my_age && $other_age && abs($my_age - $other_age) <= 3) {
                $matching_score += 1;
            }

            $final_score = ($matching_score * 100) / $total_possible_score;
            $other_user_personal_info = User::select('name', 'email')->where('id', $other_user->user_id)->first();
            return [
                "name" => $other_user_personal_info->name ?? "",
                "email" => $other_user_personal_info->email ?? "",
                'user_id' => $other_user->user_id,
                'matching_percentage' => $final_score,
                'common_hobbies' => $common_hobbies,
                'common_preferences' => $common_preferences
            ];

        })->sortByDesc('matching_percentage')->values();

        if($best_matches->where('matching_percentage',">=", 80)->count() > 0){
            $best_matches = $best_matches->take(3);
        }
        elseif($best_matches->where('matching_percentage',">=", 50)->count() > 0){
            $best_matches = $best_matches->take(6);
        }
        else{
            $best_matches = $best_matches->take(10);
        }
        

        return response()->json($best_matches);
    }
}
