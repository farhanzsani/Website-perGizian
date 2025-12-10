<?php

namespace Database\Seeders;

use App\Models\Artikel;
use Illuminate\Database\Seeder;

class ArtikelSeeder extends Seeder
{
    public function run(): void
    {
        Artikel::create([
            'judul' => 'Cara Menurunkan Berat Badan Alami',
            'content' => 'Minum air putih yang cukup dan kurangi gula...',
            'foto' => 'artikel/diet-alami.jpg',
        ]);

        Artikel::create([
            'judul' => 'Manfaat Lari Pagi',
            'content' => 'Lari pagi meningkatkan kesehatan jantung...',
            'foto' => 'artikel/lari-pagi.jpg',
        ]);
    }
}
