<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForumMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Login terlebih dahulu untuk ikut berdiskusi.');
        }

        $user = auth()->user();

        // Jika user adalah admin, langsung izinkan
        if ($user->isAdmin() || $user->isKepalaSekolah()) {
            return $next($request);
        }

        // Pastikan akun aktif
        if (!$user->isActive()) {
            return redirect()->route('login')->with('error', 'Akun Anda tidak aktif.');
        }

        // Jika alumni, cek apakah sudah verified
        if ($user->isAlumni()) {
            $alumni = $user->alumni;
            if (!$alumni || $alumni->status_verifikasi !== 'verified') {
                return redirect()->back()->with('error', 'Akun Anda belum diverifikasi admin.');
            }
        }

        return $next($request);
    }
}
