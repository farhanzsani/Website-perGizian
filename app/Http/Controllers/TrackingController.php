<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use App\Models\PelacakanMakanan;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    /**
     * Menampilkan Dashboard Tracking (Chart & History)
     */
    /**
     * Menampilkan Dashboard Tracking (Laporan & History)
     */
   public function index(Request $request)
    {
        $pengguna = Auth::user()->pengguna;

        // --- 1. SETUP FILTER & TANGGAL ---
        $selectedDate = $request->get('date', Carbon::today()->format('Y-m-d'));
        $dateObj = Carbon::parse($selectedDate);

        // Filter untuk Chart (Mingguan/Bulanan)
        $chartFilter = $request->get('chart_filter', 'mingguan');

        // Filter untuk Tabel Riwayat (Hari ini/Bulan ini)
        // PERBAIKAN: Nama variabel disamakan jadi $filter agar compact() tidak error
        $filter = $request->get('filter', 'hari_ini');


        // --- 2. HITUNG TARGET KALORI HARIAN (BMR) ---
        $targetKalori = $pengguna->kalori;


        // --- 3. DATA DONUT CHART ---
        $totalKaloriHarian = PelacakanMakanan::where('pengguna_id', $pengguna->id)
                            ->whereDate('tanggal_konsumsi', $selectedDate)
                            ->sum('total_kalori');

        $sisaKalori = max(0, $targetKalori - $totalKaloriHarian);
        $donutSeries = [$totalKaloriHarian, $sisaKalori];


        // --- 4. DATA BAR CHART ---
        if ($chartFilter == 'mingguan') {
            $startDate = $dateObj->copy()->startOfWeek();
            $endDate = $dateObj->copy()->endOfWeek();
            $periodeLabel = $startDate->format('d M') . ' - ' . $endDate->format('d M Y');
        } else {
            $startDate = $dateObj->copy()->startOfMonth();
            $endDate = $dateObj->copy()->endOfMonth();
            $periodeLabel = $startDate->format('F Y');
        }

        $logsInPeriod = PelacakanMakanan::where('pengguna_id', $pengguna->id)
            ->whereBetween('tanggal_konsumsi', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->get()
            ->groupBy('tanggal_konsumsi');

        $terpenuhi = 0;
        $belumTerpenuhi = 0;
        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $dt) {
            $dateKey = $dt->format('Y-m-d');

            // Hitung total kalori hari itu
            $dailySum = $logsInPeriod->flatten()->filter(function ($item) use ($dateKey) {
                return $item->tanggal_konsumsi->format('Y-m-d') === $dateKey;
            })->sum('total_kalori');

            if ($dailySum >= $targetKalori) {
                $terpenuhi++;
            } else {
                $belumTerpenuhi++;
            }
        }
        $barSeries = [$terpenuhi, $belumTerpenuhi];


        // --- 5. DATA HISTORY LIST ---
        $queryHistory = PelacakanMakanan::where('pengguna_id', $pengguna->id)->with('makanan');

        // PERBAIKAN: Menggunakan variabel $filter yang sudah benar
        if ($filter == 'bulan_ini') {
            $queryHistory->whereMonth('tanggal_konsumsi', $dateObj->month)
                         ->whereYear('tanggal_konsumsi', $dateObj->year);
        } else {
            $queryHistory->whereDate('tanggal_konsumsi', $selectedDate);
        }

        $history = $queryHistory->latest('tanggal_konsumsi')
                                ->latest('waktu_konsumsi')
                                ->paginate(10)
                                ->withQueryString();

        return view('makanan.trackingkalori.index', compact(
            'history',
            'totalKaloriHarian',
            'targetKalori',
            'donutSeries',
            'barSeries',
            'periodeLabel',
            'chartFilter',
            'filter',
            'selectedDate'
        ));
    }

    /**
     * Form Tambah Makanan
     */
    public function create()
    {
        $makanan = Makanan::orderBy('nama', 'asc')->get();
        return view('makanan.trackingkalori.create', compact('makanan'));
    }

    /**
     * Simpan Data
     */
    public function store(Request $request)
    {
        $request->validate([
            'makanan_id' => 'required|exists:makanan,id',
            'jumlah' => 'required|numeric|min:0.1',
            'waktu' => 'required', // Input datetime-local
        ]);

        // Parsing Waktu
        $datetime = Carbon::parse($request->waktu);

        // Ambil Data Master Makanan
        $makanan = Makanan::findOrFail($request->makanan_id);

        // Rumus Hitung Kalori: (Energi DB / Kuantitas DB) * Input User
        // Contoh: (100 kkal / 1 porsi) * 2 porsi = 200 kkal
        $kaloriPerUnit = $makanan->energi / ($makanan->kuantitas ?: 1);
        $totalKalori = $kaloriPerUnit * $request->jumlah;

        PelacakanMakanan::create([
            'pengguna_id'      => Auth::user()->pengguna->id,
            'makanan_id'       => $request->makanan_id,
            'jumlah_porsi'     => $request->jumlah,

            // SNAPSHOT: Simpan satuan saat ini agar tidak berubah meski master diedit
            'satuan'           => $makanan->satuan,

            'total_kalori'     => $totalKalori,
            'tanggal_konsumsi' => $datetime->toDateString(),
            'waktu_konsumsi'   => $datetime->toTimeString(),
        ]);

        return redirect()->route('trackingkalori.index')->with('success', 'Makanan berhasil dicatat!');
    }

    /**
     * Form Edit
     */
    public function edit($id)
    {
        $tracking = PelacakanMakanan::where('pengguna_id', Auth::user()->pengguna->id)->findOrFail($id);
        $makanan = Makanan::orderBy('nama', 'asc')->get();

        // Format waktu untuk value input datetime-local HTML5
        $datetimeValue = $tracking->tanggal_konsumsi->format('Y-m-d') . 'T' . \Carbon\Carbon::parse($tracking->waktu_konsumsi)->format('H:i');

        return view('makanan.trackingkalori.edit', compact('tracking', 'makanan', 'datetimeValue'));
    }

    /**
     * Update Data
     */
    public function update(Request $request, $id)
    {
        $tracking = PelacakanMakanan::where('pengguna_id', Auth::user()->pengguna->id)->findOrFail($id);

        $request->validate([
            'makanan_id' => 'required|exists:makanan,id',
            'jumlah' => 'required|numeric|min:0.1',
            'waktu' => 'required',
        ]);

        $datetime = Carbon::parse($request->waktu);
        $makanan = Makanan::findOrFail($request->makanan_id);

        $kaloriPerUnit = $makanan->energi / ($makanan->kuantitas ?: 1);
        $totalKalori = $kaloriPerUnit * $request->jumlah;

        $tracking->update([
            'makanan_id'       => $request->makanan_id,
            'jumlah_porsi'     => $request->jumlah,

            // Update juga satuannya jika user mengganti jenis makanan
            'satuan'           => $makanan->satuan,

            'total_kalori'     => $totalKalori,
            'tanggal_konsumsi' => $datetime->toDateString(),
            'waktu_konsumsi'   => $datetime->toTimeString(),
        ]);

        return redirect()->route('trackingkalori.index')->with('success', 'Catatan diperbarui!');
    }

    /**
     * Hapus Data
     */
    public function destroy($id)
    {
        $tracking = PelacakanMakanan::where('pengguna_id', Auth::user()->pengguna->id)->findOrFail($id);
        $tracking->delete();
        return redirect()->route('trackingkalori.index')->with('success', 'Catatan dihapus.');
    }
}
