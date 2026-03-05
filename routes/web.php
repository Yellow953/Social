<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerifyOtpController;
use App\Http\Controllers\Auth\VerifyTwoFactorController;
use App\Http\Controllers\AcademiqueController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\CookiePolicyController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\AccessLogController as AdminAccessLogController;
use App\Http\Controllers\Admin\AnalyticsController as AdminAnalyticsController;
use App\Http\Controllers\Admin\ContentManagementController as AdminContentManagementController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MaterialController as AdminMaterialController;
use App\Http\Controllers\Admin\SubscriptionController as AdminSubscriptionController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;

// ─── Authentication ───────────────────────────────────────────────────────────
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::post('/email/resend-verification', [EmailVerificationController::class, 'resendFromLogin'])->middleware('throttle:6,1')->name('verification.resend-from-login');

Route::get('/verify-otp', [VerifyOtpController::class, 'show'])->name('verify-otp');
Route::post('/verify-otp', [VerifyOtpController::class, 'verify']);
Route::post('/resend-otp', [VerifyOtpController::class, 'resend'])->name('resend-otp');

Route::middleware('auth')->group(function () {
    Route::get('/verify-2fa', [VerifyTwoFactorController::class, 'show'])->name('verify-2fa');
    Route::post('/verify-2fa', [VerifyTwoFactorController::class, 'verify']);
    Route::post('/resend-2fa', [VerifyTwoFactorController::class, 'resend'])->name('resend-2fa');
});

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// ─── Protected (auth email + single device) ───────────────────────
Route::middleware(['auth', 'two_factor', 'single.device'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/academic', [AcademiqueController::class, 'index'])->name('academique');
    Route::get('/academic/years', [AcademiqueController::class, 'years'])->name('academique.years');
    Route::get('/academic/courses', [AcademiqueController::class, 'courses'])->name('academique.courses');
    Route::get('/academic/materials', [AcademiqueController::class, 'materials'])->name('academique.materials');

    Route::get('/courses', [CourseController::class, 'index'])->name('courses');
    Route::get('/calculator', [CalculatorController::class, 'index'])->name('calculator');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/two-factor', [ProfileController::class, 'updateTwoFactor'])->name('profile.two-factor');

    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('/subscriptions/create', [SubscriptionController::class, 'create'])->name('subscriptions.create');
    Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');

    // Subscription-gated (locked materials require SOCIALPLUS)
    Route::middleware('subscription')->group(function () {
        Route::get('/materials', [MaterialController::class, 'index'])->name('materials');
        Route::get('/materials/{material}', [MaterialController::class, 'show'])->name('materials.show');
        Route::get('/materials/{material}/media', [MaterialController::class, 'media'])->name('materials.media');
        Route::post('/materials/{material}/watch-time', [MaterialController::class, 'updateWatchTime'])->name('materials.watch-time');

        Route::get('/media/{media}', [MediaController::class, 'detail'])->name('media.detail');
        Route::get('/media/{media}/view', [MediaController::class, 'view'])->name('media.view');
        Route::get('/media/{media}/stream', [MediaController::class, 'stream'])->name('media.stream');
    });
});

// ─── Admin (auth + admin role) ────────────────────────────────────────────────
Route::middleware(['auth', 'two_factor', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('analytics');
    Route::get('/access-logs', [AdminAccessLogController::class, 'index'])->name('access-logs');

    Route::resource('users', AdminUserController::class);
    Route::post('users/{user}/quick-subscription', [AdminUserController::class, 'createQuickSubscription'])->name('users.quick-subscription');

    Route::get('/subscriptions', [AdminSubscriptionController::class, 'index'])->name('subscriptions');
    Route::post('/subscriptions/{subscription}/approve', [AdminSubscriptionController::class, 'approve'])->name('subscriptions.approve');
    Route::post('/subscriptions/{subscription}/reject', [AdminSubscriptionController::class, 'reject'])->name('subscriptions.reject');

    Route::post('courses/{course}/duplicate', [AdminCourseController::class, 'duplicate'])->name('courses.duplicate');
    Route::resource('courses', AdminCourseController::class);

    Route::post('materials/upload-temp', [AdminMaterialController::class, 'uploadTemp'])->name('materials.upload-temp');
    Route::patch('materials/{material}/toggle-lock', [AdminMaterialController::class, 'toggleLock'])->name('materials.toggle-lock');
    Route::get('materials/media/{material_media}/download', [AdminMaterialController::class, 'downloadMedia'])->name('materials.media.download');
    Route::post('materials/media/{material_media}/convert-to-pdf', [AdminMaterialController::class, 'convertToPdf'])->name('materials.media.convert-to-pdf');
    Route::post('materials/{material}/duplicate', [AdminMaterialController::class, 'duplicate'])->name('materials.duplicate');
    Route::resource('materials', AdminMaterialController::class)->parameters(['session' => 'material']);

    Route::resource('content-management', AdminContentManagementController::class);
});

// ─── Public ──────────────────────────────────────────────────────────────────
Route::get('/', [WelcomeController::class, 'home'])->name('home');
Route::get('/about', [WelcomeController::class, 'about'])->name('about');
Route::get('/academique', [WelcomeController::class, 'academique'])->name('academique.public');
Route::get('/calculatrice', [WelcomeController::class, 'calculatrice'])->name('calculatrice');

Route::get('/terms', [TermsController::class, 'index'])->name('terms');
Route::get('/privacy', [PrivacyController::class, 'index'])->name('privacy');
Route::get('/cookie-policy', [CookiePolicyController::class, 'index'])->name('cookie-policy');
