<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageRedirectController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LandlordDashboardController;
use Illuminate\Http\Request;
use App\Http\Controllers\DormSeekerDashboardController;
use App\Http\Controllers\ChatController;



Route::get('/', function () {
    return view('welcome');
});

Route::view("/dorm_reg", [PageRedirectController::class, "dorm_reg"]);
Route::view("/find_dorm_mate", [PageRedirectController::class, "find_dorm_mate"]);
Route::view("/website_feedback", "website_feedback");

// Document upload / dorm registration
Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');





Route::get('/landlord/dashboard', [LandlordDashboardController::class, 'index']);




Route::get('/dorm-seeker/dashboard', function () {
    return view('dorm-seeker-dashboard');
});

Route::get('/dorm-seeker/dashboard', [DormSeekerDashboardController::class, 'index']);


Route::get('/documents/test', function () {
    return view('document');
});

Route::post('/documents/test', [DocumentController::class, 'store'])
    ->name('documents.store');





Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');
Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');




