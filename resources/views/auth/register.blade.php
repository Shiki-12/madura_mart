<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Madura Mart</title>
    <link rel="icon" type="image/png" href="{{ asset('images/pfp_mizuki.jpeg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/madura-mart.css') }}">
</head>

<body class="auth-body">
    <div class="auth-split auth-split--single">
        <div class="auth-panel">
            <div class="auth-header auth-header--center">
                <img src="{{ asset('images/pfp_mizuki.jpeg') }}" alt="Madura Mart" class="auth-header__logo">
                <h2 class="auth-header__title">Buat Akun Baru</h2>
                <p class="auth-header__sub">Daftar untuk mulai belanja</p>
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

            <form action="{{ route('register.post') }}" method="POST" id="registerForm">
                @csrf

                <div class="auth-grid">
                    <div class="auth-field">
                        <label for="name" class="auth-label">Nama Lengkap</label>
                        <input type="text" id="name" name="name" class="auth-input"
                            placeholder="John Doe" value="{{ old('name') }}" required>
                    </div>

                    <div class="auth-field">
                        <label for="email" class="auth-label">Email</label>
                        <input type="email" id="email" name="email" class="auth-input"
                            placeholder="nama@email.com" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="auth-grid">
                    <div class="auth-field">
                        <label for="password" class="auth-label">Password</label>
                        <div class="auth-pw-wrap">
                            <input type="password" id="password" name="password" class="auth-input"
                                placeholder="Minimal 8 karakter" required oninput="checkPasswordStrength()">
                            <button type="button" class="auth-pw-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye" id="toggleIconPass"></i>
                            </button>
                        </div>
                        <div class="auth-strength">
                            <div class="auth-strength__bar" id="strengthBar"></div>
                        </div>
                        <div class="auth-strength__text" id="strengthText"></div>
                    </div>

                    <div class="auth-field">
                        <label for="password_confirmation" class="auth-label">Konfirmasi Password</label>
                        <div class="auth-pw-wrap">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="auth-input" placeholder="Ulangi password" required>
                            <button type="button" class="auth-pw-toggle"
                                onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye" id="toggleIconConfirm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Role is automatically set to 'customer' for this registration form -->
                <input type="hidden" name="role" value="customer">

                <div class="auth-terms">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        Saya setuju dengan <a href="#">Syarat &amp; Ketentuan</a> dan <a href="#">Kebijakan Privasi</a> Madura Mart
                    </label>
                </div>

                <button type="submit" class="neon-btn" id="submitBtn">Daftar Sekarang</button>
            </form>

            <div class="auth-footer">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const iconId = inputId === 'password' ? 'toggleIconPass' : 'toggleIconConfirm';
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const bar = document.getElementById('strengthBar');
            const text = document.getElementById('strengthText');
            let strength = 0, message = '', color = '';

            if (password.length >= 8) strength += 25;
            if (password.match(/[a-z]/)) strength += 25;
            if (password.match(/[A-Z]/)) strength += 25;
            if (password.match(/[0-9]/)) strength += 12.5;
            if (password.match(/[^a-zA-Z0-9]/)) strength += 12.5;

            if (strength < 25)      { message = 'Lemah';        color = '#ef4444'; }
            else if (strength < 50) { message = 'Sedang';       color = '#f59e0b'; }
            else if (strength < 75) { message = 'Kuat';         color = '#00d2ff'; }
            else                    { message = 'Sangat Kuat';  color = '#22c55e'; }

            bar.style.width = strength + '%';
            bar.style.backgroundColor = color;
            text.textContent = message;
            text.style.color = color;
        }

        setTimeout(() => {
            document.querySelectorAll('.auth-alert').forEach(el => {
                el.style.transition = 'opacity 0.3s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 300);
            });
        }, 5000);

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const terms = document.getElementById('terms').checked;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
                return false;
            }
            if (!terms) {
                e.preventDefault();
                alert('Anda harus menyetujui Syarat & Ketentuan!');
                return false;
            }
            document.getElementById('submitBtn').disabled = true;
        });
    </script>
</body>

</html>
