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


            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if ($user) {

                $user->update([
                    'google_id' => $googleUser->id,
                ]);

                Auth::login($user);

                if($user->hasRole('admin')){
                    return redirect()->intended(route('admin.dashboard')); // Redirect ke dashboard
                }else{
                    if ($user->pengguna && $user->pengguna->berat_badan) {
                        return redirect()->route('onboarding');
                    } else {
                        // Data Masih Kosong (Null) -> Wajib Onboarding
                        return redirect()->intended(route('profile.edit.data'));
                    }
                }
            } else {

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
