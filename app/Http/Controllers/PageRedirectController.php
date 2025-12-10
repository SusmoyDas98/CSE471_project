<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageRedirectController extends Controller
{
    //
    public function dorm_reg(){
        return redirect("dorm_reg");
    }

    public function find_dorm_mate(){
        return redirect("find_dorm_mate");
    }
}
