@extends('layouts.admin')

@section('content')
    <div class="space-y-6" x-data="{ deleteModalOpen: false, deleteAction: '' }">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-charcoal">Pelacakan Makanan</h1>
                <p class="text-slate text-sm">Pantau konsumsi kalori harian pengguna.</p>
            </div>
            <a href="{{ route('admin.pelacakan-makanan.create') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-leaf text-white font-bold rounded-xl hover:bg-green-700 transition-all shadow-md transform hover:-translate-y-0.5">
                <i data-lucide="plus" class="w-5 h-5"></i> Tambah Pelacakan
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-2">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-slate font-semibold">
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Pengguna</th>
                            <th class="px-6 py-4">Jumlah Item</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pelacakan as $item)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="px-6 py-4 font-medium text-charcoal">
                                    {{ \Carbon\Carbon::parse($item->tanggal_konsumsi)->isoFormat('dddd, D MMMM Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-mint/30 flex items-center justify-center text-leaf font-bold text-xs">
                                            {{ substr($item->pengguna->user->name ?? '?', 0, 1) }}
                                        </div>
                                        <span class="text-sm text-charcoal">{{ $item->pengguna->user->name ?? 'User Terhapus' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate">
                                    {{ $item->detail->count() }} Makanan
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.pelacakan-makanan.show', $item->id) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-gray-50 text-slate hover:bg-gray-100 transition"
                                            title="Lihat Detail">
                                            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                            Detail
                                        </a>

                                        <button type="button" @click="deleteModalOpen = true; deleteAction = '{{ route('admin.pelacakan-makanan.destroy', $item->id) }}'"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-red-50 text-tomato hover:bg-red-100 transition"
                                            title="Hapus">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate">Belum ada data pelacakan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
        </div>

        <!-- Delete Confirmation Modal -->
        <template x-teleport="body">
            <div x-show="deleteModalOpen" style="display: none;"
                class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                
                <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl transform transition-all"
                    x-show="deleteModalOpen"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                    @click.outside="deleteModalOpen = false">
                    
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4 text-red-500">
                            <i data-lucide="alert-triangle" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-xl font-bold text-charcoal mb-2">Hapus Data Pelacakan?</h3>
                        <p class="text-slate text-sm">Data yang dihapus tidak dapat dikembalikan.</p>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" @click="deleteModalOpen = false"
                            class="flex-1 px-4 py-2.5 text-slate font-bold bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors">
                            Batal
                        </button>
                        <form :action="deleteAction" method="POST" class="flex-1">
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
@endsection
