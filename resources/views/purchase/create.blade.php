@extends('layout.master')

@section('title', 'New Purchase')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header pb-0 bg-white">
                        <h6 class="font-weight-bolder text-primary">Create New Purchase</h6>
                        <p class="text-xs text-muted">Record incoming goods from distributors.</p>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('purchase.store') }}" method="POST" id="purchase-form">
                            @csrf

                            {{-- BAGIAN 1: HEADER NOTA --}}
                            <div class="row mb-4">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Note Number (No. Nota)</label>
                                    <input type="text" class="form-control @error('note_number') is-invalid @enderror"
                                        name="note_number" value="{{ old('note_number') }}" placeholder="Ex: INV-2023-001" required>
                                    @error('note_number')
                                        <div class="invalid-feedback text-xs">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Purchase Date</label>
                                    <input type="date" class="form-control @error('purchase_date') is-invalid @enderror"
                                        name="purchase_date" value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                                    @error('purchase_date')
                                        <div class="invalid-feedback text-xs">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Distributor</label>
                                    <select class="form-select @error('distributor_id') is-invalid @enderror" name="distributor_id">
                                        <option value="" selected>-- Select Distributor (Optional) --</option>
                                        @foreach ($distributors as $distributor)
                                            <option value="{{ $distributor->id }}"
                                                {{ old('distributor_id') == $distributor->id ? 'selected' : '' }}>
                                                {{ $distributor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('distributor_id')
                                        <div class="invalid-feedback text-xs">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="horizontal dark my-4">

                            {{-- BAGIAN 2: DAFTAR BARANG (DYNAMIC TABLE) --}}
                            <h6 class="font-weight-bolder text-dark mb-3">Items List</h6>
                            
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0" id="items-table">
                                    <thead class="bg-light text-secondary">
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="40%">Product</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="15%">Quantity</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="20%">Buy Price (Satuan)</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="20%">Subtotal</th>
                                            <th class="text-secondary opacity-7" width="5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="items-body">
                                        {{-- Baris pertama default --}}
                                        <tr class="item-row">
                                            <td>
                                                <select class="form-select form-select-sm product-select" name="items[0][product_id]" required>
                                                    <option value="" disabled selected>Choose Product</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }} (Stok: {{ $product->stock }})</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm qty-input" name="items[0][quantity]" min="1" value="1" required>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="number" class="form-control price-input" name="items[0][price]" min="0" value="0" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="text" class="form-control subtotal-input bg-white" value="0" readonly>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-link text-danger text-gradient px-3 mb-0 remove-row" disabled>
                                                    <i class="far fa-trash-alt me-2"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <button type="button" class="btn btn-sm btn-outline-primary mb-0" id="add-row-btn">
                                    <i class="fas fa-plus me-1"></i> Add Another Item
                                </button>
                                
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-3">Grand Total:</h6>
                                    <h4 class="text-primary font-weight-bolder mb-0" id="grand-total-display">Rp 0</h4>
                                    {{-- Hidden input untuk kirim total ke controller jika perlu, atau hitung ulang di backend --}}
                                    <input type="hidden" name="total_price" id="grand-total-input" value="0">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-5">
                                <a href="{{ route('purchase.index') }}" class="btn btn-light m-0 me-2">Cancel</a>
                                <button type="submit" class="btn bg-gradient-dark m-0">Save Purchase</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT HITUNG-HITUNGAN & DYNAMIC ROWS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let itemIndex = 1; // Counter untuk index array name="items[1]..."

            const itemsBody = document.getElementById('items-body');
            const addRowBtn = document.getElementById('add-row-btn');
            const grandTotalDisplay = document.getElementById('grand-total-display');
            const grandTotalInput = document.getElementById('grand-total-input');

            // 1. FUNGSI FORMAT RUPIAH
            const formatRupiah = (number) => {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(number);
            };

            // 2. FUNGSI UPDATE SUBTOTAL & GRAND TOTAL
            function updateCalculations() {
                let grandTotal = 0;
                const rows = document.querySelectorAll('.item-row');

                rows.forEach(row => {
                    const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
                    const price = parseFloat(row.querySelector('.price-input').value) || 0;
                    const subtotal = qty * price;

                    // Update field subtotal di baris tersebut
                    row.querySelector('.subtotal-input').value = subtotal.toLocaleString('id-ID'); // Tampilan saja

                    grandTotal += subtotal;
                });

                // Update Grand Total
                grandTotalDisplay.innerText = formatRupiah(grandTotal);
                grandTotalInput.value = grandTotal;
            }

            // 3. FUNGSI TAMBAH BARIS
            addRowBtn.addEventListener('click', function() {
                const firstRow = itemsBody.querySelector('.item-row');
                const newRow = firstRow.cloneNode(true); // Clone baris pertama

                // Reset nilai input di baris baru
                newRow.querySelector('.qty-input').value = 1;
                newRow.querySelector('.price-input').value = 0;
                newRow.querySelector('.subtotal-input').value = 0;

                // Update atribut name="items[INDEX][...]" agar unik
                newRow.querySelector('.product-select').name = `items[${itemIndex}][product_id]`;
                newRow.querySelector('.qty-input').name = `items[${itemIndex}][quantity]`;
                newRow.querySelector('.price-input').name = `items[${itemIndex}][price]`;

                // Aktifkan tombol hapus
                newRow.querySelector('.remove-row').disabled = false;

                // Tambahkan ke tabel
                itemsBody.appendChild(newRow);
                itemIndex++;
                
                // Pasang event listener lagi untuk baris baru
                attachEvents(newRow);
            });

            // 4. FUNGSI PASANG EVENT LISTENER (Agar hitungan jalan saat diketik)
            function attachEvents(row) {
                const qtyInput = row.querySelector('.qty-input');
                const priceInput = row.querySelector('.price-input');
                const removeBtn = row.querySelector('.remove-row');

                qtyInput.addEventListener('input', updateCalculations);
                priceInput.addEventListener('input', updateCalculations);

                removeBtn.addEventListener('click', function() {
                    // Jangan hapus jika cuma ada 1 baris
                    if (document.querySelectorAll('.item-row').length > 1) {
                        row.remove();
                        updateCalculations();
                    }
                });
            }

            // Inisialisasi Event untuk baris pertama yang sudah ada
            const initialRows = document.querySelectorAll('.item-row');
            initialRows.forEach(row => attachEvents(row));

        });
    </script>
@endsection