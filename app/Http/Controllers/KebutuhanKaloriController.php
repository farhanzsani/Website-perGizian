<?php

namespace App\Http\Controllers;

use App\Models\Bmi;
use App\Models\KebutuhanKalori;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KebutuhanKaloriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'   => 'required|date',
            'aktivitas_fisik' => 'required|in:Ringan,Sedang,Berat', // Sesuaikan dengan value di database/view
        ]);

        $pengguna = $request->user()->pengguna;
        $usia = Carbon::parse($validated['tanggal_lahir'])->age;

        if ($validated['jenis_kelamin'] == 'Laki-laki') {
            $bmr = (10 * $validated['berat_badan']) + (6.25 * $validated['tinggi_badan']) - (5 * $usia) + 5;
        } else {
            $bmr = (10 * $validated['berat_badan']) + (6.25 * $validated['tinggi_badan']) - (5 * $usia) - 161;
        }

        // Tentukan Faktor Aktivitas
        $faktor = match($validated['aktivitas_fisik']) {
            'Ringan' => 1.2,
            'Sedang' => 1.55,
            'Berat'  => 1.725,
            default  => 1.2,
        };

        $totalKalori = round($bmr * $faktor);

        KebutuhanKalori::updateOrCreate(
            ['pengguna_id' => $pengguna->id],
            [
                'skor'            => $totalKalori,
                'keterangan'      => 'Kebutuhan Harian',
                'jenis_kelamin'   => $validated['jenis_kelamin'],
                'berat_badan'     => $validated['berat_badan'],
                'tinggi_badan'    => $validated['tinggi_badan'],
                'usia'            => $usia,
                'aktivitas_fisik' => $validated['aktivitas_fisik'],
            ]
        );
        // return redirect()->route('')->with('status', '');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
