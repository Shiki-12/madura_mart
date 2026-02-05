<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // 1. Hitung Omzet Hari Ini (Sales)
        $todaySales = Sale::whereDate('sale_date', $today)->sum('total_price');

        // 2. Hitung Pengeluaran Hari Ini (Purchases)
        $todayPurchases = Purchase::whereDate('purchase_date', $today)->sum('total_price');

        // 3. Hitung Profit Kasar Hari Ini (Masuk - Keluar)
        $todayProfit = $todaySales - $todayPurchases;

        // 4. Hitung Total Produk & Stok Menipis (Kurang dari 5)
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock', '<=', 5)
                                   ->orderBy('stock', 'asc')
                                   ->limit(5) // Ambil 5 teratas
                                   ->get();
    
        $recentSales = Sale::with('user')
                            ->latest()
                            ->limit(5)
                            ->get();

        return view('dashboard.index', [
            'title'             => 'Dashboard',
            'todaySales'        => $todaySales,
            'todayPurchases'    => $todayPurchases,
            'todayProfit'       => $todayProfit,
            'totalProducts'     => $totalProducts,
            'lowStockProducts'  => $lowStockProducts,
            'recentSales'       => $recentSales
        ]);
    }
}