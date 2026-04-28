<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Belanja kebutuhan harian di Madura Mart — harga merakyat, belanja mudah.">
    <title>Belanja — Madura Mart</title>
    <link rel="icon" type="image/png" href="{{ asset('images/pfp_mizuki.jpeg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/madura-mart.css') }}">
</head>
<body class="mm-public">

    {{-- TOAST NOTIFICATIONS --}}
    <div class="mm-toast-container">
        @if(session('error'))
            <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif
        @if(session('success'))
            <div class="toast align-items-center text-bg-success border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif
    </div>

    {{-- NAVBAR --}}
    <nav class="mm-navbar mm-navbar-solid" id="mainNavbar">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <a href="{{ url('/') }}" class="navbar-brand">
                    <img src="{{ asset('images/pfp_mizuki.jpeg') }}" alt="Madura Mart">
                    Madura Mart
                </a>
                <div class="mm-nav-links-wrap d-none d-lg-flex">
                    <ul class="mm-nav-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li class="mm-explore-dropdown">
                            <a href="#" class="mm-explore-toggle">Explore <i class="fas fa-chevron-down mm-explore-arrow"></i></a>
                            <ul class="mm-explore-menu">
                                <li><a href="{{ url('/') }}"><i class="fas fa-door-open mm-explore-icon"></i> Welcome</a></li>
                                <li><a href="{{ url('/mizuki') }}"><i class="fas fa-user-astronaut mm-explore-icon"></i> Mizuki</a></li>
                                <li><a href="{{ url('/lagu') }}"><i class="fas fa-music mm-explore-icon"></i> Lagu</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ route('shop.index') }}" class="mm-nav-active">Belanja</a></li>
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 mm-profile-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if(auth()->user()->picture)
                                        <img src="{{ asset('storage/' . auth()->user()->picture) }}" alt="Avatar" class="rounded-circle mm-nav-avatar">
                                    @else
                                        <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center text-dark mm-nav-avatar-placeholder">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                    {{ auth()->user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 rounded-3">
                                    <li class="px-3 py-2 text-muted small d-flex align-items-center gap-2 border-bottom mb-1">
                                        <span class="badge mm-badge-primary">{{ ucfirst(auth()->user()->role) }}</span>
                                    </li>
                                    <li><a class="dropdown-item py-2" href="{{ route('profile') }}"><i class="fas fa-user-circle me-2 text-muted"></i> Profil Saya</a></li>
                                    @if(auth()->user()->role !== 'customer')
                                        <li><a class="dropdown-item py-2" href="{{ route('dashboard.index') }}"><i class="fas fa-chart-line me-2 text-muted"></i> Dashboard Admin</a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger py-2"><i class="fas fa-sign-out-alt me-2"></i> Keluar</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}" class="mm-nav-cta">
                                    <i class="fas fa-sign-in-alt mm-icon-md"></i> Masuk
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
                <button class="mm-nav-toggle d-lg-none" id="navToggle" aria-label="Toggle navigation">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </nav>

    {{-- MOBILE NAV --}}
    <div class="mm-mobile-nav" id="mobileNav">
        <button class="mm-mobile-close" id="mobileNavClose">&times;</button>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ url('/') }}">Welcome</a>
        <a href="{{ url('/mizuki') }}">Mizuki</a>
        <a href="{{ url('/lagu') }}">Lagu</a>
        <a href="{{ route('shop.index') }}">Belanja</a>
        @auth
            <form action="{{ route('logout') }}" method="POST" class="w-100 text-center mt-3">
                @csrf
                <button type="submit" class="btn btn-danger w-75 rounded-pill"><i class="fas fa-sign-out-alt me-2"></i> Keluar</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="mm-nav-login-link">Masuk</a>
            <a href="{{ route('register') }}">Daftar</a>
        @endauth
    </div>

    {{-- SHOP HERO --}}
    <section class="mm-shop-hero">
        <div class="container mm-shop-hero-content">
            <span class="mm-section-label mm-shop-hero-label">
                <i class="fas fa-store mm-icon-primary"></i> Katalog Belanja
            </span>
            <h1>Temukan Kebutuhan Anda</h1>
            <p>Pilih produk, tambah ke keranjang, dan checkout — semudah itu.</p>
        </div>
    </section>

    {{-- FILTER BAR --}}
    <div class="container">
        <div class="mm-filter-bar">
            <form action="{{ route('shop.index') }}" method="GET">
                <div class="row g-3 align-items-center">
                    <div class="col-md-5">
                        <div class="position-relative">
                            <i class="fas fa-search mm-search-icon"></i>
                            <input type="text" name="search" class="mm-search-input" placeholder="Cari produk..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="mm-select w-100" onchange="this.form.submit()">
                            <option value="all">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="mm-filter-btn w-100">
                            <i class="fas fa-filter mm-icon-sm"></i> Filter
                        </button>
                    </div>
                    @if(request('search') || request('category'))
                        <div class="col-md-2">
                            <a href="{{ route('shop.index') }}" class="mm-filter-reset w-100">Reset</a>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- PRODUCT GRID --}}
    <section class="mm-products-section">
        <div class="container">
            <div class="row g-4">
                @forelse($products as $product)
                    <div class="col-xl-3 col-lg-4 col-md-6 reveal reveal-delay-{{ ($loop->index % 4) + 1 }}">
                        <div class="mm-product-card position-relative">
                            <div class="mm-product-img-wrap">
                                @if($product->picture)
                                    <img src="{{ asset('storage/' . $product->picture) }}" alt="{{ $product->name }}">
                                @else
                                    <div class="mm-product-img-placeholder">
                                        <i class="fas fa-box-open"></i>
                                    </div>
                                @endif
                                <span class="mm-product-badge">{{ $product->type }}</span>
                            </div>
                            <div class="mm-product-body">
                                <h3 class="mm-product-name">{{ $product->name }}</h3>
                                <p class="mm-product-stock">Stok: {{ $product->stock }} pcs</p>
                                <div class="mm-product-footer">
                                    <span class="mm-product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <button class="mm-btn-add btn-add-cart"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        data-price="{{ $product->price }}"
                                        data-stock="{{ $product->stock }}"
                                        data-img="{{ $product->picture ? asset('storage/' . $product->picture) : '' }}">
                                        <i class="fas fa-plus mm-icon-xs"></i> Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="mm-empty-state reveal">
                            <i class="fas fa-store-slash"></i>
                            <p>Tidak ada produk yang tersedia saat ini.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($products->hasPages())
                <div class="mm-pagination">
                    {{ $products->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </section>

    {{-- FLOATING CART BUTTON --}}
    <button class="mm-cart-fab" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas" id="btnOpenCart">
        <i class="fas fa-shopping-cart mm-icon-cart"></i>
        <span class="mm-cart-count" id="cartBadge">0</span>
    </button>

    {{-- CART OFFCANVAS --}}
    <div class="offcanvas offcanvas-end mm-cart-offcanvas" tabindex="-1" id="cartOffcanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title"><i class="fas fa-shopping-cart me-2 mm-icon-title"></i>Keranjang Belanja</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0 d-flex flex-column mm-cart-body">
            <div class="flex-grow-1 overflow-auto p-3" id="cartItemsList">
                <div class="mm-cart-empty" id="cartEmpty">
                    <i class="fas fa-shopping-basket d-block"></i>
                    <p>Keranjang masih kosong</p>
                </div>
            </div>
            <div class="mm-cart-footer" id="cartFooter">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="mm-cart-total-label">Total</span>
                    <span class="mm-cart-total-value" id="cartTotal">Rp 0</span>
                </div>
                @auth
                    <button class="mm-btn-checkout" data-bs-toggle="modal" data-bs-target="#checkoutModal" id="btnCheckout">
                        <i class="fas fa-credit-card mm-icon-md"></i> Checkout
                    </button>
                @else
                    <a href="{{ route('login') }}" class="mm-btn-checkout text-center text-decoration-none d-flex align-items-center justify-content-center">
                        <i class="fas fa-sign-in-alt mm-icon-md me-2"></i> Login untuk Checkout
                    </a>
                @endauth
            </div>
        </div>
    </div>

    {{-- CHECKOUT MODAL --}}
    <div class="modal fade mm-checkout-modal" id="checkoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-file-invoice me-2 mm-icon-title"></i>Checkout Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('shop.checkout') }}" method="POST" id="checkoutForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mm-checkout-summary">
                            <p class="mm-form-label mb-2">Ringkasan Pesanan</p>
                            <div id="checkoutSummary"></div>
                            <hr class="mm-checkout-hr">
                            <div class="d-flex justify-content-between">
                                <span class="mm-checkout-total-label">Total</span>
                                <span class="mm-checkout-total-value" id="checkoutTotal">Rp 0</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="mm-form-label">Alamat Pengiriman <span class="mm-required">*</span></label>
                            <textarea name="delivery_address" class="mm-form-control" rows="3" placeholder="Masukkan alamat lengkap..." required>{{ auth()->user()->address ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="mm-form-label">Metode Pembayaran <span class="mm-required">*</span></label>
                            <div class="d-flex gap-3 mt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="pmCod" value="cod" checked>
                                    <label class="form-check-label mm-payment-label" for="pmCod">
                                        <i class="fas fa-money-bill-wave me-1 mm-icon-accent"></i> COD
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="pmTransfer" value="transfer">
                                    <label class="form-check-label mm-payment-label" for="pmTransfer">
                                        <i class="fas fa-university me-1 mm-icon-accent"></i> Transfer
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="mm-form-label">Catatan (Opsional)</label>
                            <input type="text" name="notes" class="mm-form-control" placeholder="Misal: Titip di depan pagar...">
                        </div>
                        <div id="checkoutHiddenItems"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="mm-filter-reset" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="mm-btn-add mm-btn-checkout-submit">
                            <i class="fas fa-paper-plane mm-icon-sm"></i> Kirim Pesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <footer class="mm-footer">
        <div class="container">
            <div class="mm-footer-grid">
                <div class="mm-footer-brand">
                    <h3><img src="{{ asset('images/pfp_mizuki.jpeg') }}" alt="Madura Mart"> Madura Mart</h3>
                    <p>Warung Madura versi digital — menyediakan kebutuhan harian lengkap dengan harga merakyat.</p>
                    <div class="mm-footer-socials">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <div class="mm-footer-col">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('shop.index') }}">Belanja</a></li>
                        <li><a href="{{ route('login') }}">Masuk</a></li>
                    </ul>
                </div>
                <div class="mm-footer-col">
                    <h4>Layanan</h4>
                    <ul>
                        <li><a href="#">Belanja Online</a></li>
                        <li><a href="#">Pengiriman</a></li>
                        <li><a href="#">Promo</a></li>
                    </ul>
                </div>
                <div class="mm-footer-col">
                    <h4>Kontak</h4>
                    <ul>
                        <li><a href="mailto:halo@maduramart.id">halo@maduramart.id</a></li>
                        <li><a href="tel:+6281234567890">+62 812-3456-7890</a></li>
                    </ul>
                </div>
            </div>
            <div class="mm-footer-bottom">
                <p>&copy; {{ date('Y') }} Madura Mart. Hak cipta dilindungi.</p>
                <div class="d-flex gap-3">
                    <a href="#">Syarat & Ketentuan</a>
                    <a href="#">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Navbar scroll
        const navbar = document.getElementById('mainNavbar');
        window.addEventListener('scroll', () => navbar.classList.toggle('scrolled', window.scrollY > 60));

        // Mobile nav
        document.getElementById('navToggle').addEventListener('click', () => document.getElementById('mobileNav').classList.add('open'));
        document.getElementById('mobileNavClose').addEventListener('click', () => document.getElementById('mobileNav').classList.remove('open'));

        // Scroll reveal
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('visible'); revealObserver.unobserve(entry.target); }});
        }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
        document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

        // SweetAlert flash
        @if (session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
        @endif
        @if (session('error'))
            Swal.fire({ icon: 'error', title: 'Oops!', text: "{{ session('error') }}", showConfirmButton: true });
        @endif

        // Cart logic
        let cart = JSON.parse(localStorage.getItem('mm_cart') || '[]');
        function saveCart() { localStorage.setItem('mm_cart', JSON.stringify(cart)); renderCart(); }
        function formatRp(n) { return 'Rp ' + n.toLocaleString('id-ID'); }

        function renderCart() {
            const list = document.getElementById('cartItemsList');
            const footer = document.getElementById('cartFooter');
            const badge = document.getElementById('cartBadge');
            if (cart.length === 0) {
                list.innerHTML = '<div class="mm-cart-empty"><i class="fas fa-shopping-basket d-block"></i><p>Keranjang masih kosong</p></div>';
                footer.style.display = 'none'; badge.style.display = 'none'; return;
            }
            badge.style.display = ''; badge.textContent = cart.reduce((s,i) => s+i.qty, 0); footer.style.display = '';
            let total = 0, html = '';
            cart.forEach((item, idx) => {
                const sub = item.price * item.qty; total += sub;
                html += `<div class="mm-cart-item">
                    ${item.img ? `<img src="${item.img}" alt="">` : '<div class="mm-cart-item-placeholder"><i class="fas fa-box mm-icon-primary"></i></div>'}
                    <div class="flex-grow-1">
                        <p class="mm-cart-item-name">${item.name}</p>
                        <p class="mm-cart-item-price">${formatRp(item.price)} × ${item.qty} = <strong>${formatRp(sub)}</strong></p>
                    </div>
                    <div class="mm-cart-qty">
                        <button type="button" onclick="changeQty(${idx},-1)">−</button>
                        <span class="mm-cart-qty-display">${item.qty}</span>
                        <button type="button" onclick="changeQty(${idx},1)">+</button>
                    </div>
                    <button onclick="removeItem(${idx})" class="mm-cart-remove-btn"><i class="fas fa-trash-alt"></i></button>
                </div>`;
            });
            list.innerHTML = html;
            document.getElementById('cartTotal').textContent = formatRp(total);
        }

        function changeQty(idx, delta) {
            cart[idx].qty += delta;
            if (cart[idx].qty > cart[idx].stock) {
                Swal.fire({ icon:'warning', title:'Stok Terbatas', text:`Stok "${cart[idx].name}" hanya ${cart[idx].stock} pcs.`, timer:2000, showConfirmButton:false });
                cart[idx].qty = cart[idx].stock;
            }
            if (cart[idx].qty <= 0) cart.splice(idx, 1);
            saveCart();
        }
        function removeItem(idx) { cart.splice(idx, 1); saveCart(); }

        document.querySelectorAll('.btn-add-cart').forEach(btn => {
            btn.addEventListener('click', function() {
                const id=parseInt(this.dataset.id), name=this.dataset.name, price=parseInt(this.dataset.price), stock=parseInt(this.dataset.stock), img=this.dataset.img;
                const existing = cart.find(i => i.id === id);
                if (existing) { if (existing.qty >= stock) { Swal.fire({icon:'warning',title:'Stok Terbatas',text:`Stok "${name}" hanya ${stock} pcs.`,timer:2000,showConfirmButton:false}); return; } existing.qty++; }
                else { cart.push({id,name,price,stock,img,qty:1}); }
                saveCart();
                Swal.fire({toast:true,position:'top-end',icon:'success',title:`${name} ditambahkan`,showConfirmButton:false,timer:1200});
            });
        });

        document.getElementById('btnCheckout')?.addEventListener('click', function() {
            const summary=document.getElementById('checkoutSummary'), hidden=document.getElementById('checkoutHiddenItems');
            let total=0,sHtml='',hHtml='';
            cart.forEach((item,idx) => {
                const sub=item.price*item.qty; total+=sub;
                sHtml+=`<div class="d-flex justify-content-between mb-1 mm-checkout-item-row"><span>${item.name} × ${item.qty}</span><span class="mm-checkout-item-total">${formatRp(sub)}</span></div>`;
                hHtml+=`<input type="hidden" name="items[${idx}][product_id]" value="${item.id}"><input type="hidden" name="items[${idx}][quantity]" value="${item.qty}">`;
            });
            summary.innerHTML=sHtml; hidden.innerHTML=hHtml;
            document.getElementById('checkoutTotal').textContent=formatRp(total);
        });

        @if(session('success'))
            localStorage.removeItem('mm_cart'); cart = [];
        @endif
        renderCart();
    </script>
</body>
</html>
