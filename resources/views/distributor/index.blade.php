@extends('layout.master')

@section('menu')
    @include('layout.menu')
@endsection

@section('distributor')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-4 mt-3" role="alert">
            <span class="alert-icon"><i class="ni ni-like-2"></i></span>
            <span class="alert-text"><strong>Success!</strong> {{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mx-4 mt-3" role="alert">
            <span class="alert-icon"><i class="ni ni-support-16"></i></span>
            <span class="alert-text"><strong>Error!</strong> {{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>{{ $title }} table</h6>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No.
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Distributor Name
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Address
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Phone Number
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($distributors as $no => $item)
                                        <tr>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $no + 1 }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $item->name }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $item->address }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $item->phone_number }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex justify-content-center align-items-center gap-2">
                                                    {{-- Tombol Edit --}}
                                                    <a href="{{ route('distributors.edit', $item->id) }}"
                                                        class="btn btn-link text-warning text-gradient px-3 mb-0 confirm-edit"
                                                        data-bs-toggle="tooltip" data-bs-title="Edit Data">
                                                        <i class="ni ni-ruler-pencil me-2"></i>Edit
                                                    </a>

                                                    {{-- Tombol Delete --}}
                                                    <form action="{{ route('distributors.destroy', $item->id) }}"
                                                        method="POST" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-link text-danger text-gradient px-3 mb-0 btn-delete"
                                                            data-bs-toggle="tooltip" data-bs-title="Hapus Data">
                                                            <i class="ni ni-fat-remove me-2"></i>Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="px-4 py-3 text-end">
                            <a class="btn bg-gradient-dark mb-0" id="btn-add-distributor"
                                href="{{ route('distributors.create') }}">
                                <i class="fas fa-plus"></i>&nbsp;&nbsp;Add New Distributor
                            </a>
                        </div>
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
                            <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative
                                Tim</a>
                            for a better web.
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com" class="nav-link text-muted"
                                    target="_blank">Creative Tim</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted"
                                    target="_blank">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/blog" class="nav-link text-muted"
                                    target="_blank">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted"
                                    target="_blank">License</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <style>
        .dropdown-item {
            cursor: pointer;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .dropdown-item.text-danger:hover {
            background-color: rgba(255, 0, 0, 0.1);
        }

        .dropdown-item button {
            background: none;
            border: none;
            padding: 0;
            width: 100%;
        }

        .badge-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.7rem;
        }
    </style>

    <!-- SweetAlert2 Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Logika untuk Tombol Delete ---
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data distributor ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#344767', // Warna merah khas 'danger'
                        cancelButtonColor: '#82d616', // Warna hijau khas 'success'
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Eksekusi penghapusan jika dikonfirmasi
                        }
                    });
                });
            });

            // --- Logika untuk Tombol Edit (Jika diperlukan) ---
            const editLinks = document.querySelectorAll('.confirm-edit');

            editLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault(); // Hentikan navigasi langsung
                    const url = this.getAttribute('href');

                    Swal.fire({
                        title: 'Edit Data?',
                        text: "Anda akan diarahkan ke halaman pengubahan data.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#344767',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Lanjutkan',
                        cancelButtonText: 'Kembali'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = url;
                        }
                    });
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnAdd = document.getElementById('btn-add-distributor');

            if (btnAdd) {
                btnAdd.addEventListener('click', function(e) {
                    e.preventDefault(); // Menahan link agar tidak langsung pindah halaman
                    const targetUrl = this.getAttribute('href');

                    Swal.fire({
                        title: 'Tambah Distributor Baru?',
                        text: "Anda akan diarahkan ke formulir pengisian data distributor.",
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#344767', // Warna gelap sesuai tema gradient-dark
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Lanjutkan',
                        cancelButtonText: 'Batal',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = targetUrl; // Navigasi manual jika klik 'Ya'
                        }
                    });
                });
            }
        });
    </script>
@endsection
