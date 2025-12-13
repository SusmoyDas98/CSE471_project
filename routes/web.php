<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DormReviewController;

// Home page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Google OAuth Routes - keeping your original route structure
Route::get('/auth/redirect', function () {
    return Socialite::driver('google')
        ->stateless() // avoids session mismatch
        ->with(['prompt' => 'select_account']) // forces Google account chooser
        ->redirect();
})->name('google.redirect');

Route::get('/auth/callback', function () {
    $googleUser = Socialite::driver('google')
        ->stateless()
        ->user();
     
        $user = User::updateOrCreate([
            'google_id' => $googleUser->id,
        ], [
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken,
            'password' => bcrypt(uniqid()),
            'role' => 'Dorm Seeker',
        ]);
     
        Auth::login($user);
     
        return redirect('/dashboard');
    })->name('google.callback');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('auth.dashboard');
    })->name('dashboard');
});

// Dorm Review Routes
Route::get('/dorms', [DormReviewController::class, 'index'])->name('dorms.index');
Route::get('/dorms/{id}', [DormReviewController::class, 'show'])->name('dorms.show');
Route::post('/dorms/{id}/review', [DormReviewController::class, 'storeReview'])->name('dorms.review')->middleware('auth');
Route::delete('/reviews/{id}', [DormReviewController::class, 'deleteReview'])->name('reviews.delete')->middleware('auth');