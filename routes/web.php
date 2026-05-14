<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/health', fn() => response()->json(['ok' => true]));

Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    Artisan::call('config:cache');
    return '✅ Config cache cleared and rebuilt';
});



