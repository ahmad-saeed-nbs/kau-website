<?php

use App\Http\Controllers\FacultyController;
use Illuminate\Support\Facades\Route;

Route::prefix('faculty')->name('faculty.')->group(function () {

    Route::get('/', [FacultyController::class, 'index'])
        ->name('index');

    Route::get('{lang}/{faculty}', [FacultyController::class, 'profile'])
        ->name('profile');

});
