<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    public function index()
    {
        $penggunaId = Auth::user()->pengguna->id;
        $pengajuan = Pengajuan::where('pengguna_id', $penggunaId)
                        ->latest()
                        ->paginate(5);

        return view('pengajuan.index', compact('pengajuan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_makanan'     => 'required|string|max:255',
            'kategori_makanan' => 'required|string',
            'kuantitas'        => 'required|numeric|min:0',
            'satuan'           => 'required|string|max:50',
            'energi'           => 'required|numeric|min:0',
            'protein'          => 'required|numeric|min:0',
            'lemak'            => 'required|numeric|min:0',
            'karbohidrat'      => 'required|numeric|min:0',
            'foto_makanan'     => 'required|image|mimes:jpeg,png,jpg,webp|max:5048',
            'foto_gizi'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
        ]);

        // Upload Foto Makanan (Wajib)
        if ($request->hasFile('foto_makanan')) {
            $path = $request->file('foto_makanan')->store('pengajuan/makanan', 'public');
            $validated['foto_makanan'] = $path;
        }

        // Upload Foto Gizi (Opsional/Nullable)
        if ($request->hasFile('foto_gizi')) {
            $pathGizi = $request->file('foto_gizi')->store('pengajuan/gizi', 'public');
            $validated['foto_gizi'] = $pathGizi;
        }

        // Data Otomatis
        $validated['pengguna_id'] = Auth::user()->pengguna->id;
        $validated['status_pengajuan'] = 'pending';

        Pengajuan::create($validated);

        return redirect()->route('makanan.pengajuan.index')->with('success', 'Pengajuan berhasil dikirim!');
    }

    public function edit($id)
    {
        $pengajuan = Pengajuan::where('pengguna_id', Auth::user()->pengguna->id)->findOrFail($id);

        if($pengajuan->status_pengajuan !== 'pending') {
            return back()->with('error', 'Data yang sudah diproses tidak dapat diedit.');
        }

        return view('pengajuan.edit', compact('pengajuan'));
    }

    public function update(Request $request, string $id)
    {
        $pengajuan = Pengajuan::where('pengguna_id', Auth::user()->pengguna->id)->findOrFail($id);

        if($pengajuan->status_pengajuan !== 'pending') {
            return back()->with('error', 'Data tidak dapat diubah.');
        }

        $validated = $request->validate([
            'nama_makanan'     => 'required|string|max:255',
            'kategori_makanan' => 'required|string',
            'kuantitas'        => 'required|numeric',
            'satuan'           => 'required|string',
            'energi'           => 'required|numeric',
            'protein'          => 'required|numeric',
            'lemak'            => 'required|numeric',
            'karbohidrat'      => 'required|numeric',
            'foto_makanan'     => 'nullable|image|max:2048',
            'foto_gizi'        => 'nullable|image|max:2048',
        ]);

        // Update Foto Makanan
        if ($request->hasFile('foto_makanan')) {
            if ($pengajuan->foto_makanan && Storage::disk('public')->exists($pengajuan->foto_makanan)) {
                Storage::disk('public')->delete($pengajuan->foto_makanan);
            }
            $validated['foto_makanan'] = $request->file('foto_makanan')->store('pengajuan/makanan', 'public');
        }

        // Update Foto Gizi
        if ($request->hasFile('foto_gizi')) {
            if ($pengajuan->foto_gizi && Storage::disk('public')->exists($pengajuan->foto_gizi)) {
                Storage::disk('public')->delete($pengajuan->foto_gizi);
            }
            $validated['foto_gizi'] = $request->file('foto_gizi')->store('pengajuan/gizi', 'public');
        }

        $pengajuan->update($validated);

        return redirect()->route('makanan.pengajuan.index')->with('success', 'Pengajuan diperbarui.');
    }

    public function destroy(string $id)
    {
        $pengajuan = Pengajuan::where('pengguna_id', Auth::user()->pengguna->id)->findOrFail($id);

        // Hapus kedua foto
        if ($pengajuan->foto_makanan && Storage::disk('public')->exists($pengajuan->foto_makanan)) {
            Storage::disk('public')->delete($pengajuan->foto_makanan);
        }
        if ($pengajuan->foto_gizi && Storage::disk('public')->exists($pengajuan->foto_gizi)) {
            Storage::disk('public')->delete($pengajuan->foto_gizi);
        }

        $pengajuan->delete();

        return redirect()->route('makanan.pengajuan.index')->with('success', 'Pengajuan dibatalkan.');
    }
}
