@extends('layout.master')

@section('title', 'Belanja')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 font-weight-bold mb-0">Katalog Belanja</h2>
            <p class="text-muted small mb-0">Pilih produk, tambah ke keranjang, dan checkout</p>
        </div>
        <div>
            <button class="btn bg-gradient-warning mb-0 position-relative" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas" id="btnOpenCart">
                <i class="fas fa-shopping-cart me-1"></i> Keranjang
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartBadge" style="display:none;">0</span>
            </button>
        </div>
    </div>

    {{-- Filter --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form action="{{ route('shop.index') }}" method="GET">
                <div class="row g-3 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 bg-light"
                                placeholder="Cari produk..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-select form-select-sm bg-light" onchange="this.form.submit()">
                            <option value="all">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm bg-gradient-primary w-100 mb-0">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                    </div>
                    @if(request('search') || request('category'))
                        <div class="col-md-2">
                            <a href="{{ route('shop.index') }}" class="btn btn-sm btn-outline-secondary w-100 mb-0">Reset</a>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Product Grid --}}
    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm h-100 product-card">
                    <div class="position-relative overflow-hidden" style="border-radius: 0.75rem 0.75rem 0 0;">
                        @if($product->picture)
                            <img src="{{ asset('storage/' . $product->picture) }}"
                                class="card-img-top" alt="{{ $product->name }}"
                                style="height: 180px; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 180px;">
                                <i class="fas fa-box-open fa-3x text-secondary opacity-4"></i>
                            </div>
                        @endif
                        <span class="position-absolute top-0 end-0 m-2 badge bg-gradient-info text-xxs">{{ $product->type }}</span>
                    </div>
                    <div class="card-body p-3 d-flex flex-column">
                        <h6 class="font-weight-bold text-dark mb-1 text-sm">{{ $product->name }}</h6>
                        <p class="text-xs text-secondary mb-2">Stok: {{ $product->stock }} pcs</p>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="font-weight-bolder text-dark">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <button class="btn btn-sm bg-gradient-success mb-0 btn-add-cart"
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-price="{{ $product->price }}"
                                data-stock="{{ $product->stock }}"
                                data-img="{{ $product->picture ? asset('storage/' . $product->picture) : '' }}">
                                <i class="fas fa-plus me-1"></i> Tambah
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-store-slash fa-3x text-secondary opacity-5 mb-3"></i>
                <p class="text-secondary">Tidak ada produk yang tersedia saat ini.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($products->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $products->withQueryString()->links() }}
        </div>
    @endif
</div>

{{-- Cart Offcanvas --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" style="width: 420px;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title font-weight-bolder"><i class="fas fa-shopping-cart me-2 text-warning"></i>Keranjang Belanja</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0 d-flex flex-column" style="height: calc(100% - 62px);">
        {{-- Cart Items --}}
        <div class="flex-grow-1 overflow-auto p-3" id="cartItemsList">
            <div class="text-center py-5 text-secondary" id="cartEmpty">
                <i class="fas fa-shopping-basket fa-2x opacity-5 mb-2"></i>
                <p class="text-sm">Keranjang masih kosong</p>
            </div>
        </div>

        {{-- Cart Footer --}}
        <div class="border-top p-3 bg-light" id="cartFooter" style="display:none;">
            <div class="d-flex justify-content-between mb-3">
                <span class="font-weight-bold text-dark">Total:</span>
                <span class="font-weight-bolder text-dark text-lg" id="cartTotal">Rp 0</span>
            </div>
            <button class="btn bg-gradient-primary w-100 mb-0" data-bs-toggle="modal" data-bs-target="#checkoutModal" id="btnCheckout">
                <i class="fas fa-credit-card me-2"></i> Checkout
            </button>
        </div>
    </div>
</div>

{{-- Checkout Modal --}}
<div class="modal fade" id="checkoutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title font-weight-bolder"><i class="fas fa-file-invoice me-2 text-primary"></i>Checkout Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('shop.checkout') }}" method="POST" id="checkoutForm">
                @csrf
                <div class="modal-body">
                    {{-- Order Summary --}}
                    <div class="bg-light rounded-3 p-3 mb-3">
                        <p class="text-xs font-weight-bold text-uppercase text-secondary mb-2">Ringkasan Pesanan</p>
                        <div id="checkoutSummary"></div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between">
                            <span class="font-weight-bolder">Total</span>
                            <span class="font-weight-bolder text-primary" id="checkoutTotal">Rp 0</span>
                        </div>
                    </div>

                    {{-- Delivery Address --}}
                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold text-uppercase">Alamat Pengiriman <span class="text-danger">*</span></label>
                        <textarea name="delivery_address" class="form-control" rows="3"
                            placeholder="Masukkan alamat lengkap pengiriman..." required>{{ auth()->user()->address ?? '' }}</textarea>
                    </div>

                    {{-- Payment Method --}}
                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold text-uppercase">Metode Pembayaran <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="pmCod" value="cod" checked>
                                <label class="form-check-label text-sm font-weight-bold" for="pmCod">
                                    <i class="fas fa-money-bill-wave me-1 text-success"></i> COD (Bayar di Tempat)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="pmTransfer" value="transfer">
                                <label class="form-check-label text-sm font-weight-bold" for="pmTransfer">
                                    <i class="fas fa-university me-1 text-info"></i> Transfer
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div class="mb-0">
                        <label class="form-label text-xs font-weight-bold text-uppercase">Catatan (Opsional)</label>
                        <input type="text" name="notes" class="form-control" placeholder="Misal: Titip di depan pagar...">
                    </div>

                    {{-- Hidden Items --}}
                    <div id="checkoutHiddenItems"></div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn bg-gradient-success mb-0">
                        <i class="fas fa-paper-plane me-1"></i> Kirim Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .product-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 0.75rem !important;
    }
    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.12) !important;
    }
    .cart-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border-radius: 10px;
        background: #f8f9fa;
        margin-bottom: 10px;
    }
    .cart-item img {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        object-fit: cover;
    }
    .cart-item-placeholder {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cart-qty-control {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .cart-qty-control button {
        width: 26px;
        height: 26px;
        border-radius: 6px;
        border: 1px solid #dee2e6;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-weight: bold;
        font-size: 14px;
        transition: all 0.2s;
    }
    .cart-qty-control button:hover {
        background: #344767;
        color: #fff;
        border-color: #344767;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if (session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
    @endif
    @if (session('error'))
        Swal.fire({ icon: 'error', title: 'Oops!', text: "{{ session('error') }}", showConfirmButton: true });
    @endif

    // Cart state
    let cart = JSON.parse(localStorage.getItem('mm_cart') || '[]');

    function saveCart() {
        localStorage.setItem('mm_cart', JSON.stringify(cart));
        renderCart();
    }

    function formatRp(n) {
        return 'Rp ' + n.toLocaleString('id-ID');
    }

    function renderCart() {
        const list = document.getElementById('cartItemsList');
        const empty = document.getElementById('cartEmpty');
        const footer = document.getElementById('cartFooter');
        const badge = document.getElementById('cartBadge');

        if (cart.length === 0) {
            list.innerHTML = '<div class="text-center py-5 text-secondary" id="cartEmpty"><i class="fas fa-shopping-basket fa-2x opacity-5 mb-2"></i><p class="text-sm">Keranjang masih kosong</p></div>';
            footer.style.display = 'none';
            badge.style.display = 'none';
            return;
        }

        badge.style.display = '';
        badge.textContent = cart.reduce((s, i) => s + i.qty, 0);
        footer.style.display = '';

        let total = 0;
        let html = '';
        cart.forEach((item, idx) => {
            const sub = item.price * item.qty;
            total += sub;
            html += `
                <div class="cart-item">
                    ${item.img ? `<img src="${item.img}" alt="">` : '<div class="cart-item-placeholder"><i class="fas fa-box text-secondary"></i></div>'}
                    <div class="flex-grow-1">
                        <p class="text-sm font-weight-bold text-dark mb-0">${item.name}</p>
                        <p class="text-xs text-secondary mb-0">${formatRp(item.price)} × ${item.qty} = <strong>${formatRp(sub)}</strong></p>
                    </div>
                    <div class="cart-qty-control">
                        <button type="button" onclick="changeQty(${idx}, -1)">−</button>
                        <span class="text-sm font-weight-bold" style="min-width:20px;text-align:center;">${item.qty}</span>
                        <button type="button" onclick="changeQty(${idx}, 1)">+</button>
                    </div>
                    <button class="btn btn-link text-danger p-0 ms-1" onclick="removeItem(${idx})" style="font-size:14px;"><i class="fas fa-trash-alt"></i></button>
                </div>
            `;
        });
        list.innerHTML = html;
        document.getElementById('cartTotal').textContent = formatRp(total);
    }

    function changeQty(idx, delta) {
        cart[idx].qty += delta;
        if (cart[idx].qty > cart[idx].stock) {
            Swal.fire({ icon: 'warning', title: 'Stok Terbatas', text: `Stok "${cart[idx].name}" hanya ${cart[idx].stock} pcs.`, timer: 2000, showConfirmButton: false });
            cart[idx].qty = cart[idx].stock;
        }
        if (cart[idx].qty <= 0) cart.splice(idx, 1);
        saveCart();
    }

    function removeItem(idx) {
        cart.splice(idx, 1);
        saveCart();
    }

    // Add to cart buttons
    document.querySelectorAll('.btn-add-cart').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = parseInt(this.dataset.id);
            const name = this.dataset.name;
            const price = parseInt(this.dataset.price);
            const stock = parseInt(this.dataset.stock);
            const img = this.dataset.img;

            const existing = cart.find(i => i.id === id);
            if (existing) {
                if (existing.qty >= stock) {
                    Swal.fire({ icon: 'warning', title: 'Stok Terbatas', text: `Stok "${name}" hanya ${stock} pcs.`, timer: 2000, showConfirmButton: false });
                    return;
                }
                existing.qty++;
            } else {
                cart.push({ id, name, price, stock, img, qty: 1 });
            }
            saveCart();

            // Quick feedback animation
            const badge = document.getElementById('cartBadge');
            badge.classList.add('animate__animated', 'animate__rubberBand');
            setTimeout(() => badge.classList.remove('animate__animated', 'animate__rubberBand'), 600);

            Swal.fire({
                toast: true, position: 'top-end', icon: 'success',
                title: `${name} ditambahkan`, showConfirmButton: false, timer: 1200,
                customClass: { popup: 'colored-toast' }
            });
        });
    });

    // Populate checkout modal
    document.getElementById('btnCheckout')?.addEventListener('click', function() {
        const summary = document.getElementById('checkoutSummary');
        const hidden = document.getElementById('checkoutHiddenItems');
        let total = 0;
        let sHtml = '';
        let hHtml = '';

        cart.forEach((item, idx) => {
            const sub = item.price * item.qty;
            total += sub;
            sHtml += `<div class="d-flex justify-content-between text-sm mb-1">
                <span>${item.name} × ${item.qty}</span>
                <span class="font-weight-bold">${formatRp(sub)}</span>
            </div>`;
            hHtml += `<input type="hidden" name="items[${idx}][product_id]" value="${item.id}">`;
            hHtml += `<input type="hidden" name="items[${idx}][quantity]" value="${item.qty}">`;
        });

        summary.innerHTML = sHtml;
        hidden.innerHTML = hHtml;
        document.getElementById('checkoutTotal').textContent = formatRp(total);
    });

    // Clear cart on successful checkout
    @if(session('success'))
        localStorage.removeItem('mm_cart');
        cart = [];
    @endif

    renderCart();
</script>
@endsection
