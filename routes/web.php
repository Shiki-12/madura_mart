<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| 1. AREA PUBLIK (Bisa diakses siapa saja / Tamu)
|--------------------------------------------------------------------------
*/

// Halaman Utama (Landing Page)
Route::get('/', function () {
    return view('welcome', ['title' => 'Welcome to Madura Mart']);
})->name('root');

// Halaman Mizuki (Info/Profil?)
Route::get('/mizuki', function () {
    return view('mizuki', ['title' => 'Mizuki']);
})->name('mizuki');

// Utility: Logout dulu sebelum register kurir (agar session bersih)
Route::get('/register-courier-logout', [AuthController::class, 'logoutAndRedirectCourier'])->name('register.courier.logout');


/*
|--------------------------------------------------------------------------
| 2. AREA TAMU (GUEST) - Hanya bisa diakses jika BELUM login
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Register (Customer)
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Register (Courier)
    Route::get('/register-courier', function () {
        return view('auth.register-courier', ['title' => 'Register Courier']);
    })->name('register.courier');
});


/*
|--------------------------------------------------------------------------
| 3. AREA LOGIN (AUTHENTICATED) - Semua user yg login bisa akses ini
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Halaman Depan Toko (Khusus Customer/User Umum)
    Route::get('/home', function () {
        return "<h1>Ini Halaman Depan Toko (Storefront)</h1>
                <p>Halo, <b>".auth()->user()->name."</b>! Silakan belanja di sini.</p> 
                <form action='".route('logout')."' method='POST'>".csrf_field()."<button type='submit'>Logout</button></form>";
    })->name('home');
});


/*
|--------------------------------------------------------------------------
| 4. AREA ADMIN & STAFF (Dashboard, Kasir, Gudang)
|--------------------------------------------------------------------------
| Middleware: Login Dulu + Cek Role (Owner, Admin, atau Cashier)
*/
Route::middleware(['auth', 'role:owner,admin,cashier'])->group(function () {
    
    // Dashboard Utama
    Route::resource('dashboard', DashboardController::class);

    // Modul Produk (Master Barang)
    Route::put('/products/{id}/toggle', [ProductController::class, 'toggleStatus'])->name('products.toggle');
    Route::post('/products/check-unique', [ProductController::class, 'checkUnique'])->name('products.check-unique');
    Route::resource('products', ProductController::class);

    // Modul Distributor (Supplier)
    Route::post('/distributors/check-duplicate', [DistributorController::class, 'checkDuplicate'])->name('distributors.check-duplicate');
    Route::post('/distributors/check-unique', [DistributorController::class, 'checkUnique'])->name('distributors.check-unique');
    Route::resource('distributors', DistributorController::class);

    // Modul Purchase (Kulakan Barang Masuk)
    Route::post('/purchase/check-unique', [PurchaseController::class, 'checkUniqueNoteNumber'])->name('purchase.check-unique');
    Route::resource('purchase', PurchaseController::class);

    // Modul Sales (Kasir Barang Keluar)
    Route::resource('sales', SalesController::class);

    // Modul Laporan (Reports)
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/sale', [ReportController::class, 'saleReport'])->name('sale');
        Route::get('/sale/print', [ReportController::class, 'printSaleReport'])->name('sale.print');
    });

    // Test Controller (Jika masih dipakai)
    Route::resource('test', TestController::class);
});


/*
|--------------------------------------------------------------------------
| 5. AREA KHUSUS OWNER (Super Admin)
|--------------------------------------------------------------------------
| Hanya Owner yang boleh kelola Users (Tambah Kasir/Admin/Pecat Pegawai)
*/
Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::resource('users', UserController::class);
});