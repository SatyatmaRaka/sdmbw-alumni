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
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->unique()->after('username');
        });

        // Sinkronisasi data email dari tabel alumni ke users (jika sudah ada data)
        \Illuminate\Support\Facades\DB::table('alumni')
            ->whereNotNull('email')
            ->orderBy('id')
            ->chunk(100, function ($alumnis) {
                foreach ($alumnis as $alumni) {
                    \Illuminate\Support\Facades\DB::table('users')
                        ->where('id', $alumni->user_id)
                        ->update(['email' => $alumni->email]);
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
};
