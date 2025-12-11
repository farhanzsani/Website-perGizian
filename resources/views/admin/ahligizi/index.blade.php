@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-charcoal">Data Ahli Gizi</h1>
                <p class="text-slate text-sm">Kelola profil dokter dan ahli gizi yang tampil di halaman depan.</p>
            </div>
            <a href="{{ route('admin.ahligizi.create') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-leaf text-white font-bold rounded-xl hover:bg-green-700 transition-all shadow-md transform hover:-translate-y-0.5">
                <i data-lucide="user-plus" class="w-5 h-5"></i> Tambah Baru
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-2">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-slate font-semibold">
                            <th class="px-6 py-4">Profil</th>
                            <th class="px-6 py-4">Spesialisasi</th>
                            <th class="px-6 py-4">Kontak (WA)</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($ahligizi as $item)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}"
                                            class="w-12 h-12 rounded-full object-cover border border-gray-200">
                                        <div>
                                            <h3 class="font-bold text-charcoal text-sm">{{ $item->nama }}</h3>
                                            <p class="text-xs text-slate">
                                                {{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} Tahun</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-mint/30 text-leaf">
                                        {{ $item->spesialis }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="phone" class="w-4 h-4 text-leaf"></i>
                                        {{ $item->nomor_hp }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.ahligizi.show', $item->id) }}"
                                            class="p-2 text-slate hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Lihat Detail">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                        <a href="{{ route('admin.ahligizi.edit', $item->id) }}" ...>
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.ahligizi.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus ahli gizi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-slate hover:text-tomato hover:bg-red-50 rounded-lg transition-colors"
                                                title="Hapus">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate">Belum ada data ahli gizi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $ahligizi->links() }}
            </div>
        </div>
    </div>
@endsection
