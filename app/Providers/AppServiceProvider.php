<?php

namespace App\Providers;

use App\Services\GeographicalLocation;
use App\Services\IGeographicalLocation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Bind geographical service
         */
        $this->app->bind(IGeographicalLocation::class, GeographicalLocation::class);

        /**
         * Rate limit implement for creation of shortend url
         * Every user or every IP based user can only 5 shortend url generate every minute
         * It's more secure for avoid spam or abuse
         */
        RateLimiter::for('shorten-url', function ($request) {
            return Limit::perMinute(5)->by(optional($request->user())->id ?: $request->ip());
        });

        /**
         * Rate limit implement for redirect of shortend url
         * Every user or every IP based user can only 5 shortend url visit every minute
         * That provide a redirection with secure and efficeint way
         */
        RateLimiter::for('redirect-url', function ($request) {
            return Limit::perMinute(5)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
