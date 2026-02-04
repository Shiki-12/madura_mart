@extends('layout.master')

@section('title', 'Purchase Detail')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
    <div class="container-fluid py-4">
        {{-- Tombol Back --}}
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{ route('purchase.index') }}" class="btn btn-sm btn-outline-secondary mb-0">
                    <i class="fas fa-arrow-left me-2"></i> Back to List
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-white border-bottom p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-secondary text-xs font-weight-bolder mb-1">Invoice Number
                                </h6>
                                <h3 class="text-primary font-weight-bold mb-0">{{ $purchase->note_number }}</h3>
                            </div>
                            <div class="text-end">
                                <h6 class="text-uppercase text-secondary text-xs font-weight-bolder mb-1">Date</h6>
                                <p class="text-dark font-weight-bold mb-0">
                                    {{ $purchase->purchase_date->format('d F Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        {{-- Info Distributor --}}
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <h6 class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 mb-2">From
                                    Distributor:</h6>
                                @if ($purchase->distributor)
                                    <h5 class="text-dark font-weight-bold mb-1">{{ $purchase->distributor->name }}</h5>
                                    <p class="text-sm text-secondary mb-0">
                                        {{ $purchase->distributor->address }}<br>
                                        Tel: {{ $purchase->distributor->phone_number }}
                                    </p>
                                @else
                                    <span class="badge bg-secondary">General Distributor</span>
                                @endif
                            </div>
                            <div class="col-md-6 text-md-end">
                                <h6 class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 mb-2">Total
                                    Amount:</h6>
                                <h2 class="text-success font-weight-bolder">Rp
                                    {{ number_format($purchase->total_price, 0, ',', '.') }}</h2>
                            </div>
                        </div>

                        {{-- Tabel Barang --}}
                        {{-- Tabel Barang (Updated) --}}
                        <div class="table-responsive border-radius-lg bg-light p-3">
                            <h6 class="font-weight-bolder text-dark mb-3 ps-2">Items Purchased</h6>
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                            width="25%">Product Name</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                            width="15%">Buy Price</th>
                                        {{-- KOLOM BARU --}}
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                            width="10%">Margin</th>
                                        <th class="text-center text-uppercase text-success text-xxs font-weight-bolder opacity-7"
                                            width="15%">Est. Sell Price</th>
                                        {{-- END KOLOM BARU --}}
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                            width="10%">Qty</th>
                                        <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-4"
                                            width="15%">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchase->details as $detail)
                                        <tr>
                                            <td>
                                                <p class="text-xs text-secondary mb-0 ps-3">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm font-weight-bold">
                                                            {{ $detail->product ? $detail->product->name : 'Product Deleted' }}
                                                        </h6>
                                                        <p class="text-xs text-secondary mb-0">
                                                            SKU:
                                                            {{ $detail->product ? $detail->product->serial_number : '-' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- Harga Beli --}}
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    Rp {{ number_format($detail->purchase_price, 0, ',', '.') }}
                                                </span>
                                            </td>

                                            {{-- Margin % (Baru) --}}
                                            <td class="align-middle text-center">
                                                <span class="badge bg-gradient-info text-xxs">
                                                    {{ $detail->selling_margin }}%
                                                </span>
                                            </td>

                                            {{-- Est. Harga Jual (Baru - Hitung di View) --}}
                                            <td class="align-middle text-center">
                                                @php
                                                    // Rumus: Beli + (Beli * Margin / 100)
                                                    $marginValue =
                                                        $detail->purchase_price * ($detail->selling_margin / 100);
                                                    $sellPrice = $detail->purchase_price + $marginValue;
                                                @endphp
                                                <span class="text-success text-xs font-weight-bold">
                                                    Rp {{ number_format($sellPrice, 0, ',', '.') }}
                                                </span>
                                            </td>

                                            <td class="align-middle text-center">
                                                <span class="text-dark text-xs font-weight-bold">
                                                    {{ $detail->purchase_amount }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-end pe-4">
                                                <span class="text-dark text-sm font-weight-bold">
                                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="border-top">
                                    <tr>
                                        {{-- Sesuaikan colspan karena kolom bertambah --}}
                                        <td colspan="6" class="text-end pt-3">
                                            <h6 class="mb-0 text-secondary">Grand Total</h6>
                                        </td>
                                        <td class="text-end pt-3 pe-4">
                                            <h5 class="text-primary font-weight-bold">
                                                Rp {{ number_format($purchase->total_price, 0, ',', '.') }}
                                            </h5>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    {{-- Footer Actions --}}
                    <div class="card-footer bg-white text-end">
                        <form action="{{ route('purchase.destroy', $purchase->id) }}" method="POST" class="d-inline"
                            id="delete-form-detail">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDeleteDetail()" class="btn btn-outline-danger mb-0">
                                <i class="fas fa-trash me-1"></i> Delete Invoice
                            </button>
                        </form>
                        <button class="btn bg-gradient-dark mb-0 ms-2" onclick="window.print()">
                            <i class="fas fa-print me-1"></i> Print Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDeleteDetail() {
            Swal.fire({
                title: 'Delete this Invoice?',
                text: "Stock will be reversed (decreased). This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-detail').submit();
                }
            });
        }
    </script>
@endsection
