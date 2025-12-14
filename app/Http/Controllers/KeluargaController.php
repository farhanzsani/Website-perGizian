<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\PelacakanMakanan;
use App\Models\Pengguna;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KeluargaController extends Controller
{

    /**
     * Halaman utama keluarga
     */
  public function index(Request $request)
    {
        $user = Auth::user()->pengguna;
        $keluarga = $user->keluarga;

        if (!$keluarga) {
            return view('keluarga.no-family');
        }

        $anggota = $keluarga->anggota()->get();
        $isKepala = $user->isKepalaKeluarga();

        // Filter Tanggal
        $selectedDate = $request->get('date', Carbon::today()->format('Y-m-d'));

        $totalTargetKalori = 0;
        $totalTerpenuhiKalori = 0;
        $detailAnggota = [];
        $chartLabels = [];
        $chartData = [];

        foreach ($anggota as $member) {
            // Hitung BMR (Target Kalori)
            $targetKaloriMember = $member->kalori;

            // Hitung Konsumsi
            $terpenuhiKalori = PelacakanMakanan::where('pengguna_id', $member->id)
                                ->whereDate('tanggal_konsumsi', $selectedDate)
                                ->sum('total_kalori');

            $totalTargetKalori += $targetKaloriMember;
            $totalTerpenuhiKalori += $terpenuhiKalori;

            // Data Tabel Anggota
            $detailAnggota[] = [
                'id' => $member->id,
                'nama' => $member->user->name,
                'email' => $member->user->email,
                'target_kalori' => $targetKaloriMember,
                'terpenuhi_kalori' => $terpenuhiKalori,
                'progress_persen' => $targetKaloriMember > 0 ? min(100, round(($terpenuhiKalori / $targetKaloriMember) * 100)) : 0
            ];

            // Data Bar Chart
            $chartLabels[] = Str::limit($member->user->name, 8, '');
            $chartData[] = $terpenuhiKalori;
        }

        // Data Donut Chart (Pencapaian Keluarga)
        $sisaTargetKeluarga = max(0, $totalTargetKalori - $totalTerpenuhiKalori);
        $donutSeriesKeluarga = [$totalTerpenuhiKalori, $sisaTargetKeluarga];

        return view('keluarga.index', compact(
            'keluarga', 'anggota', 'isKepala',
            'totalTargetKalori', 'totalTerpenuhiKalori',
            'detailAnggota', 'selectedDate',
            'chartLabels', 'chartData',
            'donutSeriesKeluarga'
        ));
    }

    public function showMember(Request $request, $id)
    {
        $user = Auth::user()->pengguna;
        $keluarga = $user->keluarga;

        // Validasi: Pastikan yang dilihat adalah anggota keluarga sendiri
        $member = Pengguna::where('id', $id)->where('keluarga_id', $keluarga->id)->firstOrFail();

        $selectedDate = $request->get('date', Carbon::today()->format('Y-m-d'));

        // Ambil list makanan detail
        $riwayatMakan = PelacakanMakanan::with('makanan')
                        ->where('pengguna_id', $member->id)
                        ->whereDate('tanggal_konsumsi', $selectedDate)
                        ->latest('waktu_konsumsi')
                        ->get();

        // Hitung total hari itu
        $totalKalori = $riwayatMakan->sum('total_kalori');

        return view('keluarga.showdetails', compact('member', 'riwayatMakan', 'selectedDate', 'totalKalori'));
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

    // --- LOGIKA GENERATE KODE UNIK ---
    do {
        $kode = Str::upper(Str::random(6)); // Contoh: A1B2C3
    } while (Keluarga::where('kode_keluarga', $kode)->exists());
    // ---------------------------------

    $keluarga = Keluarga::create([
        'nama_keluarga' => $request->nama_keluarga,
        'kepala_keluarga_id' => $user->id,
        'kode_keluarga' => $kode, // Simpan kode
    ]);

    $user->update(['keluarga_id' => $keluarga->id]);

    return redirect()->route('keluarga.index')
        ->with('success', 'Keluarga berhasil dibuat! Kode Invite: ' . $kode);
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

        if (!$user->isKepalaKeluarga()) {
            return back()->with('error', 'Hanya Kepala Keluarga yang bisa membubarkan.');
        }

        // VALIDASI UTAMA: Cek jumlah anggota
        // Jika masih ada orang lain selain ketua, tolak request
        if ($keluarga->anggota()->count() > 1) {
            return back()->with('error', 'Gagal membubarkan. Masih ada anggota lain di keluarga ini. Silakan keluarkan mereka terlebih dahulu atau transfer jabatan kepala keluarga.');
        }

        // Proses Bubarkan (Hanya jika tinggal sendiri)
        $user->update(['keluarga_id' => null]);
        $keluarga->delete();

        return redirect()->route('keluarga.index')->with('success', 'Keluarga telah dibubarkan.');
    }

    /**
     * Kick anggota dari keluarga
     */
    public function kickMember($id)
    {
        $user = Auth::user()->pengguna;
        $keluarga = $user->keluarga;

        // Validasi: Hanya kepala keluarga yg boleh kick
        if (!$user->isKepalaKeluarga()) {
            return back()->with('error', 'Akses ditolak.');
        }

        $targetMember = Pengguna::where('id', $id)->where('keluarga_id', $keluarga->id)->firstOrFail();

        // Validasi: Tidak bisa kick diri sendiri
        if ($targetMember->id === $user->id) {
            return back()->with('error', 'Tidak bisa mengeluarkan diri sendiri.');
        }

        $targetMember->update(['keluarga_id' => null]);

        return back()->with('success', 'Anggota berhasil dikeluarkan.');
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


    public function joinForm(Request $request)
    {
        $user = Auth::user()->pengguna;

        if ($user->keluarga_id) {
            return redirect()->route('keluarga.index');
        }

        $prefillCode = $request->query('code');

        // KIRIM KE VIEW
        return view('keluarga.join', compact('prefillCode'));
    }

    /**
     * Join keluarga via link
     */
    public function join(Request $request)
    {
        $request->validate([
            'kode_keluarga' => 'required|string|size:6',
        ]);

        // Cari keluarga berdasarkan kode
        $keluarga = Keluarga::where('kode_keluarga', Str::upper($request->kode_keluarga))->first();

        if (!$keluarga) {
            return back()->with('error', 'Kode keluarga tidak valid atau tidak ditemukan!');
        }

        $pengguna = Auth::user()->pengguna;

        if ($pengguna->keluarga_id) {
            return redirect()->route('keluarga.index')->with('error', 'Kamu sudah punya keluarga!');
        }

        $pengguna->update(['keluarga_id' => $keluarga->id]);

        return redirect()->route('keluarga.index')
            ->with('success', 'Berhasil bergabung ke keluarga ' . $keluarga->nama_keluarga . '!');
    }






}
