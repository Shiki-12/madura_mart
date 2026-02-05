@extends('layout.master')

@section('title', 'Sale Reports')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white pb-0">
                    <h6 class="font-weight-bolder">Sale Reports</h6>
                    <p class="text-sm text-secondary">Filter transactions by date range to generate report.</p>
                </div>
                <div class="card-body">
                    
                    {{-- FORM FILTER --}}
                    <form action="{{ route('reports.sale') }}" method="GET" class="row g-3 align-items-end mb-4 border p-3 rounded bg-light">
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
                            
                            {{-- Tombol Print (Membuka Tab Baru) --}}
                            @if($sales->count() > 0)
                                <a href="{{ route('reports.sale.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}" 
                                   target="_blank" 
                                   class="btn btn-outline-dark w-100 mb-0">
                                    <i class="fas fa-print me-2"></i> Print PDF
                                </a>
                            @endif
                        </div>
                    </form>

                    {{-- RINGKASAN --}}
                    @if($sales->count() > 0)
                        <div class="alert alert-light border border-success d-flex justify-content-between align-items-center text-dark mb-4" role="alert">
                            <div>
                                <span class="font-weight-bold">Period:</span> {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                            </div>
                            <div>
                                <span class="font-weight-bold">Total Revenue:</span> 
                                <span class="text-success text-lg font-weight-bolder ms-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        {{-- TABEL DATA --}}
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0 table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Receipt No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Cashier</th>
                                        <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-4">Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $sale)
                                        <tr>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold ps-3">{{ $sale->sale_date->format('d/m/Y') }}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark text-xs font-weight-bold">TRX-{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</span>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">{{ $sale->user->name ?? 'Unknown' }}</span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <span class="text-dark text-sm font-weight-bold">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-3x text-secondary opacity-5 mb-3"></i>
                            <p class="text-secondary">No transaction data found for this period.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection