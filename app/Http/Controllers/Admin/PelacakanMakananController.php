<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PelacakanMakanan;
use App\Models\DetailPelacakanMakan;
use App\Models\Pengguna;
use App\Models\Makanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelacakanMakananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelacakan = PelacakanMakanan::with('pengguna.user')->latest()->get();
        return view('admin.pelacakanmakanan.index', compact('pelacakan'));
    }

    public function create()
    {
        $users = Pengguna::with('user')->get();
        $makanan = Makanan::all();
        return view('admin.pelacakanmakanan.create', compact('users', 'makanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pengguna_id' => 'required|exists:pengguna,id',
            'tanggal_konsumsi' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.makanan_id' => 'required|exists:makanan,id',
            'items.*.kuantitas' => 'required|numeric|min:0.1',
        ]);

        DB::beginTransaction();
        try {            
            $pelacakan = PelacakanMakanan::create([
                'pengguna_id' => $request->pengguna_id,
                'tanggal_konsumsi' => $request->tanggal_konsumsi,
                'waktu_konsumsi' => now()->format('H:i:s'), // Default jam input
            ]);

            foreach ($request->items as $item) {
                $makanan = Makanan::find($item['makanan_id']);
                
                DetailPelacakanMakan::create([
                    'pelacakan_makanan_id' => $pelacakan->id,
                    'makanan_id' => $item['makanan_id'],
                    'kuantitas' => $item['kuantitas'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.pelacakan-makanan.index')
                ->with('success', 'Data pelacakan makanan berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $pelacakan = PelacakanMakanan::with(['pengguna.user', 'detail.makanan'])->findOrFail($id);
        
        $totalKalori = 0;
        $totalProtein = 0;
        $totalLemak = 0;
        $totalKarbo = 0;

        foreach ($pelacakan->detail as $detail) {
            $makanan = $detail->makanan;
            if ($makanan) {
                $qty = $detail->kuantitas;                 
                $totalKalori += $makanan->energi * $qty;
                $totalProtein += $makanan->protein * $qty;
                $totalLemak += $makanan->lemak * $qty;
                $totalKarbo += $makanan->karbohidrat * $qty;
            }
        }

        return view('admin.pelacakanmakanan.show', compact('pelacakan', 'totalKalori', 'totalProtein', 'totalLemak', 'totalKarbo'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy($id)
    {
        $pelacakan = PelacakanMakanan::findOrFail($id);
        
        DB::transaction(function () use ($pelacakan) {
            $pelacakan->detail()->delete();
            $pelacakan->delete();
        });

        return redirect()->route('admin.pelacakan-makanan.index')
            ->with('success', 'Data pelacakan berhasil dihapus.');
    }
}
