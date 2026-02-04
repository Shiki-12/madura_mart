@extends('layout.master')

@section('title', 'Products')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
<div class="container-fluid py-4">

    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 font-weight-bold mb-0">Products</h2>
            <p class="text-muted small mb-0">Manage your product catalog and inventory</p>
        </div>
        <div>
            <a href="{{ route('products.create') }}" class="btn bg-gradient-dark mb-0">
                <i class="fas fa-plus me-1"></i> Add New Products
            </a>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form action="{{ route('products.index') }}" method="GET">
                <div class="row g-3">
                    {{-- Search --}}
                    <div class="col-md-4">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 bg-light"
                                   placeholder="Search product name, SKU..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>

                    {{-- Category --}}
                    <div class="col-md-3">
                        <select name="category" class="form-select form-select-sm bg-light" onchange="this.form.submit()">
                            <option value="All Categories">All Categories</option>
                            <option value="Food & Snacks" {{ request('category') == 'Food & Snacks' ? 'selected' : '' }}>Food & Snacks</option>
                            <option value="Beverages" {{ request('category') == 'Beverages' ? 'selected' : '' }}>Beverages</option>
                            <option value="Daily Essentials" {{ request('category') == 'Daily Essentials' ? 'selected' : '' }}>Daily Essentials</option>
                            <option value="Electronics" {{ request('category') == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-3">
                        <select name="status" class="form-select form-select-sm bg-light" onchange="this.form.submit()">
                            <option value="All Status">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>

                    {{-- Reset Button --}}
                    @if(request('search') || request('category') != 'All Categories' || request('status') != 'All Status')
                    <div class="col-md-2">
                        <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary w-100 mb-0">Reset</a>
                    </div>
                    @endif
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
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Details</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stock</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $index => $product)
                            <tr>
                                <td class="ps-4 text-secondary text-xs font-weight-bold">
                                    {{ $products->firstItem() + $index }}
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            @if($product->picture)
                                                <img src="{{ asset('storage/' . $product->picture) }}"
                                                     class="avatar avatar-sm me-3 rounded"
                                                     alt="{{ $product->name }}"
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <img src="https://placehold.co/100x100/grey/white?text=No+Img"
                                                     class="avatar avatar-sm me-3 rounded"
                                                     alt="No Image">
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm font-weight-bold">{{ $product->name }}</h6>
                                            <p class="text-xs text-secondary mb-0">SKU: {{ $product->serial_number }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="text-xs font-weight-bold text-secondary">{{ $product->type }}</span></td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="badge {{ $product->stock > 10 ? 'bg-info' : 'bg-warning' }} text-dark text-xs">
                                        {{ $product->stock }} Pcs
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    {{-- LOGIKA BADGE STATUS --}}
                                    @if(!$product->is_active)
                                        <span class="badge bg-secondary text-xs">Inactive</span>
                                    @elseif($product->stock <= 0)
                                        <span class="badge bg-danger text-xs">Out of Stock</span>
                                    @else
                                        <span class="badge bg-success text-xs">Active</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('products.edit', $product->id) }}"
                                       class="text-secondary font-weight-bold text-xs me-2"
                                       data-bs-toggle="tooltip" title="Edit product">
                                        <i class="fas fa-edit text-info"></i>
                                    </a>

                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" id="delete-form-{{ $product->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <a href="#" onclick="confirmDelete(event, '{{ $product->id }}', '{{ $product->name }}')"
                                           class="text-secondary font-weight-bold text-xs"
                                           data-bs-toggle="tooltip" title="Delete product">
                                            <i class="fas fa-trash text-danger"></i>
                                        </a>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <p class="text-sm text-secondary mb-0">Product not found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white border-top-0 d-flex justify-content-end py-3">
            {{ $products->links() }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    function confirmDelete(event, id, name) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Produk?',
            text: "Data '" + name + "' akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#344767',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
