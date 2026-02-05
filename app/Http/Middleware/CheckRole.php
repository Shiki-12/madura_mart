<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed  ...$roles  Daftar role yang DIBOLEHKAN masuk
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek Login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Cek Apakah Role User ada di daftar yang dibolehkan
        // $roles adalah array yang dikirim dari route, misal: ['admin', 'owner']
        if (!in_array(Auth::user()->role, $roles)) {
            // Jika role tidak cocok (misal Customer mencoba masuk Admin Area)
            abort(403, 'Unauthorized Access - Anda tidak memiliki izin ke halaman ini.');
        }

        return $next($request);
    }
}