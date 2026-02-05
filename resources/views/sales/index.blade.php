@extends('layout.master')

@section('title', 'Sales History')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
    <div class="container-fluid py-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 font-weight-bold mb-0">Sales (Point of Sale)</h2>
                <p class="text-muted small mb-0">History of transactions processed by cashiers.</p>
            </div>
            <div>
                <a href="{{ route('sales.create') }}" class="btn bg-gradient-success mb-0">
                    <i class="fas fa-cash-register me-1"></i> New Transaction
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th class="ps-4 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cashier</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $sale)
                                <tr>
                                    <td class="ps-4 text-secondary text-xs font-weight-bold">#{{ $sale->id }}</td>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center">
                                            <span class="text-dark text-sm font-weight-bold">{{ $sale->sale_date->format('d M Y') }}</span>
                                            <span class="text-secondary text-xs">{{ $sale->created_at->format('H:i A') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs me-2 bg-gradient-secondary rounded-circle">
                                                <span class="text-white text-xxs">{{ substr($sale->user->name ?? 'U', 0, 1) }}</span>
                                            </div>
                                            <span class="text-xs font-weight-bold">{{ $sale->user->name ?? 'Unknown' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-success text-sm font-weight-bolder">
                                            Rp {{ number_format($sale->total_price, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-link text-info text-gradient px-3 mb-0">
                                            <i class="fas fa-eye me-2"></i> View
                                        </a>
                                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline" id="void-form-{{ $sale->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmVoid({{ $sale->id }})" class="btn btn-link text-danger text-gradient px-3 mb-0">
                                                <i class="fas fa-ban me-2"></i> Void
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">No sales transactions yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-top-0 d-flex justify-content-end py-3">
                {{ $sales->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Success!', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
        @endif

        function confirmVoid(id) {
            Swal.fire({
                title: 'Void Transaction?',
                text: "Stock will be returned (refunded). This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, Void & Refund',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('void-form-' + id).submit();
                }
            });
        }
    </script>
@endsection