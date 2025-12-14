<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KeluargaController extends Controller
{
   public function index(Request $request)
    {
        $query = Keluarga::withCount('anggota')->with('kepalaKeluarga.user');

        // Fitur Pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama_keluarga', 'like', "%{$search}%")
                  ->orWhere('kode_keluarga', 'like', "%{$search}%");
        }

        $keluarga = $query->latest()->paginate(10);

        return view('admin.keluarga.index', compact('keluarga'));
    }

    /**
     * Form Buat Keluarga Baru
     */
    public function create()
    {
        // Ambil user yang BELUM punya keluarga untuk dijadikan Ketua
        $calonKetua = Pengguna::with('user')
                        ->whereNull('keluarga_id')
                        ->get();

        return view('admin.keluarga.create', compact('calonKetua'));
    }

    /**
     * Simpan Keluarga Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_keluarga' => 'required|string|max:255',
            'kepala_keluarga_id' => 'required|exists:pengguna,id',
        ]);

        $calonKetua = Pengguna::findOrFail($request->kepala_keluarga_id);

        if ($calonKetua->keluarga_id) {
            return back()->with('error', 'User ini sudah punya keluarga!');
        }

        // Generate Kode Unik
        do {
            $kode = Str::upper(Str::random(6));
        } while (Keluarga::where('kode_keluarga', $kode)->exists());

        // Simpan Data Keluarga
        $keluarga = Keluarga::create([
            'nama_keluarga' => $request->nama_keluarga,
            'kepala_keluarga_id' => $calonKetua->id,
            'kode_keluarga' => $kode,
        ]);

        // Update User jadi anggota keluarga tsb
        $calonKetua->update(['keluarga_id' => $keluarga->id]);

        return redirect()->route('admin.keluarga.index')
            ->with('success', 'Keluarga "' . $keluarga->nama_keluarga . '" berhasil dibuat.');
    }

    /**
     * Detail Keluarga
     */
    public function show($id)
    {
        $keluarga = Keluarga::with(['anggota.user', 'kepalaKeluarga.user'])->findOrFail($id);
        return view('admin.keluarga.show', compact('keluarga'));
    }

    /**
     * Hapus Keluarga (Wajib input kode unik)
     */
    public function destroy(Request $request, $id)
    {
        $request->validate([
            'kode_konfirmasi' => 'required|string'
        ]);

        $keluarga = Keluarga::findOrFail($id);

        // 1. Cek Kesamaan Kode
        if (strtoupper($request->kode_konfirmasi) !== strtoupper($keluarga->kode_keluarga)) {
            return back()->with('error', 'Kode konfirmasi salah! Penghapusan dibatalkan.');
        }

        // 2. Keluarkan semua anggota (set null)
        Pengguna::where('keluarga_id', $keluarga->id)->update(['keluarga_id' => null]);

        // 3. Hapus Permanen
        $keluarga->delete();

        return redirect()->route('admin.keluarga.index')
            ->with('success', 'Keluarga berhasil dihapus.');
    }
}
