<?php

namespace Database\Seeders;

use App\Models\KebutuhanKalori;
use App\Models\Pengguna;
use Illuminate\Database\Seeder;

class KebutuhanKaloriSeeder extends Seeder
{
    public function run(): void
    {
        $pengguna = Pengguna::first();
        if ($pengguna) {
            KebutuhanKalori::create([
                'pengguna_id' => $pengguna->id,
                'skor' => 2500,
                'keterangan' => 'Maintenance',
                'jenis_kelamin' => 'Laki-laki',
                'berat_badan' => 70,
                'tinggi_badan' => 175,
                'usia' => 29,
                'aktivitas_fisik' => 'Sedang',
            ]);
        }
    }
}
