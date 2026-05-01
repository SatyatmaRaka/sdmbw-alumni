<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * P2-4: Tambahkan CASCADE DELETE pada foreign key relasi alumni
     * agar saat data alumni dihapus, relasi pendidikan/pekerjaan/foto
     * terhapus otomatis oleh database tanpa perlu kode manual.
     */
    public function up(): void
    {
        // ── alumni_pendidikan ──────────────────────────────────────────
        Schema::table('alumni_pendidikan', function (Blueprint $table) {
            // Hapus foreign key lama (jika ada)
            try {
                $table->dropForeign(['alumni_id']);
            } catch (\Exception $e) {
                // Mungkin constraint belum ada — lanjutkan
            }
            // Tambahkan ulang dengan cascade
            $table->foreign('alumni_id')
                  ->references('id')
                  ->on('alumni')
                  ->onDelete('cascade');
        });

        // ── alumni_pekerjaan ───────────────────────────────────────────
        Schema::table('alumni_pekerjaan', function (Blueprint $table) {
            try {
                $table->dropForeign(['alumni_id']);
            } catch (\Exception $e) { }

            $table->foreign('alumni_id')
                  ->references('id')
                  ->on('alumni')
                  ->onDelete('cascade');
        });

        // ── alumni_fotos ───────────────────────────────────────────────
        Schema::table('alumni_fotos', function (Blueprint $table) {
            try {
                $table->dropForeign(['alumni_id']);
            } catch (\Exception $e) { }

            $table->foreign('alumni_id')
                  ->references('id')
                  ->on('alumni')
                  ->onDelete('cascade');
        });

        // ── testimonis ─────────────────────────────────────────────────
        Schema::table('testimonis', function (Blueprint $table) {
            try {
                $table->dropForeign(['alumni_id']);
            } catch (\Exception $e) { }

            $table->foreign('alumni_id')
                  ->references('id')
                  ->on('alumni')
                  ->onDelete('cascade');
        });
    }

    /**
     * Rollback: kembalikan ke foreign key tanpa cascade.
     */
    public function down(): void
    {
        Schema::table('alumni_pendidikan', function (Blueprint $table) {
            $table->dropForeign(['alumni_id']);
            $table->foreign('alumni_id')->references('id')->on('alumni');
        });

        Schema::table('alumni_pekerjaan', function (Blueprint $table) {
            $table->dropForeign(['alumni_id']);
            $table->foreign('alumni_id')->references('id')->on('alumni');
        });

        Schema::table('alumni_fotos', function (Blueprint $table) {
            $table->dropForeign(['alumni_id']);
            $table->foreign('alumni_id')->references('id')->on('alumni');
        });

        Schema::table('testimonis', function (Blueprint $table) {
            $table->dropForeign(['alumni_id']);
            $table->foreign('alumni_id')->references('id')->on('alumni');
        });
    }
};
