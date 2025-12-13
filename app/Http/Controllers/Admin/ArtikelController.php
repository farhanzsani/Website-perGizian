<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\KategoriArtikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
   public function index(Request $request)
    {
        $query = Artikel::with('kategori')->latest();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%");
        }
        if ($request->filled('kategori')) {
            $kategoriId = $request->kategori;
            $query->whereHas('kategori', function ($q) use ($kategoriId) {
                $q->where('kategori_artikel.id', $kategoriId);
            });
        }

        $artikel = $query->paginate(10)->withQueryString();
        $kategoriList = KategoriArtikel::all();

        return view('admin.artikel.index', compact('artikel', 'kategoriList'));
    }

    /**
     * Menampilkan form buat artikel baru.
     */
    public function create()
    {
        $kategori = KategoriArtikel::all();
        return view('admin.artikel.create', compact('kategori'));
    }

    public function show($id)
    {
        // Ambil artikel beserta kategorinya
        $artikel = Artikel::with('kategori')->findOrFail($id);

        return view('admin.artikel.show', compact('artikel'));
    }

    /**
     * Menyimpan artikel baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'judul'         => 'required|string|max:255',
            'content'       => 'required', // Bisa berisi HTML dari text editor
            'foto'          => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Max 2MB
            'kategori_id'   => 'required|array', // Menerima array ID kategori
            'kategori_id.*' => 'exists:kategori_artikel,id',
        ]);

        // 2. Upload Gambar
        if ($request->hasFile('foto')) {
            // Simpan di folder: storage/app/public/artikel
            $path = $request->file('foto')->store('artikel', 'public');
            $validated['foto'] = $path;
        }

        // 3. Simpan Artikel Utama
        // Hapus kategori_id dari array validated agar tidak error saat create Artikel
        $kategoriIds = $validated['kategori_id'];
        unset($validated['kategori_id']);

        $artikel = Artikel::create($validated);

        // 4. Simpan Relasi Kategori (Many-to-Many)
        // Pastikan model Artikel punya: public function kategori() { return $this->belongsToMany(...); }
        $artikel->kategori()->attach($kategoriIds);

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil diterbitkan!');
    }

    /**
     * Menampilkan form edit artikel.
     */
    public function edit($id)
    {
        $artikel = Artikel::with('kategori')->findOrFail($id);
        $kategori = KategoriArtikel::all();

        // Ambil ID kategori yang sedang aktif untuk auto-select di view
        $activeKategori = $artikel->kategori->pluck('id')->toArray();

        return view('admin.artikel.edit', compact('artikel', 'kategori', 'activeKategori'));
    }

    /**
     * Update artikel yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);

        $validated = $request->validate([
            'judul'         => 'required|string|max:255',
            'content'       => 'required',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'kategori_id'   => 'required|array',
            'kategori_id.*' => 'exists:kategori_artikel,id',
        ]);

        // 1. Cek jika ada gambar baru
        if ($request->hasFile('foto')) {
            // Hapus gambar lama jika ada
            if ($artikel->foto && Storage::disk('public')->exists($artikel->foto)) {
                Storage::disk('public')->delete($artikel->foto);
            }

            // Upload gambar baru
            $validated['foto'] = $request->file('foto')->store('artikel', 'public');
        } else {
            // Jika tidak upload baru, hapus key 'foto' agar tidak menimpa data lama dengan null
            unset($validated['foto']);
        }

        // 2. Update Data Artikel
        $kategoriIds = $validated['kategori_id'];
        unset($validated['kategori_id']); // Pisahkan agar tidak masuk ke update query artikel

        $artikel->update($validated);

        // 3. Update Relasi Kategori (Sync akan menghapus yang lama dan pasang yang baru)
        $artikel->kategori()->sync($kategoriIds);

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Hapus artikel.
     */
    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);

        // 1. Hapus Gambar dari Storage
        if ($artikel->foto && Storage::disk('public')->exists($artikel->foto)) {
            Storage::disk('public')->delete($artikel->foto);
        }

        // 2. Lepaskan Relasi Kategori (Detach)
        $artikel->kategori()->detach();

        // 3. Hapus Record
        $artikel->delete();

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
