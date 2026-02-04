<?php

namespace App\Providers;

use App\Models\HomepageSlide;
use App\Models\Material;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::bind('session', fn ($value) => Material::findOrFail($value));
        Route::bind('content_management', fn ($value) => HomepageSlide::findOrFail($value));
    }
}
