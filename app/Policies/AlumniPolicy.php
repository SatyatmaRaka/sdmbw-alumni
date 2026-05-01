<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Alumni;
use App\Models\AlumniPendidikan;
use App\Models\AlumniPekerjaan;
use App\Models\AlumniFoto;

class AlumniPolicy
{
    /**
     * Alumni hanya bisa edit profil milik sendiri.
     */
    public function update(User $user, Alumni $alumni): bool
    {
        return $user->alumni?->id === $alumni->id;
    }

    /**
     * Alumni hanya bisa hapus data pendidikan milik sendiri.
     */
    public function deletePendidikan(User $user, AlumniPendidikan $pendidikan): bool
    {
        return $user->alumni?->id === $pendidikan->alumni_id;
    }

    /**
     * Alumni hanya bisa hapus data pekerjaan milik sendiri.
     */
    public function deletePekerjaan(User $user, AlumniPekerjaan $pekerjaan): bool
    {
        return $user->alumni?->id === $pekerjaan->alumni_id;
    }

    /**
     * Alumni hanya bisa hapus foto milik sendiri.
     */
    public function deleteFoto(User $user, AlumniFoto $foto): bool
    {
        return $user->alumni?->id === $foto->alumni_id;
    }

    /**
     * Admin bisa melakukan semua aksi pada data alumni.
     * Dipanggil sebelum semua method di atas (before hook).
     */
    public function before(User $user): ?bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return null; // lanjut ke method policy spesifik
    }
}
