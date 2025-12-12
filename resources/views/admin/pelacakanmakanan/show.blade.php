@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center gap-2 text-slate mb-4">
            <a href="{{ route('admin.pelacakan-makanan.index') }}" class="hover:text-leaf transition-colors"><i
                    data-lucide="arrow-left" class="w-5 h-5"></i></a>
            <h1 class="text-xl font-bold text-charcoal">Detail Konsumsi</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header Info -->
            <div class="p-6 bg-gray-50 border-b border-gray-100 grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate uppercase tracking-wider mb-1">Pengguna</label>
                    <div class="font-bold text-charcoal">{{ $pelacakan->pengguna->user->name ?? 'User Terhapus' }}</div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate uppercase tracking-wider mb-1">Tanggal</label>
                    <div class="font-bold text-charcoal">{{ \Carbon\Carbon::parse($pelacakan->tanggal_konsumsi)->isoFormat('dddd, D MMMM Y') }}</div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate uppercase tracking-wider mb-1">Total Kalori</label>
                    <div class="font-bold text-leaf text-lg">{{ number_format($totalKalori, 0) }} Kkal</div>
                </div>
            </div>

            <!-- Nutrisi Summary Cards -->
            <div class="grid grid-cols-3 divide-x divide-gray-100 border-b border-gray-100">
                <div class="p-4 text-center hover:bg-gray-50 transition-colors">
                    <div class="text-xs text-slate font-bold uppercase mb-1">Protein</div>
                    <div class="text-xl font-black text-blue-600">{{ number_format($totalProtein, 1) }}g</div>
                </div>
                <div class="p-4 text-center hover:bg-gray-50 transition-colors">
                    <div class="text-xs text-slate font-bold uppercase mb-1">Lemak</div>
                    <div class="text-xl font-black text-yellow-500">{{ number_format($totalLemak, 1) }}g</div>
                </div>
                <div class="p-4 text-center hover:bg-gray-50 transition-colors">
                    <div class="text-xs text-slate font-bold uppercase mb-1">Karbohidrat</div>
                    <div class="text-xl font-black text-orange-500">{{ number_format($totalKarbo, 1) }}g</div>
                </div>
            </div>

            <!-- Detail Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-white border-b border-gray-100 text-xs uppercase text-slate font-semibold">
                            <th class="px-6 py-4 w-12">#</th>
                            <th class="px-6 py-4">Menu Makanan</th>
                            <th class="px-6 py-4 text-center">Porsi</th>
                            <th class="px-6 py-4 text-right">Energi Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($pelacakan->detail as $index => $detail)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-6 py-4 text-slate text-sm">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-charcoal">{{ $detail->makanan->nama }}</div>
                                <div class="text-xs text-slate">{{ $detail->makanan->kategori->kategori ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-block px-2 py-1 bg-gray-100 rounded text-xs font-bold text-charcoal">
                                    {{ $detail->kuantitas }} Porsi
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-charcoal">
                                {{ number_format($detail->makanan->energi * $detail->kuantitas, 0) }} Kkal
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50/50 border-t border-gray-100">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-bold text-slate text-xs uppercase">Total Akhir</td>
                            <td class="px-6 py-4 text-right font-black text-leaf text-lg">
                                {{ number_format($totalKalori, 0) }} Kkal
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="flex justify-between items-center mt-6">
            <form action="{{ route('admin.pelacakan-makanan.destroy', $pelacakan->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 text-sm font-bold hover:underline">Hapus Data Ini</button>
            </form>
            <a href="{{ route('admin.pelacakan-makanan.index') }}" class="px-6 py-2 bg-leaf text-white font-bold rounded-xl shadow hover:bg-green-700">Kembali</a>
        </div>
    </div>
@endsection
