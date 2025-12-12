@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
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

                                        <form action="{{ route('admin.pelacakan-makanan.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus data pelacakan ini?');"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-red-50 text-tomato hover:bg-red-100 transition"
                                                title="Hapus">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                Hapus
                                            </button>
                                        </form>
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
    </div>
@endsection
