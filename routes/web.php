<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageRedirectController;
use App\Http\Controllers\DormRegistrationController;
use App\Http\Controllers\Website_review_controller; 
use App\Http\Controllers\AutoSuggestionController;

Route::get('/', function () {
    return view('welcome');
});

// // Route::view("/dorm_reg", [PageRedirectController::class, "dorm_reg"]);
// Route::view("/search_dorm_mate", "search_dorm_mate")->name("search_dorm_mate");
// Route::view("/dorm_reg_admin_view", "dorm_reg_admin_view")->name("dorm_reg_admin_view");

// Route::view("/search_dorm_mate", [PageRedirectController::class, "search_dorm_mate"]);
Route::get("/search_dorm_mate", [AutoSuggestionController::class, "index"])->name("search_dorm_mate.index");

Route::get('/website_feedback', [Website_review_controller::class, 'index'])->name('website_feedback.index');

Route::get('/dorm_reg_view', [DormRegistrationController::class, 'index'])->name('dorm_reg_view.index');
Route::get('/dorm_reg_admin_view', [DormRegistrationController::class, 'admin_view'])->name('dorm_reg_admin_view');
Route::get('/dorm_reg', [DormRegistrationController::class, 'user_view'])->name('dorm_reg');
Route::post("/dorm_reg/approve/{id}",[DormRegistrationController::class, "approve"])->name("dorm_reg.approve");
Route::post("/dorm_reg/decline/{id}",[DormRegistrationController::class, "decline"])->name("dorm_reg.decline");





// Route::view("/submitted_dorm", "submitted_dorm")->name("submitted_dorm");

Route::get('/submitted_dorm/{id}', [DormRegistrationController::class, 'submitted_dorm_view'])->name('submitted_dorm_view');

Route::resource('dorm_registration', DormRegistrationController::class);
Route::resource('website_reviews', Website_review_controller::class);

// profile_visiting urls:
// Route::view('/user_profile','user_profile')->name('user_profile');
Route::get('/user_profile/{id}', [PageRedirectController::class, 'user_profile']);
