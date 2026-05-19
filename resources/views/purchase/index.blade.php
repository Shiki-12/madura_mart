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
                <a href="{{ route('purchase.create') }}" class="btn bg-gradient-warning mb-0">
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
                                <span class="input-group-text border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control border-start-0"
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
                    <table class="table table-hover admin-table align-middle mb-0">
                        <thead class="text-secondary admin-table-head">
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
                                           class="action-link action-link-view font-weight-bold text-xs me-2"
                                           data-bs-toggle="tooltip" title="View Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Tombol Edit --}}
                                        <button type="button"
                                            onclick="confirmPurchaseAction('edit', '{{ $purchase->id }}')"
                                            class="btn btn-link action-link action-link-edit font-weight-bold text-xs p-0 mb-0 me-2 border-0"
                                            data-bs-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('purchase.destroy', $purchase->id) }}" method="POST" class="d-inline"
                                            id="delete-form-{{ $purchase->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmPurchaseAction('delete', '{{ $purchase->id }}')"
                                               class="btn btn-link action-link action-link-delete font-weight-bold text-xs p-0 mb-0 border-0"
                                               data-bs-toggle="tooltip" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
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

            @if ($purchases->hasPages())
                <div class="card-footer border-0 d-flex justify-content-center pt-3 pb-3">
                    {{ $purchases->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                confirmButtonText: 'OK'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
                confirmButtonText: 'OK'
            });
        @endif

        async function confirmPurchaseAction(action, purchaseId) {
            const passwordResult = await Swal.fire({
                title: 'Password required!',
                text: 'Enter your account password to continue.',
                input: 'password',
                inputAttributes: {
                    autocomplete: 'current-password'
                },
                showCancelButton: true,
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                cancelButtonColor: '#344767',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Password is required.';
                    }
                }
            });

            if (!passwordResult.isConfirmed) {
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const confirmUrlTemplate = @json(route('purchase.confirm-password', ['purchase' => '__PURCHASE_ID__']));
            const confirmUrl = confirmUrlTemplate.replace('__PURCHASE_ID__', purchaseId);

            try {
                const response = await fetch(confirmUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        password: passwordResult.value,
                        action: action
                    })
                });

                const data = await response.json().catch(() => ({
                    message: 'Unable to confirm password.'
                }));

                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'Password is incorrect.');
                }

                await Swal.fire({
                    icon: 'success',
                    title: 'Nice!',
                    text: 'Your password is correct.',
                    timer: 900,
                    showConfirmButton: false
                });

                if (action === 'edit') {
                    const editConfirm = await Swal.fire({
                        icon: 'question',
                        title: 'Edit this purchase?',
                        text: 'Do you want to edit this purchase?',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, edit it',
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#f59e0b',
                        cancelButtonColor: '#344767'
                    });

                    if (editConfirm.isConfirmed) {
                        window.location.href = data.redirect;
                    }

                    return;
                }

                const deleteConfirm = await Swal.fire({
                    icon: 'warning',
                    title: 'Delete this purchase?',
                    text: 'This action will reverse the stock and cannot be undone.',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#344767'
                });

                if (deleteConfirm.isConfirmed) {
                    document.getElementById('delete-form-' + purchaseId).submit();
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Access denied',
                    text: error.message || 'Password is incorrect.',
                    confirmButtonText: 'OK'
                });
            }
        }
    </script>
@endsection
