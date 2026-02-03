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

                        {{-- 1. Menampilkan Error Validasi (Laravel Validation) --}}
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
                        <form id="edit-form" action="{{ route('distributors.update', $distributor->id) }}" method="POST"
                            class="p-4">
                            @csrf
                            @method('PUT')

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // ==========================================================
        // LOGIKA 1: MENANGKAP SESSION ERROR DARI CONTROLLER
        // (Jika user klik simpan tapi tidak mengubah apa-apa)
        // ==========================================================
        @if(session('error'))
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Tidak Ada Perubahan',
                    text: "{{ session('error') }}", // Pesan: "Tidak ada perubahan data yang dilakukan."
                    icon: 'info', // Pakai icon info agar lebih sopan daripada error
                    showCancelButton: true,
                    confirmButtonColor: '#344767',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Edit Lagi',
                    cancelButtonText: 'Batalkan Edit (Kembali)'
                }).then((result) => {
                    // Jika user memilih tombol Cancel (Batalkan Edit),
                    // Kita anggap mereka memang tidak jadi mengedit, langsung lempar ke Index.
                    if (result.dismiss === Swal.DismissReason.cancel) {
                        window.location.href = "{{ route('distributors.index') }}";
                    }
                });
            });
        @endif

        // ==========================================================
        // LOGIKA 2: KONFIRMASI TOMBOL BATAL MANUAL
        // ==========================================================
        function confirmCancel(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Batalkan Edit?',
                text: "Perubahan yang belum disimpan akan hilang!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#344767',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('distributors.index') }}";
                }
            });
        }

        // ==========================================================
        // LOGIKA 3: KONFIRMASI SAAT KLIK TOMBOL SIMPAN
        // ==========================================================
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('edit-form');

            if (form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // Tahan dulu, jangan langsung submit

                    // Ambil nilai input saat ini untuk cek sederhana (Optional, tapi controller sudah handle)
                    // Kita serahkan validasi berat ke Backend, di sini konfirmasi saja.

                    Swal.fire({
                        title: 'Simpan Perubahan?',
                        text: "Pastikan data sudah benar.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#344767',
                        cancelButtonColor: '#82d616',
                        confirmButtonText: 'Ya, Simpan!',
                        cancelButtonText: 'Cek Lagi'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit(); // Kirim form ke controller
                        }
                    });
                });
            }
        });
    </script>
@endsection
