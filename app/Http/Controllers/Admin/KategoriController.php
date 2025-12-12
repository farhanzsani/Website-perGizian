<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriArtikel;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil kategori beserta jumlah artikelnya
        $kategori = KategoriArtikel::withCount('artikel')->latest()->get();
        return view('admin.kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tidak dipakai karena pakai Modal di Index
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|string|max:50|unique:kategori_artikel,kategori',
        ], [
            'kategori.required' => 'Nama kategori wajib diisi.',
            'kategori.unique'   => 'Nama kategori ini sudah ada.',
        ]);

        KategoriArtikel::create([
            'kategori' => $validated['kategori']
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategori = KategoriArtikel::findOrFail($id);

        $validated = $request->validate([
            // Ignore ID saat update agar tidak error unique pada diri sendiri
            'kategori' => 'required|string|max:50|unique:kategori_artikel,kategori,' . $id,
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
        $kategori = KategoriArtikel::findOrFail($id);

        // Opsional: Cek jika kategori masih punya artikel
        if ($kategori->artikel()->count() > 0) {
            return redirect()->back()->with('error', 'Gagal hapus! Kategori ini masih memiliki artikel.');
        }

        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
}
