<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('alumni', function (Blueprint $table) {
            $table->string('jenjang_pendidikan_saat_ini')->default('SD')->after('tahun_lulus')
                ->comment('SD, SMP, SMA, KULIAH, KERJA');
        });

        Schema::table('alumni_pendidikan', function (Blueprint $table) {
            $table->string('fakultas')->nullable()->after('nama_instansi');
        });
    }

    public function down(): void
    {
        Schema::table('alumni', function (Blueprint $table) {
            $table->dropColumn('jenjang_pendidikan_saat_ini');
        });

        Schema::table('alumni_pendidikan', function (Blueprint $table) {
            $table->dropColumn('fakultas');
        });
    }
};
