<?php

namespace App\Http\Controllers\Makanan;

use App\Http\Controllers\Controller;
use App\Models\Makanan;
use Illuminate\Http\Request;

class CariKaloriController extends Controller
{
    /**
     * Menampilkan halaman pencarian kalori.
     */
    public function index(Request $request)
    {
        // Query dasar
        $query = Makanan::query();

        // Logika Pencarian
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where('nama', 'like', "%{$keyword}%");
        }

        // Urutkan dari nama A-Z dan Pagination
        $makanan = $query->orderBy('nama', 'asc')->paginate(12)->withQueryString();

        return view('makanan.carikalori.index', compact('makanan'));
    }

   public function show($id)
    {
        $makanan = Makanan::findOrFail($id);

        // Hitung total gram makro untuk penyebut persentase (Progress Bar)
        $totalGram = $makanan->protein + $makanan->lemak + $makanan->karbohidrat;

        // Hindari pembagian dengan nol
        $persenProtein = $totalGram > 0 ? ($makanan->protein / $totalGram) * 100 : 0;
        $persenLemak   = $totalGram > 0 ? ($makanan->lemak / $totalGram) * 100 : 0;
        $persenKarbo   = $totalGram > 0 ? ($makanan->karbohidrat / $totalGram) * 100 : 0;

        return view('makanan.carikalori.show', compact('makanan', 'persenProtein', 'persenLemak', 'persenKarbo'));
    }
}
