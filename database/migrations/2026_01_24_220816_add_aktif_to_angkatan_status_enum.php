<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("
                ALTER TABLE angkatan
                MODIFY status ENUM('AKTIF','LULUS')
                NOT NULL DEFAULT 'AKTIF'
            ");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("
                ALTER TABLE angkatan
                MODIFY status ENUM('BELUM_LULUS','LULUS')
                NOT NULL DEFAULT 'BELUM_LULUS'
            ");
        }
    }
};
