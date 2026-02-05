<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kurir - Madura Mart</title>
    <link rel="icon" type="image/png" href="{{ asset('images/come.jpeg') }}">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Instrument Sans', sans-serif;
            /* Background sedikit beda (nuansa oranye) biar user tau ini beda halaman */
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            padding: 60px 40px;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .register-header { text-align: center; margin-bottom: 40px; }

        .logo {
            width: 80px; height: 80px;
            /* Logo Background Oranye utk Kurir */
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px; box-shadow: 0 10px 30px rgba(253, 160, 133, 0.4);
        }
        .logo img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; }

        .register-header h2 { font-size: 2rem; font-weight: 700; color: #333; margin-bottom: 10px; }
        .register-header p { color: #666; font-size: 1rem; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 25px; }
        .form-group { margin-bottom: 25px; }
        .form-group.full-width { grid-column: 1 / -1; }
        .form-group label { display: block; margin-bottom: 8px; color: #333; font-weight: 600; font-size: 0.95rem; }

        .form-group input, .form-group select {
            width: 100%; padding: 15px; border: 2px solid #e0e0e0; border-radius: 10px;
            font-size: 1rem; transition: all 0.3s ease; font-family: 'Instrument Sans', sans-serif;
        }
        .form-group input:focus {
            outline: none; border-color: #fda085; box-shadow: 0 0 0 3px rgba(253, 160, 133, 0.2);
        }

        .password-wrapper { position: relative; }
        .password-toggle {
            position: absolute; right: 15px; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: #666; cursor: pointer;
            font-size: 1.2rem; padding: 5px;
        }

        .password-strength { margin-top: 10px; height: 5px; background: #e0e0e0; border-radius: 5px; overflow: hidden; }
        .password-strength-bar { height: 100%; width: 0; transition: all 0.3s ease; border-radius: 5px; }
        .password-strength-text { margin-top: 5px; font-size: 0.85rem; color: #666; }

        .terms-checkbox { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 25px; }
        .terms-checkbox input[type="checkbox"] { width: 18px; height: 18px; cursor: pointer; margin-top: 3px; }
        .terms-checkbox label { color: #666; cursor: pointer; font-size: 0.95rem; line-height: 1.5; }
        .terms-checkbox a { color: #fda085; text-decoration: none; font-weight: 600; }

        .btn-register {
            width: 100%; padding: 15px;
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
            color: white; border: none; border-radius: 10px; font-size: 1.1rem; font-weight: 600;
            cursor: pointer; transition: all 0.3s ease; font-family: 'Instrument Sans', sans-serif;
        }
        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(253, 160, 133, 0.4); }
        .btn-register:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

        .login-link { text-align: center; color: #666; font-size: 0.95rem; margin-top: 25px; }
        .login-link a { color: #fda085; text-decoration: none; font-weight: 600; transition: color 0.3s ease; }
        .login-link a:hover { color: #e67e22; }

        .alert { padding: 15px; border-radius: 10px; margin-bottom: 20px; display: none; }
        .alert.show { display: block; animation: slideDown 0.3s ease-out; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .alert-danger { background: #fee; color: #c33; border: 1px solid #fcc; }
        .alert-success { background: #efe; color: #3c3; border: 1px solid #cfc; }

        @media (max-width: 768px) {
            .register-container { padding: 40px 30px; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <div class="logo">
                <img src="{{ asset('images/come.jpeg') }}" alt="Madura Mart">
            </div>
            <h2>Gabung Mitra Pengiriman</h2>
            <p>Daftar sekarang untuk menjadi kurir kami</p>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger show">
            <ul style="list-style: none; padding: 0; margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- ROUTE KHUSUS KURIR --}}
        <form action="{{ route('register.courier.store') }}" method="POST" id="registerForm">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Nama Lengkap (Sesuai KTP)</label>
                    <input type="text" id="name" name="name" placeholder="John Doe" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required>
                </div>
            </div>

            {{-- INPUT KHUSUS KURIR: NO HP --}}
            <div class="form-group">
                <label for="phone">Nomor HP / WhatsApp</label>
                <input type="number" id="phone" name="phone" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}" required>
                <small style="color: #888; font-size: 0.8rem; margin-top: 5px; display:block;">Nomor ini akan digunakan untuk koordinasi pengiriman.</small>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required oninput="checkPasswordStrength()">
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">👁️</button>
                    </div>
                    <div class="password-strength">
                        <div class="password-strength-bar" id="strengthBar"></div>
                    </div>
                    <div class="password-strength-text" id="strengthText"></div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">👁️</button>
                    </div>
                </div>
            </div>

            <div class="terms-checkbox">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">
                    Saya setuju dengan <a href="#">Syarat & Ketentuan Mitra</a> Madura Mart
                </label>
            </div>

            <button type="submit" class="btn-register" id="submitBtn">Kirim Lamaran</button>
            <p style="text-align: center; font-size: 0.85rem; color: #666; margin-top: 15px;">
                <i class="fas fa-info-circle"></i> Akun Anda akan diverifikasi oleh Admin sebelum aktif.
            </p>
        </form>

        <div class="login-link">
            Ingin belanja saja? <a href="{{ route('register') }}">Daftar sebagai Customer</a>
            <br>
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const toggleBtn = event.target;
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text'; toggleBtn.textContent = '👁️‍🗨️';
            } else {
                passwordInput.type = 'password'; toggleBtn.textContent = '👁️';
            }
        }

        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            let strength = 0; let message = ''; let color = '';

            if (password.length >= 8) strength += 25;
            if (password.match(/[a-z]/)) strength += 25;
            if (password.match(/[A-Z]/)) strength += 25;
            if (password.match(/[0-9]/)) strength += 12.5;
            if (password.match(/[^a-zA-Z0-9]/)) strength += 12.5;

            if (strength < 25) { message = 'Lemah'; color = '#f44336'; }
            else if (strength < 50) { message = 'Sedang'; color = '#ff9800'; }
            else if (strength < 75) { message = 'Kuat'; color = '#2196f3'; }
            else { message = 'Sangat Kuat'; color = '#4caf50'; }

            strengthBar.style.width = strength + '%';
            strengthBar.style.backgroundColor = color;
            strengthText.textContent = message;
            strengthText.style.color = color;
        }

        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert.show');
            alerts.forEach(alert => {
                alert.style.animation = 'slideDown 0.3s ease-out reverse';
                setTimeout(() => alert.classList.remove('show'), 300);
            });
        }, 5000);

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const terms = document.getElementById('terms').checked;

            if (password !== confirmPassword) {
                e.preventDefault(); alert('Password dan konfirmasi password tidak cocok!'); return false;
            }
            if (!terms) {
                e.preventDefault(); alert('Anda harus menyetujui Syarat & Ketentuan!'); return false;
            }
            document.getElementById('submitBtn').disabled = true;
        });
    </script>
</body>
</html>
