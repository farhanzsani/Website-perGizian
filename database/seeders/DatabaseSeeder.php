<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,

            KategoriArtikelSeeder::class,
            ArtikelSeeder::class,
            DetailArtikelSeeder::class,

            KategoriMakananSeeder::class,
            MakananSeeder::class,

            PenggunaSeeder::class,
            KeluargaSeeder::class, // Harus sesudah Pengguna

            BmiSeeder::class,
            KebutuhanKaloriSeeder::class,
            JadwalMakanSeeder::class,
            PengajuanSeeder::class,

            PelacakanMakananSeeder::class,
            DetailPelacakanMakanSeeder::class,
        ]);
    }
}
