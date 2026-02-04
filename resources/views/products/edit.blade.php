@extends('layout.master')

@section('title', 'Edit Product')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header pb-0 bg-white">
                    <h6 class="font-weight-bolder text-primary">Edit Product</h6>
                    <p class="text-xs text-muted">Update product information.</p>
                </div>
                
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{ route('products.update', $product->id) }}" method="POST" 
                          enctype="multipart/form-data" id="edit-product-form">
                        @csrf
                        @method('PUT')
                        
                        {{-- Hidden Input ID untuk validasi JS (agar ignore self) --}}
                        <input type="hidden" id="current_product_id" value="{{ $product->id }}">

                        <div class="row">
                            {{-- KOLOM KIRI: Image Upload --}}
                            <div class="col-md-5 mb-4">
                                <div class="card h-100 border-0 shadow-none">
                                    <div class="card-body p-0">
                                        <label class="form-label text-xs font-weight-bold text-uppercase mb-2">Product Image</label>
                                        
                                        <div id="drop-area" 
                                             class="position-relative border-2 border-dashed border-secondary rounded-3 d-flex align-items-center justify-content-center bg-light overflow-hidden" 
                                             style="height: 350px; cursor: pointer; transition: all 0.3s ease;">
                                            
                                            {{-- Placeholder jika tidak ada gambar --}}
                                            <div id="placeholder-content" class="text-center p-4 {{ $product->picture ? 'd-none' : '' }}" style="pointer-events: none;">
                                                <div class="mb-3">
                                                    <i class="fas fa-cloud-upload-alt fa-3x text-secondary opacity-5"></i>
                                                </div>
                                                <h6 class="text-sm font-weight-bold mb-1 text-secondary">Change Image</h6>
                                                <p class="text-xxs text-muted mb-0">Click or Drop new image here</p>
                                            </div>

                                            {{-- Image Preview --}}
                                            <img id="img-preview" 
                                                 src="{{ $product->picture ? asset('storage/' . $product->picture) : '' }}" 
                                                 class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover {{ $product->picture ? '' : 'd-none' }}" 
                                                 style="pointer-events: none;">
                                            
                                            {{-- Drag Overlay --}}
                                            <div id="drop-overlay" class="position-absolute top-0 start-0 w-100 h-100 bg-white opacity-0 d-flex align-items-center justify-content-center" 
                                                 style="transition: opacity 0.2s; pointer-events: none;">
                                                <span class="badge bg-gradient-primary">Release to Upload</span>
                                            </div>
                                        </div>

                                        <input type="file" class="d-none" id="picture" name="picture" accept="image/*">
                                        
                                        <div class="text-center mt-3">
                                            <button type="button" class="btn btn-sm btn-outline-dark mb-0" onclick="document.getElementById('picture').click()">
                                                <i class="fas fa-camera me-1"></i> Change Photo
                                            </button>
                                            <p class="text-xxs text-muted mt-2 mb-0">Leave empty to keep current image.</p>
                                        </div>

                                        @error('picture')
                                            <div class="text-danger text-xs mt-2 text-center">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- KOLOM KANAN: Form Inputs --}}
                            <div class="col-md-7">
                                <div class="card bg-gray-100 border-0 h-100">
                                    <div class="card-body">
                                        
                                        {{-- Row 1: SKU & Name --}}
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-xs font-weight-bold text-uppercase">Serial Number (SKU)</label>
                                                <input type="text" class="form-control" name="serial_number" id="serial_number"
                                                       value="{{ old('serial_number', $product->serial_number) }}" required>
                                                {{-- Pesan Error Realtime --}}
                                                <div class="invalid-feedback text-xs">
                                                    Serial Number already exists!
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-xs font-weight-bold text-uppercase">Product Name</label>
                                                <input type="text" class="form-control" name="name" id="name"
                                                       value="{{ old('name', $product->name) }}" required>
                                                <div class="invalid-feedback text-xs">
                                                    Product Name already exists!
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Row 2: Distributor & Category --}}
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-xs font-weight-bold text-uppercase">Distributor</label>
                                                <select class="form-select" name="distributor_id" required>
                                                    @foreach($distributors as $distributor)
                                                        <option value="{{ $distributor->id }}" 
                                                            {{ old('distributor_id', $product->distributor_id) == $distributor->id ? 'selected' : '' }}>
                                                            {{ $distributor->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-xs font-weight-bold text-uppercase">Category</label>
                                                <select class="form-select" name="type" required>
                                                    <option value="Food & Snacks" {{ old('type', $product->type) == 'Food & Snacks' ? 'selected' : '' }}>Food & Snacks</option>
                                                    <option value="Beverages" {{ old('type', $product->type) == 'Beverages' ? 'selected' : '' }}>Beverages</option>
                                                    <option value="Daily Essentials" {{ old('type', $product->type) == 'Daily Essentials' ? 'selected' : '' }}>Daily Essentials</option>
                                                    <option value="Electronics" {{ old('type', $product->type) == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                                                </select>
                                            </div>
                                        </div>

                                        {{-- Row 3: Description --}}
                                        <div class="mb-3">
                                            <label class="form-label text-xs font-weight-bold text-uppercase">Description</label>
                                            <textarea class="form-control" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                                        </div>

                                        {{-- Row 4: Price, Stock, Date --}}
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label text-xs font-weight-bold text-uppercase">Price (IDR)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="number" class="form-control" name="price" value="{{ old('price', $product->price) }}" min="0" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label text-xs font-weight-bold text-uppercase">Stock</label>
                                                <input type="number" class="form-control" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label text-xs font-weight-bold text-uppercase">Exp. Date</label>
                                                <input type="date" class="form-control" name="expiration_date" value="{{ old('expiration_date', optional($product->expiration_date)->format('Y-m-d')) }}">
                                            </div>
                                        </div>

                                        {{-- Row 5: Status --}}
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <div class="form-check form-switch ps-0 d-flex align-items-center bg-white p-3 rounded border">
                                                    <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0 font-weight-bold" for="isActiveSwitch">
                                                        Status Produk (Aktif/Nonaktif)
                                                        <small class="d-block text-xs text-muted font-weight-normal">Jika dinonaktifkan, produk tidak akan muncul di katalog user.</small>
                                                    </label>
                                                    <input class="form-check-input ms-auto" type="checkbox" id="isActiveSwitch" 
                                                           name="is_active" value="1" 
                                                           {{ $product->is_active ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end mt-4">
                                            <a href="#" onclick="confirmCancel(event)" class="btn btn-light m-0 me-2">Cancel</a>
                                            {{-- ID button penting untuk disabled state --}}
                                            <button type="submit" id="btn-submit" class="btn bg-gradient-primary m-0">Update Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    {{-- Form End --}}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-dashed { border-style: dashed !important; border-width: 2px !important; }
    .drag-over { border-color: #cb0c9f !important; background-color: rgba(203, 12, 159, 0.03) !important; }
    .drag-over #drop-overlay { opacity: 0.9 !important; }
    .object-fit-cover { object-fit: cover; }
    .form-control.is-invalid {
        border-color: #fd5c70;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23fd5c70'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23fd5c70' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- 1. REAL-TIME VALIDATION LOGIC ---
        const serialInput = document.getElementById('serial_number');
        const nameInput = document.getElementById('name');
        const submitBtn = document.getElementById('btn-submit');
        const currentProductId = document.getElementById('current_product_id').value;

        // Simpan nilai awal agar tidak memicu validasi jika user tidak mengubah apa-apa
        const initialSerial = serialInput ? serialInput.value : '';
        const initialName = nameInput ? nameInput.value : '';

        function checkDuplicate(inputElement, fieldName, initialValue) {
            const value = inputElement.value;
            
            // Jika nilai sama dengan nilai awal (milik sendiri), jangan cek DB
            if (value === initialValue) {
                inputElement.classList.remove('is-invalid');
                inputElement.classList.add('is-valid');
                checkAllInputs();
                return;
            }

            if (value.length < 3) return;

            fetch("{{ route('products.check-unique') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ 
                    field: fieldName, 
                    value: value,
                    ignore_id: currentProductId // Kirim ID produk ini untuk pengecualian (optional di sisi server)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    inputElement.classList.add('is-invalid');
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    inputElement.classList.remove('is-invalid');
                    inputElement.classList.add('is-valid');
                    checkAllInputs();
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function checkAllInputs() {
            const invalids = document.querySelectorAll('.is-invalid');
            if (invalids.length === 0) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        if(serialInput) {
            serialInput.addEventListener('blur', function() { checkDuplicate(this, 'serial_number', initialSerial); });
            serialInput.addEventListener('input', function() { this.classList.remove('is-invalid', 'is-valid'); });
        }
        
        if(nameInput) {
            nameInput.addEventListener('blur', function() { checkDuplicate(this, 'name', initialName); });
            nameInput.addEventListener('input', function() { this.classList.remove('is-invalid', 'is-valid'); });
        }


        // --- 2. DRAG & DROP LOGIC ---
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('picture');
        const imgPreview = document.getElementById('img-preview');
        const placeholder = document.getElementById('placeholder-content');

        if (dropArea) {
            ['dragenter', 'dragover'].forEach(eventName => dropArea.addEventListener(eventName, e => {
                e.preventDefault(); dropArea.classList.add('drag-over');
            }));
            ['dragleave', 'drop'].forEach(eventName => dropArea.addEventListener(eventName, e => {
                e.preventDefault(); dropArea.classList.remove('drag-over');
            }));
            dropArea.addEventListener('drop', handleDrop);
            dropArea.addEventListener('click', () => fileInput.click());
        }

        if (fileInput) fileInput.addEventListener('change', () => previewImage(fileInput));

        function handleDrop(e) {
            e.preventDefault(); e.stopPropagation();
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                if (!files[0].type.startsWith('image/')) {
                    Swal.fire({ icon: 'error', title: 'Format Salah', text: 'Mohon upload file gambar.', confirmButtonColor: '#344767' });
                    return;
                }
                fileInput.files = files;
                previewImage(fileInput);
            }
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if(placeholder) placeholder.classList.add('d-none');
                    if(imgPreview) {
                        imgPreview.src = e.target.result;
                        imgPreview.classList.remove('d-none');
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // --- 3. SUBMIT CONFIRMATION ---
        const form = document.getElementById('edit-product-form');
        if (form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Simpan Perubahan?',
                    text: "Pastikan data sudah benar.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#cb0c9f',
                    cancelButtonColor: '#82d616',
                    confirmButtonText: 'Ya, Update!',
                    cancelButtonText: 'Cek Lagi'
                }).then((result) => { if (result.isConfirmed) this.submit(); });
            });
        }
    });

    function confirmCancel(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Batalkan Edit?',
            text: "Perubahan belum disimpan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#344767',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Batal',
            cancelButtonText: 'Lanjut'
        }).then((result) => { if (result.isConfirmed) window.location.href = "{{ route('products.index') }}"; });
    }
</script>
@endsection