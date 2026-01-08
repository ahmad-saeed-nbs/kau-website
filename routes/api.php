<?php

use App\Models\Faculty;
use Illuminate\Support\Facades\Route;

Route::get('/faculties', function () {
    return Faculty::all();
});

Route::get('/faculties/{lang}', function ($lang) {
    return Faculty::where('language', $lang)->get();
});
