<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KepalaSekolahMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah user adalah kepala sekolah atau admin
        if (!in_array(Auth::user()->role, [\App\Enums\UserRole::KEPALA_SEKOLAH->value, \App\Enums\UserRole::ADMIN->value])) {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk Kepala Sekolah.');
        }

        return $next($request);
    }
}
