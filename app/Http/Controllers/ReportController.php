<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Carbon\Carbon;

class ReportController extends Controller
{
    // Halaman Laporan Penjualan
    public function saleReport(Request $request)
    {
        // Default tanggal: Hari ini
        $startDate = $request->input('start_date', Carbon::now()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Query Penjualan berdasarkan rentang tanggal
        $sales = Sale::with('user')
            ->whereDate('sale_date', '>=', $startDate)
            ->whereDate('sale_date', '<=', $endDate)
            ->latest()
            ->get();

        // Hitung Total Omzet di periode tersebut
        $totalRevenue = $sales->sum('total_price');

        return view('reports.sale.index', [
            'title' => 'Sale Reports',
            'sales' => $sales,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalRevenue' => $totalRevenue
        ]);
    }

    // Halaman Cetak Laporan (Print View)
    public function printSaleReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Validasi simpel
        if (!$startDate || !$endDate) {
            return redirect()->back()->with('error', 'Please select date range first.');
        }

        $sales = Sale::with('user')
            ->whereDate('sale_date', '>=', $startDate)
            ->whereDate('sale_date', '<=', $endDate)
            ->oldest() // Urutkan dari yang terlama (kronologis)
            ->get();

        $totalRevenue = $sales->sum('total_price');

        return view('reports.sale.print', [
            'sales' => $sales,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalRevenue' => $totalRevenue
        ]);
    }
}