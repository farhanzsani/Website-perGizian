<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bmi;
use App\Models\KebutuhanKalori;
use App\Models\Pengguna; // Pastikan model Pengguna diimport
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class KalkulatorController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cek apakah user sudah punya data pengguna (profil)
        if (!$user->pengguna) {
            return redirect()->route('onboarding')->with('warning', 'Silakan lengkapi data diri terlebih dahulu.');
        }

        $historyBMI = $user->pengguna->bmi()->latest()->take(5)->get();
        $historyKalori = $user->pengguna->kebutuhanKalori()->latest()->take(5)->get();


        $defaults = $user->pengguna;

        return view('kalkulator.index', compact('historyBMI', 'historyKalori', 'defaults'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'type'            => 'required|in:bmi,kalori',
            'berat_badan'     => 'required|numeric|min:30',
            'tinggi_badan'    => 'required|numeric|min:100',
            'usia'            => 'required|integer|min:10',
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'aktivitas_fisik' => 'nullable|in:Ringan,Sedang,Berat',
        ]);

        $pengguna = Auth::user()->pengguna;


        if ($request->type == 'bmi') {
            $tinggiMeter = $validated['tinggi_badan'] / 100;
            $skor = $validated['berat_badan'] / ($tinggiMeter * $tinggiMeter);

            $keterangan = 'Normal';
            if ($skor < 18.5) $keterangan = 'Kekurangan Berat Badan';
            elseif ($skor >= 25 && $skor <= 29.9) $keterangan = 'Kelebihan Berat Badan';
            elseif ($skor >= 30) $keterangan = 'Obesitas';

            Bmi::create([
                'pengguna_id' => $pengguna->id,
                'skor' => $skor,
                'keterangan' => $keterangan,
                'berat_badan' => $validated['berat_badan'],
                'tinggi_badan' => $validated['tinggi_badan'],
            ]);

            return back()
            ->with('result_bmi', ['skor' => $skor, 'keterangan' => $keterangan])
            ->with('active_tab', 'bmi');
        }


        if ($request->type == 'kalori') {
            if ($validated['jenis_kelamin'] == 'Laki-laki') {
                $bmr = (10 * $validated['berat_badan']) + (6.25 * $validated['tinggi_badan']) - (5 * $validated['usia']) + 5;
            } else {
                $bmr = (10 * $validated['berat_badan']) + (6.25 * $validated['tinggi_badan']) - (5 * $validated['usia']) - 161;
            }

            $faktor = match($validated['aktivitas_fisik']) {
                'Ringan' => 1.2,
                'Sedang' => 1.55,
                'Berat'  => 1.725,
                default  => 1.2,
            };

            $totalKalori = round($bmr * $faktor);

            KebutuhanKalori::create([
                'pengguna_id' => $pengguna->id,
                'skor' => $totalKalori,
                'keterangan' => 'Manual Calculation',
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'berat_badan' => $validated['berat_badan'],
                'tinggi_badan' => $validated['tinggi_badan'],
                'usia' => $validated['usia'],
                'aktivitas_fisik' => $validated['aktivitas_fisik'],
            ]);

            return back()
            ->with('result_kalori', $totalKalori)
            ->with('active_tab', 'kalori');

            }
        }
    }

