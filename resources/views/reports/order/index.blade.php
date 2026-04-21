@extends('layout.master')

@section('title', 'Order Reports')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="row align-items-center mb-4">
        <div class="col-lg-8">
            <h4 class="font-weight-bolder text-dark mb-0">Order Reports</h4>
            <p class="text-secondary text-sm">Comprehensive analytics — revenue, order status, and sales velocity.</p>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <p class="text-sm mb-0 font-weight-bold text-secondary">Total Orders</p>
                            <h5 class="font-weight-bolder mb-0">{{ number_format($totalOrders) }}</h5>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fas fa-shopping-cart text-lg text-white opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <p class="text-sm mb-0 font-weight-bold text-secondary">Total Revenue</p>
                            <h5 class="font-weight-bolder mb-0 text-success">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h5>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                <i class="fas fa-dollar-sign text-lg text-white opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <p class="text-sm mb-0 font-weight-bold text-secondary">Avg Order Value</p>
                            <h5 class="font-weight-bolder mb-0 text-info">Rp {{ number_format($avgOrderValue, 0, ',', '.') }}</h5>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                <i class="fas fa-chart-line text-lg text-white opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <p class="text-sm mb-0 font-weight-bold text-secondary">Completed</p>
                            <h5 class="font-weight-bolder mb-0 text-dark">
                                {{ $statusBreakdown->get('completed')->count ?? 0 }}
                            </h5>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                <i class="fas fa-check-double text-lg text-white opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="card border-0 shadow-lg mb-4">
        <div class="card-body">
            <form action="{{ route('reports.order') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label text-xs font-weight-bold text-uppercase">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-xs font-weight-bold text-uppercase">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn bg-gradient-primary w-100 mb-0">
                        <i class="fas fa-filter me-2"></i> Filter Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Status Breakdown --}}
    <div class="row mb-4">
        @php
            $statuses = [
                'pending'          => ['label' => 'Pending', 'color' => 'secondary', 'icon' => 'fa-clock'],
                'payment_verified' => ['label' => 'Verified', 'color' => 'info', 'icon' => 'fa-check-circle'],
                'processed'        => ['label' => 'Processed', 'color' => 'primary', 'icon' => 'fa-cog'],
                'shipped'          => ['label' => 'Shipped', 'color' => 'info', 'icon' => 'fa-shipping-fast'],
                'arrived'          => ['label' => 'Arrived', 'color' => 'success', 'icon' => 'fa-map-marker-alt'],
                'completed'        => ['label' => 'Completed', 'color' => 'success', 'icon' => 'fa-check-double'],
                'cancelled'        => ['label' => 'Cancelled', 'color' => 'danger', 'icon' => 'fa-times-circle'],
            ];
        @endphp
        @foreach ($statuses as $key => $s)
            <div class="col mb-2">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-2 text-center">
                        <i class="fas {{ $s['icon'] }} text-{{ $s['color'] }} mb-1"></i>
                        <p class="text-xxs font-weight-bold text-secondary mb-0 text-uppercase">{{ $s['label'] }}</p>
                        <h6 class="font-weight-bolder mb-0 text-{{ $s['color'] }}">
                            {{ $statusBreakdown->get($key)->count ?? 0 }}
                        </h6>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        {{-- Sales Velocity Chart --}}
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-lg h-100">
                <div class="card-header bg-white pb-0">
                    <h6 class="font-weight-bolder"><i class="fas fa-chart-area text-primary me-2"></i>Daily Sales Velocity</h6>
                    <p class="text-sm text-secondary">Number of orders and revenue per day.</p>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="velocityChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Top Products --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-lg h-100">
                <div class="card-header bg-white pb-0">
                    <h6 class="font-weight-bolder"><i class="fas fa-trophy text-warning me-2"></i>Top Products</h6>
                    <p class="text-sm text-secondary">Best-selling products in this period.</p>
                </div>
                <div class="card-body p-0">
                    @forelse($topProducts as $index => $item)
                        <div class="d-flex align-items-center px-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="me-3">
                                <span class="badge bg-gradient-{{ $index == 0 ? 'warning' : ($index == 1 ? 'secondary' : 'dark') }} rounded-circle p-2" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">
                                    {{ $index + 1 }}
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="text-sm mb-0">{{ $item->product_name }}</h6>
                                <p class="text-xs text-secondary mb-0">{{ number_format($item->total_qty) }} units sold</p>
                            </div>
                            <div class="text-end">
                                <span class="text-sm font-weight-bold text-success">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-2x text-secondary opacity-5 mb-2"></i>
                            <p class="text-xs text-secondary">No product data</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Payment Method Breakdown --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md me-3">
                        <i class="fas fa-university text-lg opacity-10"></i>
                    </div>
                    <div>
                        <p class="text-xs mb-0 font-weight-bold text-secondary text-uppercase">Transfer Orders</p>
                        <h5 class="font-weight-bolder mb-0">{{ $paymentBreakdown->get('transfer')->count ?? 0 }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md me-3">
                        <i class="fas fa-money-bill-wave text-lg opacity-10"></i>
                    </div>
                    <div>
                        <p class="text-xs mb-0 font-weight-bold text-secondary text-uppercase">COD Orders</p>
                        <h5 class="font-weight-bolder mb-0">{{ $paymentBreakdown->get('cod')->count ?? 0 }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Orders Table --}}
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-white pb-0">
            <h6 class="font-weight-bolder">Order Details</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0 table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Invoice</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Customer</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Courier</th>
                            <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-4">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            @php
                                $sc = [
                                    'pending'          => 'secondary',
                                    'payment_verified' => 'info',
                                    'processed'        => 'primary',
                                    'shipped'          => 'info',
                                    'arrived'          => 'success',
                                    'completed'        => 'success',
                                    'cancelled'        => 'danger',
                                ];
                            @endphp
                            <tr>
                                <td class="ps-3">
                                    <span class="text-xs font-weight-bold text-dark">{{ $order->invoice_number }}</span>
                                </td>
                                <td>
                                    <span class="text-xs font-weight-bold">{{ $order->user->name ?? 'Guest' }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="text-xs text-secondary">{{ $order->order_date }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-sm bg-gradient-{{ $sc[$order->status] ?? 'secondary' }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-sm bg-gradient-{{ $order->payment_method == 'transfer' ? 'info' : 'warning' }}">
                                        {{ strtoupper($order->payment_method) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-xs text-secondary">{{ $order->courier->name ?? '-' }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <span class="text-sm font-weight-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-search fa-3x text-secondary opacity-5 mb-3"></i>
                                    <p class="text-secondary">No orders found for this period.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($orders->hasPages())
            <div class="card-footer border-0 d-flex justify-content-center pt-3 pb-3">
                {{ $orders->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Chart.js for Sales Velocity --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('velocityChart');
    if (ctx) {
        var gradientRevenue = ctx.getContext('2d').createLinearGradient(0, 230, 0, 50);
        gradientRevenue.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
        gradientRevenue.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
        gradientRevenue.addColorStop(0, 'rgba(94, 114, 228, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($dailyOrders->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))) !!},
                datasets: [{
                    label: 'Revenue (Rp)',
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 3,
                    pointBackgroundColor: '#5e72e4',
                    borderColor: '#5e72e4',
                    backgroundColor: gradientRevenue,
                    fill: true,
                    data: {!! json_encode($dailyOrders->pluck('revenue')) !!},
                }, {
                    label: 'Orders',
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 3,
                    pointBackgroundColor: '#2dce89',
                    borderColor: '#2dce89',
                    backgroundColor: 'transparent',
                    fill: false,
                    data: {!! json_encode($dailyOrders->pluck('count')) !!},
                    yAxisID: 'y1',
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true, position: 'top' },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { callback: function(v) { return 'Rp ' + v.toLocaleString('id-ID'); } }
                    },
                    y1: {
                        position: 'right',
                        beginAtZero: true,
                        grid: { drawOnChartArea: false },
                        ticks: { stepSize: 1 }
                    },
                    x: { ticks: { color: '#b2b9bf' } }
                },
            },
        });
    }
});
</script>
@endsection
