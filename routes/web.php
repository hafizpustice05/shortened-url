<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\ShortendUrl\ShortendUrlController;
use App\Http\Controllers\UrlRedirectController;
use Illuminate\Support\Facades\Route;


Route::name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('home');
    Route::get('/analytics-url/{shortUrl}', [DashboardController::class, 'analyticsUrl'])->name('analytics-url');
});

Route::get('shortenurl', [ShortendUrlController::class, 'create']);

Route::middleware('throttle:shorten-url')->group(function () {
    Route::post('shortenurl', [ShortendUrlController::class, 'store'])->name('shortenurl');
});;

/**
 * short-url redirect route
 */
Route::middleware('throttle:redirect-url')->group(function () {
    Route::get('/{shortenedUrl}', UrlRedirectController::class);
});
