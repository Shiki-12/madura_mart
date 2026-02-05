<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // --- HELPER: Tentukan Arah Redirect ---
    private function redirectBasedOnRole()
    {
        // Pastikan ada user yg login
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $role = Auth::user()->role;

        // Role Internal -> Masuk Dashboard
        if (in_array($role, ['owner', 'admin', 'cashier'])) {
            return redirect()->route('dashboard.index');
        }

        // Role External (Customer/Courier) -> Masuk Halaman Depan
        return redirect()->route('home');
    }

    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('auth.login', ['title' => 'Login']);
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('auth.register', ['title' => 'Register']);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        // Coba Login
        if (Auth::attempt($credentials, $remember)) {

            // --- CEK STATUS AKTIF ---
            if (Auth::user()->is_active == 0) {
                Auth::logout(); // Tendang keluar

                return back()->withErrors(['email' => 'Akun Anda masih dalam peninjauan Admin (Pending).']);
            }
            // ------------------------

            $request->session()->regenerate();
            Log::info('User logged in', ['id' => Auth::id(), 'role' => Auth::user()->role]);

            return $this->redirectBasedOnRole()
                ->with('success', 'Selamat datang kembali, '.Auth::user()->name);
        }

        return back()->withErrors(['email' => 'Email atau password salah'])->withInput($request->only('email'));
    }

    public function register(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'terms' => 'accepted',
            // HAPUS validasi 'role' dari sini agar user tidak bisa milih role sendiri
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // PERBAIKAN KEAMANAN: Paksa role jadi 'customer'
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'customer', // <--- Hardcode: Register publik pasti customer
            ]);

            Auth::login($user);
            $request->session()->regenerate();

            // Customer baru langsung ke Home
            return redirect()->route('home')
                ->with('success', 'Registrasi berhasil! Selamat berbelanja.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal registrasi: '.$e->getMessage()])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout');
    }

    // Menangani Submit Form Register Courier
    public function storeCourier(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric', // Tambahan wajib HP
            'password' => 'required|min:8|confirmed',
            'terms' => 'accepted',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => 'courier',     // Role Kurir
                'is_active' => false,    // PENTING: Status Non-Aktif (Pending)
            ]);

            // Jangan auto-login! Redirect ke halaman login dengan pesan.
            return redirect()->route('login')
                ->with('success', 'Lamaran terkirim! Admin akan memverifikasi akun Anda dalam 1x24 jam.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mendaftar: '.$e->getMessage()])->withInput();
        }
    }
}
