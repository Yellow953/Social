<?php

namespace App\Providers;

use App\Models\HomepageSlide;
use App\Models\Material;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);
        Route::bind('session', fn ($value) => Material::findOrFail($value));
        Route::bind('content_management', fn ($value) => HomepageSlide::findOrFail($value));
    }
}
