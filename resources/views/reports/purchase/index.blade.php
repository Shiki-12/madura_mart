@extends('layout.master')

@section('title', 'Purchase Reports')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white pb-0">
                    <h6 class="font-weight-bolder">Purchase Reports</h6>
                    <p class="text-sm text-secondary">Filter purchase transactions by date range to generate report.</p>
                </div>
                <div class="card-body">

                    {{-- FORM FILTER --}}
                    <form action="{{ route('reports.purchase') }}" method="GET" class="row g-3 align-items-end mb-4 border p-3 rounded bg-light">
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
                                <i class="fas fa-filter me-2"></i> Filter Data
                            </button>

                            @if($purchases->count() > 0)
                                <a href="{{ route('reports.purchase.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                                   target="_blank"
                                   class="btn btn-outline-dark w-100 mb-0">
                                    <i class="fas fa-print me-2"></i> Print PDF
                                </a>
                            @endif
                        </div>
                    </form>

                    @if($purchases->count() > 0)
                        {{-- SUMMARY STATS --}}
                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="card border shadow-none">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md me-3">
                                                <i class="fas fa-file-invoice text-white opacity-10 admin-icon-stat"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs text-secondary mb-0 font-weight-bold text-uppercase">Total Notes</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $totalNotes }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="card border shadow-none">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md me-3">
                                                <i class="fas fa-boxes text-white opacity-10 admin-icon-stat"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs text-secondary mb-0 font-weight-bold text-uppercase">Items Procured</p>
                                                <h5 class="font-weight-bolder mb-0">{{ number_format($totalItems) }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="card border shadow-none">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md me-3">
                                                <i class="fas fa-money-bill-wave text-white opacity-10 admin-icon-stat"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs text-secondary mb-0 font-weight-bold text-uppercase">Total Expenditure</p>
                                                <h5 class="font-weight-bolder mb-0">Rp {{ number_format($totalExpenditure, 0, ',', '.') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="card border shadow-none">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md me-3">
                                                <i class="fas fa-calculator text-white opacity-10 admin-icon-stat"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs text-secondary mb-0 font-weight-bold text-uppercase">Avg / Note</p>
                                                <h5 class="font-weight-bolder mb-0">Rp {{ number_format($avgPerNote, 0, ',', '.') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PERIOD INFO --}}
                        <div class="alert alert-light border border-warning d-flex justify-content-between align-items-center text-dark mb-4" role="alert">
                            <div>
                                <span class="font-weight-bold">Period:</span> {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                            </div>
                            <div>
                                <span class="font-weight-bold">Total Expenditure:</span>
                                <span class="text-danger text-lg font-weight-bolder ms-2">Rp {{ number_format($totalExpenditure, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        {{-- TABEL DATA --}}
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0 table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">#</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Note Number</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Distributor</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Items</th>
                                        <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-4">Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchases as $index => $purchase)
                                        <tr>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold ps-3">{{ $index + 1 }}</span>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">{{ $purchase->purchase_date->format('d/m/Y') }}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark text-xs font-weight-bold">{{ $purchase->note_number }}</span>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    @if($purchase->distributor)
                                                        <i class="fas fa-building me-1"></i>{{ $purchase->distributor->name }}
                                                    @else
                                                        <span class="badge bg-secondary text-xxs">General</span>
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info text-xxs">{{ $purchase->details->sum('purchase_amount') }} pcs</span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <span class="text-dark text-sm font-weight-bold">Rp {{ number_format($purchase->total_price, 0, ',', '.') }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- TOP PURCHASED PRODUCTS --}}
                        @if($topProducts->count() > 0)
                            <div class="mt-4">
                                <h6 class="font-weight-bolder text-sm">Top Purchased Products</h6>
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">#</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Product</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qty Purchased</th>
                                                <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-4">Total Spent</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($topProducts as $i => $item)
                                                <tr>
                                                    <td><span class="text-secondary text-xs font-weight-bold ps-3">{{ $i + 1 }}</span></td>
                                                    <td><span class="text-dark text-xs font-weight-bold">{{ $item->product->name ?? 'Unknown' }}</span></td>
                                                    <td class="text-center"><span class="badge bg-gradient-info text-xxs">{{ number_format($item->total_qty) }} pcs</span></td>
                                                    <td class="text-end pe-4"><span class="text-dark text-xs font-weight-bold">Rp {{ number_format($item->total_spent, 0, ',', '.') }}</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-3x text-secondary opacity-5 mb-3"></i>
                            <p class="text-secondary">No purchase data found for this period.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
