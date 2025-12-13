<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageRedirectController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandlordDashboardController;



Route::get('/', function () {
    return view('welcome');
});

Route::view("/dorm_reg", [PageRedirectController::class, "dorm_reg"]);
Route::view("/find_dorm_mate", [PageRedirectController::class, "find_dorm_mate"]);
Route::view("/website_feedback", "website_feedback");

// Document upload / dorm registration
Route::get('/documentInd', [DocumentController::class, 'index'])->name('documents.index');
Route::post('/documentStore', [DocumentController::class, 'store'])->name('documents.store');



// Dashboard routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::post('/dashboard/{id}/like', [DashboardController::class, 'like'])->name('dashboard.like');
Route::post('/dashboard/{id}/share', [DashboardController::class, 'share'])->name('dashboard.share');




Route::get('/landlord/dashboard', [LandlordDashboardController::class, 'index']);



