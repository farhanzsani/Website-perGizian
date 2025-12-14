<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Artikel;
use App\Models\Makanan; // Asumsi untuk pengajuan makanan
use App\Models\Keluarga;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. STATISTIK UTAMA (Dengan Tren)
        // Hitung total dan data baru bulan ini untuk persentase kenaikan
        $totalUser = User::count();
        $newUserThisMonth = User::whereMonth('created_at', Carbon::now()->month)->count();

        $totalArtikel = Artikel::count();
        $artikelBaru = Artikel::whereMonth('created_at', Carbon::now()->month)->count();

        $totalMakanan = Makanan::count(); // Asumsi ada status
        $pengajuanPending = Pengajuan::where('status_pengajuan', 'pending')->count();

        $totalKeluarga = Keluarga::count();

        // 2. DATA CHART (Pengguna Baru 7 Hari Terakhir)
        // Format: ['Senin', 'Selasa', ...] dan [5, 12, ...]
        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartData[] = User::whereDate('created_at', $date)->count();
        }

        // 3. TABEL TERBARU
        $latestUsers = User::latest()->take(5)->get();
        $popularArtikel = Artikel::latest()->take(4)->get(); // Asumsi ada relasi views

        return view('admin.dashboard', compact(
            'totalUser', 'newUserThisMonth',
            'totalArtikel', 'artikelBaru',
            'totalMakanan', 'pengajuanPending',
            'totalKeluarga',
            'chartLabels', 'chartData',
            'latestUsers', 'popularArtikel'
        ));
    }
}
