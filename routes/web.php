<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
// ... other use statements

// Public Routes (accessible to all)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Guest Routes (only accessible when not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/signup', [SignupController::class, 'showSignupForm'])->name('signup');
    Route::post('/signup', [SignupController::class, 'signup']);
    
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Password Reset Routes
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
         ->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
         ->name('password.email');
    Route::get('/password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])
         ->name('password.reset');
    Route::post('/password/reset', [ForgotPasswordController::class, 'reset'])
         ->name('password.update');
});

// Authenticated Routes (require login)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Resource Routes
    Route::resource('patients', PatientController::class);
    Route::resource('inventory', InventoryController::class);
    Route::resource('prescriptions', PrescriptionController::class);
    Route::resource('orders', OrderController::class);
    
    // Custom Routes
    Route::get('/inventory/low-stock', [InventoryController::class, 'lowStock'])
         ->name('inventory.low-stock');
    Route::get('/orders/pending', [OrderController::class, 'pending'])
         ->name('orders.pending');
    Route::get('/reports', [ReportController::class, 'index'])
         ->name('reports.index');
    Route::get('/activity-log', [ActivityController::class, 'index'])
         ->name('activity.log');
    
    // Profile Routes
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');

    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
         ->name('notifications.read');
});