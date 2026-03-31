<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Order;
use App\Models\Product;
use App\Models\Distributor;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // ================================================================
    // SALE REPORTS (existing)
    // ================================================================

    public function saleReport(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $sales = Sale::with('user')
            ->whereDate('sale_date', '>=', $startDate)
            ->whereDate('sale_date', '<=', $endDate)
            ->latest()
            ->get();

        $totalRevenue = $sales->sum('total_price');

        return view('reports.sale.index', [
            'title'        => 'Sale Reports',
            'sales'        => $sales,
            'startDate'    => $startDate,
            'endDate'      => $endDate,
            'totalRevenue' => $totalRevenue,
        ]);
    }

    public function printSaleReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if (!$startDate || !$endDate) {
            return redirect()->back()->with('error', 'Please select date range first.');
        }

        $sales = Sale::with('user')
            ->whereDate('sale_date', '>=', $startDate)
            ->whereDate('sale_date', '<=', $endDate)
            ->oldest()
            ->get();

        $totalRevenue = $sales->sum('total_price');

        return view('reports.sale.print', [
            'sales'        => $sales,
            'startDate'    => $startDate,
            'endDate'      => $endDate,
            'totalRevenue' => $totalRevenue,
        ]);
    }

    // ================================================================
    // DISTRIBUTOR REPORTS
    // ================================================================

    public function distributorReport(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Distributors with aggregated purchase data
        $distributors = Distributor::withCount(['purchases' => function ($q) use ($startDate, $endDate) {
            $q->whereDate('purchase_date', '>=', $startDate)
              ->whereDate('purchase_date', '<=', $endDate);
        }])
        ->withSum(['purchases' => function ($q) use ($startDate, $endDate) {
            $q->whereDate('purchase_date', '>=', $startDate)
              ->whereDate('purchase_date', '<=', $endDate);
        }], 'total_price')
        ->get();

        // Summary stats
        $totalDistributors = Distributor::count();

        $purchaseQuery = Purchase::whereDate('purchase_date', '>=', $startDate)
            ->whereDate('purchase_date', '<=', $endDate);

        $totalPurchaseValue = (clone $purchaseQuery)->sum('total_price');
        $totalPurchases = (clone $purchaseQuery)->count();

        $totalItemsProcured = PurchaseDetail::whereHas('purchase', function ($q) use ($startDate, $endDate) {
            $q->whereDate('purchase_date', '>=', $startDate)
              ->whereDate('purchase_date', '<=', $endDate);
        })->sum('purchase_amount');

        $avgPerDistributor = $totalDistributors > 0 ? round($totalPurchaseValue / max($distributors->where('purchases_count', '>', 0)->count(), 1)) : 0;

        // Top purchased products in period
        $topProducts = PurchaseDetail::select('product_id', DB::raw('SUM(purchase_amount) as total_qty'), DB::raw('SUM(subtotal) as total_spent'))
            ->whereHas('purchase', function ($q) use ($startDate, $endDate) {
                $q->whereDate('purchase_date', '>=', $startDate)
                  ->whereDate('purchase_date', '<=', $endDate);
            })
            ->groupBy('product_id')
            ->with('product')
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();

        return view('reports.distributor.index', [
            'title'              => 'Distributor Reports',
            'distributors'       => $distributors,
            'startDate'          => $startDate,
            'endDate'            => $endDate,
            'totalDistributors'  => $totalDistributors,
            'totalPurchaseValue' => $totalPurchaseValue,
            'totalPurchases'     => $totalPurchases,
            'totalItemsProcured' => $totalItemsProcured,
            'avgPerDistributor'  => $avgPerDistributor,
            'topProducts'        => $topProducts,
        ]);
    }

    public function printDistributorReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if (!$startDate || !$endDate) {
            return redirect()->back()->with('error', 'Please select date range first.');
        }

        $distributors = Distributor::withCount(['purchases' => function ($q) use ($startDate, $endDate) {
            $q->whereDate('purchase_date', '>=', $startDate)
              ->whereDate('purchase_date', '<=', $endDate);
        }])
        ->withSum(['purchases' => function ($q) use ($startDate, $endDate) {
            $q->whereDate('purchase_date', '>=', $startDate)
              ->whereDate('purchase_date', '<=', $endDate);
        }], 'total_price')
        ->get();

        $totalPurchaseValue = Purchase::whereDate('purchase_date', '>=', $startDate)
            ->whereDate('purchase_date', '<=', $endDate)
            ->sum('total_price');

        return view('reports.distributor.print', [
            'distributors'       => $distributors,
            'startDate'          => $startDate,
            'endDate'            => $endDate,
            'totalPurchaseValue' => $totalPurchaseValue,
        ]);
    }

    // ================================================================
    // PRODUCT REPORTS
    // ================================================================

    public function productReport(Request $request)
    {
        $search = $request->input('search');
        $stockFilter = $request->input('stock_filter', 'all');

        // Base query
        $query = Product::with('distributor');

        // Search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%");
            });
        }

        // Stock filter
        switch ($stockFilter) {
            case 'out':
                $query->where('stock', 0);
                break;
            case 'critical':
                $query->where('stock', '>', 0)->where('stock', '<=', 5);
                break;
            case 'low':
                $query->where('stock', '>', 5)->where('stock', '<=', 15);
                break;
            case 'healthy':
                $query->where('stock', '>', 15);
                break;
        }

        $products = $query->orderBy('stock', 'asc')->paginate(15);

        // Summary stats
        $totalSKUs = Product::count();
        $totalStockValue = Product::selectRaw('SUM(price * stock) as total')->value('total') ?? 0;
        $outOfStock = Product::where('stock', 0)->count();
        $lowStockCount = Product::where('stock', '>', 0)->where('stock', '<=', 5)->count();
        $expiringSoon = Product::whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<=', Carbon::now()->addDays(30))
            ->whereDate('expiration_date', '>=', Carbon::now())
            ->count();
        $expired = Product::whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<', Carbon::now())
            ->count();

        // Stock movement (purchases in & sales out) - last 30 days
        $thirtyDaysAgo = Carbon::now()->subDays(30)->format('Y-m-d');
        $stockIn = PurchaseDetail::whereHas('purchase', function ($q) use ($thirtyDaysAgo) {
            $q->whereDate('purchase_date', '>=', $thirtyDaysAgo);
        })->sum('purchase_amount');

        $stockOut = DB::table('sale_details')
            ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
            ->whereDate('sales.sale_date', '>=', $thirtyDaysAgo)
            ->sum('sale_details.quantity');

        return view('reports.product.index', [
            'title'           => 'Product Reports',
            'products'        => $products,
            'totalSKUs'       => $totalSKUs,
            'totalStockValue' => $totalStockValue,
            'outOfStock'      => $outOfStock,
            'lowStockCount'   => $lowStockCount,
            'expiringSoon'    => $expiringSoon,
            'expired'         => $expired,
            'stockIn'         => $stockIn,
            'stockOut'        => $stockOut,
            'search'          => $search,
            'stockFilter'     => $stockFilter,
        ]);
    }

    // ================================================================
    // ORDER REPORTS
    // ================================================================

    public function orderReport(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Orders in date range
        $orders = Order::with(['user', 'courier'])
            ->whereDate('order_date', '>=', $startDate)
            ->whereDate('order_date', '<=', $endDate)
            ->latest()
            ->paginate(15);

        // All orders in range (for stats)
        $allOrdersQuery = Order::whereDate('order_date', '>=', $startDate)
            ->whereDate('order_date', '<=', $endDate);

        $totalOrders = (clone $allOrdersQuery)->count();
        $totalRevenue = (clone $allOrdersQuery)->sum('total_price');
        $avgOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders) : 0;

        // Status breakdown
        $statusBreakdown = Order::whereDate('order_date', '>=', $startDate)
            ->whereDate('order_date', '<=', $endDate)
            ->select('status', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_price) as total'))
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        // Top products by orders
        $topProducts = OrderItem::select('product_id', 'product_name', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_revenue'))
            ->whereHas('order', function ($q) use ($startDate, $endDate) {
                $q->whereDate('order_date', '>=', $startDate)
                  ->whereDate('order_date', '<=', $endDate);
            })
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        // Daily sales velocity (for chart)
        $dailyOrders = Order::whereDate('order_date', '>=', $startDate)
            ->whereDate('order_date', '<=', $endDate)
            ->select(DB::raw('DATE(order_date) as date'), DB::raw('COUNT(*) as count'), DB::raw('SUM(total_price) as revenue'))
            ->groupBy(DB::raw('DATE(order_date)'))
            ->orderBy('date')
            ->get();

        // Payment method breakdown
        $paymentBreakdown = Order::whereDate('order_date', '>=', $startDate)
            ->whereDate('order_date', '<=', $endDate)
            ->select('payment_method', DB::raw('COUNT(*) as count'))
            ->groupBy('payment_method')
            ->get()
            ->keyBy('payment_method');

        return view('reports.order.index', [
            'title'            => 'Order Reports',
            'orders'           => $orders,
            'startDate'        => $startDate,
            'endDate'          => $endDate,
            'totalOrders'      => $totalOrders,
            'totalRevenue'     => $totalRevenue,
            'avgOrderValue'    => $avgOrderValue,
            'statusBreakdown'  => $statusBreakdown,
            'topProducts'      => $topProducts,
            'dailyOrders'      => $dailyOrders,
            'paymentBreakdown' => $paymentBreakdown,
        ]);
    }
}