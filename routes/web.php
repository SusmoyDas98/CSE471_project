<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageRedirectController;
use App\Http\Controllers\DormRegistrationController;
use App\Http\Controllers\Website_review_controller;                   


Route::get('/', function () {
    return view('welcome');
});

// // Route::view("/dorm_reg", [PageRedirectController::class, "dorm_reg"]);
// Route::view("/dorm_reg", "dorm_reg")->name("dorm_reg");
// Route::view("/dorm_reg_admin_view", "dorm_reg_admin_view")->name("dorm_reg_admin_view");

// Route::view("/find_dorm_mate", [PageRedirectController::class, "find_dorm_mate"]);
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