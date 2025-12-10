<?php

namespace App\Http\Controllers;

use App\Models\Bmi;
use Illuminate\Http\Request;

class BmiController extends Controller
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
                    'berat_badan' => 'required|numeric|min:30',
                    'tinggi_badan'=> 'required|numeric|min:100',
                ]);
                $pengguna = $request->user()->pengguna;
            $tinggiMeter = $validated['tinggi_badan'] / 100;
            $skorBmi = $validated['berat_badan'] / ($tinggiMeter * $tinggiMeter);

            $keteranganBmi = 'Normal';
            if ($skorBmi < 18.5) $keteranganBmi = 'Kekurangan Berat Badan';
            elseif ($skorBmi >= 18.5 && $skorBmi <= 24.9) $keteranganBmi = 'Normal';
            elseif ($skorBmi >= 25 && $skorBmi <= 29.9) $keteranganBmi = 'Kelebihan Berat Badan';
            else $keteranganBmi = 'Obesitas';

            Bmi::create([
                'pengguna_id'  => $pengguna,
                'skor'         => $skorBmi,
                'keterangan'   => $keteranganBmi,
                'berat_badan'  => $validated['berat_badan'],
                'tinggi_badan' => $validated['tinggi_badan'],
            ]);

            // return redirect('')
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
