<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/test', function () {
//     return view('test');
// });

Route::get('/mizuki', function () {
    return view('mizuki');
});

Route::resource('dashboard', App\Http\Controllers\DashboardController::class);
Route::resource('test', App\Http\Controllers\TestController::class);