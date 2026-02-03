@extends('layout.master')

@section('title', 'Add New Product')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header pb-0 bg-white">
                    <h6 class="font-weight-bolder text-primary">Add New Product</h6>
                    <p class="text-xs text-muted">Please fill in the product information below.</p>
                </div>

                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="create-product-form">
                        @csrf

                        <div class="row">
                            {{-- KOLOM KIRI: Image Upload (Drag & Drop Area) --}}
                            <div class="col-md-4 mb-4">
                                <div class="card bg-light border-radius-lg border-0 h-100">
                                    <div class="card-body text-center d-flex flex-column align-items-center justify-content-center">
                                        <h6 class="text-secondary text-sm mb-3">Product Image</h6>

                                        {{--
                                            DROP ZONE AREA
                                            Perbaikan: pointer-events-none pada anak elemen agar drop area stabil
                                        --}}
                                        <div id="drop-area" class="avatar avatar-xxl position-relative mb-3 border border-2 border-white shadow-sm"
                                             style="width: 150px; height: 150px; cursor: pointer; overflow: hidden; transition: all 0.3s ease;">

                                            {{-- Image Preview (Pointer events none agar tidak mengganggu drag) --}}
                                            <img id="img-preview" src="https://placehold.co/150x150/grey/white?text=Drop+Image"
                                                 alt="Preview" class="w-100 h-100 object-fit-cover rounded-circle" style="pointer-events: none;">

                                            {{-- Overlay Text --}}
                                            <div id="drop-overlay" class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark opacity-0"
                                                 style="transition: opacity 0.3s; pointer-events: none;">
                                                <span class="text-white font-weight-bold text-xs">Drop Here</span>
                                            </div>
                                        </div>

                                        {{-- Hidden File Input --}}
                                        <div class="small-upload-btn-wrapper">
                                            {{-- Onchange dipicu via JS --}}
                                            <input type="file" class="d-none" id="picture" name="picture" accept="image/*">
                                            <button type="button" class="btn btn-sm btn-outline-primary mb-0" onclick="document.getElementById('picture').click()">
                                                Choose Image
                                            </button>
                                        </div>
                                        <p class="text-xxs text-muted mt-2">Drag & Drop or Click. Allowed: JPG, PNG (Max 2MB)</p>

                                        @error('picture')
                                            <span class="text-danger text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- KOLOM KANAN: Form Inputs --}}
                            <div class="col-md-8">
                                <div class="row">
                                    {{-- Serial Number / SKU --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="serial_number" class="form-label text-xs font-weight-bold text-uppercase">Serial Number (SKU)</label>
                                        <input type="text" class="form-control @error('serial_number') is-invalid @enderror"
                                               id="serial_number" name="serial_number" value="{{ old('serial_number') }}"
                                               placeholder="Ex: KKA-001" maxlength="20" required>
                                        @error('serial_number')
                                            <div class="invalid-feedback text-xs">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Product Name --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label text-xs font-weight-bold text-uppercase">Product Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name') }}"
                                               placeholder="Ex: Kapal Api Coffee" required>
                                        @error('name')
                                            <div class="invalid-feedback text-xs">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Category --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="type" class="form-label text-xs font-weight-bold text-uppercase">Category</label>
                                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                            <option value="" disabled selected>Select Category</option>
                                            <option value="Food & Snacks" {{ old('type') == 'Food & Snacks' ? 'selected' : '' }}>Food & Snacks</option>
                                            <option value="Beverages" {{ old('type') == 'Beverages' ? 'selected' : '' }}>Beverages</option>
                                            <option value="Daily Essentials" {{ old('type') == 'Daily Essentials' ? 'selected' : '' }}>Daily Essentials</option>
                                            <option value="Electronics" {{ old('type') == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback text-xs">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Expiration Date --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="expiration_date" class="form-label text-xs font-weight-bold text-uppercase">Expiration Date</label>
                                        <input type="date" class="form-control @error('expiration_date') is-invalid @enderror"
                                               id="expiration_date" name="expiration_date" value="{{ old('expiration_date') }}">
                                        @error('expiration_date')
                                            <div class="invalid-feedback text-xs">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Price --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="price" class="form-label text-xs font-weight-bold text-uppercase">Price (IDR)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control @error('price') is-invalid @enderror"
                                                   id="price" name="price" value="{{ old('price') }}"
                                                   placeholder="0" min="0" required>
                                        </div>
                                        @error('price')
                                            <div class="text-danger text-xs mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Stock --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="stock" class="form-label text-xs font-weight-bold text-uppercase">Initial Stock</label>
                                        <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                               id="stock" name="stock" value="{{ old('stock') }}"
                                               placeholder="0" min="0" required>
                                        @error('stock')
                                            <div class="invalid-feedback text-xs">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="d-flex justify-content-end mt-4">
                                    <a href="#" onclick="confirmCancel(event)" class="btn btn-light m-0 me-2">Cancel</a>
                                    <button type="submit" class="btn bg-gradient-primary m-0">Save Product</button>
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

{{-- CSS KHUSUS --}}
<style>
    .drag-over {
        border-color: #cb0c9f !important;
        border-style: dashed !important;
        background-color: rgba(203, 12, 159, 0.05); /* Sedikit pink transparan */
        transform: scale(1.02);
    }
    .drag-over #drop-overlay {
        opacity: 0.8 !important;
    }
</style>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Pastikan script berjalan SETELAH halaman termuat
    document.addEventListener('DOMContentLoaded', function() {

        // ==========================================
        // 1. GLOBAL PREVENT DEFAULT (PENTING!)
        // ==========================================
        // Mencegah tab baru terbuka jika user meleset saat drop file
        window.addEventListener('dragover', function(e) {
            e.preventDefault();
        }, false);
        window.addEventListener('drop', function(e) {
            e.preventDefault();
        }, false);


        // ==========================================
        // 2. DRAG & DROP LOGIC
        // ==========================================
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('picture');
        const imgPreview = document.getElementById('img-preview');

        if (dropArea) {
            // Highlight saat drag masuk
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, () => {
                    dropArea.classList.add('drag-over');
                }, false);
            });

            // Hapus highlight saat drag keluar/drop
            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, () => {
                    dropArea.classList.remove('drag-over');
                }, false);
            });

            // Handle saat file dijatuhkan (DROP)
            dropArea.addEventListener('drop', handleDrop, false);

            // Handle saat diklik (Click to Upload)
            dropArea.addEventListener('click', () => fileInput.click());
        }

        // Listener untuk Input File manual (jika user klik tombol Choose Image)
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                previewImage(this);
            });
        }

        function handleDrop(e) {
            // Stop browser behavior asli
            e.preventDefault();
            e.stopPropagation();

            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length > 0) {
                // Validasi tipe file
                if (!files[0].type.startsWith('image/')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Salah',
                        text: 'Mohon upload file gambar (JPG/PNG).',
                        confirmButtonColor: '#344767'
                    });
                    return;
                }

                // Masukkan file ke input form
                fileInput.files = files;

                // Tampilkan preview
                previewImage(fileInput);
            }
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if(imgPreview) imgPreview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }


        // ==========================================
        // 3. FORM CONFIRMATION LOGIC
        // ==========================================
        const form = document.getElementById('create-product-form');
        if (form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Simpan Produk?',
                    text: "Pastikan data sudah benar.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#344767',
                    cancelButtonColor: '#82d616',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Cek Lagi'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        }
    });

    // Fungsi Global untuk tombol Cancel
    function confirmCancel(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Batalkan?',
            text: "Data yang sudah diketik akan hilang.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#344767',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Batalkan',
            cancelButtonText: 'Lanjut Isi'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('products.index') }}";
            }
        });
    }
</script>
@endsection
