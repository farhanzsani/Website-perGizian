<?php

namespace Database\Seeders;

use App\Models\Makanan;
use App\Models\KategoriMakanan;
use Illuminate\Database\Seeder;

class MakananSeeder extends Seeder
{
    public function run(): void
    {
        $katPokok = KategoriMakanan::where('kategori', 'Makanan Pokok')->first();

        if ($katPokok) {
            Makanan::create([
                'nama' => 'Nasi Putih (100g)',
                'energi' => 130,
                'lemak' => 0.3,
                'protein' => 2.7,
                'karbohidrat' => 28,
                'kategori_makanan_id' => $katPokok->id,
                'foto_makanan' => 'makanan/nasi.jpg',
                'foto_gizi' => 'gizi/nasi-gizi.jpg',
            ]);
        }
    }
}
