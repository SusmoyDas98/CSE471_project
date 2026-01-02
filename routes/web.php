<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDetailController;
use App\Http\Controllers\DormController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApplicationReviewController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('welcome');
});

// Simple login route (placeholder - you can implement proper authentication later)
Route::get('/login', function () {
    // Auto-login with first user or create test user
    $user = \App\Models\User::first();
    if (!$user) {
        $user = \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'seeker',
        ]);
    }
    auth()->login($user);
    return redirect()->intended('/dashboard');
})->name('login');

// ============================================
// TEST ROUTES (No Authentication Required)
// Remove these routes after adding authentication
// ============================================

Route::prefix('test')->name('test.')->group(function () {
    // Feature 1: Additional Details
    Route::get('/profile/preferences', function () {
        try {
            // Create a test user for viewing
            $user = \App\Models\User::first();
            if (!$user) {
                $user = \App\Models\User::create([
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => 'seeker',
                ]);
            }

            // Temporarily set auth user
            auth()->login($user);

            return app(\App\Http\Controllers\UserDetailController::class)->edit();
        } catch (\Exception $e) {
            return response("Error: " . $e->getMessage(), 500);
        }
    })->name('test.profile.preferences');

    // Feature 1: Browse Other Seekers' Profiles
    Route::get('/seekers', function () {
        try {
            // Create test seeker user
            $seeker = \App\Models\User::where('role', 'seeker')->first();
            if (!$seeker) {
                $seeker = \App\Models\User::create([
                    'name' => 'Test Seeker',
                    'email' => 'seeker@test.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => 'seeker',
                ]);
            }
            auth()->login($seeker);

            // Create sample seekers with details if they don't exist
            $sampleSeekers = [
                [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                    'role' => 'seeker',
                    'detail' => [
                        'bio' => 'Friendly and clean person looking for a roommate. Love cooking and reading. BRACU student.',
                        'budget_min' => 5000,
                        'budget_max' => 8000,
                        'room_type_pref' => 'Shared',
                        'gender_pref' => 'Male',
                        'smoking' => false,
                        'pet_friendly' => true,
                        'cleanliness_level' => 4,
                        'noise_tolerance' => 3,
                        'interests' => ['cooking', 'reading', 'music'],
                        'languages' => ['English', 'Bengali'],
                        'preferred_areas' => ['BRACU', 'BRAC University'],
                    ]
                ],
                [
                    'name' => 'Sarah Smith',
                    'email' => 'sarah@example.com',
                    'role' => 'seeker',
                    'detail' => [
                        'bio' => 'Quiet student who prefers a peaceful environment. Non-smoker and pet-friendly. Studying at BRACU.',
                        'budget_min' => 6000,
                        'budget_max' => 10000,
                        'room_type_pref' => 'Private',
                        'gender_pref' => 'Female',
                        'smoking' => false,
                        'pet_friendly' => true,
                        'cleanliness_level' => 5,
                        'noise_tolerance' => 2,
                        'interests' => ['studying', 'yoga', 'movies'],
                        'languages' => ['English', 'Bengali', 'Hindi'],
                        'preferred_areas' => ['BRACU'],
                    ]
                ],
                [
                    'name' => 'Mike Johnson',
                    'email' => 'mike@example.com',
                    'role' => 'seeker',
                    'detail' => [
                        'bio' => 'Easy-going person, love sports and outdoor activities. BRACU student looking for roommate.',
                        'budget_min' => 4000,
                        'budget_max' => 7000,
                        'room_type_pref' => 'Shared',
                        'gender_pref' => 'Any',
                        'smoking' => false,
                        'pet_friendly' => false,
                        'cleanliness_level' => 3,
                        'noise_tolerance' => 4,
                        'interests' => ['sports', 'gaming', 'cooking'],
                        'languages' => ['English'],
                        'preferred_areas' => ['BRACU', 'BRAC University'],
                    ]
                ],
                [
                    'name' => 'Ahmed Rahman',
                    'email' => 'ahmed@example.com',
                    'role' => 'seeker',
                    'detail' => [
                        'bio' => 'BRACU student seeking a compatible roommate. Clean, organized, and respectful.',
                        'budget_min' => 5500,
                        'budget_max' => 9000,
                        'room_type_pref' => 'Shared',
                        'gender_pref' => 'Male',
                        'smoking' => false,
                        'pet_friendly' => true,
                        'cleanliness_level' => 4,
                        'noise_tolerance' => 3,
                        'interests' => ['studying', 'reading', 'BRACU'],
                        'languages' => ['English', 'Bengali'],
                        'preferred_areas' => ['BRACU'],
                    ]
                ],
            ];

            foreach ($sampleSeekers as $sample) {
                $user = \App\Models\User::where('email', $sample['email'])->first();
                if (!$user) {
                    $user = \App\Models\User::create([
                        'name' => $sample['name'],
                        'email' => $sample['email'],
                        'password' => \Illuminate\Support\Facades\Hash::make('password'),
                        'role' => $sample['role'],
                    ]);

                    $user->detail()->create($sample['detail']);
                } elseif (!$user->detail) {
                    // If user exists but has no detail, create it
                    $user->detail()->create($sample['detail']);
                } else {
                    // Update existing detail to ensure it has all fields including BRACU
                    $user->detail()->update($sample['detail']);
                }
            }

            return app(\App\Http\Controllers\SeekerProfileController::class)->index(request());
        } catch (\Exception $e) {
            return response("Error: " . $e->getMessage() . " - " . $e->getTraceAsString(), 500);
        }
    })->name('seekers');

    // Feature 2: Vacancy Management (Owner Dashboard)
    Route::get('/owner/dorms', function () {
        try {
            // Create test owner user
            $owner = \App\Models\User::where('role', 'owner')->first();
            if (!$owner) {
                $owner = \App\Models\User::create([
                    'name' => 'Test Owner',
                    'email' => 'owner@test.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => 'owner',
                ]);
            }
            auth()->login($owner);

            return app(\App\Http\Controllers\DormController::class)->index();
        } catch (\Exception $e) {
            return response("Error: " . $e->getMessage(), 500);
        }
    })->name('test.owner.dorms');

    // Feature 2: Owner - Review Applications (Direct Access)
    Route::get('/owner/applications', function () {
        try {
            // Create test owner user
            $owner = \App\Models\User::where('role', 'owner')->first();
            if (!$owner) {
                $owner = \App\Models\User::create([
                    'name' => 'Test Owner',
                    'email' => 'owner@test.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => 'owner',
                ]);
            }
            auth()->login($owner);

            return app(\App\Http\Controllers\ApplicationReviewController::class)->index(request());
        } catch (\Exception $e) {
            return response("Error: " . $e->getMessage(), 500);
        }
    })->name('test.owner.applications');

    // Feature 2: Owner - Create Dorm (Test Route)
    Route::get('/owner/dorms/create', function () {
        try {
            // Create test owner user
            $owner = \App\Models\User::where('role', 'owner')->first();
            if (!$owner) {
                $owner = \App\Models\User::create([
                    'name' => 'Test Owner',
                    'email' => 'owner@test.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => 'owner',
                ]);
            }
            auth()->login($owner);

            return app(\App\Http\Controllers\DormController::class)->create();
        } catch (\Exception $e) {
            return response("Error: " . $e->getMessage(), 500);
        }
    })->name('test.owner.dorms.create');

    // Feature 2: Owner - Store Dorm (Test Route)
    Route::post('/owner/dorms', function () {
        try {
            // Create test owner user
            $owner = \App\Models\User::where('role', 'owner')->first();
            if (!$owner) {
                $owner = \App\Models\User::create([
                    'name' => 'Test Owner',
                    'email' => 'owner@test.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => 'owner',
                ]);
            }
            auth()->login($owner);

            return app(\App\Http\Controllers\DormController::class)->store(request());
        } catch (\Exception $e) {
            return response("Error: " . $e->getMessage(), 500);
        }
    })->name('test.owner.dorms.store');

    // Feature 2: Seeker - Dashboard
    Route::get('/seeker/dashboard', function () {
        try {
            // Create test seeker user
            $seeker = \App\Models\User::where('role', 'seeker')->first();
            if (!$seeker) {
                $seeker = \App\Models\User::create([
                    'name' => 'Test Seeker',
                    'email' => 'seeker@test.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => 'seeker',
                ]);
            }
            auth()->login($seeker);

            return app(\App\Http\Controllers\SeekerDashboardController::class)->index();
        } catch (\Exception $e) {
            return response("Error: " . $e->getMessage(), 500);
        }
    })->name('test.seeker.dashboard');

    // Feature 2: Seeker - View Application (Test Route)
    Route::get('/my-applications/{application}', function ($applicationId) {
        try {
            // Create test seeker user
            $seeker = \App\Models\User::where('role', 'seeker')->first();
            if (!$seeker) {
                $seeker = \App\Models\User::create([
                    'name' => 'Test Seeker',
                    'email' => 'seeker@test.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => 'seeker',
                ]);
            }
            auth()->login($seeker);

            $application = \App\Models\Application::findOrFail($applicationId);

            // If application doesn't belong to this user, assign it to them for testing
            if ($application->user_id !== $seeker->id) {
                $application->update(['user_id' => $seeker->id]);
            }

            return app(\App\Http\Controllers\ApplicationController::class)->show($application);
        } catch (\Exception $e) {
            return response("Error: " . $e->getMessage(), 500);
        }
    })->name('test.seeker.application.show');

    // Feature 2: Seeker - Browse and Apply for Dorms
    Route::get('/seeker/vacancies', function () {
        try {
            // Create test seeker user
            $seeker = \App\Models\User::where('role', 'seeker')->first();
            if (!$seeker) {
                $seeker = \App\Models\User::create([
                    'name' => 'Test Seeker',
                    'email' => 'seeker@test.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => 'seeker',
                ]);
            }
            auth()->login($seeker);

            return app(\App\Http\Controllers\VacancyBrowseController::class)->index(request());
        } catch (\Exception $e) {
            return response("Error: " . $e->getMessage(), 500);
        }
    })->name('test.seeker.vacancies');

    // Feature 3: Community Forum
    Route::get('/community', function () {
        try {
            $user = \App\Models\User::first();
            if (!$user) {
                $user = \App\Models\User::create([
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => 'seeker',
                ]);
            }
            auth()->login($user);

            return app(\App\Http\Controllers\CommunityController::class)->index();
        } catch (\Exception $e) {
            return response("Error: " . $e->getMessage(), 500);
        }
    })->name('community');

    // Feature 4: Payment Portal
    Route::get('/payments', function () {
        try {
            $user = \App\Models\User::first();
            if (!$user) {
                $user = \App\Models\User::create([
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => 'seeker',
                ]);
            }
            auth()->login($user);

            return app(\App\Http\Controllers\PaymentController::class)->index();
        } catch (\Exception $e) {
            return response("Error: " . $e->getMessage(), 500);
        }
    })->name('payments');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile/preferences', [UserDetailController::class, 'edit'])->name('profile.preferences.edit');
    Route::put('/profile/preferences', [UserDetailController::class, 'update'])->name('profile.preferences.update');
    Route::get('/profile/document', [UserDetailController::class, 'viewDocument'])->name('profile.document.view');

    // Seeker: Browse other seekers' profiles to find roommates
    Route::get('/seekers', [\App\Http\Controllers\SeekerProfileController::class, 'index'])->name('seeker.profiles.index');
    Route::get('/seekers/{user}', [\App\Http\Controllers\SeekerProfileController::class, 'show'])->name('seeker.profiles.show');
    Route::post('/seekers/{user}/select-roommate', [\App\Http\Controllers\SeekerProfileController::class, 'selectRoommate'])->name('seeker.profiles.select-roommate');
    Route::delete('/seekers/{user}/remove-roommate', [\App\Http\Controllers\SeekerProfileController::class, 'removeRoommate'])->name('seeker.profiles.remove-roommate');

    // Payment Portal
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/invoices/{invoice}', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/invoices/{invoice}', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/history', [PaymentController::class, 'history'])->name('payments.history');
    Route::post('/payments/bkash/callback', [PaymentController::class, 'bkashCallback'])->name('payments.bkash.callback');

    // Payment Methods Management
    Route::get('/payments/payment-methods/create', [PaymentController::class, 'createPaymentMethod'])->name('payments.payment-methods.create');
    Route::post('/payments/payment-methods', [PaymentController::class, 'storePaymentMethod'])->name('payments.payment-methods.store');
    Route::delete('/payments/payment-methods/{paymentMethod}', [PaymentController::class, 'deletePaymentMethod'])->name('payments.payment-methods.delete');
    Route::post('/payments/payment-methods/{paymentMethod}/set-default', [PaymentController::class, 'setDefaultPaymentMethod'])->name('payments.payment-methods.set-default');

    // Community forum
    Route::get('/community', [CommunityController::class, 'index'])->name('community.index');
    Route::get('/community/dorms/{dorm}/join', [CommunityController::class, 'join'])->name('community.join');
    Route::get('/community/dorms/{dorm}/leave', [CommunityController::class, 'leave'])->name('community.leave');
    Route::get('/community/dorms/{dorm}', [CommunityController::class, 'show'])->name('community.show');
    Route::post('/community/dorms/{dorm}/posts', [CommunityController::class, 'store'])->name('community.posts.store');

    // Seeker: Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\SeekerDashboardController::class, 'index'])->name('seeker.dashboard');

    // Seeker: Browse vacancies and apply
    Route::get('/vacancies', [\App\Http\Controllers\VacancyBrowseController::class, 'index'])->name('seeker.vacancies.index');
    Route::get('/vacancies/{vacancy}', [\App\Http\Controllers\VacancyBrowseController::class, 'show'])->name('seeker.vacancies.show');
    Route::post('/vacancies/{vacancy}/apply', [ApplicationController::class, 'store'])->name('vacancies.apply');

    // Seeker: View own applications
    Route::get('/my-applications', [ApplicationController::class, 'index'])->name('seeker.applications.index');
    Route::get('/my-applications/{application}', [ApplicationController::class, 'show'])->name('seeker.applications.show');

    // Notifications
    Route::put('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');

    // Owner routes
    Route::middleware('owner')->prefix('owner')->name('owner.')->group(function () {
        Route::get('/dorms', [DormController::class, 'index'])->name('dorms.index');
        Route::get('/dorms/create', [DormController::class, 'create'])->name('dorms.create');
        Route::post('/dorms', [DormController::class, 'store'])->name('dorms.store');
        Route::get('/dorms/{dorm}/edit', [DormController::class, 'edit'])->name('dorms.edit');
        Route::put('/dorms/{dorm}', [DormController::class, 'update'])->name('dorms.update');
        Route::delete('/dorms/{dorm}', [DormController::class, 'destroy'])->name('dorms.destroy');

        Route::get('/dorms/{dorm}/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
        Route::post('/dorms/{dorm}/rooms', [RoomController::class, 'store'])->name('rooms.store');
        Route::get('/dorms/{dorm}/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
        Route::put('/dorms/{dorm}/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
        Route::delete('/dorms/{dorm}/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

        Route::get('/rooms/{room}/vacancies/create', [VacancyController::class, 'create'])->name('vacancies.create');
        Route::post('/rooms/{room}/vacancies', [VacancyController::class, 'store'])->name('vacancies.store');
        Route::get('/vacancies/{vacancy}/edit', [VacancyController::class, 'edit'])->name('vacancies.edit');
        Route::put('/vacancies/{vacancy}', [VacancyController::class, 'update'])->name('vacancies.update');

        Route::get('/applications', [ApplicationReviewController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}', [ApplicationReviewController::class, 'show'])->name('applications.show');
        Route::get('/applications/{application}/document', [ApplicationReviewController::class, 'viewSeekerDocument'])->name('applications.viewDocument');
        Route::get('/vacancies/{vacancy}/applications', [ApplicationReviewController::class, 'byVacancy'])->name('applications.byVacancy');
        Route::put('/applications/{application}/status', [ApplicationReviewController::class, 'updateStatus'])->name('applications.updateStatus');
        Route::post('/applications/{application}/quick-action', [ApplicationReviewController::class, 'quickAction'])->name('applications.quickAction');
    });
});
