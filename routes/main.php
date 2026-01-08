<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainSiteController;

Route::get('/', [MainSiteController::class, 'home']);

Route::prefix('{lang}')
    ->where(['lang' => 'en|ar'])
    ->group(function () {
        Route::get('/', [MainSiteController::class, 'home']);
        Route::get('/about', [MainSiteController::class, 'about']);
    });
