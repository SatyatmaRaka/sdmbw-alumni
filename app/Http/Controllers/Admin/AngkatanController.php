<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Services\CacheService;

class AngkatanController extends Controller
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }
    /**
     * Tampilkan daftar angkatan
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $angkatans = Angkatan::withCount('alumni')
            ->when($search, function($query, $search) {
                return $query->where('nama_angkatan', 'like', "%{$search}%")
                             ->orWhere('tahun_ajaran', 'like', "%{$search}%");
            })
            ->orderBy('id', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.angkatan.index', compact('angkatans', 'search'));
    }

    /**
     * Form tambah angkatan
     */
    public function create()
    {
        // Hitung nomor angkatan berikutnya berdasarkan jumlah data yang ada
        $totalAngkatan = Angkatan::count();
        $nextNumber = $totalAngkatan + 1;

        return view('admin.angkatan.create', compact('nextNumber'));
    }

    /**
     * Simpan angkatan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_angkatan' => 'required|string|max:255',
            'tahun_ajaran'  => 'required|string|max:255',
            'status'        => 'required|in:AKTIF,LULUS',
        ]);

        $angkatan = Angkatan::create($validated);

        // Log aktivitas admin
        AdminLog::log(
            Auth::id(),
            'create_angkatan',
            'angkatan',
            $angkatan->id,
            "Menambah angkatan: {$angkatan->nama_angkatan}"
        );

        $this->clearCache();

        return redirect()
            ->route('admin.angkatan.index')
            ->with('success', 'Angkatan berhasil ditambahkan!');
    }

    /**
     * Form edit angkatan
     */
    public function edit(Angkatan $angkatan)
    {
        return view('admin.angkatan.edit', compact('angkatan'));
    }

    /**
     * Update angkatan
     */
    public function update(Request $request, Angkatan $angkatan)
    {
        $validated = $request->validate([
            'nama_angkatan' => 'required|string|max:255',
            'tahun_ajaran'  => 'required|string|max:255',
            'status'        => 'required|in:AKTIF,LULUS',
        ]);

        $oldStatus = $angkatan->status;
        $angkatan->update($validated);

        // Susun deskripsi log untuk mencatat perubahan status jika ada
        $description = "Mengubah angkatan: {$angkatan->nama_angkatan}";
        if ($oldStatus != $validated['status']) {
            $description .= " (Status: {$oldStatus} → {$validated['status']})";
        }

        // Log aktivitas admin
        AdminLog::log(
            Auth::id(),
            'update_angkatan',
            'angkatan',
            $angkatan->id,
            $description
        );

        $this->clearCache();

        return redirect()
            ->route('admin.angkatan.index')
            ->with('success', 'Angkatan berhasil diupdate!');
    }

    /**
     * Hapus angkatan
     */
    public function destroy(Angkatan $angkatan)
    {
        // Proteksi: Cek apakah ada alumni yang terhubung dengan angkatan ini
        if ($angkatan->alumni()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus angkatan yang sudah memiliki alumni!');
        }

        $namaAngkatan = $angkatan->nama_angkatan;
        $angkatan->delete();

        // Log aktivitas admin
        AdminLog::log(
            Auth::id(),
            'delete_angkatan',
            'angkatan',
            null,
            "Menghapus angkatan: {$namaAngkatan}"
        );

        $this->clearCache();

        return redirect()
            ->route('admin.angkatan.index')
            ->with('success', 'Angkatan berhasil dihapus!');
    }

    /**
     * Bersihkan semua cache yang bergantung pada data angkatan
     */
    private function clearCache(): void
    {
        $this->cacheService->clearAllAlumniRelated();
    }
}
