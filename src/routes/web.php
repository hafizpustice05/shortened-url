<?php

use App\Events\MessageNotification;
use App\Http\Controllers\BloomFilterController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\ElasticsearchController;
use App\Http\Controllers\ShortendUrl\ShortendUrlController;
use App\Http\Controllers\TestNotificationSettingController;
use App\Http\Controllers\UrlRedirectController;
use App\Services\ElasticsearchService;
use App\Services\IGeographicalLocation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

//test
use Illuminate\Support\Facades\Route;

// Container::getInstance()->make(FilesystemFactory::class);

Route::get('image-upload', [BloomFilterController::class, 'index']);
Route::post('image-upload', [BloomFilterController::class, 'upload'])->name('image-upload');

Route::get('/bloom-test', [BloomFilterController::class, 'testBloomFilter']);

Route::get('/products', [ElasticsearchController::class, 'store']); // Create/Update
Route::get('/products/search', [ElasticsearchController::class, 'search']); // Search
Route::get('/products/{id}', [ElasticsearchController::class, 'show']); // Retrieve
Route::delete('/products/{id}', [ElasticsearchController::class, 'destroy']); // Delete

Route::get('test-1', [TestNotificationSettingController::class, 'index']);
Route::get('/test', function (IGeographicalLocation $iGeographicalLocation) {

    dd(app()['config']);
    $params = [
        'index' => 'products',
        'body'  => [
            'settings' => [
                'number_of_shards'   => 2,
                'number_of_replicas' => 0
            ]
        ]
    ];

    return (new ElasticsearchService())->searchDocuments('', $params);

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
    Route::get('/dashboard/test', [DashboardController::class, 'dashboard'])->name('home');
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
