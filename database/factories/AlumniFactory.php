<?php

namespace Database\Factories;

use App\Models\Alumni;
use App\Models\User;
use App\Models\Angkatan;
use App\Enums\AlumniStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlumniFactory extends Factory
{
    protected $model = Alumni::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nisn' => $this->faker->unique()->numerify('##########'),
            'nipd' => $this->faker->unique()->numerify('#####'),
            'nama_lengkap' => $this->faker->name(),
            'nama_panggilan' => $this->faker->firstName(),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'angkatan_id' => Angkatan::factory()->lulus(),
            'tahun_lulus' => $this->faker->numberBetween(2005, 2025),
            'jenjang_pendidikan_saat_ini' => 'SD',
            'alamat' => $this->faker->address(),
            'no_hp' => $this->faker->numerify('08##########'),
            'show_no_hp' => true,
            'email' => $this->faker->safeEmail(),
            'harapan' => $this->faker->sentence(),
            'status_verifikasi' => AlumniStatus::PENDING->value,
            'is_profile_complete' => false,
        ];
    }

    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_verifikasi' => AlumniStatus::VERIFIED->value,
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_verifikasi' => AlumniStatus::REJECTED->value,
        ]);
    }

    public function profileComplete(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_profile_complete' => true,
        ]);
    }
}
