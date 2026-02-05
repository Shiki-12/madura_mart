<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome', ['title' => 'Welcome']);
})->name('home');

Route::get('/mizuki', function () {
    return view('mizuki', ['title' => 'Mizuki']);
})->name('mizuki');

Route::get('/register-courier-logout', [AuthController::class, 'logoutAndRedirectCourier'])->name('register.courier.logout');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/register-courier', function () {
        return view('auth.register-courier', ['title' => 'Register Courier']);
    })->name('register.courier');
});

Route::middleware('auth')->group(function () {
    Route::resource('dashboard', DashboardController::class);
    Route::resource('test', TestController::class);
    Route::resource('distributors', DistributorController::class);
    Route::resource('purchase', PurchaseController::class);
    Route::resource('sales', SalesController::class);
    Route::post('/purchase/check-unique', [App\Http\Controllers\PurchaseController::class, 'checkUniqueNoteNumber'])->name('purchase.check-unique');
    Route::post('/distributors/check-duplicate', [DistributorController::class, 'checkDuplicate'])->name('distributors.check-duplicate');
    Route::post('/distributors/check-unique', [DistributorController::class, 'checkUnique'])->name('distributors.check-unique');
    Route::put('/products/{id}/toggle', [ProductController::class, 'toggleStatus'])->name('products.toggle');
    Route::post('/products/check-unique', [App\Http\Controllers\ProductController::class, 'checkUnique'])->name('products.check-unique');
    Route::resource('products', ProductController::class);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/sale', [ReportController::class, 'saleReport'])->name('sale');
    Route::get('/sale/print', [ReportController::class, 'printSaleReport'])->name('sale.print');
}); 

Route::get('/home', function () {
    return "<h1>Ini Halaman Depan Toko (Storefront)</h1><p>Customer belanja di sini.</p> <form action='".route('logout')."' method='POST'>".csrf_field()."<button type='submit'>Logout</button></form>";
})->name('home');

Route::get('/', function() {
    return redirect()->route('home');
});