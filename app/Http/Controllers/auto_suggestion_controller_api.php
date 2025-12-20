<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User_Preferences;
use App\Models\User;
use Illuminate\Validation\Rules\Unique;
use PhpParser\Node\Stmt\ElseIf_;
use App\Models\Dorm;

use function PHPUnit\Framework\isEmpty;

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
            'dorm_id' => $mine_user->dorm_id ?? "",

            'age' => $mine_user->age ?? null
        ];

        $total_possible_score = count($mine_preferences['preferences'] ?? [])
                              + count($mine_preferences['hobbies'] ?? [])
                              + 1
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
            if (($mine_preferences['dorm_id'] ?? "") === ($other_user->dorm_id ?? "")) {
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
            return [
                "name" => $other_user->user_name ?? "",
                "email" => $other_user->user_email ?? "",
                'matching_percentage' => $final_score,
                'user_id' => $other_user->user_id,
                'dorm' => $other_user->dorm_name ?? null,
                "age"=>$other_user->age,
                "gender"=>$other_user->gender,
                'common_hobbies' => $common_hobbies,
                'common_preferences' =>$common_preferences
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



    public function fetch_filtered_dorm_mate(Request $request, $user_id)
    {
        $all_user_except_mine_infos = User_Preferences::where("user_id", "!=", $user_id)->get();

        $name = $request->query('name');
        $min_age = $request->query('min_age');
        $max_age = $request->query('max_age');
        $gender =  $request->query('gender');
        $dorm_id = $request->query("dorm_id");

        // $filter_nums = count(collect([$min_age, $max_age, $gender, $dorm_id])->filter(function($items){
        //     return !empty($items);
        //         }));
        
        $filters = collect([
                            "name" => $name,
                            "min_age" => $min_age,
                            "max_age" => $max_age,
                            "gender"  => $gender,
                            "dorm_id" => $dorm_id
                        ]);


        $best_matches =  $all_user_except_mine_infos->map(function($other_user) use ($name, $min_age ,$max_age ,$gender ,$dorm_id, $filters){
            $selected_id = [];
            $true_checker = $filters->map(function ($items) { return false;});

            if (!empty($filters["min_age"]) || !empty($filters["max_age"])){
                if($min_age!==null && $max_age!==null){
                    if ($min_age <= $other_user['age'] && $other_user['age']  <= $max_age){
                        $selected_id[] = $other_user["user_id"]; 
                        $true_checker["min_age"] = true;
                        $true_checker["max_age"] = true;

                    }

                }
                elseif($min_age!==null && $max_age === null){
                    if ($min_age <= $other_user['age']){
                        $selected_id[] = $other_user["user_id"]; 
                        $true_checker["min_age"] = true;
                        
                    }
                }
                elseif($min_age===null && $max_age !== null){
                    if ($max_age >= $other_user['age']){
                        $selected_id[] = $other_user["user_id"]; 
                        $true_checker["max_age"] = true;
                    }            
                }}

            if (!empty($filters["name"]) && strpos(strtolower($other_user['user_name']), strtolower($name)) !== false) {
                $selected_id[] = $other_user["user_id"];
                $true_checker["name"] = true;
            }


            if(!empty($filters["gender"])  && $gender === $other_user['gender']){
                    $selected_id[] = $other_user["user_id"]; 
                    $true_checker["gender"] = true;

            }
            if(!empty($filters["dorm_id"])  && $dorm_id == $other_user['dorm_id']){
                    $selected_id[] = $other_user["user_id"]; 
                    $true_checker["dorm_id"] = true;

            }            

            $selected_id = array_unique($selected_id);

            $filter_trues =  $filters->filter(function($vals){
                return $vals !== null && $vals !== "";
            });
            $checker_trues =  $true_checker->filter(function($vals){
                return $vals === true;
            });

            $verdict = ($filter_trues->keys()->all() === $checker_trues->keys()->all() ? true : false );

            if(count($selected_id)>0 && $verdict === true){

            // $other_user_personal_info = User::select('name', 'email')->where('id', $other_user->user_id)->first();            
            // $dorm_info = Dorm::select('name')->where('id', $other_user->dorm_id)->first();                        
            // dd($other_user->dorm_id);
            return [
                "name" => $other_user->user_name ?? "",
                "email" => $other_user->user_email ?? "",
                'user_id' => $other_user->user_id,
                'dorm' => $other_user->dorm_name ?? null,
                "age"=>$other_user->age,
                "gender"=>$other_user->gender,
                'common_hobbies' =>json_decode($other_user->hobbies),
                'common_preferences' => json_decode($other_user->preferences)
            ];}
            else{
                return [];
            }
        })->filter(function($item){
            return !empty($item);
        });


        return response()->json($best_matches->values());


}
}