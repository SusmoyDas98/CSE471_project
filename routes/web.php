<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\PageRedirectController;
use App\Http\Controllers\DormRegistrationController;
use App\Http\Controllers\Website_review_controller; 
use App\Http\Controllers\AutoSuggestionController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LandlordDashboardController;
use Illuminate\Http\Request;
use App\Http\Controllers\DormSeekerDashboardController;
use App\Http\Controllers\ChatController;


=======
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DormReviewController;
use App\Http\Controllers\DormRegistrationController;
>>>>>>> afia-branch


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

    Route::get('/google/select-role', function () {
        if (!session()->has('google_user_data')) {
            return redirect()->route('login')->with('error', 'Google session expired. Please try again.');
        }
        return view('auth.google-role');
    })->name('google.role.select');


    Route::post('/google/select-role', function (\Illuminate\Http\Request $request) {

        $request->validate([
            'role' => 'required|in:Dorm Seeker,Dorm Owner',
        ]);

        $googleData = session('google_user_data');

        if (!$googleData) {
            return redirect()->route('login')
                ->with('error', 'Google session expired. Please try again.');
        }

        // Create user AFTER role is selected
        $user = User::create([
            'name' => $googleData['name'],
            'email' => $googleData['email'],
            'google_id' => $googleData['id'],
            'google_token' => $googleData['token'],
            'google_refresh_token' => $googleData['refreshToken'],
            'password' => bcrypt(uniqid()),
            'role' => $request->role,
        ]);

        // Cleanup session
        session()->forget('google_user_data');

        Auth::login($user);

        return redirect('/dashboard');

    })->name('google.role.store');

    
    
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

        // 1️⃣ Check if user already exists
        $user = User::where('google_id', $googleUser->id)
                    ->orWhere('email', $googleUser->email)
                    ->first();

        // 2️⃣ If user EXISTS → just login
        if ($user) {
            Auth::login($user);
            return redirect('/dashboard');
        }

        // 3️⃣ User does NOT exist → must select role first
        session([
            'google_user_data' => [
                'id' => $googleUser->id,
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'token' => $googleUser->token,
                'refreshToken' => $googleUser->refreshToken,
            ]
        ]);

        return redirect()->route('google.role.select');

    })->name('google.callback');

});

<<<<<<< HEAD
// // Route::view("/dorm_reg", [PageRedirectController::class, "dorm_reg"]);
// Route::view("/search_dorm_mate", "search_dorm_mate")->name("search_dorm_mate");
// Route::view("/dorm_reg_admin_view", "dorm_reg_admin_view")->name("dorm_reg_admin_view");

// Route::view("/search_dorm_mate", [PageRedirectController::class, "search_dorm_mate"]);
Route::get("/search_dorm_mate", [AutoSuggestionController::class, "index"])->name("search_dorm_mate.index");

Route::get('/website_feedback', [Website_review_controller::class, 'index'])->name('website_feedback.index');

Route::get('/dorm_reg_view', [DormRegistrationController::class, 'index'])->name('dorm_reg_view.index');
Route::get('/dorm_reg_admin_view', [DormRegistrationController::class, 'admin_view'])->name('dorm_reg_admin_view');
Route::get('/dorm_reg', [DormRegistrationController::class, 'user_view'])->name('dorm_reg');
// Route::post("/dorm_reg/approve/{id}",[DormRegistrationController::class, "approve"])->name("dorm_reg.approve");
// Route::post("/dorm_reg/decline/{id}",[DormRegistrationController::class, "decline"])->name("dorm_reg.decline");
Route::view("/dorm_reg", [PageRedirectController::class, "dorm_reg"]);
Route::view("/find_dorm_mate", [PageRedirectController::class, "find_dorm_mate"]);
Route::view("/website_feedback", "website_feedback");

// Document upload / dorm registration
#Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
#Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');

#Route::middleware('auth')->group(function () {
    #Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    #Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
#});

Route::get('/documents/test', [DocumentController::class, 'index'])->name('documents.test');
Route::post('/documents/test', [DocumentController::class, 'store'])->name('documents.store');



Route::get('/landlord/dashboard', [LandlordDashboardController::class, 'index']);




Route::get('/dorm-seeker/dashboard', [DormSeekerDashboardController::class, 'index'])
    ->name('dormseeker.dashboard');


Route::get('/documents/test', function () {
    return view('document');
});

Route::post('/documents/test', [DocumentController::class, 'store'])
    ->name('documents.store');





// Route::view("/submitted_dorm", "submitted_dorm")->name("submitted_dorm");

Route::get('/submitted_dorm/{id}', [DormRegistrationController::class, 'submitted_dorm_view'])->name('submitted_dorm_view');

Route::resource('dorm_registration', DormRegistrationController::class);
Route::resource('website_reviews', Website_review_controller::class);

Route::resource('website_feedback_admin_view', Website_review_controller::class);

// profile_visiting urls:
// Route::view('/user_profile','user_profile')->name('user_profile');
Route::get('/user_profile/{id}', [PageRedirectController::class, 'user_profile']);
Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');
Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
Route::get('/chat/messages/{user}', [ChatController::class, 'fetchMessages'])
    ->name('chat.fetch');





=======
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

// Notification Routes
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::delete('/notifications/{id}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.delete');
    Route::get('/notifications/unread-count', [App\Http\Controllers\NotificationController::class, 'getUnreadCount'])->name('notifications.unreadCount');
});

// Dorm Application Routes
Route::middleware('auth')->group(function () {
    Route::get('/dorms/{id}/apply', [App\Http\Controllers\DormApplicationController::class, 'create'])->name('dorms.apply');
    Route::post('/dorms/{id}/apply', [App\Http\Controllers\DormApplicationController::class, 'store'])->name('dorms.apply.store');
    Route::get('/my-applications', [App\Http\Controllers\DormApplicationController::class, 'myApplications'])->name('applications.my');
    Route::get('/received-applications', [App\Http\Controllers\DormApplicationController::class, 'receivedApplications'])->name('applications.received');
});

// Dorm Registration Routes
Route::middleware('auth')->group(function () {
    Route::get('/dorm_reg_view', [DormRegistrationController::class, 'index'])->name('dorm_reg_view.index');
    Route::get('/dorm_reg_admin_view', [DormRegistrationController::class, 'admin_view'])->name('dorm_reg_admin_view');
    Route::get('/dorm_reg', [DormRegistrationController::class, 'user_view'])->name('dorm_reg');
    Route::post("/dorm_reg/approve/{id}",[DormRegistrationController::class, "approve"])->name("dorm_reg.approve");
    Route::post("/dorm_reg/decline/{id}",[DormRegistrationController::class, "decline"])->name("dorm_reg.decline");
});

// Admin Routes
Route::middleware('auth')->group(function () {
    Route::get('/admin/pending-dorms', [App\Http\Controllers\DormRegistrationController::class, 'pendingRegistrations'])->name('admin.pending.dorms');
    Route::post('/admin/dorms/{id}/approve', [App\Http\Controllers\DormRegistrationController::class, 'approve'])->name('admin.dorm.approve');
    Route::post('/admin/dorms/{id}/decline', [App\Http\Controllers\DormRegistrationController::class, 'decline'])->name('admin.dorm.decline');
});

// Dorm Owner Approve/Decline Application Routes (handled by DormApplicationController)
Route::post('/applications/{id}/approve', [App\Http\Controllers\DormApplicationController::class, 'approve'])->name('applications.approve')->middleware('auth');
Route::post('/applications/{id}/decline', [App\Http\Controllers\DormApplicationController::class, 'decline'])->name('applications.decline')->middleware('auth');

// Serve application files securely
Route::get('/applications/{id}/file/{type}', [App\Http\Controllers\DormApplicationController::class, 'serveDocument'])->name('applications.file')->middleware('auth');


// Dorm Search Routes
Route::middleware('auth')->group(function () {
    Route::get('/search-dorms', [App\Http\Controllers\DormSearchController::class, 'index'])->name('dorms.search');
    Route::post('/search-dorms/manual', [App\Http\Controllers\DormSearchController::class, 'manualSearch'])->name('dorms.search.manual');
    Route::post('/search-dorms/ai', [App\Http\Controllers\DormSearchController::class, 'aiSearch'])->name('dorms.search.ai');
});

Route::get('/submitted_dorm/{id}', [DormRegistrationController::class, 'submitted_dorm_view'])->name('submitted_dorm_view');

Route::resource('dorm_registration', DormRegistrationController::class);
>>>>>>> afia-branch
