<?php

namespace Database\Seeders;

use App\Models\Keluarga;
use App\Models\Pengguna;
use Illuminate\Database\Seeder;

class KeluargaSeeder extends Seeder
{
    public function run(): void
    {
        $pengguna = Pengguna::first();

        if ($pengguna) {
            // Buat Keluarga
            $keluarga = Keluarga::create([
                'nama_keluarga' => 'Keluarga Budi',
                'kepala_keluarga_id' => $pengguna->id,
            ]);

            // Update Pengguna jadi anggota keluarga
            $pengguna->update(['keluarga_id' => $keluarga->id]);
        }
    }
}
