<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pengguna; // Jangan lupa import ini untuk create data Pengguna
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    // 1. Arahkan user ke halaman login Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Handle data callback dari Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari user berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if ($user) {
                // Jika user ada, update google_id (jika sebelumnya login email biasa) dan avatar
                $user->update([
                    'google_id' => $googleUser->id,
                ]);

                Auth::login($user);
                return redirect()->intended('dashboard'); // Redirect ke dashboard
            } else {
                // Jika user belum ada, buat user baru
                $newUser = User::create([
                    'name'      => $googleUser->name,
                    'email'     => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password'  => Hash::make(Str::random(16)), // Password random
                ]);

                // Assign Role (Spatie)
                $newUser->assignRole('user');

                // Create Data Pengguna (PENTING: Agar tidak error di dashboard/onboarding)
                Pengguna::create([
                    'user_id' => $newUser->id,
                ]);

                Auth::login($newUser);

                // Arahkan ke onboarding karena ini user baru
                return redirect()->route('onboarding');
            }

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login dengan Google.');
        }
    }
}
