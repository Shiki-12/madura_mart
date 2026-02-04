@extends('layout.master')

@section('title', 'Purchases')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
    <div class="container-fluid py-4">

        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 font-weight-bold mb-0">Purchases</h2>
                <p class="text-muted small mb-0">Manage incoming goods and distributor invoices</p>
            </div>
            <div>
                <a href="{{ route('purchase.create') }}" class="btn bg-gradient-dark mb-0">
                    <i class="fas fa-plus me-1"></i> New Purchase
                </a>
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-3">
                <form action="{{ route('purchase.index') }}" method="GET">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control border-start-0 bg-light"
                                    placeholder="Search Note Number..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            @if(request('search'))
                                <a href="{{ route('purchase.index') }}" class="btn btn-sm btn-outline-secondary w-100 mb-0">Reset</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th class="ps-4 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="5%">#</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Note Number</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Distributor</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Price</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchases as $index => $purchase)
                                <tr>
                                    <td class="ps-4 text-secondary text-xs font-weight-bold">
                                        {{ $purchases->firstItem() + $index }}
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            {{-- Ganti Gambar Produk dengan Icon Invoice agar tidak Error --}}
                                            <div class="avatar avatar-sm me-3 bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="fas fa-file-invoice text-white"></i>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm font-weight-bold text-primary">
                                                    {{ $purchase->note_number }}
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ $purchase->purchase_date->format('d M Y') }}
                                        </p>
                                    </td>
                                    <td>
                                        @if($purchase->distributor)
                                            <span class="text-xs font-weight-bold text-dark">
                                                <i class="fas fa-building me-1 text-secondary"></i>
                                                {{ $purchase->distributor->name }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary text-xxs">General / No Distributor</span>
                                        @endif
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0 text-success">
                                            Rp {{ number_format($purchase->total_price, 0, ',', '.') }}
                                        </p>
                                    </td>
                                    <td class="align-middle text-center">
                                        {{-- Tombol Detail (FIXED ROUTE) --}}
                                        <a href="{{ route('purchase.show', $purchase->id) }}"
                                           class="text-secondary font-weight-bold text-xs me-2"
                                           data-bs-toggle="tooltip" title="View Detail">
                                            <i class="fas fa-eye text-info"></i>
                                        </a>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('purchase.destroy', $purchase->id) }}" method="POST" class="d-inline"
                                            id="delete-form-{{ $purchase->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <a href="#" onclick="confirmDelete(event, '{{ $purchase->id }}', '{{ $purchase->note_number }}')"
                                               class="text-secondary font-weight-bold text-xs"
                                               data-bs-toggle="tooltip" title="Delete">
                                                <i class="fas fa-trash text-danger"></i>
                                            </a>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <i class="fas fa-shopping-cart fa-3x text-secondary mb-3 opacity-5"></i>
                                            <p class="text-sm text-secondary mb-0">No purchase history found.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-white border-top-0 d-flex justify-content-end py-3">
                {{ $purchases->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        function confirmDelete(event, id, note) {
            event.preventDefault();
            Swal.fire({
                title: 'Delete Purchase?',
                text: "Deleting purchase note '" + note + "' will also remove its items history.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#344767',
                confirmButtonText: 'Yes, Delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
