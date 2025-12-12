<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Makanan;
use App\Models\KategoriMakanan; // Pastikan model ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KelolaMakananController extends Controller
{
    /**
     * Menampilkan daftar makanan.
     */
   public function index(Request $request)
{
    $query = Makanan::with('kategori');

    // Filter Pencarian (Nama)
    if ($request->filled('search')) {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    // Filter Kategori (Dropdown)
    if ($request->filled('kategori')) {
        $query->where('kategori_makanan_id', $request->kategori);
    }

    $makanan = $query->latest()->paginate(10)->withQueryString();

    // Ambil list kategori untuk dropdown filter
    $kategoriList = KategoriMakanan::all();

    return view('admin.kelolamakanan.index', compact('makanan', 'kategoriList'));
}

    /**
     * Form tambah makanan.
     */
    public function create()
    {
        $kategori = KategoriMakanan::all(); // Ambil data kategori untuk dropdown
        return view('admin.kelolamakanan.create', compact('kategori'));
    }

    /**
     * Simpan makanan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'                => 'required|string|max:255',
            'kategori_makanan_id' => 'required|exists:Kategori_Makanan,id', // Sesuaikan nama tabel kategori
            'energi'              => 'required|numeric',
            'protein'             => 'required|numeric',
            'lemak'               => 'required|numeric',
            'karbohidrat'         => 'required|numeric',
            'kuantitas'           => 'required|numeric',
            'satuan'              => 'required|string',
            'foto_makanan'        => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Upload Gambar
        if ($request->hasFile('foto_makanan')) {
            $path = $request->file('foto_makanan')->store('makanan', 'public');
            $validated['foto_makanan'] = $path;
        }

        Makanan::create($validated);

        return redirect()->route('admin.kelolamakanan.index')->with('success', 'Data makanan berhasil ditambahkan!');
    }

    /**
     * Detail makanan.
     */
    public function show(string $id)
    {
        $makanan = Makanan::with('kategori')->findOrFail($id);
        return view('admin.kelolamakanan.show', compact('makanan'));
    }

    /**
     * Form edit makanan.
     */
    public function edit(string $id)
    {
        $makanan = Makanan::findOrFail($id);
        $kategori = KategoriMakanan::all();
        return view('admin.kelolamakanan.edit', compact('makanan', 'kategori'));
    }

    /**
     * Update makanan.
     */
    public function update(Request $request, string $id)
    {
        $makanan = Makanan::findOrFail($id);

        $validated = $request->validate([
            'nama'                => 'required|string|max:255',
            'kategori_makanan_id' => 'required|exists:Kategori_Makanan,id',
            'energi'              => 'required|numeric',
            'protein'             => 'required|numeric',
            'lemak'               => 'required|numeric',
            'karbohidrat'         => 'required|numeric',
            'kuantitas'           => 'required|numeric',
            'satuan'              => 'required|string',
            'foto_makanan'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Cek Gambar Baru
        if ($request->hasFile('foto_makanan')) {
            // Hapus gambar lama
            if ($makanan->foto_makanan && Storage::disk('public')->exists($makanan->foto_makanan)) {
                Storage::disk('public')->delete($makanan->foto_makanan);
            }
            // Upload baru
            $validated['foto_makanan'] = $request->file('foto_makanan')->store('makanan', 'public');
        } else {
            unset($validated['foto_makanan']);
        }

        $makanan->update($validated);

        return redirect()->route('admin.kelolamakanan.index')->with('success', 'Data makanan berhasil diperbarui!');
    }

    /**
     * Hapus makanan.
     */
    public function destroy(string $id)
    {
        $makanan = Makanan::findOrFail($id);

        if ($makanan->foto_makanan && Storage::disk('public')->exists($makanan->foto_makanan)) {
            Storage::disk('public')->delete($makanan->foto_makanan);
        }

        $makanan->delete();

        return redirect()->route('admin.kelolamakanan.index')->with('success', 'Data makanan berhasil dihapus!');
    }
}
