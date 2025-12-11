<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class KeluargaController extends Controller
{

    /**
     * Halaman utama keluarga
     */
    public function index()
    {
        $user = Auth::user()->pengguna; 
        $keluarga = $user->keluarga;

        if (!$keluarga) {
            return view('keluarga.no-family');
        }

        $anggota = $keluarga->anggota()->get();
        $isKepala = $user->isKepalaKeluarga();

        return view('keluarga.index', compact('keluarga', 'anggota', 'isKepala'));
    }

    /**
     * Form buat keluarga baru
     */
    public function create()
    {
        $user = Auth::user()->pengguna;

        if ($user->keluarga_id) {
            return redirect()->route('keluarga.index')
                ->with('error', 'Kamu sudah tergabung dalam keluarga!');
        }

        return view('keluarga.create');
    }

    /**
     * Simpan keluarga baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_keluarga' => 'required|string|max:255',
        ]);

        $user = Auth::user()->pengguna;

        if ($user->keluarga_id) {
            return redirect()->route('keluarga.index')
                ->with('error', 'Kamu sudah tergabung dalam keluarga!');
        }

        // Buat keluarga baru
        $keluarga = Keluarga::create([
            'nama_keluarga' => $request->nama_keluarga,
            'kepala_keluarga_id' => $user->id, 
        ]);

        // Set user sebagai anggota keluarga
        $user->update([
            'keluarga_id' => $keluarga->id,
        ]);

        return redirect()->route('keluarga.index')
            ->with('success', 'Keluarga berhasil dibuat! Kamu sekarang kepala keluarga.');
    }

    /**
     * Form edit keluarga
     */
    public function edit()
    {
        $user = Auth::user()->pengguna;
        $keluarga = $user->keluarga;

        if (!$keluarga) {
            return redirect()->route('keluarga.index')
                ->with('error', 'Kamu belum tergabung dalam keluarga!');
        }

        if (!$user->isKepalaKeluarga()) {
            return redirect()->route('keluarga.index')
                ->with('error', 'Hanya kepala keluarga yang bisa edit!');
        }

        return view('keluarga.edit', compact('keluarga'));
    }

    /**
     * Update keluarga
     */
    public function update(Request $request)
    {
        $request->validate([
            'nama_keluarga' => 'required|string|max:255',
        ]);

        $user = Auth::user()->pengguna;
        $keluarga = $user->keluarga;

        if (!$user->isKepalaKeluarga()) {
            return redirect()->route('keluarga.index')
                ->with('error', 'Hanya kepala keluarga yang bisa edit!');
        }

        $keluarga->update([
            'nama_keluarga' => $request->nama_keluarga,
        ]);

        return redirect()->route('keluarga.index')
            ->with('success', 'Keluarga berhasil diupdate!');
    }

    /**
     * Keluar dari keluarga (untuk anggota biasa)
     */
    public function leave()
    {
        $user = Auth::user()->pengguna;

        if (!$user->keluarga_id) {
            return redirect()->route('keluarga.index')
                ->with('error', 'Kamu tidak tergabung dalam keluarga!');
        }

        if ($user->isKepalaKeluarga()) {
            return redirect()->route('keluarga.index')
                ->with('error', 'Kepala keluarga tidak bisa keluar! Transfer kepemilikan atau hapus keluarga.');
        }

        $user->update(['keluarga_id' => null]);

        return redirect()->route('keluarga.index')
            ->with('success', 'Berhasil keluar dari keluarga.');
    }

    /**
     * Hapus keluarga (hanya kepala keluarga)
     */
    public function destroy()
    {
        $user = Auth::user()->pengguna;
        $keluarga = $user->keluarga;

        if (!$keluarga) {
            return redirect()->route('keluarga.index')
                ->with('error', 'Kamu tidak tergabung dalam keluarga!');
        }

        if (!$user->isKepalaKeluarga()) {
            return redirect()->route('keluarga.index')
                ->with('error', 'Hanya kepala keluarga yang bisa hapus keluarga!');
        }

        // Set semua anggota keluarga_id jadi null
        Pengguna::where('keluarga_id', $keluarga->id)
            ->update(['keluarga_id' => null]);

        // Hapus keluarga
        $keluarga->delete();

        return redirect()->route('keluarga.index')
            ->with('success', 'Keluarga berhasil dihapus.');
    }

    /**
     * Kick anggota dari keluarga
     */
    public function kickMember($id)
    {
        $user = Auth::user()->pengguna;
        $keluarga = $user->keluarga;

        if (!$user->isKepalaKeluarga()) {
            return redirect()->route('keluarga.index')
                ->with('error', 'Hanya kepala keluarga yang bisa kick anggota!');
        }

        $anggota = Pengguna::find($id);

        if (!$anggota || $anggota->keluarga_id != $keluarga->id) {
            return redirect()->route('keluarga.index')
                ->with('error', 'Anggota tidak ditemukan!');
        }

        if ($anggota->id == $user->id) {
            return redirect()->route('keluarga.index')
                ->with('error', 'Kamu tidak bisa kick diri sendiri!');
        }

        $anggota->update(['keluarga_id' => null]);

        return redirect()->route('keluarga.index')
            ->with('success', 'Anggota berhasil dikeluarkan dari keluarga.');
    }

    /**
     * Form invite anggota (generate link invite)
     */
    public function invite()
    {
        $user = Auth::user()->pengguna;
        $keluarga = $user->keluarga;

        if (!$keluarga) {
            return redirect()->route('keluarga.index')
                ->with('error', 'Kamu belum tergabung dalam keluarga!');
        }

        if (!$user->isKepalaKeluarga()) {
            return redirect()->route('keluarga.index')
                ->with('error', 'Hanya kepala keluarga yang bisa invite!');
        }

        return view('keluarga.invite', compact('keluarga'));
    }

    /**
     * Join keluarga via link
     */
    public function join(Request $request)
    {
       $keluargaId = $request->input('keluarga_id') ?? $request->keluarga_id;

        if (!$keluargaId) {
            return redirect()->route('keluarga.index')
                ->with('error', 'Link undangan tidak valid!');
        }

        $keluarga = Keluarga::find($keluargaId);

        if (!$keluarga) {
            return redirect()->route('keluarga.index')
                ->with('error', 'Keluarga tidak ditemukan!');
        }

        
        $pengguna = Auth::user()->pengguna;

        if ($pengguna->keluarga_id) {
            return redirect()->route('keluarga.index')
                ->with('error', 'Kamu sudah tergabung dalam keluarga!');
        }

        $pengguna->update([
            'keluarga_id' => $keluarga->id,
        ]);

        return redirect()->route('keluarga.index')
            ->with('success', 'Berhasil bergabung ke keluarga ' . $keluarga->nama_keluarga . '!');


    }


    
}
