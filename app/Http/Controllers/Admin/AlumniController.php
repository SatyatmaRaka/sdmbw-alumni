<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Angkatan;
use App\Services\AlumniService;
use App\Services\CacheService;
use App\Http\Requests\UpdateAdminAlumniRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;

class AlumniController extends Controller
{
    private AlumniService $alumniService;
    private CacheService $cacheService;

    public function __construct(AlumniService $alumniService, CacheService $cacheService)
    {
        $this->alumniService = $alumniService;
        $this->cacheService = $cacheService;
    }

    /**
     * Tampilkan daftar alumni dengan filter lengkap
     */
    public function index(Request $request)
    {
        $query = Alumni::with(['user', 'angkatan']);

        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }
        if ($request->filled('angkatan_id')) {
            $query->where('angkatan_id', $request->angkatan_id);
        }
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }
        if ($request->filled('complete')) {
            $query->where('is_profile_complete', $request->complete === '1');
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $alumnis   = $query->latest()->paginate(20)->withQueryString();
        $angkatans = Angkatan::get();

        return view('admin.alumni.index', compact('alumnis', 'angkatans'));
    }

    /**
     * Menampilkan profil detail dari seorang alumni.
     * Termasuk memuat relasi pendidikan, pekerjaan, dan foto yang terkait.
     */
    public function show(Alumni $alumni)
    {
        $alumni->load(['user', 'angkatan', 'pendidikan', 'pekerjaan', 'fotos']);
        return view('admin.alumni.show', compact('alumni'));
    }

    /**
     * Menampilkan halaman formulir untuk mengedit data alumni.
     */
    public function edit(Alumni $alumni)
    {
        $alumni->load(['user', 'angkatan', 'pendidikan', 'pekerjaan', 'fotos']);
        $angkatans = Angkatan::get();
        return view('admin.alumni.edit', compact('alumni', 'angkatans'));
    }

    /**
     * Memproses penyimpanan pembaruan data alumni ke database.
     * Log aktivitas admin akan otomatis dicatat oleh AlumniService.
     */
    public function update(UpdateAdminAlumniRequest $request, Alumni $alumni)
    {
        try {
            $this->alumniService->updateAlumni($alumni, $request->validated(), Auth::id());
            
            if ($request->wantsJson()) {
                session()->flash('success', 'Data alumni berhasil diperbarui!');
                return response()->json(['success' => true]);
            }

            return redirect()->route('admin.alumni.show', $alumni)
                ->with('success', 'Data alumni berhasil diperbarui!');
        } catch (Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Mengubah status verifikasi pendaftaran alumni (Pending/Verified/Rejected).
     * Jika diverifikasi, akun pengguna terkait akan otomatis diaktifkan.
     */
    public function verify(Request $request, Alumni $alumni)
    {
        $request->validate([
            'status' => ['required', \Illuminate\Validation\Rule::enum(\App\Enums\AlumniStatus::class)],
        ]);

        try {
            $message = $this->alumniService->verifyAlumni($alumni, $request->status, Auth::id());
            return back()->with('success', $message);
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat verifikasi: ' . $e->getMessage());
        }
    }

    /**
     * Mereset password akun alumni menjadi karakter acak secara otomatis.
     * Password baru akan ditampilkan dalam pesan flash (session) satu kali.
     */
    public function resetPassword(Alumni $alumni)
    {
        try {
            $newPassword = $this->alumniService->resetPassword($alumni, Auth::id());
            return back()->with('success', "Password {$alumni->nama_lengkap} berhasil direset. Password baru: {$newPassword}");
        } catch (Exception $e) {
            return back()->with('error', 'Gagal reset password: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman form untuk melakukan reset password berdasarkan NISN.
     */
    public function resetPasswordForm()
    {
        return view('admin.alumni.reset-password');
    }

    /**
     * Memproses permintaan reset password spesifik menggunakan NISN alumni.
     * Password akan disesuaikan dengan input yang diberikan oleh Admin.
     */
    public function resetPasswordByNisn(Request $request)
    {
        $request->validate([
            'nisn'     => 'required|string|exists:alumni,nisn',
            'password' => 'required|min:8|confirmed',
        ], [
            'nisn.required'      => 'NISN wajib diisi',
            'nisn.exists'        => 'NISN tidak ditemukan dalam sistem',
            'password.required'  => 'Password wajib diisi',
            'password.min'       => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        try {
            $alumni = $this->alumniService->resetPasswordByNisn($request->nisn, $request->password, Auth::id());
            return redirect()->route('admin.alumni.resetPasswordForm')
                ->with('success', "Password alumni NISN {$request->nisn} ({$alumni->nama_lengkap}) berhasil direset!");
        } catch (Exception $e) {
            return back()->with('error', 'Gagal reset password: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menghapus permanen satu data alumni beserta seluruh relasi dan akunnya.
     * Tindakan ini tidak dapat dibatalkan (Force Delete).
     */
    public function destroy($id)
    {
        try {
            $alumni = Alumni::withTrashed()->findOrFail($id);
            $this->alumniService->deleteAlumni($alumni, Auth::id());
            return redirect()->route('admin.alumni.index')
                ->with('success', 'Data alumni berhasil dihapus permanen!');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman form untuk mengekspor data alumni ke dalam file Excel.
     */
    public function exportForm()
    {
        $angkatans = Angkatan::get();
        return view('admin.alumni.export', compact('angkatans'));
    }

    /**
     * Memproses filter data dan mengunduh hasil ekspor data alumni dalam format Excel (.xlsx).
     */
    public function export(Request $request)
    {
        $filters = $request->only(['status', 'angkatan_id', 'complete']);
        
        $timestamp = now()->format('Y-m-d_H-i-s');
        $fileName = "Data_Alumni_{$timestamp}.xlsx";

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\AlumniExport($filters), 
            $fileName
        );
    }

    /**
     * Menampilkan halaman form untuk mengimpor data alumni dari file Excel.
     */
    public function importForm()
    {
        return view('admin.alumni.import');
    }

    /**
     * Mengunduh template file Excel kosong yang sudah disesuaikan formatnya untuk keperluan impor data.
     */
    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\AlumniTemplateExport, 
            'template_import_alumni.xlsx'
        );
    }

    /**
     * Memproses file Excel yang diunggah untuk memasukkan data alumni secara massal.
     * File sementara akan dihapus secara otomatis setelah proses selesai atau gagal.
     */
    public function import(Request $request)
    {
        // Queue connection harus SYNC di shared hosting cPanel
        // Set QUEUE_CONNECTION=sync di .env production
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048', // max 2MB untuk shared hosting
        ], [
            'file.required' => 'File Excel wajib diunggah',
            'file.mimes'    => 'Format file harus berupa Excel (.xlsx, .xls) atau CSV',
            'file.max'      => 'Ukuran file maksimal 2MB (batas shared hosting)',
        ]);

        // Beri batas waktu 2 menit — aman karena ada limit, berbeda dengan set_time_limit(0)
        set_time_limit(120);

        $filePath = null;
        try {
            $filePath = $request->file('file')->store('imports');

            $import = new \App\Imports\AlumniImport(Auth::id());
            \Maatwebsite\Excel\Facades\Excel::import($import, $filePath);

            $this->cacheService->clearAllAlumniRelated();

            $successCount = $import->getSuccessCount();
            $failedCount  = $import->getFailedCount();
            $fatalCount   = $import->getFatalCount();

            $message = "Import selesai: {$successCount} data alumni berhasil dimasukkan.";
            if ($failedCount > 0) {
                $message .= " {$failedCount} baris dilewati (duplikat/tidak valid).";
            }
            if ($fatalCount > 0) {
                $message .= " PERINGATAN: Ada {$fatalCount} batch yang batal diimport karena error database sistem. Silakan cek log.";
                return redirect()->route('admin.alumni.index')->with('warning', $message);
            }

            return redirect()->route('admin.alumni.index')->with('success', $message);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = collect($e->failures())->map(fn($f) => "Baris {$f->row()}: " . implode(', ', $f->errors()))->implode(' | ');
            \Illuminate\Support\Facades\Log::warning('Import validation errors: ' . $failures);
            return back()->with('error', 'Terdapat kesalahan validasi pada file: ' . $failures);
        } catch (Exception $e) {
            \Illuminate\Support\Facades\Log::error('Import initiation failed: ' . $e->getMessage());
            return back()->with('error', 'Gagal memulai proses import: ' . $e->getMessage());
        } finally {
            if ($filePath && \Illuminate\Support\Facades\Storage::exists($filePath)) {
                \Illuminate\Support\Facades\Storage::delete($filePath);
            }
        }
    }

    /**
     * Fitur berbahaya: Menghapus SELURUH data alumni di sistem secara massal.
     * Membutuhkan kata kunci konfirmasi spesifik dari pengguna untuk mencegah ketidaksengajaan.
     */
    public function deleteAll(Request $request)
    {
        $request->validate([
            'confirmation' => 'required|string|in:HAPUS SEMUA DATA',
            'password'     => 'required|string',
        ], [
            'confirmation.in'   => 'Kata konfirmasi tidak sesuai. Ketik "HAPUS SEMUA DATA" untuk melanjutkan.',
            'password.required' => 'Password admin wajib diisi untuk verifikasi.',
        ]);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return back()->with('error', 'Password yang Anda masukkan salah. Proses penghapusan massal dibatalkan.');
        }

        try {
            $this->alumniService->deleteAllAlumni(Auth::id());
            return redirect()->route('admin.alumni.index')
                ->with('success', 'Seluruh data alumni berhasil dihapus secara permanen.');
        } catch (Exception $e) {
            \Illuminate\Support\Facades\Log::error('Bulk delete failed: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus data masal: ' . $e->getMessage());
        }
    }
}
