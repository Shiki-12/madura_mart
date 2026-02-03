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

                            {{-- Gambar Ilustrasi --}}
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

                            {{-- Form Input --}}
                            <div class="col-md-7">
                                <div class="p-3">
                                    <form id="create-form" role="form" action="{{ route('distributors.store') }}" method="POST">
                                        @csrf

                                        {{-- INPUT NAME --}}
                                        <label>Name</label>
                                        <div class="mb-3">
                                            <input type="text" name="name" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Input Distributor's Name"
                                                value="{{ old('name') }}" required autocomplete="off">

                                            {{-- Container Error Realtime --}}
                                            <small id="name-error-msg" class="text-danger fw-bold" style="display:none;"></small>

                                            {{-- Error Laravel Bawaan (Backup) --}}
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- INPUT ADDRESS --}}
                                        <label>Address</label>
                                        <div class="mb-3">
                                            <textarea name="address" id="address"
                                                class="form-control @error('address') is-invalid @enderror"
                                                rows="4"
                                                placeholder="Input Distributor's Address"
                                                required>{{ old('address') }}</textarea>

                                            @error('address')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- INPUT PHONE NUMBER --}}
                                        <label>Phone Number</label>
                                        <div class="mb-3">
                                            <input type="text" name="phone_number" id="phone_number"
                                                class="form-control @error('phone_number') is-invalid @enderror"
                                                placeholder="Input Distributor's Phone Number"
                                                value="{{ old('phone_number') }}" required autocomplete="off">

                                            {{-- Container Error Realtime --}}
                                            <small id="phone-error-msg" class="text-danger fw-bold" style="display:none;"></small>

                                            @error('phone_number')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- BUTTONS --}}
                                        <div class="text-end">
                                            <a href="#" onclick="confirmCancel(event)" class="btn bg-gradient-light mt-4 mb-0">Cancel</a>
                                            {{-- ID submit-btn penting untuk JS --}}
                                            <button type="submit" id="submit-btn" class="btn bg-gradient-dark mt-4 mb-0">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
                            © <script>document.write(new Date().getFullYear())</script>,
                            made with <i class="fa fa-heart"></i> by Creative Tim.
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const nameInput = document.getElementById('name');
            const phoneInput = document.getElementById('phone_number');
            const submitBtn = document.getElementById('submit-btn');

            // Fungsi Validasi Server-Side via AJAX
            function validateField(inputElement, errorMsgElementId, dataField) {
                const value = inputElement.value.trim();
                const errorMsgElement = document.getElementById(errorMsgElementId);

                // Jika kosong, jangan cek ke server, tapi reset error
                if (value === '') {
                    resetError(inputElement, errorMsgElement);
                    checkSubmitButton();
                    return;
                }

                // Siapkan data untuk dikirim
                let bodyData = {};
                bodyData[dataField] = value;

                fetch("{{ route('distributors.check-unique') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(bodyData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        // KASUS: DATA DUPLIKAT
                        // 1. Kasih border merah
                        inputElement.classList.add('is-invalid');
                        // 2. Tampilkan pesan error
                        errorMsgElement.innerText = data.message;
                        errorMsgElement.style.display = 'block';
                        // 3. Matikan tombol submit
                        submitBtn.disabled = true;
                    } else {
                        // KASUS: DATA AMAN
                        resetError(inputElement, errorMsgElement);
                    }
                    // Cek status tombol setiap kali selesai validasi
                    checkSubmitButton();
                })
                .catch(error => console.error('Error:', error));
            }

            // Fungsi Hapus Error
            function resetError(input, msgElement) {
                input.classList.remove('is-invalid'); // Hapus border merah
                msgElement.style.display = 'none';      // Sembunyikan teks error
                msgElement.innerText = '';
            }

            // Fungsi Cek Apakah Tombol Boleh Nyala
            function checkSubmitButton() {
                // Tombol hanya nyala jika TIDAK ADA class 'is-invalid' di form
                const hasError = document.querySelectorAll('.is-invalid').length > 0;

                if (hasError) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }

            // EVENT LISTENER (BLUR = Saat user klik luar kolom / pindah kolom)
            nameInput.addEventListener('blur', function() {
                validateField(this, 'name-error-msg', 'name');
            });

            phoneInput.addEventListener('blur', function() {
                validateField(this, 'phone-error-msg', 'phone_number');
            });

            // Agar saat user mulai mengetik ulang, error hilang sementara (UX improvement)
            nameInput.addEventListener('input', function() {
                if(this.classList.contains('is-invalid')) {
                    resetError(this, document.getElementById('name-error-msg'));
                    checkSubmitButton();
                }
            });
            phoneInput.addEventListener('input', function() {
                if(this.classList.contains('is-invalid')) {
                    resetError(this, document.getElementById('phone-error-msg'));
                    checkSubmitButton();
                }
            });

            // --- FUNGSI SUBMIT (SWEETALERT) ---
            const form = document.getElementById('create-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                // Double check sebelum submit
                if (submitBtn.disabled) return;

                Swal.fire({
                    title: 'Save Data?',
                    text: "Are you sure the data is correct?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#344767',
                    cancelButtonColor: '#82d616',
                    confirmButtonText: 'Yes, Save!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        function confirmCancel(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "The data you entered will be lost!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#344767',
                confirmButtonText: 'Yes, cancel it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('distributors.index') }}";
                }
            });
        }
    </script>
@endsection
