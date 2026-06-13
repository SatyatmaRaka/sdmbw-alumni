<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Alumni;
use App\Models\Angkatan;
use Illuminate\Support\Facades\DB;
use App\Enums\UserRole;
use App\Enums\AlumniStatus;

class RegisterController extends Controller
{
    /**
     * Menampilkan form registrasi.
     */
    public function showRegistrationForm()
    {
        $angkatans = Angkatan::orderBy('tahun_ajaran', 'asc')->get();
        return view('auth.register', compact('angkatans'));
    }

    /**
     * Memproses data registrasi alumni.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nisn' => 'required|numeric|digits:10|unique:alumni,nisn',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'angkatan_id' => 'required|exists:angkatan,id',
            'tahun_lulus' => 'required|numeric|digits:4',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.digits' => 'NISN harus 10 digit.',
            'nisn.unique' => 'NISN ini sudah terdaftar di sistem.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 6 karakter.'
        ]);

        DB::beginTransaction();
        try {
            // 1. Buat User (Alumni) - nonaktif sampai disetujui admin
            $user = User::create([
                'username' => $request->nisn,
                'password' => $request->password, // Akan otomatis di-hash oleh model
                'role' => UserRole::ALUMNI->value,
                'is_active' => false,
                'must_change_password' => false, // Karena mereka membuat passwordnya sendiri
            ]);

            // 2. Buat Profil Alumni
            Alumni::create([
                'user_id' => $user->id,
                'nisn' => $request->nisn,
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'angkatan_id' => $request->angkatan_id,
                'tahun_lulus' => $request->tahun_lulus,
                'status_verifikasi' => AlumniStatus::PENDING->value,
                'is_profile_complete' => false,
            ]);

            DB::commit();

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Akun Anda saat ini berstatus Pending dan sedang menunggu verifikasi dari Admin. Silakan coba login secara berkala.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem saat mendaftar. Silakan coba lagi.')->withInput();
        }
    }
}
