<?php

namespace App\Http\Controllers;

use App\Models\JadwalMakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalMakanController extends Controller
{
   public function index()
    {
        // Ambil jadwal milik user yang login, urutkan dari pagi ke malam
        $jadwal = JadwalMakan::where('pengguna_id', Auth::user()->pengguna->id)
                    ->orderBy('waktu_jadwal', 'asc')
                    ->get();

        return view('jadwal.index', compact('jadwal'));
    }

    /**
     * Menyimpan jadwal baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jadwal' => 'required|string|max:50', // Contoh: "Sarapan", "Snack Sore"
            'waktu_jadwal' => 'required', // Format jam (H:i)
        ]);

        JadwalMakan::create([
            'pengguna_id' => Auth::user()->pengguna->id,
            'nama_jadwal' => $request->nama_jadwal,
            'waktu_jadwal' => $request->waktu_jadwal,
        ]);

        return back()->with('success', 'Jadwal pengingat berhasil ditambahkan.');
    }

    /**
     * Menghapus jadwal
     */
    public function destroy($id)
    {
        $jadwal = JadwalMakan::where('pengguna_id', Auth::user()->pengguna->id)->findOrFail($id);
        $jadwal->delete();

        return back()->with('success', 'Jadwal berhasil dihapus.');
    }
}
