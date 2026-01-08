<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Health check endpoint for container health checks
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now()->toISOString(),
        'environment' => app()->environment(),
        'version' => config('app.version', '1.0.0')
    ]);
});

// Readiness check for load balancers
Route::get('/ready', function () {
    try {
        // Check database connection
        \DB::connection()->getPdo();
        
        return response()->json([
            'status' => 'ready',
            'checks' => [
                'database' => 'ok',
                'cache' => cache()->get('health-check') !== null ? 'ok' : 'warning'
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'not ready',
            'error' => $e->getMessage()
        ], 503);
    }
});