<?php

namespace Database\Seeders;

use App\Models\DetailPelacakanMakan;
use App\Models\PelacakanMakanan;
use App\Models\Makanan;
use Illuminate\Database\Seeder;

class DetailPelacakanMakanSeeder extends Seeder
{
    public function run(): void
    {
        $pelacakan = PelacakanMakanan::first();
        $makanan = Makanan::first();

        if ($pelacakan && $makanan) {
            DetailPelacakanMakan::create([
                'pelacakan_makanan_id' => $pelacakan->id,
                'makanan_id' => $makanan->id,
            ]);
        }
    }
}
