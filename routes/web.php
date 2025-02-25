<?php

use App\Events\MessageNotification;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\ShortendUrl\ShortendUrlController;
use App\Http\Controllers\TestNotificationSettingController;
use App\Http\Controllers\UrlRedirectController;
use App\Services\IGeographicalLocation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


//test
Route::get('test-1', [TestNotificationSettingController::class, 'index']);
Route::get('/test', function (IGeographicalLocation $iGeographicalLocation) {


    broadcast(new MessageNotification('this is the first messahe'))->toOthers();
    $placeholders = [
        'FIRST_NAME' => 'Md. hafizul Islam...',
        'EMAIL'      => 'hafiz',
        'PASSWORD'   => '123',
        'ROLE'       => '34',
        'LOGIN_URL'  => '4545'
    ];

    if ($placeholders instanceof Arr) {
        return 'array';
    }

    $template = DB::table('email_templates')->where('id', 1)->first()->body;

    foreach ($placeholders as $key => $value) {
        $template = str_replace("{{$key}}", $value, $template);
    }

    return $template;
});

Route::name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('home');
    Route::get('/analytics-url/{shortUrl}', [DashboardController::class, 'analyticsUrl'])->name('analytics-url');
});

Route::get('shortenurl', [ShortendUrlController::class, 'create']);

Route::middleware('throttle:shorten-url')->group(function () {
    Route::post('shortenurl', [ShortendUrlController::class, 'store'])->name('shortenurl');
});

/**
 * short-url redirect route
 */
Route::middleware('throttle:redirect-url')->group(function () {
    Route::get('/{shortenedUrl}', UrlRedirectController::class);
});