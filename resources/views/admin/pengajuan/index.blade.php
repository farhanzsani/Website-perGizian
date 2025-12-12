@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-charcoal">Verifikasi Pengajuan</h1>
                <p class="text-slate text-sm">Validasi data makanan yang dikirim oleh pengguna.</p>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-2">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-slate font-semibold">
                            <th class="px-6 py-4">Makanan</th>
                            <th class="px-6 py-4">Pengaju</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pengajuan as $item)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100 border border-gray-200 flex-shrink-0">
                                            @if ($item->foto_makanan)
                                                <img src="{{ asset('storage/' . $item->foto_makanan) }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate"><i
                                                        data-lucide="utensils" class="w-5 h-5"></i></div>
                                            @endif
                                        </div>
                                        <div>
                                            <span
                                                class="font-bold text-charcoal text-sm block">{{ $item->nama_makanan }}</span>
                                            <span class="text-xs text-slate">{{ $item->kategori_makanan }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-6 h-6 rounded-full bg-mint/30 flex items-center justify-center text-leaf text-xs font-bold">
                                            {{ substr($item->pengguna->user->name ?? 'U', 0, 1) }}
                                        </div>
                                        <span
                                            class="text-sm text-charcoal">{{ $item->pengguna->user->name ?? 'User' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate">
                                    {{ $item->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($item->status_pengajuan == 'pending')
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200 flex items-center gap-1 w-fit">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span>
                                            Pending
                                        </span>
                                    @elseif($item->status_pengajuan == 'disetujui')
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200 w-fit">
                                            Disetujui
                                        </span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200 w-fit">
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.pengajuan.show', $item->id) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-xs font-bold text-slate hover:border-leaf hover:text-leaf transition-colors">
                                        <i data-lucide="eye" class="w-3 h-3"></i> Review
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate">
                                    <div class="flex flex-col items-center">
                                        <i data-lucide="inbox" class="w-10 h-10 text-slate/30 mb-2"></i>
                                        <span>Belum ada pengajuan baru.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $pengajuan->links() }}
            </div>
        </div>
    </div>
@endsection
