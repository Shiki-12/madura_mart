<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Madura Mart  Toko online kebutuhan harian lengkap dengan harga merakyat. Warung Madura versi digital, belanja mudah dan cepat.">
    <meta name="keywords" content="madura mart, warung madura, toko online, kebutuhan harian, belanja online, harga murah">

    <title>Madura Mart - Warung Madura Digital</title>
    <link rel="icon" type="image/png" href="{{ asset('images/pfp_mizuki.jpeg') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Global Design System --}}
    <link rel="stylesheet" href="{{ asset('css/madura-mart.css') }}">


</head>


<body class="mm-public">



    <!-- ===============================================
         TOAST NOTIFICATIONS
         =============================================== -->
    <div class="toast-container position-fixed top-0 end-0 p-3 mm-toast-top">
        @if(session('error'))
            <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
        @if(session('success'))
            <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <!-- ===============================================
         NAVBAR
    =============================================== -->
    <nav class="mm-navbar" id="mainNavbar">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <a href="{{ url('/') }}" class="navbar-brand" id="navbar-brand">
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
                        <li><a href="{{ route('shop.index') }}">Belanja</a></li>
                        <li><a href="#beranda">Beranda</a></li>
                        <li><a href="#tentang">Tentang Kami</a></li>
                        <li><a href="#keunggulan">Keunggulan</a></li>
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
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 rounded-3" aria-labelledby="navbarDropdown">
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
                                    <i class="fas fa-sign-in-alt mm-icon-md"></i>
                                    Masuk
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

    <!-- Mobile Nav Overlay -->
    <div class="mm-mobile-nav" id="mobileNav">
        <button class="mm-mobile-close" id="mobileNavClose" aria-label="Close navigation">&times;</button>
        <a href="{{ route('home') }}" onclick="closeMobileNav()">Home</a>
        <a href="{{ url('/') }}" onclick="closeMobileNav()">Welcome</a>
        <a href="{{ url('/mizuki') }}" onclick="closeMobileNav()">Mizuki</a>
        <a href="{{ url('/lagu') }}" onclick="closeMobileNav()">Lagu</a>
        <a href="{{ route('shop.index') }}" onclick="closeMobileNav()">Belanja</a>
        <a href="#beranda" onclick="closeMobileNav()">Beranda</a>
        <a href="#tentang" onclick="closeMobileNav()">Tentang Kami</a>
        <a href="#keunggulan" onclick="closeMobileNav()">Keunggulan</a>
        @auth
            <div class="d-flex align-items-center gap-3 mb-3 border-bottom border-secondary pb-3 w-100 justify-content-center">
                @if(auth()->user()->picture)
                    <img src="{{ asset('storage/' . auth()->user()->picture) }}" alt="Avatar" class="rounded-circle mm-mobile-avatar">
                @else
                    <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center text-dark mm-mobile-avatar-placeholder">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                <div class="text-start">
                    <div class="mm-mobile-user-name">{{ auth()->user()->name }}</div>
                    <div class="mm-mobile-user-role">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
            </div>
            <a href="{{ route('profile') }}">Profil Saya</a>
            @if(auth()->user()->role !== 'customer')
                <a href="{{ route('dashboard.index') }}">Dashboard Admin</a>
            @endif
            <form action="{{ route('logout') }}" method="POST" class="w-100 text-center mt-3">
                @csrf
                <button type="submit" class="btn btn-danger w-75 rounded-pill"><i class="fas fa-sign-out-alt me-2"></i> Keluar</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="mm-nav-login-link">Masuk</a>
            <a href="{{ route('register') }}">Daftar</a>
        @endauth
    </div>

    <!-- ===============================================
         HERO SECTION
    =============================================== -->
    <section class="mm-hero" id="beranda">
        <div class="mm-hero-bg">
            <img src="{{ asset('images/hero-warung-madura.png') }}" alt="Warung Madura">
        </div>
        <div class="mm-hero-overlay"></div>

        <div class="container mm-hero-content">
            <div class="row">
                <div class="col-lg-7">
                    <div class="mm-hero-badge">
                        <i class="fas fa-store"></i>
                        Warung Madura Versi Digital
                    </div>

                    <h1>
                        Semua Kebutuhan<br>
                        Harian, <span class="text-gradient">Satu Klik</span> Saja.
                    </h1>

                    <p class="mm-hero-subtitle">
                        Madura Mart menghadirkan kelengkapan dan kehangatan Warung Madura ke layar Anda.
                        Belanja kebutuhan harian dengan harga merakyat, tanpa perlu keluar rumah.
                    </p>

                    <div class="mm-hero-actions">
                        @auth
                            <a href="{{ route('shop.index') }}" class="mm-btn-primary" id="hero-cta-primary">
                                Mulai Belanja
                                <i class="fas fa-arrow-right mm-icon-arrow"></i>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="mm-btn-primary" id="hero-cta-primary">
                                Daftar Gratis
                                <i class="fas fa-arrow-right mm-icon-arrow"></i>
                            </a>
                        @endauth
                        <a href="#tentang" class="mm-btn-outline" id="hero-cta-secondary">
                            <i class="fas fa-play-circle mm-icon-play"></i>
                            Kenali Kami
                        </a>
                    </div>

                    <div class="mm-hero-stats">
                        <div class="mm-hero-stat">
                            <h3>500+</h3>
                            <p>Produk Tersedia</p>
                        </div>
                        <div class="mm-hero-stat">
                            <h3>24/7</h3>
                            <p>Layanan Nonstop</p>
                        </div>
                        <div class="mm-hero-stat">
                            <h3>50rb+</h3>
                            <p>Pelanggan Puas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mm-scroll-indicator">
            <span>Scroll</span>
            <div class="scroll-line"></div>
        </div>
    </section>

    <!-- ===============================================
         ABOUT SECTION
    =============================================== -->
    <section class="mm-about" id="tentang">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5">
                    <div class="reveal">
                        <span class="mm-section-label">Tentang Kami</span>
                        <h2 class="mm-section-title">
                            Semangat Warung Madura,<br>
                            Sentuhan Digital.
                        </h2>
                        <p class="mm-about-text">
                            Warung Madura telah lama menjadi bagian dari kehidupan masyarakat Indonesiaselalu ada,
                            selalu buka, dan selalu menyediakan apa yang Anda butuhkan. Madura Mart lahir untuk
                            meneruskan tradisi legendaris itu ke dunia digital.
                        </p>
                        <p class="mm-about-text mm-about-text--spaced">
                            Kami percaya belanja kebutuhan harian seharusnya <strong>mudah, terjangkau, dan menyenangkan</strong>
                             persis seperti mampir ke warung langganan Anda.
                        </p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="mm-about-card reveal reveal-delay-2">
                        <div class="mm-values-grid">
                            <div class="mm-value-item">
                                <div class="mm-value-icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div>
                                    <h4>Ramah & Terpercaya</h4>
                                    <p>Pelayanan hangat layaknya warung sendiri, didukung sistem yang transparan.</p>
                                </div>
                            </div>
                            <div class="mm-value-item">
                                <div class="mm-value-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <h4>Selalu Sedia</h4>
                                    <p>Buka kapan saja, pesan kapan saja. Tidak ada kata kehabisan stok.</p>
                                </div>
                            </div>
                            <div class="mm-value-item">
                                <div class="mm-value-icon">
                                    <i class="fas fa-tags"></i>
                                </div>
                                <div>
                                    <h4>Harga Jujur</h4>
                                    <p>Tanpa markup berlebihan. Harga yang wajar untuk semua kalangan.</p>
                                </div>
                            </div>
                            <div class="mm-value-item">
                                <div class="mm-value-icon">
                                    <i class="fas fa-leaf"></i>
                                </div>
                                <div>
                                    <h4>Produk Berkualitas</h4>
                                    <p>Dipilih langsung dari distributor terpercaya untuk menjaga mutu.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===============================================
         FEATURES / KEUNGGULAN SECTION
    =============================================== -->
    <section class="mm-features" id="keunggulan">
        <div class="container">
            <div class="mm-features-header reveal">
                <span class="mm-section-label">Keunggulan Kami</span>
                <h2 class="mm-section-title">Kenapa Belanja di Madura Mart?</h2>
                <p>
                    Kami menggabungkan kenyamanan belanja online dengan kelengkapan dan keterjangkauan
                    khas Warung Madura yang sudah Anda kenal.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="mm-feature-card reveal reveal-delay-1">
                        <div class="mm-feature-icon icon-orange">
                            <i class="fas fa-boxes-stacked"></i>
                        </div>
                        <h3>Kebutuhan Harian Lengkap</h3>
                        <p>Dari sembako, jajanan, minuman dingin, hingga perlengkapan rumah tangga  semua tersedia dalam satu tempat.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mm-feature-card reveal reveal-delay-2">
                        <div class="mm-feature-icon icon-teal">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <h3>Harga Merakyat</h3>
                        <p>Harga bersaing tanpa biaya tersembunyi. Kami berkomitmen memberikan harga termurah untuk produk berkualitas.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mm-feature-card reveal reveal-delay-3">
                        <div class="mm-feature-icon icon-amber">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h3>Mudah & Cepat</h3>
                        <p>Proses pemesanan yang intuitif dan pengiriman cepat langsung ke depan pintu rumah Anda.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mm-feature-card reveal reveal-delay-4">
                        <div class="mm-feature-icon icon-rose">
                            <i class="fas fa-truck-fast"></i>
                        </div>
                        <h3>Pengiriman Andal</h3>
                        <p>Tim kurir kami siap mengantarkan pesanan dengan aman dan tepat waktu, setiap hari tanpa libur.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mm-feature-card reveal reveal-delay-5">
                        <div class="mm-feature-icon icon-indigo">
                            <i class="fas fa-shield-halved"></i>
                        </div>
                        <h3>Belanja Aman</h3>
                        <p>Transaksi terjamin dengan sistem keamanan modern. Data pribadi Anda selalu terlindungi.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mm-feature-card reveal reveal-delay-6">
                        <div class="mm-feature-icon icon-emerald">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3>Layanan Pelanggan</h3>
                        <p>Tim kami selalu siap membantu pertanyaan dan keluhan Anda dengan respons cepat dan ramah.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===============================================
         CTA SECTION
    =============================================== -->
    <section class="mm-cta">
        <div class="container">
            <div class="mm-cta-box reveal">
                <h2>Siap Belanja Lebih Mudah?</h2>
                <p>Bergabung dengan ribuan pelanggan Madura Mart dan nikmati belanja kebutuhan harian tanpa repot.</p>
                @auth
                    <a href="{{ route('shop.index') }}" class="mm-btn-primary" id="cta-bottom">
                        Belanja Sekarang
                        <i class="fas fa-arrow-right mm-icon-arrow"></i>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="mm-btn-primary" id="cta-bottom">
                        Buat Akun Gratis
                        <i class="fas fa-arrow-right mm-icon-arrow"></i>
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- ===============================================
    FOOTER
    =============================================== -->
    <footer class="mm-footer">
        <div class="container">
            <div class="mm-footer-grid">
                <div class="mm-footer-brand">
                    <h3>
                        <img src="{{ asset('images/pfp_mizuki.jpeg') }}" alt="Madura Mart">
                        Madura Mart
                    </h3>
                    <p>
                        Warung Madura versi digital  menyediakan kebutuhan harian lengkap dengan harga merakyat dan pelayanan terpercaya.
                    </p>
                    <div class="mm-footer-socials">
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>

                <div class="mm-footer-col">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="#beranda">Beranda</a></li>
                        <li><a href="#tentang">Tentang Kami</a></li>
                        <li><a href="#keunggulan">Keunggulan</a></li>
                        <li><a href="{{ route('login') }}">Masuk</a></li>
                    </ul>
                </div>

                <div class="mm-footer-col">
                    <h4>Layanan</h4>
                    <ul>
                        <li><a href="#">Belanja Online</a></li>
                        <li><a href="#">Pengiriman</a></li>
                        <li><a href="{{ route('register.courier') }}">Gabung Kurir</a></li>
                        <li><a href="#">Promo</a></li>
                    </ul>
                </div>

                <div class="mm-footer-col">
                    <h4>Kontak</h4>
                    <ul>
                        <li><a href="mailto:halo@maduramart.id">halo@maduramart.id</a></li>
                        <li><a href="tel:+6281234567890">+62 812-3456-7890</a></li>
                        <li><a href="#">Pusat Bantuan</a></li>
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

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        /* ============================================
           NAVBAR SCROLL BEHAVIOR
           ============================================ */
        const navbar = document.getElementById('mainNavbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 60);
        });

        /* ============================================
           MOBILE NAV TOGGLE
           ============================================ */
        const navToggle = document.getElementById('navToggle');
        const mobileNav = document.getElementById('mobileNav');
        const mobileNavClose = document.getElementById('mobileNavClose');

        navToggle.addEventListener('click', () => mobileNav.classList.add('open'));
        mobileNavClose.addEventListener('click', () => mobileNav.classList.remove('open'));

        function closeMobileNav() {
            mobileNav.classList.remove('open');
        }

        /* ============================================
           SCROLL REVEAL ANIMATION
           ============================================ */
        const revealElements = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.15,
            rootMargin: '0px 0px -40px 0px'
        });

        revealElements.forEach(el => revealObserver.observe(el));

        /* ============================================
           SMOOTH SCROLL FOR ANCHOR LINKS
           ============================================ */
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    const offsetTop = target.offsetTop - 80;
                    window.scrollTo({ top: offsetTop, behavior: 'smooth' });
                }
            });
        });
    </script>

</body>

</html>
