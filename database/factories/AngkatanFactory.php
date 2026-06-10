<?php

namespace Database\Factories;

use App\Models\Angkatan;
use Illuminate\Database\Eloquent\Factories\Factory;

class AngkatanFactory extends Factory
{
    protected $model = Angkatan::class;

    public function definition(): array
    {
        $startYear = fake()->unique()->numberBetween(2000, 2030);
        $endYear = $startYear + 1;

        return [
            'nama_angkatan' => 'Angkatan ' . $startYear,
            'tahun_ajaran' => "{$startYear}-{$endYear}",
            'status' => 'BELUM_LULUS',
        ];
    }

    public function aktif(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'AKTIF',
        ]);
    }

    public function lulus(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'LULUS',
        ]);
    }
}
