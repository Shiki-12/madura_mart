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
        if (!in_array(Auth::user()->role, $roles)) {
            // Graceful redirect instead of raw 403
            $role = Auth::user()->role;

            if ($role === 'courier') {
                return redirect()->route('courier.index')
                    ->with('error', 'Access denied — you do not have permission to view that page.');
            }

            if ($role === 'customer') {
                return redirect()->route('home')
                    ->with('error', 'Access denied — you do not have permission to view that page.');
            }

            // For admin/owner trying to access wrong area, send back
            return redirect()->back()
                ->with('error', 'Access denied — you do not have permission to view that page.');
        }

        return $next($request);
    }
}