<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/', function () {
    // 'welcome' mengacu ke resources/views/welcome.blade.php
    // 'title' => 'Dashboard' INI PENTING! (Lihat Peringatan di bawah)
    return view('welcome', ['title' => 'Dashboard']);
});

Route::get('/mizuki', function () {
    return view('mizuki');
});

Route::resource('dashboard', App\Http\Controllers\DashboardController::class);
Route::resource('test', App\Http\Controllers\TestController::class);
