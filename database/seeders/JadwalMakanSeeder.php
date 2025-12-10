<?php

namespace Database\Seeders;

use App\Models\JadwalMakan;
use App\Models\Pengguna;
use Illuminate\Database\Seeder;

class JadwalMakanSeeder extends Seeder
{
    public function run(): void
    {
        $pengguna = Pengguna::first();
        if ($pengguna) {
            JadwalMakan::create([
                'pengguna_id' => $pengguna->id,
                'nama_jadwal' => 'Sarapan',
                'waktu_jadwal' => '07:00:00',
            ]);
        }
    }
}
