<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya — Madura Mart</title>
    <link rel="icon" type="image/png" href="{{ asset('images/pfp_mizuki.jpeg') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* ============================================
           DESIGN TOKENS (Copied from home.blade.php)
           ============================================ */
        :root {
            --c-primary: #E8590C;
            --c-primary-dark: #C2410C;
            --c-primary-light: #FED7AA;
            --c-accent: #0D9488;
            --c-dark: #1C1917;
            --c-dark-soft: #292524;
            --c-warm-gray: #44403C;
            --c-text: #1C1917;
            --c-text-muted: #78716C;
            --c-surface: #FFFFFF;
            --c-bg-body: #F9FAFB;
            --c-border: #E7E5E4;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 20px;
            --font-main: 'Plus Jakarta Sans', system-ui, sans-serif;
            --shadow-sm: 0 1px 3px rgba(28, 25, 23, 0.06), 0 1px 2px rgba(28, 25, 23, 0.04);
            --shadow-md: 0 4px 16px rgba(28, 25, 23, 0.08), 0 2px 4px rgba(28, 25, 23, 0.04);
        }

        body {
            font-family: var(--font-main);
            color: var(--c-text);
            background: var(--c-bg-body);
            line-height: 1.7;
            -webkit-font-smoothing: antialiased;
        }

        /* NAVBAR */
        .mm-navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .mm-navbar .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--c-primary);
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .mm-navbar .navbar-brand img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--c-primary-light);
        }

        /* PROFILE LAYOUT */
        .profile-container {
            padding: 60px 0;
            min-height: calc(100vh - 80px - 200px); /* Height minus nav/footer */
        }

        .profile-card {
            background: var(--c-surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--c-border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            border-top: 5px solid var(--c-primary);
        }

        .profile-header {
            padding: 40px;
            text-align: center;
            border-bottom: 1px solid var(--c-border);
            background: #FFF7ED; /* Warm section bg */
        }

        .profile-avatar-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }

        .profile-avatar {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--c-surface);
            box-shadow: var(--shadow-md);
        }

        .profile-avatar-placeholder {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--c-primary-light), var(--c-primary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: 800;
            color: #fff;
            border: 4px solid var(--c-surface);
            box-shadow: var(--shadow-md);
        }

        .profile-name {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--c-dark);
            margin-bottom: 4px;
        }

        .profile-role-badge {
            display: inline-block;
            background: var(--c-primary);
            color: #fff;
            padding: 4px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .profile-body {
            padding: 40px;
        }

        .form-label {
            font-weight: 600;
            color: var(--c-dark-soft);
            font-size: 0.95rem;
        }

        .form-control {
            padding: 14px 18px;
            border-radius: var(--radius-sm);
            border: 2px solid var(--c-border);
            font-family: var(--font-main);
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--c-primary);
            box-shadow: 0 0 0 4px rgba(232, 89, 12, 0.1);
        }

        .btn-update {
            background: linear-gradient(135deg, var(--c-primary), var(--c-primary-dark));
            color: #fff;
            padding: 14px 32px;
            border-radius: var(--radius-md);
            font-weight: 700;
            border: none;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(232, 89, 12, 0.3);
            width: 100%;
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(232, 89, 12, 0.4);
            color: #fff;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--c-dark);
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--c-border);
        }

    </style>
</head>

<body>

    <!-- Toast Notifications -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
        @if(session('error'))
            <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body"><i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif
        @if(session('success'))
            <div class="toast align-items-center text-bg-success border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body"><i class="fas fa-check-circle me-2"></i> {{ session('success') }}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif
        @if($errors->any())
            <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-exclamation-circle me-2"></i> Terdapat kesalahan pada input Anda.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif
    </div>

    <!-- NAVBAR -->
    <nav class="mm-navbar">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="navbar-brand">
                <img src="{{ asset('images/pfp_mizuki.jpeg') }}" alt="Madura Mart">
                Madura Mart
            </a>

            <div class="d-flex align-items-center gap-4">
                <a href="{{ route('home') }}" class="text-decoration-none text-muted fw-semibold hover-primary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
                </a>
                
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-4 fw-bold">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- PROFILE SECTION -->
    <main class="profile-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    
                    <div class="profile-card">
                        <div class="profile-header">
                            <div class="profile-avatar-wrapper">
                                @if($user->picture)
                                    <img src="{{ asset('storage/' . $user->picture) }}" alt="Avatar" class="profile-avatar">
                                @else
                                    <div class="profile-avatar-placeholder">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <h2 class="profile-name">{{ $user->name }}</h2>
                            <div class="profile-role-badge">Pelanggan Setia</div>
                        </div>

                        <div class="profile-body">
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <h3 class="section-title">Data Pribadi</h3>
                                
                                <div class="row g-4 mb-5">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nomor Telepon / WhatsApp</label>
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone_number) }}" placeholder="0812...">
                                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Ubah Foto Profil</label>
                                        <input type="file" name="picture" class="form-control @error('picture') is-invalid @enderror" accept="image/*">
                                        @error('picture')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Alamat Lengkap Pengiriman</label>
                                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" placeholder="Nama Jalan, RT/RW, Kecamatan...">{{ old('address', $user->address) }}</textarea>
                                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <h3 class="section-title">Keamanan Akun</h3>
                                <div class="row g-4 mb-5">
                                    <div class="col-12">
                                        <p class="text-muted small mb-3"><i class="fas fa-info-circle me-1"></i> Biarkan kosong jika tidak ingin mengubah password.</p>
                                        <label class="form-label">Password Baru</label>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 6 karakter" minlength="6">
                                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn-update">
                                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <footer style="background: var(--c-dark); padding: 24px 0; text-align: center; color: rgba(255,255,255,0.4); font-size: 0.85rem;">
        <p class="m-0">&copy; {{ date('Y') }} Madura Mart. Hak cipta dilindungi.</p>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto hide toasts if they exist
        document.addEventListener('DOMContentLoaded', function () {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'))
            var toastList = toastElList.map(function (toastEl) {
                return new bootstrap.Toast(toastEl, { delay: 4000 });
            });
            toastList.forEach(toast => toast.show());
        });
    </script>
</body>
</html>
