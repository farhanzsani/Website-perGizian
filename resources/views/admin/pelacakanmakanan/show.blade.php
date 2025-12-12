@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center justify-between text-slate mb-4">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.pelacakan-makanan.index') }}" class="hover:text-leaf transition-colors"><i
                        data-lucide="arrow-left" class="w-5 h-5"></i></a>
                <h1 class="text-xl font-bold text-charcoal">Detail Konsumsi</h1>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header Info -->
            <div class="p-8 pb-6 bg-white border-b border-gray-100/50 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-mint/20 flex items-center justify-center text-leaf shrink-0">
                        <i data-lucide="user" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate uppercase tracking-wider mb-1">Pengguna</label>
                        <div class="font-bold text-charcoal text-lg">{{ $pelacakan->pengguna->user->name ?? 'User Terhapus' }}</div>
                        <div class="text-sm text-slate">{{ $pelacakan->pengguna->user->email ?? '-' }}</div>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-500 shrink-0">
                        <i data-lucide="calendar" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate uppercase tracking-wider mb-1">Tanggal</label>
                        <div class="font-bold text-charcoal text-lg">{{ \Carbon\Carbon::parse($pelacakan->tanggal_konsumsi)->isoFormat('dddd, D MMMM Y') }}</div>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-500 shrink-0">
                        <i data-lucide="flame" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate uppercase tracking-wider mb-1">Total Kalori</label>
                        <div class="font-black text-charcoal text-2xl">{{ number_format($totalKalori, 0) }} <span class="text-sm text-slate font-medium">Kkal</span></div>
                    </div>
                </div>
            </div>

            <!-- Nutrisi Summary Cards -->
            <div class="grid grid-cols-3 divide-x divide-gray-100 border-b border-gray-100 bg-gray-50/50">
                <div class="p-6 text-center group hover:bg-white transition-colors">
                    <div class="text-xs text-slate font-bold uppercase mb-2">Protein</div>
                    <div class="text-2xl font-black text-blue-600 group-hover:scale-110 transition-transform">{{ number_format($totalProtein, 1) }}g</div>
                </div>
                <div class="p-6 text-center group hover:bg-white transition-colors">
                    <div class="text-xs text-slate font-bold uppercase mb-2">Lemak</div>
                    <div class="text-2xl font-black text-yellow-500 group-hover:scale-110 transition-transform">{{ number_format($totalLemak, 1) }}g</div>
                </div>
                <div class="p-6 text-center group hover:bg-white transition-colors">
                    <div class="text-xs text-slate font-bold uppercase mb-2">Karbohidrat</div>
                    <div class="text-2xl font-black text-orange-500 group-hover:scale-110 transition-transform">{{ number_format($totalKarbo, 1) }}g</div>
                </div>
            </div>

            <!-- Detail Table -->
            <div class="overflow-x-auto p-4">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-xs uppercase text-slate font-bold tracking-wider border-b border-gray-100">
                            <th class="px-6 py-4 w-16 text-center">#</th>
                            <th class="px-6 py-4">Menu Makanan</th>
                            <th class="px-6 py-4 text-center">Porsi</th>
                            <th class="px-6 py-4 text-right">Energi Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($pelacakan->detail as $index => $detail)
                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="px-6 py-4 text-slate text-sm text-center font-medium">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-charcoal group-hover:text-leaf transition-colors">{{ $detail->makanan->nama }}</div>
                                <div class="text-xs text-slate">{{ $detail->makanan->kategori->kategori ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 bg-gray-100 rounded-lg text-xs font-bold text-slate group-hover:bg-mint/20 group-hover:text-leaf transition-colors">
                                    {{ $detail->kuantitas }} Porsi
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="font-bold text-charcoal">{{ number_format($detail->makanan->energi * $detail->kuantitas, 0) }}</span> 
                                <span class="text-xs text-slate">Kkal</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t-2 border-gray-100">
                        <tr>
                            <td colspan="3" class="px-6 py-6 text-right font-bold text-slate uppercase tracking-wider text-xs">Total Akhir</td>
                            <td class="px-6 py-6 text-right">
                                <span class="font-black text-leaf text-2xl">{{ number_format($totalKalori, 0) }}</span>
                                <span class="text-sm text-leaf font-bold">Kkal</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="flex justify-between items-center mt-8" x-data="{ showDeleteModal: false }">
            <button type="button" @click="showDeleteModal = true"
                class="flex items-center gap-2 px-5 py-2.5 rounded-xl border border-red-100 text-red-500 font-bold hover:bg-red-50 hover:border-red-200 transition-all text-sm">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
                Hapus Data Ini
            </button>
            
            <a href="{{ route('admin.pelacakan-makanan.index') }}" 
                class="px-6 py-2.5 bg-leaf text-white font-bold rounded-xl shadow-md hover:bg-green-700 hover:-translate-y-0.5 transition-all text-sm">
                Kembali
            </a>

            <!-- Delete Confirmation Modal -->
            <template x-teleport="body">
                <div x-show="showDeleteModal" style="display: none;"
                    class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">
                    
                    <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl transform transition-all"
                        x-show="showDeleteModal"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                        @click.outside="showDeleteModal = false">
                        
                        <div class="text-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4 text-red-500">
                                <i data-lucide="alert-triangle" class="w-8 h-8"></i>
                            </div>
                            <h3 class="text-xl font-bold text-charcoal mb-2">Hapus Data Pelacakan?</h3>
                            <p class="text-slate text-sm">Data yang dihapus tidak dapat dikembalikan. Stok nutrisi hari ini akan berkurang.</p>
                        </div>

                        <div class="flex gap-3">
                            <button type="button" @click="showDeleteModal = false"
                                class="flex-1 px-4 py-2.5 text-slate font-bold bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors">
                                Batal
                            </button>
                            <form action="{{ route('admin.pelacakan-makanan.destroy', $pelacakan->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full px-4 py-2.5 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 transition-colors shadow-lg shadow-red-200">
                                    Ya, Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
@endsection
