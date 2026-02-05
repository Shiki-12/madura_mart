@extends('layout.master')

@section('title', 'New Transaction')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        {{-- Kolom Kiri: Form Kasir --}}
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white pb-0">
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-bolder text-success">Cashier Transaction</h6>
                        <span class="badge bg-success">{{ date('d M Y') }}</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger text-white mb-4" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('sales.store') }}" method="POST" id="sales-form">
                        @csrf
                        
                        {{-- Input Hidden Tanggal (Default Hari Ini) --}}
                        <input type="hidden" name="sale_date" value="{{ date('Y-m-d') }}">

                        {{-- Tabel Keranjang Belanja --}}
                        <div class="table-responsive mb-4">
                            <table class="table align-items-center mb-0" id="cart-table">
                                <thead class="bg-light text-secondary">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="40%">Product</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="15%">Stock</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="20%">Price</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="10%">Qty</th>
                                        <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="15%">Subtotal</th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody id="cart-body">
                                    {{-- Baris Pertama Default --}}
                                    <tr class="cart-item">
                                        <td>
                                            <select class="form-select product-select" name="items[0][product_id]" required>
                                                <option value="" disabled selected>Scan / Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" 
                                                            data-price="{{ $product->price }}" 
                                                            data-stock="{{ $product->stock }}">
                                                        {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary stock-display">-</span>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                {{-- Harga Readonly (Ambil dari DB) --}}
                                                <input type="text" class="form-control price-display bg-white" value="0" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control qty-input" name="items[0][quantity]" min="1" value="1" required>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" class="form-control subtotal-display bg-white text-end font-weight-bold" value="0" readonly>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-link text-danger mb-0 remove-row" disabled>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-outline-success btn-sm mb-0" id="add-item-btn">
                                <i class="fas fa-plus me-1"></i> Add Item
                            </button>
                            
                            <div class="text-end">
                                <h6 class="text-secondary text-xs mb-1">Total Payment</h6>
                                <h2 class="text-success font-weight-bolder mb-0" id="grand-total">Rp 0</h2>
                            </div>
                        </div>

                        <hr class="horizontal dark my-4">
                        
                        <div class="text-end">
                            <a href="{{ route('sales.index') }}" class="btn btn-light m-0 me-2">Cancel</a>
                            <button type="submit" class="btn bg-gradient-success m-0 w-25">Process Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let rowIndex = 1;
        const cartBody = document.getElementById('cart-body');
        const grandTotalEl = document.getElementById('grand-total');

        const formatRupiah = (num) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(num);

        // --- 1. Fungsi Update Baris ---
        function updateRow(row) {
            const select = row.querySelector('.product-select');
            const qtyInput = row.querySelector('.qty-input');
            const stockBadge = row.querySelector('.stock-display');
            const priceInput = row.querySelector('.price-display');
            const subtotalInput = row.querySelector('.subtotal-display');

            // Ambil data dari option yang dipilih
            const selectedOption = select.options[select.selectedIndex];
            const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
            const qty = parseInt(qtyInput.value) || 0;

            // Update Tampilan Harga & Stok
            if(select.value) {
                stockBadge.innerText = stock + ' Pcs';
                priceInput.value = price.toLocaleString('id-ID'); // Visual only
                
                // Validasi Stok (UX)
                if(qty > stock) {
                    qtyInput.classList.add('is-invalid');
                    Swal.fire({ icon: 'error', title: 'Stok Kurang!', text: 'Sisa stok hanya ' + stock, timer: 1500, showConfirmButton: false });
                    qtyInput.value = stock; // Reset ke max stok
                } else {
                    qtyInput.classList.remove('is-invalid');
                }
            }

            // Hitung Subtotal
            const finalQty = parseInt(qtyInput.value) || 0;
            const subtotal = price * finalQty;
            subtotalInput.value = subtotal.toLocaleString('id-ID');

            updateGrandTotal();
        }

        // --- 2. Fungsi Grand Total ---
        function updateGrandTotal() {
            let total = 0;
            document.querySelectorAll('.cart-item').forEach(row => {
                const subRaw = row.querySelector('.subtotal-display').value.replace(/\./g, ''); // Hapus titik format ribuan
                total += parseInt(subRaw) || 0;
            });
            grandTotalEl.innerText = formatRupiah(total);
        }

        // --- 3. Event Listener Baris ---
        function attachEvents(row) {
            const select = row.querySelector('.product-select');
            const qty = row.querySelector('.qty-input');
            const removeBtn = row.querySelector('.remove-row');

            select.addEventListener('change', () => updateRow(row));
            qty.addEventListener('input', () => updateRow(row));
            
            removeBtn.addEventListener('click', () => {
                if(document.querySelectorAll('.cart-item').length > 1) {
                    row.remove();
                    updateGrandTotal();
                }
            });
        }

        // --- 4. Tambah Baris Baru ---
        document.getElementById('add-item-btn').addEventListener('click', () => {
            const firstRow = document.querySelector('.cart-item');
            const newRow = firstRow.cloneNode(true);

            // Reset Nilai
            newRow.querySelector('.product-select').name = `items[${rowIndex}][product_id]`;
            newRow.querySelector('.product-select').value = "";
            newRow.querySelector('.qty-input').name = `items[${rowIndex}][quantity]`;
            newRow.querySelector('.qty-input').value = 1;
            newRow.querySelector('.stock-display').innerText = "-";
            newRow.querySelector('.price-display').value = 0;
            newRow.querySelector('.subtotal-display').value = 0;
            newRow.querySelector('.remove-row').disabled = false;

            cartBody.appendChild(newRow);
            attachEvents(newRow);
            rowIndex++;
        });

        // Init baris pertama
        attachEvents(document.querySelector('.cart-item'));
    });
</script>
@endsection