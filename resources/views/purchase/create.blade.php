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
                        <p class="text-xs text-muted">Record incoming goods and set selling price automatically.</p>
                    </div>

                    <div class="card-body">
                        {{-- Tampilkan Error Validasi Global --}}
                        @if($errors->any())
                            <div class="alert alert-danger text-white text-sm" role="alert">
                                <strong>Oops!</strong> Please fix the errors below.
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('purchase.store') }}" method="POST" id="purchase-form">
                            @csrf

                            {{-- BAGIAN 1: HEADER NOTA --}}
                            <div class="row mb-4">
                                <div class="col-md-4 mb-3 position-relative">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Note Number (No. Nota)</label>
                                    <input type="text" class="form-control @error('note_number') is-invalid @enderror"
                                        id="note_number" name="note_number" value="{{ old('note_number') }}"
                                        placeholder="Ex: INV-2023-001" required>

                                    <div id="note_error" class="invalid-feedback text-xs">
                                        Note Number already exists!
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Purchase Date</label>
                                    <input type="date" class="form-control" name="purchase_date" value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Distributor</label>
                                    <select class="form-select" name="distributor_id">
                                        <option value="" selected>-- Select Distributor (Optional) --</option>
                                        @foreach ($distributors as $distributor)
                                            <option value="{{ $distributor->id }}" {{ old('distributor_id') == $distributor->id ? 'selected' : '' }}>
                                                {{ $distributor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <hr class="horizontal dark my-4">

                            {{-- BAGIAN 2: DAFTAR BARANG --}}
                            <h6 class="font-weight-bolder text-dark mb-3">Items List</h6>

                            <div class="table-responsive">
                                <table class="table align-items-center mb-0" id="items-table">
                                    <thead class="bg-light text-secondary">
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" width="30%">Product</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" width="10%">Qty</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" width="15%">Buy Price</th>
                                            {{-- KOLOM BARU: MARGIN --}}
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" width="10%">Margin %</th>
                                            {{-- KOLOM BARU: ESTIMASI JUAL --}}
                                            <th class="text-uppercase text-success text-xxs font-weight-bolder opacity-7 ps-2" width="15%">New Sell Price</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" width="15%">Subtotal</th>
                                            <th class="text-secondary opacity-7" width="5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="items-body">
                                        <tr class="item-row">
                                            <td>
                                                <select class="form-select form-select-sm product-select" name="items[0][product_id]" required>
                                                    <option value="" disabled selected>Choose Product</option>
                                                    @foreach ($products as $product)
                                                        {{-- Simpan harga jual lama di data-attribute untuk referensi --}}
                                                        <option value="{{ $product->id }}" data-current-price="{{ $product->price }}">
                                                            {{ $product->name }} (Stok: {{ $product->stock }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="text-xs text-muted old-price-display d-none">Current Sell Price: Rp <span>0</span></small>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm qty-input" name="items[0][quantity]" min="1" value="1" required>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text text-xs">Rp</span>
                                                    <input type="number" class="form-control price-input" name="items[0][price]" min="0" value="0" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <input type="number" class="form-control margin-input" name="items[0][margin]" min="0" max="500" value="10" required>
                                                    <span class="input-group-text text-xs">%</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text text-xs text-success font-weight-bold">Rp</span>
                                                    {{-- Readonly: Ini cuma kalkulator visual --}}
                                                    <input type="text" class="form-control new-sell-price bg-white text-success font-weight-bold" value="0" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text text-xs">Rp</span>
                                                    <input type="text" class="form-control subtotal-input bg-white" value="0" readonly>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-link text-danger px-3 mb-0 remove-row" disabled>
                                                    <i class="fas fa-trash-alt"></i>
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
                                    <input type="hidden" name="total_price" id="grand-total-input" value="0">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-5">
                                <a href="{{ route('purchase.index') }}" class="btn btn-light m-0 me-2">Cancel</a>
                                <button type="submit" id="btn-submit" class="btn bg-gradient-dark m-0">Save Purchase</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // --- 1. LOGIKA UTAMA (DYNAMIC ROWS + CALCULATOR) ---
            let itemIndex = 1;
            const itemsBody = document.getElementById('items-body');
            const addRowBtn = document.getElementById('add-row-btn');
            const grandTotalDisplay = document.getElementById('grand-total-display');
            const grandTotalInput = document.getElementById('grand-total-input');

            const formatRupiah = (num) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(num);

            function updateCalculations() {
                let grandTotal = 0;
                const rows = document.querySelectorAll('.item-row');

                rows.forEach(row => {
                    // Ambil Value Input
                    const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
                    const buyPrice = parseFloat(row.querySelector('.price-input').value) || 0;
                    const margin = parseFloat(row.querySelector('.margin-input').value) || 0;

                    // 1. Hitung Subtotal (Qty * Harga Beli)
                    const subtotal = qty * buyPrice;
                    row.querySelector('.subtotal-input').value = subtotal.toLocaleString('id-ID');
                    grandTotal += subtotal;

                    // 2. Hitung Estimasi Harga Jual (Harga Beli + Margin%)
                    // Rumus: Beli + (Beli * Margin / 100)
                    const marginValue = buyPrice * (margin / 100);
                    const newSellPrice = buyPrice + marginValue;
                    row.querySelector('.new-sell-price').value = newSellPrice.toLocaleString('id-ID');
                });

                grandTotalDisplay.innerText = formatRupiah(grandTotal);
                grandTotalInput.value = grandTotal;
            }

            // Fungsi saat Dropdown Produk Berubah (Opsional: Tampilkan Harga Lama)
            function handleProductChange(selectElement) {
                const row = selectElement.closest('.item-row');
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                const oldPrice = selectedOption.getAttribute('data-current-price');

                const display = row.querySelector('.old-price-display');
                const priceSpan = display.querySelector('span');

                if(oldPrice) {
                    priceSpan.innerText = parseFloat(oldPrice).toLocaleString('id-ID');
                    display.classList.remove('d-none');
                } else {
                    display.classList.add('d-none');
                }
            }

            // Fungsi Tambah Baris
            addRowBtn.addEventListener('click', function() {
                const firstRow = itemsBody.querySelector('.item-row');
                const newRow = firstRow.cloneNode(true);

                // Reset Values
                newRow.querySelector('.qty-input').value = 1;
                newRow.querySelector('.price-input').value = 0;
                newRow.querySelector('.margin-input').value = 10; // Default margin 10%
                newRow.querySelector('.subtotal-input').value = 0;
                newRow.querySelector('.new-sell-price').value = 0;
                newRow.querySelector('.old-price-display').classList.add('d-none');

                // Update Names
                newRow.querySelector('.product-select').name = `items[${itemIndex}][product_id]`;
                newRow.querySelector('.qty-input').name = `items[${itemIndex}][quantity]`;
                newRow.querySelector('.price-input').name = `items[${itemIndex}][price]`;
                newRow.querySelector('.margin-input').name = `items[${itemIndex}][margin]`;

                newRow.querySelector('.remove-row').disabled = false;
                itemsBody.appendChild(newRow);
                itemIndex++;
                attachEvents(newRow);
            });

            function attachEvents(row) {
                const inputs = row.querySelectorAll('input');
                const removeBtn = row.querySelector('.remove-row');
                const productSelect = row.querySelector('.product-select');

                inputs.forEach(input => input.addEventListener('input', updateCalculations));

                productSelect.addEventListener('change', function() {
                    handleProductChange(this);
                });

                removeBtn.addEventListener('click', function() {
                    if (document.querySelectorAll('.item-row').length > 1) {
                        row.remove();
                        updateCalculations();
                    }
                });
            }

            // Inisialisasi
            const initialRows = document.querySelectorAll('.item-row');
            initialRows.forEach(row => attachEvents(row));


            // --- 2. CEK NOMOR NOTA UNIK ---
            const noteInput = document.getElementById('note_number');
            const submitBtn = document.getElementById('btn-submit');
            const noteError = document.getElementById('note_error');

            if(noteInput) {
                noteInput.addEventListener('blur', function() {
                    const val = this.value;
                    if(val.length < 3) return;
                    fetch("{{ route('purchase.check-unique') }}", {
                        method: "POST", headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                        body: JSON.stringify({ note_number: val })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.exists) {
                            noteInput.classList.add('is-invalid');
                            noteError.style.display = 'block';
                            submitBtn.disabled = true;
                        } else {
                            noteInput.classList.remove('is-invalid');
                            noteInput.classList.add('is-valid');
                            noteError.style.display = 'none';
                            submitBtn.disabled = false;
                        }
                    });
                });
                noteInput.addEventListener('input', function() {
                    this.classList.remove('is-invalid', 'is-valid');
                    noteError.style.display = 'none';
                    submitBtn.disabled = false;
                });
            }
        });
    </script>
@endsection
