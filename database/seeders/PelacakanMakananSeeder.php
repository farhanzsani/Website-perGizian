<?php

namespace Database\Seeders;

use App\Models\PelacakanMakanan;
use App\Models\Pengguna;
use Illuminate\Database\Seeder;

class PelacakanMakananSeeder extends Seeder
{
    public function run(): void
    {
        $pengguna = Pengguna::first();
        if ($pengguna) {
            PelacakanMakanan::create([
                'pengguna_id' => $pengguna->id,
                'tanggal_konsumsi' => now(),
                'waktu_konsumsi' => '07:15:00',
            ]);
        }
    }
}
