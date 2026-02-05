<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // --- HELPER: Tentukan User harus dilempar ke mana ---
    private function redirectBasedOnRole()
    {
        $role = Auth::user()->role;

        // Jika Staff (Owner, Admin, Cashier) -> Masuk Dashboard
        if (in_array($role, ['owner', 'admin', 'cashier'])) {
            return redirect()->route('dashboard.index');
        }

        // Jika Customer / Courier -> Masuk Halaman Depan (Home)
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
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            Log::info('User logged in', ['id' => Auth::id(), 'role' => Auth::user()->role]);

            // PERBAIKAN: Redirect sesuai Role
            if (in_array(Auth::user()->role, ['owner', 'admin', 'cashier'])) {
                return redirect()->intended(route('dashboard.index'))
                    ->with('success', 'Welcome back, ' . Auth::user()->name);
            } else {
                // Customer ke Home
                return redirect()->route('home')
                    ->with('success', 'Selamat datang di Madura Mart!');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah'])->withInput($request->only('email'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'terms' => 'accepted',
            // Role dihapus dari validasi input, karena kita set manual
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // PERBAIKAN KEAMANAN:
            // Paksa role jadi 'customer'.
            // Jangan biarkan input form menentukan role admin/owner.
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'customer', // <--- HARDCODED CUSTOMER
            ]);

            Log::info('New customer registered', ['id' => $user->id]);
            
            Auth::login($user);
            $request->session()->regenerate();

            // Customer baru daftar langsung ke Home, bukan Dashboard
            return redirect()->route('home')
                ->with('success', 'Registrasi berhasil! Selamat belanja.');

        } catch (\Exception $e) {
            Log::error('Register fail', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Gagal registrasi.'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout');
    }
}