<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Health Check (ALB / ECS Safe)
|--------------------------------------------------------------------------
*/
Route::get('/health', function () {
    info("Route /health hit");

    $checks = [
        'app'   => 'up',
        'redis' => 'unknown',
    ];

    try {
        Cache::put('health_check', 'ok', 5);
        $checks['redis'] = Cache::get('health_check') === 'ok' ? 'up' : 'down';
    } catch (\Throwable $e) {
        $checks['redis'] = 'down';
    }

    $status = in_array('down', $checks, true) ? 'degraded' : 'ok';

    return response()->json([
        'status' => $status,
        'site'   => env('APP_SITE'),
        'env'    => app()->environment(),
        'time'   => now()->toISOString(),
        'checks' => $checks,
    ], $status === 'ok' ? 200 : 503);
});

/*
|--------------------------------------------------------------------------
| Redis Functional Test (Manual)
|--------------------------------------------------------------------------
*/
Route::get('/cache-test', function () {
    info("Route /cache-test hit");

    Cache::put('test_key', 'hello world', 3600);

    return response()->json([
        'cached_value' => Cache::get('test_key'),
    ]);
});

/*
|--------------------------------------------------------------------------
| Site-Specific Routes
|--------------------------------------------------------------------------
*/
Route::group([], function () {

    if (isMainSite()) {
        info("Main site routes loaded");
        require __DIR__ . '/main.php';
    }

    if (isFacultySite()) {
        info("Faculty site routes loaded");
        require __DIR__ . '/faculty.php';
    }

});

/*
|--------------------------------------------------------------------------
| Fallback (Optional but Recommended)
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->json([
        'message' => 'Route not found',
        'site'    => env('APP_SITE'),
    ], 404);
});
