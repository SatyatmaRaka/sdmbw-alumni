<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek berdasarkan role admin agar tidak duplikat
        $adminExists = User::where('role', 'admin')->exists();

        if (!$adminExists) {
            User::create([
                'username'  => 'adminalumnibw',
                // Password diganti menjadi mudah diingat namun cukup kuat
                'password'  => Hash::make('SdmbwAdmin#2026!'),
                'role'      => 'admin',
                // PENTING: Admin harus otomatis aktif agar bisa login
                'is_active' => true,
            ]);

            $this->command->info('✅ Akun admin berhasil dibuat!');
            $this->command->info('   Username: adminalumnibw');
            $this->command->info('   Password: SdmbwAdmin#2026!');
            $this->command->info('   Status  : Aktif (Bypass Verifikasi)');
        } else {
            $this->command->warn('⚠️ Akun admin sudah ada, skip...');
        }
    }
}
