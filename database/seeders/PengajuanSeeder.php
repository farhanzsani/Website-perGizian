<?php

namespace Database\Seeders;

use App\Models\Pengajuan;
use App\Models\Pengguna;
use Illuminate\Database\Seeder;

class PengajuanSeeder extends Seeder
{
    public function run(): void
    {
        $pengguna = Pengguna::first();

        if ($pengguna) {
            // Contoh 1: Pengajuan Makanan Tradisional
            Pengajuan::create([
                'pengguna_id' => $pengguna->id,
                'nama_makanan' => 'Tempe Mendoan (1 Pcs)',
                'kategori_makanan' => 'Gorengan',

                // Data Gizi Lengkap
                'energi' => 120,       // kkal
                'lemak' => 8.5,        // gram
                'protein' => 4.2,      // gram
                'karbohidrat' => 9.0,  // gram
                'kuantitas' => 1,
                'satuan' => 'pcs',

                // Foto Bukti
                'foto_makanan' => 'pengajuan/tempe-mendoan.jpg',
                'foto_gizi' => 'pengajuan/referensi-gizi-tempe.jpg',

                'status_pengajuan' => 'pending',
            ]);

            // Contoh 2: Pengajuan Minuman
            Pengajuan::create([
                'pengguna_id' => $pengguna->id,
                'nama_makanan' => 'Jus Alpukat Tanpa Gula',
                'kategori_makanan' => 'Minuman',

                // Data Gizi Lengkap
                'energi' => 180,
                'lemak' => 15.0,
                'protein' => 2.0,
                'karbohidrat' => 12.0,

                'kuantitas' => 500,
                'satuan' => 'ml',

                'foto_makanan' => 'pengajuan/jus-alpukat.jpg',
                'foto_gizi' => 'pengajuan/label-gizi-alpukat.jpg',

                'status_pengajuan' => 'approved', // Contoh yang sudah disetujui admin
            ]);
        }
    }
}
