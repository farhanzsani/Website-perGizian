<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriMakanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriMakananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = KategoriMakanan::WithCount('makanan')->latest()->paginate(10);
        return view ('admin.kategorimakanan.index', compact('kategori'));

    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|string|max:50|unique:kategori_makanan,kategori',
        ],
        [
            'kategori.required' => 'Nama kategori wajib diisi.',
            'kategori.unique'   => 'Nama kategori ini sudah ada.',
        ]);

        KategoriMakanan::create([
            'kategori' => $validated['kategori']
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategori = KategoriMakanan::findOrFail($id);

        $validated = $request->validate([
            // Ignore ID saat update agar tidak error unique pada diri sendiri
            'kategori' => 'required|string|max:50|unique:kategori_makanan,kategori,' . $id,
        ], [
            'kategori.required' => 'Nama kategori wajib diisi.',
            'kategori.unique'   => 'Nama kategori ini sudah ada.',
        ]);

        $kategori->update([
            'kategori' => $validated['kategori']
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = KategoriMakanan::findOrFail($id);

        // Opsional: Cek jika kategori masih punya artikel
        if ($kategori->makanan()->count() > 0) {
            return redirect()->back()->with('error', 'Gagal hapus! Kategori ini masih memiliki makanan.');
        }

        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
}
