@extends('layout.master')

@section('title', 'Edit Purchase')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
    @php
        $oldItems = old('items');
        $rows = $oldItems
            ? collect($oldItems)->values()
            : $purchase->details->map(function ($detail) {
                return [
                    'product_id' => $detail->product_id,
                    'quantity' => $detail->purchase_amount,
                    'price' => $detail->purchase_price,
                    'margin' => $detail->selling_margin,
                ];
            })->values();
    @endphp

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header pb-0">
                        <h6 class="font-weight-bolder text-primary">Edit Purchase</h6>
                        <p class="text-xs text-muted">Update incoming goods, stock, and selling prices.</p>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger text-white text-sm" role="alert">
                                <strong>Oops!</strong> Please fix the errors below.
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger text-white text-sm" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('purchase.update', $purchase->id) }}" method="POST" id="purchase-form">
                            @csrf
                            @method('PUT')

                            <div class="row mb-4">
                                <div class="col-md-4 mb-3 position-relative">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Note Number (No. Nota)</label>
                                    <input type="text" class="form-control @error('note_number') is-invalid @enderror"
                                        id="note_number" name="note_number"
                                        value="{{ old('note_number', $purchase->note_number) }}"
                                        data-original-note="{{ $purchase->note_number }}"
                                        placeholder="Ex: INV-2023-001" required>

                                    <div id="note_error" class="invalid-feedback text-xs">
                                        Note Number already exists!
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Purchase Date</label>
                                    <input type="date" class="form-control" name="purchase_date"
                                        value="{{ old('purchase_date', $purchase->purchase_date->format('Y-m-d')) }}" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Distributor</label>
                                    <select class="form-select" name="distributor_id">
                                        <option value="">-- Select Distributor (Optional) --</option>
                                        @foreach ($distributors as $distributor)
                                            <option value="{{ $distributor->id }}"
                                                {{ (string) old('distributor_id', $purchase->distributor_id) === (string) $distributor->id ? 'selected' : '' }}>
                                                {{ $distributor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <hr class="horizontal dark my-4">

                            <h6 class="font-weight-bolder text-dark mb-3">Items List</h6>

                            <div class="table-responsive">
                                <table class="table admin-table align-items-center mb-0" id="items-table">
                                    <thead class="text-secondary admin-table-head">
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" width="30%">Product</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" width="10%">Qty</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" width="15%">Buy Price</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" width="10%">Margin %</th>
                                            <th class="text-uppercase text-success text-xxs font-weight-bolder opacity-7 ps-2" width="15%">New Sell Price</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" width="15%">Subtotal</th>
                                            <th class="text-secondary opacity-7" width="5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="items-body">
                                        @foreach ($rows as $index => $row)
                                            <tr class="item-row">
                                                <td>
                                                    <select class="form-select form-select-sm product-select" name="items[{{ $index }}][product_id]" required>
                                                        <option value="" disabled {{ empty($row['product_id']) ? 'selected' : '' }}>Choose Product</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}" data-current-price="{{ $product->price }}"
                                                                {{ (string) ($row['product_id'] ?? '') === (string) $product->id ? 'selected' : '' }}>
                                                                {{ $product->name }} (Stok: {{ $product->stock }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <small class="text-xs text-muted old-price-display d-none">
                                                        Current Sell Price: Rp <span>0</span>
                                                    </small>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm qty-input"
                                                        name="items[{{ $index }}][quantity]" min="1"
                                                        value="{{ $row['quantity'] ?? 1 }}" required>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text text-xs">Rp</span>
                                                        <input type="number" class="form-control price-input"
                                                            name="items[{{ $index }}][price]" min="0"
                                                            value="{{ $row['price'] ?? 0 }}" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" class="form-control margin-input"
                                                            name="items[{{ $index }}][margin]" min="0" max="500"
                                                            value="{{ $row['margin'] ?? 10 }}" required>
                                                        <span class="input-group-text text-xs">%</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text text-xs text-success font-weight-bold">Rp</span>
                                                        <input type="text" class="form-control new-sell-price text-success font-weight-bold" value="0" readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text text-xs">Rp</span>
                                                        <input type="text" class="form-control subtotal-input" value="0" readonly>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-link text-danger px-3 mb-0 remove-row"
                                                        {{ $rows->count() <= 1 ? 'disabled' : '' }}>
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
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
                                    <input type="hidden" name="total_price" id="grand-total-input" value="{{ old('total_price', $purchase->total_price) }}">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-5">
                                <a href="{{ route('purchase.index') }}" class="btn btn-light m-0 me-2">Cancel</a>
                                <button type="submit" id="btn-submit" class="btn bg-gradient-warning m-0">Update Purchase</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let itemIndex = document.querySelectorAll('.item-row').length;
            const itemsBody = document.getElementById('items-body');
            const addRowBtn = document.getElementById('add-row-btn');
            const grandTotalDisplay = document.getElementById('grand-total-display');
            const grandTotalInput = document.getElementById('grand-total-input');

            const formatRupiah = (num) => new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(num);

            function updateCalculations() {
                let grandTotal = 0;
                const rows = document.querySelectorAll('.item-row');

                rows.forEach(row => {
                    const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
                    const buyPrice = parseFloat(row.querySelector('.price-input').value) || 0;
                    const margin = parseFloat(row.querySelector('.margin-input').value) || 0;
                    const subtotal = qty * buyPrice;
                    const newSellPrice = buyPrice + (buyPrice * (margin / 100));

                    row.querySelector('.subtotal-input').value = subtotal.toLocaleString('id-ID');
                    row.querySelector('.new-sell-price').value = Math.round(newSellPrice).toLocaleString('id-ID');
                    grandTotal += subtotal;
                });

                grandTotalDisplay.innerText = formatRupiah(grandTotal);
                grandTotalInput.value = grandTotal;
            }

            function syncRemoveButtons() {
                const rows = document.querySelectorAll('.item-row');
                rows.forEach(row => {
                    row.querySelector('.remove-row').disabled = rows.length <= 1;
                });
            }

            function handleProductChange(selectElement) {
                const row = selectElement.closest('.item-row');
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                const oldPrice = selectedOption.getAttribute('data-current-price');
                const display = row.querySelector('.old-price-display');
                const priceSpan = display.querySelector('span');

                if (oldPrice) {
                    priceSpan.innerText = parseFloat(oldPrice).toLocaleString('id-ID');
                    display.classList.remove('d-none');
                } else {
                    display.classList.add('d-none');
                }
            }

            function attachEvents(row) {
                row.querySelectorAll('input').forEach(input => input.addEventListener('input', updateCalculations));

                row.querySelector('.product-select').addEventListener('change', function() {
                    handleProductChange(this);
                });

                row.querySelector('.remove-row').addEventListener('click', function() {
                    if (document.querySelectorAll('.item-row').length > 1) {
                        row.remove();
                        syncRemoveButtons();
                        updateCalculations();
                    }
                });
            }

            addRowBtn.addEventListener('click', function() {
                const firstRow = itemsBody.querySelector('.item-row');
                const newRow = firstRow.cloneNode(true);

                newRow.querySelector('.product-select').selectedIndex = 0;
                newRow.querySelector('.qty-input').value = 1;
                newRow.querySelector('.price-input').value = 0;
                newRow.querySelector('.margin-input').value = 10;
                newRow.querySelector('.subtotal-input').value = 0;
                newRow.querySelector('.new-sell-price').value = 0;
                newRow.querySelector('.old-price-display').classList.add('d-none');

                newRow.querySelector('.product-select').name = `items[${itemIndex}][product_id]`;
                newRow.querySelector('.qty-input').name = `items[${itemIndex}][quantity]`;
                newRow.querySelector('.price-input').name = `items[${itemIndex}][price]`;
                newRow.querySelector('.margin-input').name = `items[${itemIndex}][margin]`;

                itemsBody.appendChild(newRow);
                itemIndex++;
                attachEvents(newRow);
                syncRemoveButtons();
            });

            document.querySelectorAll('.item-row').forEach(row => {
                attachEvents(row);
                handleProductChange(row.querySelector('.product-select'));
            });

            syncRemoveButtons();
            updateCalculations();

            const noteInput = document.getElementById('note_number');
            const submitBtn = document.getElementById('btn-submit');
            const noteError = document.getElementById('note_error');

            if (noteInput) {
                noteInput.addEventListener('blur', function() {
                    const val = this.value;

                    if (val.length < 3 || val === this.dataset.originalNote) return;

                    fetch("{{ route('purchase.check-unique') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            note_number: val,
                            purchase_id: "{{ $purchase->id }}"
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.exists) {
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
