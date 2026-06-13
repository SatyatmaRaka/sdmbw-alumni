<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Alumni;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\AlumniProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    private AlumniProfileService $profileService;

    public function __construct(AlumniProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function edit(): View|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $alumni = Alumni::with(['user', 'angkatan', 'pendidikan', 'pekerjaan', 'fotos'])
            ->where('user_id', $user->id)
            ->first();

        if (!$alumni) {
            return redirect()->route('login')->with('error', 'Data alumni tidak ditemukan.');
        }

        return view('alumni.profile.edit', compact('alumni'));
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $alumni = $user->alumni;

        if (!$alumni) {
            return redirect()->route('login')->with('error', 'Data alumni tidak ditemukan.');
        }

        // Validasi tambahan untuk file foto yang lebih ketat
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'foto.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            // Delegasi ke Service Layer
            $this->profileService->updateProfile(
                $user,
                $alumni,
                $request->all(),
                $request->hasFile('foto') ? $request->file('foto') : null
            );

            // Cek apakah ini pertama kali mengisi profil atau sudah pernah
            $wasProfileComplete = $alumni->is_profile_complete;

            return $wasProfileComplete
                ? redirect()->route('alumni.dashboard')
                    ->with('success', 'Profil berhasil diperbarui!')
                : redirect()->route('alumni.testimonial.form')
                    ->with('success', 'Profil berhasil diperbarui! Satu langkah lagi — berikan testimoni Anda.');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Profile update failed: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui profil. Silakan coba beberapa saat lagi.')->withInput();
        }
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'password.required'         => 'Password baru wajib diisi',
            'password.min'              => 'Password minimal 8 karakter',
            'password.confirmed'        => 'Konfirmasi password tidak sesuai',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
        }

        $user->update([
            'password'             => $validated['password'], // otomatis di-hash via $casts
            'must_change_password' => false,
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }

    public function testimonialForm(): View|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $alumni = $user->alumni;

        if (!$alumni || !$alumni->is_profile_complete) {
            return redirect()->route('alumni.profile.edit')->with('warning', 'Silakan lengkapi profil Anda terlebih dahulu.');
        }

        // Cek jika sudah pernah mengisi testimoni
        if (\App\Models\Testimoni::where('alumni_id', $alumni->id)->exists()) {
            return redirect()->route('alumni.dashboard');
        }

        return view('alumni.profile.testimonial', compact('alumni'));
    }

    public function storeTestimonial(Request $request): RedirectResponse
    {
        $request->validate([
            'content' => 'required|string|min:10|max:1000',
        ], [
            'content.required' => 'Testimoni wajib diisi',
            'content.min'      => 'Testimoni minimal 10 karakter',
            'content.max'      => 'Testimoni maksimal 1000 karakter',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $alumni = $user->alumni;

        \App\Models\Testimoni::create([
            'alumni_id'   => $alumni->id,
            'content'     => $request->content,
            'is_active'   => true,   // Langsung aktif, muncul setelah admin set is_featured
            'is_featured' => false,  // Admin yang menentukan apakah ditampilkan di landing
        ]);

        return redirect()->route('alumni.dashboard')
            ->with('success', 'Terima kasih atas testimoni Anda! Profil Anda kini telah aktif sepenuhnya.');
    }
}

