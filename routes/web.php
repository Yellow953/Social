<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerifyOtpController;
use App\Http\Controllers\Auth\VerifyTwoFactorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AnalyticsController as AdminAnalyticsController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\PrivacyController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public routes
Route::get('/', function () {
    return Inertia::render('Welcome', ['page' => 'home']);
});
Route::get('/about', function () {
    return Inertia::render('Welcome', ['page' => 'about']);
});
Route::get('/academique', function () {
    return Inertia::render('Welcome', ['page' => 'academique']);
});
Route::get('/calculatrice', function () {
    return Inertia::render('Welcome', ['page' => 'calculatrice']);
});

// Legal pages
Route::get('/terms', [TermsController::class, 'index'])->name('terms');
Route::get('/privacy', [PrivacyController::class, 'index'])->name('privacy');

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// OTP Verification routes
Route::get('/verify-otp', [VerifyOtpController::class, 'show'])->name('verify-otp');
Route::post('/verify-otp', [VerifyOtpController::class, 'verify']);
Route::post('/resend-otp', [VerifyOtpController::class, 'resend'])->name('resend-otp');

// Two-Factor Authentication routes
Route::get('/verify-2fa', [VerifyTwoFactorController::class, 'show'])->name('verify-2fa');
Route::post('/verify-2fa', [VerifyTwoFactorController::class, 'verify']);
Route::post('/resend-2fa', [VerifyTwoFactorController::class, 'resend'])->name('resend-2fa');

// Password Reset routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Protected routes (require authentication)
Route::middleware(['auth', 'single.device'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/courses', [CourseController::class, 'index'])->name('courses');
    Route::middleware('subscription')->group(function () {
        Route::get('/sessions', [SessionController::class, 'index'])->name('sessions');
        Route::get('/sessions/{session}', [SessionController::class, 'show'])->name('sessions.show');
        Route::post('/sessions/{session}/watch-time', [SessionController::class, 'updateWatchTime'])->name('sessions.watch-time');
        Route::get('/media/{media}', [\App\Http\Controllers\MediaController::class, 'detail'])->name('media.detail');
        Route::get('/media/{media}/view', [\App\Http\Controllers\MediaController::class, 'view'])->name('media.view');
        Route::get('/media/{media}/stream', [\App\Http\Controllers\MediaController::class, 'stream'])->name('media.stream');
    });
    Route::get('/calculator', [CalculatorController::class, 'index'])->name('calculator');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::get('/subscriptions', [\App\Http\Controllers\SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('/subscriptions/create', [\App\Http\Controllers\SubscriptionController::class, 'create'])->name('subscriptions.create');
    Route::post('/subscriptions', [\App\Http\Controllers\SubscriptionController::class, 'store'])->name('subscriptions.store');
});

// Admin routes (require authentication + admin role)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class);
    Route::post('users/{user}/quick-subscription', [AdminUserController::class, 'createQuickSubscription'])->name('admin.users.quick-subscription');
    Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('analytics');
    Route::get('/subscriptions', [\App\Http\Controllers\Admin\SubscriptionController::class, 'index'])->name('subscriptions');
    Route::post('/subscriptions/{subscription}/approve', [\App\Http\Controllers\Admin\SubscriptionController::class, 'approve'])->name('subscriptions.approve');
    Route::post('/subscriptions/{subscription}/reject', [\App\Http\Controllers\Admin\SubscriptionController::class, 'reject'])->name('subscriptions.reject');
    Route::get('/access-logs', [\App\Http\Controllers\Admin\AccessLogController::class, 'index'])->name('access-logs');

    // Courses CRUD
    Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class);

    // Sessions CRUD
    Route::resource('sessions', \App\Http\Controllers\Admin\SessionController::class);
});
