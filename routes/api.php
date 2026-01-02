<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website_review_controller_api;
use App\Http\Controllers\Dorm_Registration_Controller_api;
use App\Http\Controllers\auto_suggestion_controller_api;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// fetch the website reviews
Route::get('/website_reviews_get/{type}', [Website_review_controller_api::class, 'get_reviews']);
// submit the website reviews
<<<<<<< HEAD
Route::post('/website_reviews_post', [Website_review_controller_api::class, 'store']);
=======
>>>>>>> afia-branch
Route::post('/website_reviews_update/{message_id}/{label}', [Website_review_controller_api::class, 'update_label']);
// fetch the submission infos
Route::get('/get_submission_infos/{submission_id}',[Dorm_Registration_Controller_api::class, 'show']);
// updating the submission status
Route::post('/update_submission_infos/{submission_id}/{verdict}',[Dorm_Registration_Controller_api::class, 'update_status']);
// fetching the dorm mate suggestions
Route::get('/get_auto_suggestions_dorm_mate/{user_id}',[auto_suggestion_controller_api::class,"fetch_auto_dorm_mate"]);
// fetching the dorm mate suggestions
Route::get("/get_filtered_suggestions_dorm_mate/{user_id}",[auto_suggestion_controller_api::class,"fetch_filtered_dorm_mate"]);
