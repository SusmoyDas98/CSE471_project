<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageRedirectController extends Controller
{
    //
    public function user_profile($id){
        // $current_user_id = '12';
        // $current_user_role = 'dorm_seeker';
        $current_user_id = $id;
        return view('user_profile', (
            [
                'current_user_id'=>$current_user_id,
            ]
            ));
    }

    public function dorm_reg(){
        return redirect("dorm_reg");
    }

    public function search_dorm_mate(){
        return redirect("search_dorm_mate");
    }
}
