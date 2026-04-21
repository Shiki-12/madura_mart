@extends('layout.master')

@section('title', 'Distributor Reports')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="row align-items-center mb-4">
        <div class="col-lg-8">
            <h4 class="font-weight-bolder text-dark mb-0">Distributor Reports</h4>
            <p class="text-secondary text-sm">Procurement analytics — purchases from distributors over time.</p>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <p class="text-sm mb-0 font-weight-bold text-secondary">Total Distributors</p>
                            <h5 class="font-weight-bolder mb-0">{{ $totalDistributors }}</h5>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fas fa-warehouse text-lg opacity-10"></i>
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
                            <p class="text-sm mb-0 font-weight-bold text-secondary">Total Purchase Value</p>
                            <h5 class="font-weight-bolder mb-0 text-danger">Rp {{ number_format($totalPurchaseValue, 0, ',', '.') }}</h5>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                                <i class="fas fa-money-bill-wave text-lg opacity-10"></i>
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
                            <p class="text-sm mb-0 font-weight-bold text-secondary">Avg per Distributor</p>
                            <h5 class="font-weight-bolder mb-0 text-info">Rp {{ number_format($avgPerDistributor, 0, ',', '.') }}</h5>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                <i class="fas fa-chart-bar text-lg opacity-10"></i>
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
                            <p class="text-sm mb-0 font-weight-bold text-secondary">Items Procured</p>
                            <h5 class="font-weight-bolder mb-0 text-success">{{ number_format($totalItemsProcured) }}</h5>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                <i class="fas fa-cubes text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="card border-0 shadow-lg mb-4">
        <div class="card-header bg-white pb-0">
            <h6 class="font-weight-bolder">Distributor Procurement Overview</h6>
        </div>
        <div class="card-body">

            {{-- Date Filter --}}
            <form action="{{ route('reports.distributor') }}" method="GET" class="row g-3 align-items-end mb-4 border p-3 rounded bg-light">
                <div class="col-md-4">
                    <label class="form-label text-xs font-weight-bold text-uppercase">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-xs font-weight-bold text-uppercase">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}" required>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn bg-gradient-primary w-100 mb-0">
                        <i class="fas fa-filter me-2"></i> Filter
                    </button>
                    @if($distributors->where('purchases_count', '>', 0)->count() > 0)
                        <a href="{{ route('reports.distributor.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                           target="_blank" class="btn btn-outline-dark w-100 mb-0">
                            <i class="fas fa-print me-2"></i> Print
                        </a>
                    @endif
                </div>
            </form>

            {{-- Period Info --}}
            <div class="alert alert-light border d-flex justify-content-between align-items-center text-dark mb-4">
                <span><strong>Period:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</span>
                <span><strong>Total Purchases:</strong> {{ $totalPurchases }} transactions</span>
            </div>

            {{-- Distributor Table --}}
            <div class="table-responsive">
                <table class="table align-items-center mb-0 table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Distributor</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Purchases</th>
                            <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-4">Total Spent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($distributors->sortByDesc('purchases_sum_total_price') as $dist)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center px-3">
                                        <div class="avatar me-3 bg-gradient-primary rounded shadow-sm d-flex align-items-center justify-content-center"
                                            style="width: 36px; height: 36px;">
                                            <i class="fas fa-building text-white text-xs"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-sm">{{ $dist->name }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $dist->phone_number }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-sm bg-gradient-{{ $dist->purchases_count > 0 ? 'info' : 'secondary' }}">
                                        {{ $dist->purchases_count }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <span class="text-sm font-weight-bold {{ $dist->purchases_sum_total_price > 0 ? 'text-dark' : 'text-secondary' }}">
                                        Rp {{ number_format($dist->purchases_sum_total_price ?? 0, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <i class="fas fa-warehouse fa-3x text-secondary opacity-5 mb-3"></i>
                                    <p class="text-secondary">No distributors registered.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Top Purchased Products --}}
    @if($topProducts->count() > 0)
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-white pb-0">
            <h6 class="font-weight-bolder"><i class="fas fa-trophy text-warning me-2"></i>Top Procured Products</h6>
            <p class="text-sm text-secondary">Most purchased products from distributors in this period.</p>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">#</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Qty</th>
                            <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-4">Total Spent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topProducts as $index => $item)
                            <tr>
                                <td class="ps-4"><span class="text-xs font-weight-bold">{{ $index + 1 }}</span></td>
                                <td>
                                    <span class="text-sm font-weight-bold">{{ $item->product->name ?? 'Deleted Product' }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-sm bg-gradient-success">{{ number_format($item->total_qty) }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <span class="text-sm font-weight-bold">Rp {{ number_format($item->total_spent, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
