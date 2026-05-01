<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureAlumniOnboarding
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // 1. Jika Admin, lewati
        if ($user && $user->isAdmin()) {
            return $next($request);
        }

        // 2. Jika Alumni, jalankan alur Onboarding
        if ($user && $user->isAlumni()) {
            
            // Pengecualian rute agar tidak terjadi infinite redirect
            $allowedRoutes = [
                'alumni.profile.edit',
                'alumni.profile.update',
                'alumni.profile.updatePassword',
                'alumni.testimonial.form',
                'alumni.testimonial.store',
                'logout',
            ];

            if ($request->routeIs($allowedRoutes)) {
                return $next($request);
            }

            $alumni = $user->alumni;

            // Step 1: Wajib ganti password HANYA jika profil belum pernah dilengkapi
            // (first-time onboarding). Jika sudah complete, password reset oleh admin
            // tidak memblokir akses ke dashboard.
            if ($user->must_change_password && (!$alumni || !$alumni->is_profile_complete)) {
                return redirect()->route('alumni.profile.edit')
                    ->with('warning', 'Silakan lengkapi profil Anda terlebih dahulu untuk mengaktifkan akun.');
            }

            // Step 2: Wajib lengkapi profil (Alamat, No HP, Minimal 1 pendidikan)
            if (!$alumni || !$alumni->is_profile_complete) {
                return redirect()->route('alumni.profile.edit')
                    ->with('warning', 'Silakan lengkapi profil Anda terlebih dahulu.');
            }

            // Step 3: Wajib isi testimoni
            if (!\App\Models\Testimoni::where('alumni_id', $alumni->id)->exists()) {
                return redirect()->route('alumni.testimonial.form')
                    ->with('info', 'Satu langkah lagi! Mohon berikan testimoni singkat pengalaman Anda di sekolah.');
            }
        }

        return $next($request);
    }
}
