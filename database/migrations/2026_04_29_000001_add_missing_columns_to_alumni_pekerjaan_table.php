<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom yang dibutuhkan RiwayatController ke tabel alumni_pekerjaan.
     * Kolom gaji, lokasi_perusahaan, tanggal_mulai, tanggal_berakhir dihapus dari model
     * karena tidak sesuai dengan struktur form yang ada.
     */
    public function up(): void
    {
        Schema::table('alumni_pekerjaan', function (Blueprint $table) {
            $table->string('tahun_mulai', 4)->nullable()->after('jabatan');
            $table->string('tahun_selesai', 4)->nullable()->after('tahun_mulai');
            $table->string('alamat_perusahaan', 500)->nullable()->after('tahun_selesai');
        });
    }

    public function down(): void
    {
        Schema::table('alumni_pekerjaan', function (Blueprint $table) {
            $table->dropColumn(['tahun_mulai', 'tahun_selesai', 'alamat_perusahaan']);
        });
    }
};
