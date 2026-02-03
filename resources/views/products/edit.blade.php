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
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="edit-product-form">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- KOLOM KIRI: Gambar --}}
                            <div class="col-md-4 mb-4">
                                <div class="card bg-light border-radius-lg border-0 h-100">
                                    <div class="card-body text-center d-flex flex-column align-items-center justify-content-center">
                                        <h6 class="text-secondary text-sm mb-3">Product Image</h6>

                                        <div id="drop-area" class="avatar avatar-xxl position-relative mb-3 border border-2 border-white shadow-sm"
                                             style="width: 150px; height: 150px; cursor: pointer; overflow: hidden; transition: all 0.3s ease;">

                                            @if($product->picture)
                                                <img id="img-preview" src="{{ asset('storage/' . $product->picture) }}"
                                                     alt="Preview" class="w-100 h-100 object-fit-cover rounded-circle" style="pointer-events: none;">
                                            @else
                                                <img id="img-preview" src="https://placehold.co/150x150/grey/white?text=No+Image"
                                                     alt="Preview" class="w-100 h-100 object-fit-cover rounded-circle" style="pointer-events: none;">
                                            @endif

                                            <div id="drop-overlay" class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark opacity-0"
                                                 style="transition: opacity 0.3s; pointer-events: none;">
                                                <span class="text-white font-weight-bold text-xs">Change Image</span>
                                            </div>
                                        </div>

                                        <div class="small-upload-btn-wrapper">
                                            <input type="file" class="d-none" id="picture" name="picture" accept="image/*">
                                            <button type="button" class="btn btn-sm btn-outline-primary mb-0" onclick="document.getElementById('picture').click()">
                                                Change Image
                                            </button>
                                        </div>
                                        <p class="text-xxs text-muted mt-2">Leave empty to keep current image.</p>
                                        @error('picture') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- KOLOM KANAN: Input Data --}}
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-xs font-weight-bold text-uppercase">Serial Number (SKU)</label>
                                        <input type="text" class="form-control" name="serial_number" value="{{ old('serial_number', $product->serial_number) }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-xs font-weight-bold text-uppercase">Product Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-xs font-weight-bold text-uppercase">Category</label>
                                        <select class="form-select" name="type" required>
                                            <option value="Food & Snacks" {{ old('type', $product->type) == 'Food & Snacks' ? 'selected' : '' }}>Food & Snacks</option>
                                            <option value="Beverages" {{ old('type', $product->type) == 'Beverages' ? 'selected' : '' }}>Beverages</option>
                                            <option value="Daily Essentials" {{ old('type', $product->type) == 'Daily Essentials' ? 'selected' : '' }}>Daily Essentials</option>
                                            <option value="Electronics" {{ old('type', $product->type) == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-xs font-weight-bold text-uppercase">Expiration Date</label>
                                        <input type="date" class="form-control" name="expiration_date" value="{{ old('expiration_date', optional($product->expiration_date)->format('Y-m-d')) }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-xs font-weight-bold text-uppercase">Price (IDR)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control" name="price" value="{{ old('price', $product->price) }}" min="0" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-xs font-weight-bold text-uppercase">Stock</label>
                                        <input type="number" class="form-control" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required>
                                    </div>
                                </div>

                                {{-- STATUS TOGGLE (Disini posisi barunya) --}}
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-check form-switch ps-0 d-flex align-items-center bg-light p-3 rounded border">
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
                                    <button type="submit" class="btn bg-gradient-primary m-0">Update Changes</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CSS & JS sama seperti sebelumnya, hanya dihapus session error handler agar lebih clean --}}
<style>
    .drag-over {
        border-color: #cb0c9f !important;
        border-style: dashed !important;
        background-color: rgba(203, 12, 159, 0.05);
        transform: scale(1.02);
    }
    .drag-over #drop-overlay { opacity: 0.8 !important; }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Drag & Drop Logic
        window.addEventListener('dragover', e => e.preventDefault(), false);
        window.addEventListener('drop', e => e.preventDefault(), false);
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('picture');
        const imgPreview = document.getElementById('img-preview');

        if (dropArea) {
            ['dragenter', 'dragover'].forEach(eventName => dropArea.addEventListener(eventName, () => dropArea.classList.add('drag-over'), false));
            ['dragleave', 'drop'].forEach(eventName => dropArea.addEventListener(eventName, () => dropArea.classList.remove('drag-over'), false));
            dropArea.addEventListener('drop', handleDrop, false);
            dropArea.addEventListener('click', () => fileInput.click());
        }
        if (fileInput) fileInput.addEventListener('change', function() { previewImage(this); });
        function handleDrop(e) {
            e.preventDefault(); e.stopPropagation();
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                if (!files[0].type.startsWith('image/')) { Swal.fire({ icon: 'error', title: 'File Salah', text: 'Mohon upload gambar.' }); return; }
                fileInput.files = files; previewImage(fileInput);
            }
        }
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => { if(imgPreview) imgPreview.src = e.target.result; }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Submit Logic
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
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Batal',
            cancelButtonText: 'Lanjut'
        }).then((result) => { if (result.isConfirmed) window.location.href = "{{ route('products.index') }}"; });
    }
</script>
@endsection
