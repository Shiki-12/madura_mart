@extends('layout.master')

@section('menu')
    @include('layout.menu')
@endsection

@section('distributor')
    {{-- Navbar dihapus karena sudah ada di Master Layout --}}

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Edit Distributor</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">

                        {{-- Menampilkan Error Validasi (Wajib ada agar user tahu jika input salah/duplikat dari controller) --}}
                        @if ($errors->any())
                            <div class="alert alert-danger mx-4 mt-3">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-white text-sm">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Form Start --}}
                        {{-- PENTING: Saya menambahkan id="edit-form" agar bisa dipanggil di JavaScript --}}
                        <form id="edit-form" action="{{ route('distributors.update', $distributor->id) }}" method="POST"
                            class="p-4">
                            @csrf
                            @method('PUT') {{-- Method PUT untuk Update data --}}

                            <div class="form-group">
                                <label for="name">Nama Distributor</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $distributor->name) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="address">Alamat</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address', $distributor->address) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="phone_number">Nomor Telepon</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number"
                                    value="{{ old('phone_number', $distributor->phone_number) }}" required>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                {{-- Tambahkan 'me-2' di sini untuk jarak ke kanan --}}
                                <a href="#" onclick="confirmCancel(event)"
                                    class="btn bg-gradient-light mt-4 mb-0 me-2">Batal</a>

                                <button type="submit" class="btn bg-gradient-dark mt-4 mb-0">Simpan Perubahan</button>
                            </div>
                        </form>
                        {{-- Form End --}}

                    </div>
                </div>
            </div>
        </div>

        <footer class="footer pt-3">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>,
                            made with <i class="fa fa-heart"></i> by
                            <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                            for a better web.
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    {{-- Script SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

    <script>
        // 1. Fungsi Konfirmasi Batal (Cancel)
        function confirmCancel(event) {
            event.preventDefault(); // Mencegah link langsung pindah halaman

            Swal.fire({
                title: 'Batalkan Edit?',
                text: "Perubahan yang belum disimpan akan hilang!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#344767', // Warna gelap (sesuai tema)
                cancelButtonColor: '#d33', // Warna merah
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke halaman index jika user klik Ya
                    window.location.href = "{{ route('distributors.index') }}";
                }
            });
        }

        // 2. Fungsi Konfirmasi Simpan (Submit Form)
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('edit-form'); // Pastikan ID sesuai dengan tag <form>

            if (form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // Tahan proses submit asli

                    Swal.fire({
                        title: 'Simpan Perubahan?',
                        text: "Pastikan data yang diubah sudah benar.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#344767', // Warna tombol konfirmasi
                        cancelButtonColor: '#82d616', // Warna tombol batal (hijau muda/sesuaikan)
                        confirmButtonText: 'Ya, Simpan!',
                        cancelButtonText: 'Cek Lagi'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Jika user klik Ya, baru form dikirim ke server
                            this.submit();
                        }
                    });
                });
            }
        });
    </script>
@endsection
