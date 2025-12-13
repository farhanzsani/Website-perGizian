<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ahligizi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AhliGiziController extends Controller
{
    /**
     * Menampilkan daftar ahli gizi.
     */
    public function index()
    {
        $ahligizi = AhliGizi::latest()->paginate(10);
        return view('admin.ahligizi.index', compact('ahligizi'));
    }

    /**
     * Menampilkan form tambah data.
     */
    public function create()
    {
        return view('admin.ahligizi.create');
    }

    /**
     * Menyimpan data baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'spesialis'     => 'required|string|max:255',
            'nomor_hp'      => 'required|numeric', // Format: 628...
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required|string',
            'deskripsi'     => 'nullable|string',
            'foto'          => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Max 2MB
        ]);

        // Upload Foto
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('ahli_gizi', 'public');
            $validated['foto'] = $path;
        }

        AhliGizi::create($validated);

        return redirect()->route('admin.ahligizi.index')
            ->with('success', 'Ahli Gizi berhasil ditambahkan.');
    }

    /**
     * (Opsional) Detail data. Kita skip karena info sudah ada di index/edit.
     */
    public function show(string $id)
    {
        $ahligizi = AhliGizi::findOrFail($id);
        return view('admin.ahligizi.show', compact('ahligizi'));
    }

    /**
     * Menampilkan form edit data.
     */
    public function edit(string $id)
    {
        $ahligizi = AhliGizi::findOrFail($id);
        return view('admin.ahligizi.edit', compact('ahligizi'));
    }

    /**
     * Mengupdate data yang ada.
     */
    public function update(Request $request, string $id)
    {
        $ahligizi = AhliGizi::findOrFail($id);

        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'spesialis'     => 'required|string|max:255',
            'nomor_hp'      => 'required|numeric',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required|string',
            'deskripsi'     => 'nullable|string',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Cek jika ada foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($ahligizi->foto && Storage::disk('public')->exists($ahligizi->foto)) {
                Storage::disk('public')->delete($ahligizi->foto);
            }
            // Simpan foto baru
            $validated['foto'] = $request->file('foto')->store('ahli_gizi', 'public');
        } else {
            // Hapus key foto agar tidak menimpa data lama dengan null
            unset($validated['foto']);
        }

        $ahligizi->update($validated);

        return redirect()->route('admin.ahligizi.index')
            ->with('success', 'Data Ahli Gizi berhasil diperbarui.');
    }

    /**
     * Menghapus data.
     */
    public function destroy(string $id)
    {
        $ahligizi = AhliGizi::findOrFail($id);

        // Hapus file fisik
        if ($ahligizi->foto && Storage::disk('public')->exists($ahligizi->foto)) {
            Storage::disk('public')->delete($ahligizi->foto);
        }

        $ahligizi->delete();

        return redirect()->route('admin.ahligizi.index')
            ->with('success', 'Data Ahli Gizi berhasil dihapus.');
    }
}
