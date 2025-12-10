<?php

namespace Database\Seeders;

use App\Models\KategoriMakanan;
use Illuminate\Database\Seeder;

class KategoriMakananSeeder extends Seeder
{
    public function run(): void
    {
        $data = ['Makanan Pokok', 'Lauk Pauk', 'Sayuran', 'Buah', 'Minuman'];
        foreach ($data as $d) {
            KategoriMakanan::create(['kategori' => $d]);
        }
    }
}
