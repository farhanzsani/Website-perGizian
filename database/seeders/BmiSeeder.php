<?php

namespace Database\Seeders;

use App\Models\Bmi;
use App\Models\Pengguna;
use Illuminate\Database\Seeder;

class BmiSeeder extends Seeder
{
    public function run(): void
    {
        $pengguna = Pengguna::first();
        if ($pengguna) {
            Bmi::create([
                'pengguna_id' => $pengguna->id,
                'skor' => 22.8,
                'keterangan' => 'Normal',
                'berat_badan' => 70,
                'tinggi_badan' => 175,
            ]);
        }
    }
}
