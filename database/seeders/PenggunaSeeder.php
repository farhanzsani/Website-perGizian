<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use App\Models\User;
use Illuminate\Database\Seeder;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'budi@gmail.com')->first();

        if ($user) {
            Pengguna::create([
                'user_id' => $user->id,
                'jenis_kelamin' => 'Laki-laki',
                'berat_badan' => 70,
                'tinggi_badan' => 175,
                'tanggal_lahir' => '1995-05-20',
                'aktivitas_fisik' => 'Sedang',
            ]);
        }
    }
}
