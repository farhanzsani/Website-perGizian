<?php

namespace Database\Seeders;

use App\Models\KategoriArtikel;
use Illuminate\Database\Seeder;

class KategoriArtikelSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = ['Kesehatan', 'Tips Diet', 'Resep Sehat', 'Olahraga'];
        foreach ($kategori as $k) {
            KategoriArtikel::create(['kategori' => $k]);
        }
    }
}
