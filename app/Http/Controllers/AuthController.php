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
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }
        return view('auth.login', ['title' => 'Login']);
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
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
            'password.min' => 'Password minimal 8 karakter',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            Log::info('User logged in', ['user_id' => Auth::id(), 'email' => Auth::user()->email, 'ip' => $request->ip()]);
            return redirect()->intended(route('dashboard.index'))
                ->with('success', 'Login berhasil! Selamat datang ' . Auth::user()->name);
        }

        Log::warning('Failed login attempt', ['email' => $request->email, 'ip' => $request->ip()]);
        return back()->withErrors(['email' => 'Email atau password salah'])->withInput($request->only('email'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:customer,courier,admin,owner',
            'terms' => 'accepted',
        ], [
            'name.required' => 'Nama harus diisi',
            'name.max' => 'Nama maksimal 255 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'role.required' => 'Role harus dipilih',
            'role.in' => 'Role tidak valid',
            'terms.accepted' => 'Anda harus menyetujui Syarat & Ketentuan',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            Log::info('New user registered', ['user_id' => $user->id, 'email' => $user->email, 'role' => $user->role, 'ip' => $request->ip()]);
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('dashboard.index')
                ->with('success', 'Registrasi berhasil! Selamat datang ' . $user->name);
        } catch (\Exception $e) {
            Log::error('Registration failed', ['email' => $request->email, 'error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Log::info('User logged out', ['user_id' => Auth::id(), 'email' => Auth::user()->email, 'ip' => $request->ip()]);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout');
    }

    public function logoutAndRedirectCourier(Request $request)
    {
        if (Auth::check()) {
            Log::info('User logged out for courier registration', ['user_id' => Auth::id(), 'email' => Auth::user()->email, 'ip' => $request->ip()]);
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        return redirect()->route('register.courier');
    }
}
