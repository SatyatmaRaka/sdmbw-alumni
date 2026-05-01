<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Hapus tabel pendidikan dan pekerjaan yang merupakan duplikat
     * dari alumni_pendidikan dan alumni_pekerjaan.
     *
     * Semua logika sekarang menggunakan:
     *   - AlumniPendidikan → tabel alumni_pendidikan
     *   - AlumniPekerjaan  → tabel alumni_pekerjaan
     */
    public function up(): void
    {
        Schema::dropIfExists('pendidikan');
        Schema::dropIfExists('pekerjaan');
    }

    public function down(): void
    {
        // Tabel pendidikan lama
        Schema::create('pendidikan', function ($table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained('alumni')->onDelete('cascade');
            $table->string('nama_instansi');
            $table->string('jenjang');
            $table->string('program_studi')->nullable();
            $table->string('tahun_masuk', 4)->nullable();
            $table->string('tahun_lulus', 4)->nullable();
            $table->boolean('is_ongoing')->default(false);
            $table->timestamps();
        });

        // Tabel pekerjaan lama
        Schema::create('pekerjaan', function ($table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained('alumni')->onDelete('cascade');
            $table->string('nama_perusahaan');
            $table->string('jabatan')->nullable();
            $table->string('tahun_mulai', 4)->nullable();
            $table->string('tahun_selesai', 4)->nullable();
            $table->string('alamat_perusahaan')->nullable();
            $table->timestamps();
        });
    }
};
