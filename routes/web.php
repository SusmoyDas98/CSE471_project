<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageRedirectController;

Route::get('/', function () {
    return view('welcome');
});

Route::view("/dorm_reg", [PageRedirectController::class, "dorm_reg"]);
Route::view("/find_dorm_mate", [PageRedirectController::class, "find_dorm_mate"]);
