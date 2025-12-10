<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return view('profile.index', [
            'user' => $request->user(),

        ]);
    }
    /**
     * Display the user's profile form.
     */
    public function editdata(Request $request): View
    {
        return view('profile.editdata', [
            'pengguna' => $request->user()->pengguna,
        ]);
    }

     public function updatedata(Request $request)
    {

        $validated = $request->validate([
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'berat_badan'     => 'required|numeric|min:30',
            'tinggi_badan'    => 'required|numeric|min:100',
            'tanggal_lahir'   => 'required|date',
            'aktivitas_fisik' => 'required|in:Ringan,Sedang,Berat',
        ]);


        $pengguna = $request->user()->pengguna;


        if (!$pengguna) {
            return redirect()->route('onboarding')->with('error', 'Silakan isi data awal terlebih dahulu.');
        }


        $tinggiMeter = $validated['tinggi_badan'] / 100;


        $skorBmi = $validated['berat_badan'] / ($tinggiMeter * $tinggiMeter);


        $usia = Carbon::parse($validated['tanggal_lahir'])->age;


        if ($validated['jenis_kelamin'] == 'Laki-laki') {
            $bmr = (10 * $validated['berat_badan']) + (6.25 * $validated['tinggi_badan']) - (5 * $usia) + 5;
        } else {
            $bmr = (10 * $validated['berat_badan']) + (6.25 * $validated['tinggi_badan']) - (5 * $usia) - 161;
        }


        $faktor = match($validated['aktivitas_fisik']) {
            'Ringan' => 1.2,
            'Sedang' => 1.55,
            'Berat'  => 1.725,
            default  => 1.2,
        };

        $totalKalori = round($bmr * $faktor);

        $pengguna->update([
            'jenis_kelamin'   => $validated['jenis_kelamin'],
            'berat_badan'     => $validated['berat_badan'],
            'tinggi_badan'    => $validated['tinggi_badan'],
            'tanggal_lahir'   => $validated['tanggal_lahir'],
            'aktivitas_fisik' => $validated['aktivitas_fisik'],
            'bmi'             => $skorBmi,
            'kalori'          => $totalKalori
        ]);


        return redirect()->route('profile.index')->with('status', 'profile-updated');
    }



    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.index')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
