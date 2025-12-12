<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Makanan;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index(){
        $pengajuan = Pengajuan::with('pengguna')->latest()->paginate(10);
        return view('admin.pengajuan.index', compact('pengajuan'));
    }

    public function show($id){
        $pengajuan = Pengajuan::with('pengguna')->findOrFail($id);
        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    public function setuju($id){
        $pengajuan = Pengajuan::findOrFail($id);
        if ($pengajuan->status_pengajuan == 'disetujui') {
            return back()->with('error', 'Pengajuan ini sudah disetujui sebelumnya.');
        }
        $kategori = \App\Models\KategoriMakanan::firstOrCreate(
            ['kategori' => $pengajuan->kategori_makanan]
        );

        Makanan::create([
            'nama'                => $pengajuan->nama_makanan,
            'kategori_makanan_id' => $kategori->id,
            'kuantitas'           => $pengajuan->kuantitas,
            'satuan'              => $pengajuan->satuan,
            'energi'              => $pengajuan->energi,
            'protein'             => $pengajuan->protein,
            'lemak'               => $pengajuan->lemak,
            'karbohidrat'         => $pengajuan->karbohidrat,
            'foto_makanan'        => $pengajuan->foto_makanan, // Pakai foto yang sama
            'foto_gizi'           => $pengajuan->foto_gizi,
        ]);

        // 2. Update status pengajuan jadi 'approved'
        $pengajuan->update([
            'status_pengajuan' => 'disetujui' // Gunakan lowercase agar sesuai view
        ]);

        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan disetujui & masuk database makanan!');
    }

    public function tolak($id){
        $pengajuan = Pengajuan::findOrFail($id);

        $pengajuan->update([
            'status_pengajuan' => 'rejected'
        ]);

        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan telah ditolak.');
    }
}
