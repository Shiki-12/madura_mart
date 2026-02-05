@extends('layout.master')

@section('title', 'Dashboard')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
    <div class="container-fluid py-4">

        {{-- BARIS 1: KARTU STATISTIK (TETAP) --}}
        <div class="row">
            {{-- Card 1: Omzet Hari Ini --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Today's Sales</p>
                                    <h5 class="font-weight-bolder mb-0 text-success">
                                        Rp {{ number_format($todaySales, 0, ',', '.') }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                    <i class="fas fa-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 2: Pengeluaran Hari Ini --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Today's Expense</p>
                                    <h5 class="font-weight-bolder mb-0 text-danger">
                                        Rp {{ number_format($todayPurchases, 0, ',', '.') }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                                    <i class="fas fa-shopping-cart text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 3: Cash Flow Hari Ini --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Daily Net Flow</p>
                                    <h5
                                        class="font-weight-bolder mb-0 {{ $todayProfit >= 0 ? 'text-primary' : 'text-warning' }}">
                                        {{ $todayProfit >= 0 ? '+' : '' }} Rp
                                        {{ number_format($todayProfit, 0, ',', '.') }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="fas fa-wallet text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 4: Total Produk --}}
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Products</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $totalProducts }} Items
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                    <i class="fas fa-box-open text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BARIS 2: TABEL PERINGATAN & HISTORY --}}
        <div class="row mt-4">
            {{-- Kolom Kiri: Peringatan Stok Menipis --}}
            <div class="col-lg-7 mb-lg-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-2 text-danger font-weight-bold">
                                <i class="fas fa-exclamation-triangle me-2"></i> Low Stock Alert (Below 5)
                            </h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Category</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Remaining Stock</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowStockProducts as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $product->name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $product->serial_number }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-xs font-weight-bold">{{ $product->type }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-danger">{{ $product->stock }}
                                                Pcs</span>
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('purchase.create') }}"
                                                class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                                data-original-title="Restock">
                                                Restock
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <i class="fas fa-check-circle text-success fa-2x mb-2"></i>
                                            <p class="text-sm text-muted mb-0">All stock levels are safe.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Transaksi Terakhir --}}
            <div class="col-lg-5">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Recent Sales</h6>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            @forelse($recentSales as $sale)
                                <li
                                    class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center">
                                        <button
                                            class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center">
                                            <i class="fas fa-shopping-bag"></i>
                                        </button>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark text-sm">Sale #{{ $sale->id }}</h6>
                                            <span class="text-xs">{{ $sale->created_at->diffForHumans() }} by
                                                {{ $sale->user->name ?? 'User' }}</span>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                        + Rp {{ number_format($sale->total_price, 0, ',', '.') }}
                                    </div>
                                </li>
                            @empty
                                <p class="text-sm text-center text-muted mt-3">No transactions today.</p>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- BARIS 3: CARD TAMBAHAN (QUICK ACTIONS & SYSTEM INFO) --}}
        <div class="row mt-4">
            {{-- Quick Actions --}}
            <div class="col-lg-8 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <h6 class="mb-0">Quick Actions</h6>
                        <p class="text-sm mb-0 text-secondary">Shortcuts for daily operations</p>
                    </div>
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('sales.create') }}"
                                    class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                    <i class="fas fa-cash-register fa-2x mb-2"></i>
                                    <span>Cashier</span>
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('products.create') }}"
                                    class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                    <i class="fas fa-box fa-2x mb-2"></i>
                                    <span>Add Product</span>
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('purchase.create') }}"
                                    class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                    <i class="fas fa-truck-loading fa-2x mb-2"></i>
                                    <span>Restock</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- System Info --}}
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <h6 class="mb-0">System Info</h6>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <i class="fab fa-laravel text-lg text-danger me-3"></i>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Laravel Version</h6>
                                        <span class="text-xs">Framework Core</span>
                                    </div>
                                </div>
                                <span
                                    class="text-dark font-weight-bold text-sm">v{{ Illuminate\Foundation\Application::VERSION }}</span>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <i class="fab fa-php text-lg text-primary me-3"></i>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">PHP Version</h6>
                                        <span class="text-xs">Server Side</span>
                                    </div>
                                </div>
                                <span class="text-dark font-weight-bold text-sm">v{{ PHP_VERSION }}</span>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-database text-lg text-warning me-3"></i>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Database</h6>
                                        <span class="text-xs">Madura Mart</span>
                                    </div>
                                </div>
                                <span class="badge bg-gradient-success">Connected</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- BARIS 4: SYSTEM OVERVIEW / FOOTER CARD (YANG DIPERBAIKI) --}}
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 overflow-hidden"> {{-- Tambahkan overflow-hidden biar rounded corner rapi --}}
                    <div class="card-body p-0"> {{-- Padding 0 agar gambar full --}}
                        <div class="row g-0"> {{-- g-0 untuk menghilangkan gutter/jarak antar kolom --}}

                            {{-- KOLOM KIRI: TEKS --}}
                            <div class="col-lg-7 p-4">
                                <div class="d-flex flex-column h-100 justify-content-center">
                                    <p class="mb-1 pt-2 text-bold text-success text-uppercase">Point of Sales System</p>
                                    <h3 class="font-weight-bolder">Madura Mart Management</h3>
                                    <p class="mb-4 text-secondary">
                                        Sistem manajemen ritel terintegrasi yang dirancang untuk efisiensi bisnis Anda.
                                        Kelola stok (Inventory), pantau penjualan harian, dan analisis keuntungan secara
                                        real-time.
                                    </p>
                                    <div>
                                        <a class="btn bg-gradient-success mb-0" href="https://github.com/shiki-12/madura_mart" target="_blank">
                                            <i class="fas fa-book-reader me-2"></i> Read Guide
                                        </a>
                                        <a class="btn btn-outline-success mb-0 ms-2" href="https://mail.google.com/mail/?view=cm&fs=1&to=uknowndonp@gmail.com" target="_blank">
                                            Contact Support
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- KOLOM KANAN: GAMBAR BACKGROUND (Fix CSS) --}}
                            <div class="col-lg-5">
                                <div class="h-100 bg-cover"
                                    style="
                                        background-image: url('{{ asset('images/banner_dashboard.jpg') }}'); 
                                        background-size: cover; 
                                        background-position: center; 
                                        min-height: 300px;
                                        position: relative;
                                     ">
                                    {{-- Overlay Gelap (Opsional, agar tulisan di atas gambar terbaca jika ada) --}}
                                    <div class="mask bg-gradient-dark opacity-2"></div>

                                    <div
                                        class="d-flex flex-column align-items-center justify-content-center h-100 position-relative z-index-2 text-white p-3 text-center">
                                        <i class="fas fa-store fa-3x mb-3 text-white"></i>
                                        <h4 class="text-white font-weight-bolder">Toko Serba Ada</h4>
                                        <p class="text-white text-sm opacity-8 mb-0">
                                            "Kepuasan Pelanggan adalah Prioritas Kami."
                                        </p>
                                        <span class="badge bg-white text-dark mt-3">v1.0.0 Stable</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
