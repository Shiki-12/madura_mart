@extends('layout.master')
@section('menu')
    @include('layout.menu')
@endsection
@section('distributor')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>{{ $title }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">

                            <div class="col-md-5 text-center mb-4 mb-md-0">
                                <div class="position-relative">
                                    <img src="{{ asset('images/makise.png') }}"
                                         alt="Illustration"
                                         class="img-fluid border-radius-lg shadow-sm"
                                         style="max-height: 450px; width: 100%; object-fit: cover;">

                                    <div class="mt-3 text-sm text-muted">
                                        <em>Makise Kurisu 🎶</em>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="p-3">
                                    <form id="create-form" role="form" action="{{ route('distributors.store') }}" method="POST">
                                        @csrf
                                        <label>Name</label>
                                        <div class="mb-3">
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Input Distributor's Name" aria-label="Name" required>
                                        </div>

                                        <label>Address</label>
                                        <div class="mb-3">
                                            <textarea name="address" class="form-control" rows="4"
                                                placeholder="Input Distributor's Address" aria-label="Address"
                                                required></textarea>
                                        </div>

                                        <label>Phone Number</label>
                                        <div class="mb-3">
                                            <input type="text" name="phone_number" class="form-control"
                                                placeholder="Input Distributor's Phone Number" aria-label="PhoneNumber"
                                                required>
                                        </div>

                                        <div class="text-end">
                                            <a href="#" onclick="confirmCancel(event)"
                                                class="btn bg-gradient-light mt-4 mb-0">Cancel</a>

                                            <button type="submit" class="btn bg-gradient-dark mt-4 mb-0">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer pt-3  ">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            © <script>document.write(new Date().getFullYear())</script>,
                            made with <i class="fa fa-heart"></i> by
                            <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                            for a better web.
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

    <script>
        function confirmCancel(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang sudah diisi akan hilang!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#344767',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, batalkan!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('distributors.index') }}";
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('create-form');
            if (form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Simpan Data?',
                        text: "Pastikan data yang diinput sudah benar.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#344767',
                        cancelButtonColor: '#82d616',
                        confirmButtonText: 'Ya, Simpan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            }
        });
    </script>
@endsection
