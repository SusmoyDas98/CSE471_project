<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dorm;
use App\Models\User;

class AutoSuggestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user_id = 1;
        $all_dorms = Dorm::select("id",'name', 'location')->get();
        $genders = ['Male', 'Female'];
        $marital_status = ['Married', "Unmarried"];
        return view("search_dorm_mate", [
            "user_id"=>$user_id,
            "all_dorms"=>$all_dorms,
            "genders"=>$genders,
            "marital_status"=> $marital_status
        ]);
    }

}
