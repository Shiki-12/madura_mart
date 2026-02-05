@extends('layout.master')

@section('title', 'Receipt Details')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
<div class="container-fluid py-4">
    {{-- Tombol Kembali --}}
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-secondary mb-0">
                <i class="fas fa-arrow-left me-2"></i> Back to History
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        {{-- Kolom dibuat lebih sempit (col-lg-5) agar mirip struk fisik --}}
        <div class="col-lg-5 col-md-8">
            <div class="card border-0 shadow-lg" id="print-area">
                <div class="card-header bg-white text-center pt-4 pb-0 border-0">
                    <div class="mb-3">
                        {{-- Icon Toko --}}
                        <div class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-lg mx-auto mb-3">
                            <i class="fas fa-shopping-bag opacity-10" style="font-size: 1.5rem; line-height: 50px;"></i>
                        </div>
                        <h4 class="font-weight-bolder text-dark mb-0">MADURA MART</h4>
                        <p class="text-xs text-secondary mb-0">Jalan Raya Telang No. 123, Bangkalan</p>
                        <p class="text-xs text-secondary">Telp: 0812-3456-7890</p>
                    </div>
                    
                    {{-- Garis Putus-putus ala Struk --}}
                    <div style="border-bottom: 2px dashed #ddd;" class="my-3"></div>
                </div>

                <div class="card-body pt-0">
                    {{-- Informasi Transaksi --}}
                    <div class="row mb-3 text-sm">
                        <div class="col-6 text-start">
                            <span class="text-secondary d-block text-xxs font-weight-bold text-uppercase">Receipt No</span>
                            <span class="text-dark font-weight-bold">TRX-{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="col-6 text-end">
                            <span class="text-secondary d-block text-xxs font-weight-bold text-uppercase">Date</span>
                            <span class="text-dark font-weight-bold">{{ $sale->sale_date->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    <div class="row mb-4 text-sm">
                        <div class="col-12 text-start">
                            <span class="text-secondary d-block text-xxs font-weight-bold text-uppercase">Cashier</span>
                            <span class="text-dark font-weight-bold">{{ $sale->user->name ?? 'Unknown Staff' }}</span>
                        </div>
                    </div>

                    {{-- Tabel Barang (Simpel) --}}
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Item</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qty</th>
                                    <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-2">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->details as $detail)
                                    <tr>
                                        <td class="ps-2">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm font-weight-bold text-truncate" style="max-width: 140px;">
                                                    {{ $detail->product->name ?? 'Item Deleted' }}
                                                </h6>
                                                <p class="text-xxs text-secondary mb-0">
                                                    @ Rp {{ number_format($detail->selling_price, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="font-weight-bold text-dark">{{ $detail->quantity }}</span>
                                        </td>
                                        <td class="align-middle text-end pe-2">
                                            <span class="font-weight-bold text-dark text-sm">
                                                {{ number_format($detail->subtotal, 0, ',', '.') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Garis Putus-putus --}}
                    <div style="border-bottom: 2px dashed #ddd;" class="my-3"></div>

                    {{-- Total Section --}}
                    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
                        <h6 class="text-secondary text-sm mb-0">Grand Total</h6>
                        <h3 class="text-success font-weight-bolder mb-0">
                            Rp {{ number_format($sale->total_price, 0, ',', '.') }}
                        </h3>
                    </div>
                    
                    <div class="text-center mt-5">
                        <p class="text-xs text-secondary mb-1 fw-bold">TERIMA KASIH ATAS KUNJUNGAN ANDA</p>
                        <p class="text-xxs text-secondary">Barang yang sudah dibeli tidak dapat ditukar/dikembalikan</p>
                        {{-- Barcode (Hiasan Visual) --}}
                        <div class="mt-3 opacity-6">
                            <i class="fas fa-barcode fa-3x"></i>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white text-center pt-0 border-0 pb-4">
                     {{-- Tombol Print --}}
                     <button onclick="window.print()" class="btn bg-gradient-dark w-100 mb-2">
                        <i class="fas fa-print me-2"></i> Print Receipt
                    </button>
                    
                    {{-- Tombol Void (Khusus Kasus Salah Input) --}}
                     <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline" id="void-form-detail">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmVoidDetail()" class="btn btn-outline-danger w-100 mb-0">
                            <i class="fas fa-ban me-2"></i> Void Transaction
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CSS KHUSUS PRINT (FIXED) --}}
<style>
    @media print {
        /* 1. Sembunyikan SEMUA elemen di body */
        body * {
            visibility: hidden;
        }

        /* 2. Tampilkan HANYA #print-area dan isinya */
        #print-area, #print-area * {
            visibility: visible;
        }

        /* 3. Atur posisi Struk agar menempel di pojok kiri atas kertas */
        #print-area {
            position: fixed; /* Pakai fixed agar lepas dari container induk */
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 20px;
            background-color: white; /* Pastikan background putih */
            z-index: 9999; /* Pastikan dia di layer paling atas */
            box-shadow: none !important; /* Hilangkan bayangan card */
            border: none !important; /* Hilangkan border card */
        }

        /* 4. Sembunyikan elemen interface yang mengganggu */
        .navbar, .sidenav, .btn, .card-footer, footer, .fixed-plugin {
            display: none !important;
        }
    }
</style>

{{-- SCRIPT CONFIRM VOID --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmVoidDetail() {
        Swal.fire({
            title: 'Void Transaction?',
            text: "Stock will be returned (refunded) to inventory. Use this only for errors!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#8392AB',
            confirmButtonText: 'Yes, Void & Refund',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('void-form-detail').submit();
            }
        });
    }
</script>
@endsection