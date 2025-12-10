<?php

namespace Database\Seeders;

use App\Models\Artikel;
use App\Models\KategoriArtikel;
use App\Models\DetailArtikel;
use Illuminate\Database\Seeder;

class DetailArtikelSeeder extends Seeder
{
    public function run(): void
    {
        $artikel = Artikel::first();
        $kategori = KategoriArtikel::first();

        if ($artikel && $kategori) {
            DetailArtikel::create([
                'artikel_id' => $artikel->id,
                'kategori_artikel_id' => $kategori->id,
            ]);
        }
    }
}
