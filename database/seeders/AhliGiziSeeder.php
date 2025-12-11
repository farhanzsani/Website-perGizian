<?php

namespace Database\Seeders;

use App\Models\Ahligizi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AhliGiziSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data 1
        AhliGizi::create([
            'nama' => 'Dr. Sari Rahmawati',
            // Kita isi path dummy agar tidak error database
            'foto' => 'ahli_gizi/dr-sari.jpg',
            'nomor_hp' => '6281234567890',
            'spesialis' => 'Spesialis Gizi Klinik',
            'alamat' => 'Jl. Kesehatan No. 10, Jakarta',
            'deskripsi' => 'Ahli dalam diet diabetes & hipertensi.',
            'tanggal_lahir' => '1985-05-20',
        ]);

        // Data 2
        AhliGizi::create([
            'nama' => 'Budi Santoso, S.Gz',
            'foto' => 'ahli_gizi/budi-santoso.jpg',
            'nomor_hp' => '6281234567891',
            'spesialis' => 'Ahli Gizi Olahraga',
            'alamat' => 'Jl. Olahraga No. 88, Bandung',
            'deskripsi' => 'Fokus pada pembentukan massa otot & stamina.',
            'tanggal_lahir' => '1990-08-15',
        ]);

        // Data 3
        AhliGizi::create([
            'nama' => 'Rina Amalia, M.Gizi',
            'foto' => 'ahli_gizi/rina-amalia.jpg',
            'nomor_hp' => '6281234567892',
            'spesialis' => 'Nutrisionis Anak',
            'alamat' => 'Jl. Melati No. 5, Surabaya',
            'deskripsi' => 'Spesialisasi MPASI dan gizi tumbuh kembang anak.',
            'tanggal_lahir' => '1992-12-10',
        ]);
    }
}
