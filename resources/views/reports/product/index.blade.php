@extends('layout.master')

@section('title', 'Product Reports')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="row align-items-center mb-4">
        <div class="col-lg-8">
            <h4 class="font-weight-bolder text-dark mb-0">Product Reports</h4>
            <p class="text-secondary text-sm">Inventory health dashboard — stock levels, movement, and expiry tracking.</p>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-xl-2 col-sm-4 mb-xl-0 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <p class="text-xs mb-0 font-weight-bold text-secondary text-uppercase">Total SKUs</p>
                    <h5 class="font-weight-bolder mb-0">{{ $totalSKUs }}</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-4 mb-xl-0 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <p class="text-xs mb-0 font-weight-bold text-secondary text-uppercase">Stock Value</p>
                    <h5 class="font-weight-bolder mb-0 text-primary admin-stat-sm">Rp {{ number_format($totalStockValue, 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-4 mb-xl-0 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <p class="text-xs mb-0 font-weight-bold text-secondary text-uppercase">Out of Stock</p>
                    <h5 class="font-weight-bolder mb-0 text-danger">{{ $outOfStock }}</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-4 mb-xl-0 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <p class="text-xs mb-0 font-weight-bold text-secondary text-uppercase">Critical Stock</p>
                    <h5 class="font-weight-bolder mb-0 text-warning">{{ $lowStockCount }}</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-4 mb-xl-0 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <p class="text-xs mb-0 font-weight-bold text-secondary text-uppercase">Expiring Soon</p>
                    <h5 class="font-weight-bolder mb-0 text-info">{{ $expiringSoon }}</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <p class="text-xs mb-0 font-weight-bold text-secondary text-uppercase">Expired</p>
                    <h5 class="font-weight-bolder mb-0 text-danger">{{ $expired }}</h5>
                </div>
            </div>
        </div>
    </div>

    {{-- Stock Movement (Last 30 days) --}}
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm border-start border-success border-3">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md me-3">
                        <i class="fas fa-arrow-down text-lg opacity-10"></i>
                    </div>
                    <div>
                        <p class="text-xs mb-0 font-weight-bold text-secondary">Stock In (Last 30 Days)</p>
                        <h5 class="font-weight-bolder mb-0 text-success">+{{ number_format($stockIn) }} units</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm border-start border-danger border-3">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md me-3">
                        <i class="fas fa-arrow-up text-lg opacity-10"></i>
                    </div>
                    <div>
                        <p class="text-xs mb-0 font-weight-bold text-secondary">Stock Out (Last 30 Days)</p>
                        <h5 class="font-weight-bolder mb-0 text-danger">-{{ number_format($stockOut) }} units</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Product Table --}}
    <div class="card border-0 shadow-lg">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h6 class="font-weight-bolder">Stock Level Overview</h6>
                <div class="d-flex gap-2 flex-wrap">
                    {{-- Stock Filter --}}
                    @php
                        $filters = [
                            'all'      => ['label' => 'All', 'color' => 'primary'],
                            'out'      => ['label' => 'Out of Stock', 'color' => 'danger'],
                            'critical' => ['label' => 'Critical (≤5)', 'color' => 'warning'],
                            'low'      => ['label' => 'Low (≤15)', 'color' => 'info'],
                            'healthy'  => ['label' => 'Healthy (>15)', 'color' => 'success'],
                        ];
                    @endphp
                    @foreach ($filters as $key => $f)
                        <a href="{{ route('reports.product', array_merge(request()->all(), ['stock_filter' => $key])) }}"
                            class="btn btn-sm {{ $stockFilter == $key ? 'bg-gradient-' . $f['color'] . ' text-white' : 'btn-outline-secondary' }} mb-0">
                            {{ $f['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
            {{-- Search --}}
            <form action="{{ route('reports.product') }}" method="GET" class="mt-3">
                <input type="hidden" name="stock_filter" value="{{ $stockFilter }}">
                <div class="input-group admin-search-sm">
                    <span class="input-group-text border-end-0"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0"
                        placeholder="Search product name or serial..." value="{{ $search }}">
                </div>
            </form>
        </div>
        <div class="card-body px-0 pt-3 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0 table-hover admin-table">
                    <thead class="admin-table-head">
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Product</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Serial</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Distributor</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stock</th>
                            <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                            <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stock Value</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-3">Expiry</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            @php
                                if ($product->stock == 0) {
                                    $stockStatus = ['label' => 'Out', 'color' => 'danger'];
                                } elseif ($product->stock <= 5) {
                                    $stockStatus = ['label' => 'Critical', 'color' => 'warning'];
                                } elseif ($product->stock <= 15) {
                                    $stockStatus = ['label' => 'Low', 'color' => 'info'];
                                } else {
                                    $stockStatus = ['label' => 'Healthy', 'color' => 'success'];
                                }

                                $isExpired = $product->expiration_date && $product->expiration_date->isPast();
                                $isExpiringSoon = $product->expiration_date && !$isExpired && $product->expiration_date->diffInDays(now()) <= 30;
                            @endphp
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center">
                                        @if ($product->picture)
                                            <img src="{{ asset('storage/' . $product->picture) }}" class="avatar me-2 rounded shadow-sm admin-report-thumb">
                                        @else
                                            <div class="avatar me-2 bg-gradient-secondary rounded shadow-sm d-flex align-items-center justify-content-center admin-report-thumb-placeholder">
                                                <i class="fas fa-box text-white text-xs"></i>
                                            </div>
                                        @endif
                                        <span class="text-sm font-weight-bold">{{ $product->name }}</span>
                                    </div>
                                </td>
                                <td><span class="text-xs text-dark font-weight-bold">{{ $product->serial_number }}</span></td>
                                <td><span class="text-xs text-secondary">{{ $product->distributor->name ?? '-' }}</span></td>
                                <td class="text-center">
                                    <span class="font-weight-bolder text-{{ $stockStatus['color'] }}">{{ $product->stock }}</span>
                                </td>
                                <td class="text-end"><span class="text-xs">Rp {{ number_format($product->price, 0, ',', '.') }}</span></td>
                                <td class="text-end"><span class="text-xs font-weight-bold">Rp {{ number_format($product->price * $product->stock, 0, ',', '.') }}</span></td>
                                <td class="text-center">
                                    <span class="badge badge-sm bg-gradient-{{ $stockStatus['color'] }}">{{ $stockStatus['label'] }}</span>
                                </td>
                                <td class="text-center pe-3">
                                    @if ($product->expiration_date)
                                        <span class="text-xs {{ $isExpired ? 'text-danger font-weight-bolder' : ($isExpiringSoon ? 'text-warning font-weight-bold' : 'text-secondary') }}">
                                            {{ $product->expiration_date->format('d M Y') }}
                                            @if ($isExpired)
                                                <br><span class="badge badge-sm bg-gradient-danger">EXPIRED</span>
                                            @elseif ($isExpiringSoon)
                                                <br><span class="badge badge-sm bg-gradient-warning">SOON</span>
                                            @endif
                                        </span>
                                    @else
                                        <span class="text-xs text-secondary">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="fas fa-box-open fa-3x text-secondary opacity-5 mb-3"></i>
                                    <h6 class="text-secondary">No products found</h6>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($products->hasPages())
            <div class="card-footer border-0 d-flex justify-content-center pt-3 pb-3">
                {{ $products->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
