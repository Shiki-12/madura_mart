<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Madura Mart</title>
    <link rel="icon" type="image/png" href="{{ asset('images/pfp_mizuki.jpeg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/madura-mart.css') }}">
</head>

<body class="auth-body">
    <div class="auth-split">

        <!-- Branding Panel -->
        <div class="auth-brand">
            <div class="auth-brand__inner">
                <img src="{{ asset('images/pfp_mizuki.jpeg') }}" alt="Madura Mart" class="auth-brand__logo">
                <div class="auth-brand__accent"></div>
                <h1 class="auth-brand__title">Selamat Datang di Madura Mart!</h1>
                <p class="auth-brand__text">Masuk untuk mengakses dashboard dan mengelola toko Anda dengan mudah.</p>
            </div>
            <div class="auth-brand__dots">
                <span class="auth-brand__dot"></span><span class="auth-brand__dot"></span><span class="auth-brand__dot"></span><span class="auth-brand__dot"></span><span class="auth-brand__dot"></span>
                <span class="auth-brand__dot"></span><span class="auth-brand__dot"></span><span class="auth-brand__dot"></span><span class="auth-brand__dot"></span><span class="auth-brand__dot"></span>
                <span class="auth-brand__dot"></span><span class="auth-brand__dot"></span><span class="auth-brand__dot"></span><span class="auth-brand__dot"></span><span class="auth-brand__dot"></span>
            </div>
        </div>

        <!-- Form Panel -->
        <div class="auth-panel">
            <div class="auth-header">
                <h2 class="auth-header__title">Masuk</h2>
                <p class="auth-header__sub">Masukkan kredensial Anda untuk melanjutkan</p>
            </div>

            @if ($errors->any())
                <div class="auth-alert auth-alert--danger">
                    <ul class="auth-alert__list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="auth-alert auth-alert--success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" id="loginForm">
                @csrf

                <div class="auth-field">
                    <label for="email" class="auth-label">Email</label>
                    <input type="email" id="email" name="email" class="auth-input"
                        placeholder="nama@email.com" value="{{ old('email') }}" required>
                </div>

                <div class="auth-field">
                    <label for="password" class="auth-label">Password</label>
                    <div class="auth-pw-wrap">
                        <input type="password" id="password" name="password" class="auth-input"
                            placeholder="Masukkan password Anda" required>
                        <button type="button" class="auth-pw-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="auth-options">
                    <div class="auth-check">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Ingat Saya</label>
                    </div>
                    <a href="#" class="auth-link">Lupa Password?</a>
                </div>

                <button type="submit" class="neon-btn">Masuk</button>
            </form>

            <div class="auth-divider">
                <span>Atau masuk dengan</span>
            </div>

            <div class="auth-socials">
                <button type="button" class="auth-social-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Google
                </button>
                <button type="button" class="auth-social-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="#1877F2">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </button>
            </div>

            <div class="auth-footer">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>

            <div class="auth-courier-cta">
                <p>Ingin bergabung sebagai mitra pengiriman?</p>
                <a href="{{ route('register.courier') }}">
                    <i class="fas fa-truck"></i> Daftar sebagai Kurir
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
        setTimeout(() => {
            document.querySelectorAll('.auth-alert').forEach(el => {
                el.style.transition = 'opacity 0.3s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 300);
            });
        }, 5000);
    </script>
</body>

</html>
