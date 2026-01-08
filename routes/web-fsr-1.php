<?php

use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

Route::get('/cache-test', function () {
    // Store value in Redis for 1 hour
    Cache::put('test_key', 'hello world', 3600);

    // Retrieve value from Redis
    $value = Cache::get('test_key');

    return response()->json(['cached_value' => $value]);
});

if (isMainSite()) {
    require __DIR__.'/main.php';
}

if (isFacultySite()) {
    require __DIR__.'/faculty.php';
}
