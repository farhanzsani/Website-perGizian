<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Makanan;

class MakananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan tabel dulu agar tidak duplikat saat di-seed ulang (Opsional)
        // DB::table('makanan')->truncate();
        // DB::table('Kategori_Makanan')->truncate(); // Hati-hati jika ada relasi lain

        // Struktur Data: [Nama Kategori => [Daftar Makanan]]
        $databaseMakanan = [
            'Makanan Pokok' => [
                ['nama' => 'Nasi Putih', 'energi' => 130, 'protein' => 2.4, 'lemak' => 0.3, 'karbohidrat' => 28, 'kuantitas' => 100, 'satuan' => 'gram', 'foto' => 'makanan/nasi-putih.jpg'],
                ['nama' => 'Nasi Merah', 'energi' => 110, 'protein' => 2.8, 'lemak' => 0.9, 'karbohidrat' => 23, 'kuantitas' => 100, 'satuan' => 'gram', 'foto' => 'makanan/nasi-merah.jpg'],
                ['nama' => 'Roti Gandum', 'energi' => 67, 'protein' => 2.4, 'lemak' => 1.1, 'karbohidrat' => 12, 'kuantitas' => 1, 'satuan' => 'lembar', 'foto' => 'makanan/roti-gandum.jpg'],
                ['nama' => 'Kentang Rebus', 'energi' => 87, 'protein' => 1.9, 'lemak' => 0.1, 'karbohidrat' => 20, 'kuantitas' => 100, 'satuan' => 'gram', 'foto' => 'makanan/kentang-rebus.jpg'],
                ['nama' => 'Ubi Jalar Kukus', 'energi' => 90, 'protein' => 2, 'lemak' => 0.2, 'karbohidrat' => 21, 'kuantitas' => 100, 'satuan' => 'gram', 'foto' => 'makanan/ubi-jalar.jpg'],
                ['nama' => 'Oatmeal (Bubur)', 'energi' => 70, 'protein' => 2.5, 'lemak' => 1.5, 'karbohidrat' => 12, 'kuantitas' => 100, 'satuan' => 'gram', 'foto' => 'makanan/oatmeal.jpg'],
                ['nama' => 'Mie Goreng (Instan)', 'energi' => 380, 'protein' => 8, 'lemak' => 14, 'karbohidrat' => 54, 'kuantitas' => 1, 'satuan' => 'bungkus', 'foto' => 'makanan/mie-goreng.jpg'],
                ['nama' => 'Lontong Sayur', 'energi' => 350, 'protein' => 8, 'lemak' => 15, 'karbohidrat' => 50, 'kuantitas' => 1, 'satuan' => 'porsi', 'foto' => 'makanan/lontong-sayur.jpg'],
            ],
            'Lauk Pauk' => [
                ['nama' => 'Dada Ayam Rebus', 'energi' => 165, 'protein' => 31, 'lemak' => 3.6, 'karbohidrat' => 0, 'kuantitas' => 100, 'satuan' => 'gram', 'foto' => 'makanan/dada-ayam.jpg'],
                ['nama' => 'Ayam Goreng Paha', 'energi' => 245, 'protein' => 25, 'lemak' => 15, 'karbohidrat' => 0, 'kuantitas' => 100, 'satuan' => 'gram', 'foto' => 'makanan/ayam-goreng.jpg'],
                ['nama' => 'Telur Rebus', 'energi' => 78, 'protein' => 6, 'lemak' => 5, 'karbohidrat' => 0.6, 'kuantitas' => 1, 'satuan' => 'butir', 'foto' => 'makanan/telur-rebus.jpg'],
                ['nama' => 'Telur Dadar', 'energi' => 95, 'protein' => 6.5, 'lemak' => 7, 'karbohidrat' => 0.4, 'kuantitas' => 1, 'satuan' => 'butir', 'foto' => 'makanan/telur-dadar.jpg'],
                ['nama' => 'Tempe Goreng', 'energi' => 35, 'protein' => 3, 'lemak' => 2, 'karbohidrat' => 1.5, 'kuantitas' => 1, 'satuan' => 'potong', 'foto' => 'makanan/tempe-goreng.jpg'],
                ['nama' => 'Tahu Bacem', 'energi' => 45, 'protein' => 2.5, 'lemak' => 1.5, 'karbohidrat' => 6, 'kuantitas' => 1, 'satuan' => 'potong', 'foto' => 'makanan/tahu-bacem.jpg'],
                ['nama' => 'Ikan Salmon Panggang', 'energi' => 206, 'protein' => 22, 'lemak' => 12, 'karbohidrat' => 0, 'kuantitas' => 100, 'satuan' => 'gram', 'foto' => 'makanan/ikan-salmon.jpg'],
                ['nama' => 'Ikan Lele Goreng', 'energi' => 220, 'protein' => 18, 'lemak' => 14, 'karbohidrat' => 3, 'kuantitas' => 100, 'satuan' => 'gram', 'foto' => 'makanan/lele-goreng.jpg'],
                ['nama' => 'Rendang Sapi', 'energi' => 195, 'protein' => 22, 'lemak' => 11, 'karbohidrat' => 5, 'kuantitas' => 1, 'satuan' => 'potong', 'foto' => 'makanan/rendang.jpg'],
                ['nama' => 'Sate Ayam', 'energi' => 35, 'protein' => 4, 'lemak' => 2, 'karbohidrat' => 1, 'kuantitas' => 1, 'satuan' => 'tusuk', 'foto' => 'makanan/sate-ayam.jpg'],
            ],
            'Sayuran' => [
                ['nama' => 'Brokoli Rebus', 'energi' => 35, 'protein' => 2.4, 'lemak' => 0.4, 'karbohidrat' => 7, 'kuantitas' => 100, 'satuan' => 'gram', 'foto' => 'makanan/brokoli.jpg'],
                ['nama' => 'Bayam Bening', 'energi' => 36, 'protein' => 3.5, 'lemak' => 0.5, 'karbohidrat' => 6, 'kuantitas' => 1, 'satuan' => 'mangkuk', 'foto' => 'makanan/sayur-bayam.jpg'],
                ['nama' => 'Tumis Kangkung', 'energi' => 90, 'protein' => 3, 'lemak' => 6, 'karbohidrat' => 5, 'kuantitas' => 1, 'satuan' => 'porsi', 'foto' => 'makanan/tumis-kangkung.jpg'],
                ['nama' => 'Sayur Asem', 'energi' => 80, 'protein' => 3, 'lemak' => 2, 'karbohidrat' => 15, 'kuantitas' => 1, 'satuan' => 'mangkuk', 'foto' => 'makanan/sayur-asem.jpg'],
                ['nama' => 'Capcay Kuah', 'energi' => 120, 'protein' => 6, 'lemak' => 5, 'karbohidrat' => 12, 'kuantitas' => 1, 'satuan' => 'porsi', 'foto' => 'makanan/capcay.jpg'],
                ['nama' => 'Salad Sayur (Tanpa Dressing)', 'energi' => 25, 'protein' => 1, 'lemak' => 0.2, 'karbohidrat' => 5, 'kuantitas' => 100, 'satuan' => 'gram', 'foto' => 'makanan/salad-sayur.jpg'],
            ],
            'Buah-buahan' => [
                ['nama' => 'Apel Merah', 'energi' => 52, 'protein' => 0.3, 'lemak' => 0.2, 'karbohidrat' => 14, 'kuantitas' => 1, 'satuan' => 'buah sedang', 'foto' => 'makanan/apel.jpg'],
                ['nama' => 'Pisang Ambon', 'energi' => 105, 'protein' => 1.3, 'lemak' => 0.4, 'karbohidrat' => 27, 'kuantitas' => 1, 'satuan' => 'buah', 'foto' => 'makanan/pisang.jpg'],
                ['nama' => 'Jeruk Manis', 'energi' => 45, 'protein' => 0.9, 'lemak' => 0.1, 'karbohidrat' => 11, 'kuantitas' => 1, 'satuan' => 'buah', 'foto' => 'makanan/jeruk.jpg'],
                ['nama' => 'Alpukat', 'energi' => 160, 'protein' => 2, 'lemak' => 15, 'karbohidrat' => 9, 'kuantitas' => 100, 'satuan' => 'gram', 'foto' => 'makanan/alpukat.jpg'],
                ['nama' => 'Pepaya Potong', 'energi' => 43, 'protein' => 0.5, 'lemak' => 0.3, 'karbohidrat' => 11, 'kuantitas' => 100, 'satuan' => 'gram', 'foto' => 'makanan/pepaya.jpg'],
                ['nama' => 'Semangka', 'energi' => 30, 'protein' => 0.6, 'lemak' => 0.2, 'karbohidrat' => 8, 'kuantitas' => 100, 'satuan' => 'gram', 'foto' => 'makanan/semangka.jpg'],
            ],
            'Minuman & Susu' => [
                ['nama' => 'Susu Sapi Full Cream', 'energi' => 150, 'protein' => 8, 'lemak' => 8, 'karbohidrat' => 12, 'kuantitas' => 250, 'satuan' => 'ml', 'foto' => 'makanan/susu-fullcream.jpg'],
                ['nama' => 'Susu Low Fat', 'energi' => 100, 'protein' => 8, 'lemak' => 2.5, 'karbohidrat' => 12, 'kuantitas' => 250, 'satuan' => 'ml', 'foto' => 'makanan/susu-lowfat.jpg'],
                ['nama' => 'Kopi Hitam (Tanpa Gula)', 'energi' => 2, 'protein' => 0.3, 'lemak' => 0, 'karbohidrat' => 0, 'kuantitas' => 200, 'satuan' => 'ml', 'foto' => 'makanan/kopi-hitam.jpg'],
                ['nama' => 'Es Teh Manis', 'energi' => 90, 'protein' => 0, 'lemak' => 0, 'karbohidrat' => 22, 'kuantitas' => 250, 'satuan' => 'ml', 'foto' => 'makanan/es-teh.jpg'],
                ['nama' => 'Jus Alpukat (Gula Sedikit)', 'energi' => 190, 'protein' => 2, 'lemak' => 12, 'karbohidrat' => 20, 'kuantitas' => 1, 'satuan' => 'gelas', 'foto' => 'makanan/jus-alpukat.jpg'],
                ['nama' => 'Air Kelapa Muda', 'energi' => 45, 'protein' => 0.7, 'lemak' => 0.2, 'karbohidrat' => 9, 'kuantitas' => 250, 'satuan' => 'ml', 'foto' => 'makanan/air-kelapa.jpg'],
            ],
            'Camilan' => [
                ['nama' => 'Coklat Batang (Dark)', 'energi' => 170, 'protein' => 2, 'lemak' => 12, 'karbohidrat' => 15, 'kuantitas' => 30, 'satuan' => 'gram', 'foto' => 'makanan/coklat.jpg'],
                ['nama' => 'Kacang Almond Panggang', 'energi' => 160, 'protein' => 6, 'lemak' => 14, 'karbohidrat' => 6, 'kuantitas' => 28, 'satuan' => 'gram', 'foto' => 'makanan/almond.jpg'],
                ['nama' => 'Keripik Singkong', 'energi' => 160, 'protein' => 1, 'lemak' => 8, 'karbohidrat' => 20, 'kuantitas' => 30, 'satuan' => 'gram', 'foto' => 'makanan/keripik.jpg'],
                ['nama' => 'Biskuit Gandum', 'energi' => 70, 'protein' => 1, 'lemak' => 3, 'karbohidrat' => 10, 'kuantitas' => 1, 'satuan' => 'keping', 'foto' => 'makanan/biskuit.jpg'],
                ['nama' => 'Yoghurt Plain', 'energi' => 60, 'protein' => 3.5, 'lemak' => 3, 'karbohidrat' => 4.7, 'kuantitas' => 100, 'satuan' => 'gram', 'foto' => 'makanan/yoghurt.jpg'],
            ]
        ];

        // Loop Kategori
        foreach ($databaseMakanan as $kategoriNama => $items) {

            // 1. Cek atau Buat Kategori
            // Pastikan nama kolom 'nama' atau 'kategori' sesuai tabel Kategori_Makanan Anda
            $kategoriId = DB::table('Kategori_Makanan')->where('kategori', $kategoriNama)->value('id');

            if (!$kategoriId) {
                $kategoriId = DB::table('Kategori_Makanan')->insertGetId([
                    'kategori' => $kategoriNama,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 2. Loop Makanan dalam Kategori tersebut
            foreach ($items as $makanan) {
                // Cek agar tidak duplikat jika di-seed berulang kali
                if (!Makanan::where('nama', $makanan['nama'])->exists()) {
                    Makanan::create([
                        'nama'                => $makanan['nama'],
                        'energi'              => $makanan['energi'],
                        'protein'             => $makanan['protein'],
                        'lemak'               => $makanan['lemak'],
                        'karbohidrat'         => $makanan['karbohidrat'],
                        'kuantitas'           => $makanan['kuantitas'],
                        'satuan'              => $makanan['satuan'],
                        'kategori_makanan_id' => $kategoriId,
                        'foto_makanan'        => $makanan['foto'],
                        'foto_gizi'           => null, // Nullable
                    ]);
                }
            }
        }
    }
}
