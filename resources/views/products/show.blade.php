@extends('layout.master')

@section('title', 'Product Detail')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
<div class="container-fluid py-4">
    {{-- Tombol Back --}}
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary mb-0">
                <i class="fas fa-arrow-left me-2"></i> Back to List
            </a>
        </div>
    </div>

    <div class="row">
        {{-- KOLOM KIRI: Gambar Produk Besar --}}
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-2 d-flex align-items-center justify-content-center bg-light rounded-3" style="min-height: 400px;">
                    @if($product->picture)
                        <img src="{{ asset('storage/' . $product->picture) }}" 
                             alt="{{ $product->name }}" 
                             class="img-fluid rounded-3 shadow-sm" 
                             style="max-height: 400px; width: 100%; object-fit: cover;">
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-box-open fa-4x mb-3 opacity-5"></i>
                            <p class="mb-0 font-weight-bold">No Image Available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: Informasi Detail --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom pb-0">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="badge bg-gradient-info mb-2">{{ $product->type }}</span>
                            <h3 class="font-weight-bolder text-dark mb-1">{{ $product->name }}</h3>
                            <p class="text-sm text-muted mb-0">SKU: {{ $product->serial_number }}</p>
                        </div>
                        <div class="text-end">
                            @if(!$product->is_active)
                                <span class="badge bg-secondary">Inactive</span>
                            @elseif($product->stock <= 0)
                                <span class="badge bg-danger">Out of Stock</span>
                            @else
                                <span class="badge bg-success">Active</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Harga & Stok --}}
                    <div class="d-flex align-items-center mb-4">
                        <h2 class="font-weight-bold text-primary mb-0 me-4">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </h2>
                        <div class="border-start ps-4">
                            <p class="text-xs text-muted font-weight-bold mb-0 text-uppercase">Current Stock</p>
                            <h5 class="mb-0 text-dark">{{ $product->stock }} <small class="text-sm text-muted">pcs</small></h5>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <h6 class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Description</h6>
                        <p class="text-sm text-dark opacity-8">
                            {{ $product->description ?? 'No description provided for this product.' }}
                        </p>
                    </div>

                    <hr class="horizontal dark my-4">

                    {{-- Informasi Tambahan (Grid) --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-building text-dark opacity-6"></i>
                                </div>
                                <div>
                                    <p class="text-xs mb-0 text-secondary font-weight-bold">Distributor</p>
                                    <h6 class="text-sm font-weight-bolder mb-0">
                                        {{ $product->distributor ? $product->distributor->name : 'Unknown Distributor' }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-calendar-alt text-dark opacity-6"></i>
                                </div>
                                <div>
                                    <p class="text-xs mb-0 text-secondary font-weight-bold">Expiration Date</p>
                                    <h6 class="text-sm font-weight-bolder mb-0">
                                        {{ $product->expiration_date ? $product->expiration_date->format('d M Y') : 'N/A' }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top pt-3 text-end">
                    <a href="{{ route('products.edit', $product->id) }}" class="btn bg-gradient-dark mb-0">
                        <i class="fas fa-edit me-1"></i> Edit Product
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection