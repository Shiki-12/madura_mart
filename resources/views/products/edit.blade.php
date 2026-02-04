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

                            <div class="row">
                                {{-- KOLOM KIRI: Image Upload (Aesthetic Style) --}}
                                <div class="col-md-5 mb-4">
                                    <div class="card h-100 border-0 shadow-none">
                                        <div class="card-body p-0">
                                            <label class="form-label text-xs font-weight-bold text-uppercase mb-2">Product
                                                Image</label>

                                            {{-- DROP ZONE --}}
                                            <div id="drop-area"
                                                class="position-relative border-2 border-dashed border-secondary rounded-3 d-flex align-items-center justify-content-center bg-light overflow-hidden"
                                                style="height: 350px; cursor: pointer; transition: all 0.3s ease;">

                                                {{-- 1. Placeholder Content (Jika tidak ada gambar) --}}
                                                <div id="placeholder-content"
                                                    class="text-center p-4 {{ $product->picture ? 'd-none' : '' }}"
                                                    style="pointer-events: none;">
                                                    <div class="mb-3">
                                                        <i
                                                            class="fas fa-cloud-upload-alt fa-3x text-secondary opacity-5"></i>
                                                    </div>
                                                    <h6 class="text-sm font-weight-bold mb-1 text-secondary">Change Image
                                                    </h6>
                                                    <p class="text-xxs text-muted mb-0">Click or Drop new image here</p>
                                                </div>

                                                {{-- 2. Image Preview (Tampilkan jika ada gambar di DB) --}}
                                                <img id="img-preview"
                                                    src="{{ $product->picture ? asset('storage/' . $product->picture) : '' }}"
                                                    class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover {{ $product->picture ? '' : 'd-none' }}"
                                                    style="pointer-events: none;">

                                                {{-- 3. Drag Overlay (Muncul saat drag) --}}
                                                <div id="drop-overlay"
                                                    class="position-absolute top-0 start-0 w-100 h-100 bg-white opacity-0 d-flex align-items-center justify-content-center"
                                                    style="transition: opacity 0.2s; pointer-events: none;">
                                                    <span class="badge bg-gradient-primary">Release to Upload</span>
                                                </div>
                                            </div>

                                            {{-- Hidden Input --}}
                                            <input type="file" class="d-none" id="picture" name="picture"
                                                accept="image/*">

                                            {{-- Tombol Kecil di Bawah --}}
                                            <div class="text-center mt-3">
                                                <button type="button" class="btn btn-sm btn-outline-dark mb-0"
                                                    onclick="document.getElementById('picture').click()">
                                                    <i class="fas fa-camera me-1"></i> Change Photo
                                                </button>
                                                <p class="text-xxs text-muted mt-2 mb-0">Leave empty to keep current image.
                                                </p>
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
                                            {{-- SKU & Nama --}}
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label text-xs font-weight-bold text-uppercase">Serial
                                                        Number (SKU)</label>
                                                    <input type="text" class="form-control" name="serial_number"
                                                        value="{{ old('serial_number', $product->serial_number) }}"
                                                        required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label
                                                        class="form-label text-xs font-weight-bold text-uppercase">Product
                                                        Name</label>
                                                    <input type="text" class="form-control" name="name"
                                                        value="{{ old('name', $product->name) }}" required>
                                                </div>
                                            </div>

                                            {{-- Distributor & Kategori --}}
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label
                                                        class="form-label text-xs font-weight-bold text-uppercase">Distributor</label>
                                                    <select class="form-select" name="distributor_id" required>
                                                        @foreach ($distributors as $distributor)
                                                            <option value="{{ $distributor->id }}"
                                                                {{ old('distributor_id', $product->distributor_id) == $distributor->id ? 'selected' : '' }}>
                                                                {{ $distributor->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label
                                                        class="form-label text-xs font-weight-bold text-uppercase">Category</label>
                                                    <select class="form-select" name="type" required>
                                                        <option value="Food & Snacks"
                                                            {{ old('type', $product->type) == 'Food & Snacks' ? 'selected' : '' }}>
                                                            Food & Snacks</option>
                                                        <option value="Beverages"
                                                            {{ old('type', $product->type) == 'Beverages' ? 'selected' : '' }}>
                                                            Beverages</option>
                                                        <option value="Daily Essentials"
                                                            {{ old('type', $product->type) == 'Daily Essentials' ? 'selected' : '' }}>
                                                            Daily Essentials</option>
                                                        <option value="Electronics"
                                                            {{ old('type', $product->type) == 'Electronics' ? 'selected' : '' }}>
                                                            Electronics</option>
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Deskripsi --}}
                                            <div class="mb-3">
                                                <label
                                                    class="form-label text-xs font-weight-bold text-uppercase">Description</label>
                                                <textarea class="form-control" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                                            </div>

                                            {{-- Harga, Stok, Expired --}}
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label
                                                        class="form-label text-xs font-weight-bold text-uppercase">Price</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Rp</span>
                                                        <input type="number" class="form-control" name="price"
                                                            value="{{ old('price', $product->price) }}" min="0"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label
                                                        class="form-label text-xs font-weight-bold text-uppercase">Stock</label>
                                                    <input type="number" class="form-control" name="stock"
                                                        value="{{ old('stock', $product->stock) }}" min="0"
                                                        required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label text-xs font-weight-bold text-uppercase">Exp.
                                                        Date</label>
                                                    <input type="date" class="form-control" name="expiration_date"
                                                        value="{{ old('expiration_date', optional($product->expiration_date)->format('Y-m-d')) }}">
                                                </div>
                                            </div>

                                            {{-- Toggle Status --}}
                                            <div class="row mt-2">
                                                <div class="col-12">
                                                    <div
                                                        class="form-check form-switch ps-0 d-flex align-items-center bg-white p-3 rounded border">
                                                        <label class="form-check-label text-body ms-3 font-weight-bold"
                                                            for="isActiveSwitch">
                                                            Status Produk
                                                        </label>
                                                        <input class="form-check-input ms-auto" type="checkbox"
                                                            id="isActiveSwitch" name="is_active" value="1"
                                                            {{ $product->is_active ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-end mt-4">
                                                <a href="#" onclick="confirmCancel(event)"
                                                    class="btn btn-light m-0 me-2">Cancel</a>
                                                <button type="submit" class="btn bg-gradient-primary m-0">Update
                                                    Changes</button>
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

    {{-- Style Tambahan --}}
    <style>
        .border-dashed {
            border-style: dashed !important;
            border-width: 2px !important;
        }

        .drag-over {
            border-color: #cb0c9f !important;
            background-color: rgba(203, 12, 159, 0.03) !important;
        }

        .drag-over #drop-overlay {
            opacity: 0.9 !important;
        }

        .object-fit-cover {
            object-fit: cover;
        }
    </style>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- PREVENT DEFAULT ---
            window.addEventListener('dragover', e => e.preventDefault(), false);
            window.addEventListener('drop', e => e.preventDefault(), false);

            // --- DRAG & DROP LOGIC ---
            const dropArea = document.getElementById('drop-area');
            const fileInput = document.getElementById('picture');
            const imgPreview = document.getElementById('img-preview');
            const placeholder = document.getElementById('placeholder-content');

            if (dropArea) {
                ['dragenter', 'dragover'].forEach(eventName => {
                    dropArea.addEventListener(eventName, () => dropArea.classList.add('drag-over'), false);
                });
                ['dragleave', 'drop'].forEach(eventName => {
                    dropArea.addEventListener(eventName, () => dropArea.classList.remove('drag-over'),
                        false);
                });

                dropArea.addEventListener('drop', handleDrop, false);
                dropArea.addEventListener('click', () => fileInput.click());
            }

            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    previewImage(this);
                });
            }

            function handleDrop(e) {
                e.preventDefault();
                e.stopPropagation();
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    if (!files[0].type.startsWith('image/')) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Format Salah',
                            text: 'Mohon upload file gambar (JPG/PNG).',
                            confirmButtonColor: '#344767'
                        });
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
                        if (placeholder) placeholder.classList.add('d-none');
                        if (imgPreview) {
                            imgPreview.src = e.target.result;
                            imgPreview.classList.remove('d-none');
                        }
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // --- SUBMIT CONFIRMATION ---
            const form = document.getElementById('edit-product-form');
            if (form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Simpan Perubahan?',
                        text: "Pastikan data sudah benar.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#344767',
                        cancelButtonColor: '#82d616',
                        confirmButtonText: 'Ya, Update!',
                        cancelButtonText: 'Cek Lagi'
                    }).then((result) => {
                        if (result.isConfirmed) this.submit();
                    });
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
            }).then((result) => {
                if (result.isConfirmed) window.location.href = "{{ route('products.index') }}";
            });
        }
    </script>
@endsection
