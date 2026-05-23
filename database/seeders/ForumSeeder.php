<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $forums = [
            [
                'name' => 'Diskusi Umum',
                'slug' => 'diskusi-umum',
                'description' => 'Tempat berkumpul dan berdiskusi seputar hal-hal umum.',
                'icon' => '💬',
                'order' => 1,
            ],
            [
                'name' => 'Berbagi Pengalaman',
                'slug' => 'berbagi-pengalaman',
                'description' => 'Bagikan kisah sukses, inspirasi, atau pengalaman berharga Anda di sini.',
                'icon' => '🌟',
                'order' => 2,
            ],
            [
                'name' => 'Karir & Pekerjaan',
                'slug' => 'karir-dan-pekerjaan',
                'description' => 'Informasi lowongan kerja, tips wawancara, dan pengembangan karir.',
                'icon' => '💼',
                'order' => 3,
            ],
            [
                'name' => 'Reuni & Nostalgia',
                'slug' => 'reuni-dan-nostalgia',
                'description' => 'Mengenang masa-masa indah di sekolah dan merencanakan temu kangen.',
                'icon' => '🎓',
                'order' => 4,
            ],
        ];

        foreach ($forums as $forum) {
            \App\Models\Forum::create($forum);
        }
    }
}
