<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // 2. User Biasa (Budi)
        $user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('user');
    }
}
