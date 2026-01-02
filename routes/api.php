<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentController as ApiPaymentController;

// Note: For production, install Laravel Sanctum: composer require laravel/sanctum
// Then use 'auth:sanctum' middleware. For now using basic auth.
Route::middleware('auth')->prefix('v1')->group(function () {
    Route::prefix('payments')->name('api.payments.')->group(function () {
        Route::get('/', [ApiPaymentController::class, 'index'])->name('index');
        Route::get('/{payment}', [ApiPaymentController::class, 'show'])->name('show');
        Route::post('/', [ApiPaymentController::class, 'store'])->name('store');
        Route::get('/invoices/pending', [ApiPaymentController::class, 'pendingInvoices'])->name('pending');
        Route::get('/history', [ApiPaymentController::class, 'history'])->name('history');
    });
});

