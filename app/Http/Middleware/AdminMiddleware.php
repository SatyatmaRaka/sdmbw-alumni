<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * AdminMiddleware — Production-Ready.
 *
 * Middleware ini sudah siap digunakan di lingkungan production cPanel.
 * Melakukan 3 pengecekan secara berurutan:
 *   1. Pastikan user sudah login (Auth::check()).
 *   2. Pastikan akun user masih aktif (is_active = true).
 *   3. Pastikan role user adalah ADMIN sesuai enum UserRole::ADMIN.
 *
 * Jika salah satu cek gagal, pengguna akan diarahkan ke halaman login
 * atau mendapat respons 403 Forbidden.
 */
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek apakah akun user aktif
        if (!Auth::user()->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            return redirect()->route('login')->with('error', 'Akun Anda telah dinonaktifkan oleh administrator.');
        }

        // 2. Cek apakah role user adalah 'admin'
        // Kita langsung cek kolom 'role' agar tidak bergantung pada fungsi tambahan
        if (Auth::user()->role !== \App\Enums\UserRole::ADMIN->value) {
            // Kita gunakan abort 403 (Forbidden) atau lempar ke login
            abort(403, 'Akses ditolak. Halaman ini khusus untuk administrator.');
        }

        return $next($request);
    }
}
