<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\DistributorController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome', ['title' => 'Welcome']);
})->name('home');

Route::get('/mizuki', function () {
    return view('mizuki', ['title' => 'Mizuki']);
})->name('mizuki');

Route::resource('/distributors', DistributorController::class);

// Route to logout and redirect to courier registration
Route::get('/register-courier-logout', [AuthController::class, 'logoutAndRedirectCourier'])->name('register.courier.logout');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Guest Only)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/register-courier', function () {
        return view('auth.register-courier', ['title' => 'Register Courier']);
    })->name('register.courier');
});

/*
|--------------------------------------------------------------------------
| Protected Routes (Authenticated Users Only)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::resource('dashboard', DashboardController::class);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('test', TestController::class);
});
