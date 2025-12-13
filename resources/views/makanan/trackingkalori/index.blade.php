@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-eggshell py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-charcoal">Tracking Kalori</h1>
                    <p class="text-slate text-sm">Pantau kesehatan dan pola makanmu.</p>
                </div>

                <form action="{{ route('trackingkalori.index') }}" method="GET"
                    class="flex items-center gap-2 bg-white p-1 rounded-xl shadow-sm border border-gray-200">
                    <div class="relative">
                        <input type="date" name="date" value="{{ $selectedDate }}" onchange="this.form.submit()"
                            class="pl-10 pr-3 py-2 border-none rounded-lg text-sm font-bold text-charcoal focus:ring-0 cursor-pointer hover:bg-gray-50">
                        <i data-lucide="calendar"
                            class="w-4 h-4 text-leaf absolute left-3 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
                    </div>

                    {{-- Keep other filters --}}
                    <input type="hidden" name="filter" value="{{ $filter }}">
                    <input type="hidden" name="chart_filter" value="{{ $chartFilter }}">
                </form>

                <a href="{{ route('trackingkalori.create') }}"
                    class="inline-flex items-center gap-2 bg-leaf text-white font-bold py-2.5 px-5 rounded-xl hover:bg-green-700 transition-all shadow-md">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i> Catat Makan
                </a>
            </div>

            @if (session('success'))
                <div
                    class="mb-6 bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-5 h-5"></i> {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

                <div
                    class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center justify-center relative h-full">
                    <h3 class="text-charcoal font-bold text-sm uppercase mb-1">
                        {{ \Carbon\Carbon::parse($selectedDate)->isToday() ? 'Hari Ini' : \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}
                    </h3>

                    <x-diagrams.donut :series="$donutSeries" :labels="['Masuk', 'Sisa']" :colors="['#2E9A62', '#9E9E9EFF']" height="250" satuan="kkal"
                        :showTotal="false" />

                    <div
                        class="absolute top-[58%] left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center pointer-events-none">
                        <p class="text-[10px] text-slate uppercase font-bold">Total</p>
                        <p class="text-xl font-black text-leaf">{{ number_format($totalKaloriHarian) }}</p>
                        <p class="text-[10px] text-slate">/ {{ number_format($targetKalori) }} kkal</p>
                    </div>
                </div>

                <div class="md:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-gray-100 h-full flex flex-col">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <div>
                            <h3 class="text-charcoal font-bold text-lg">Performa Target</h3>
                            <p class="text-xs text-leaf font-bold bg-mint/10 px-2 py-1 rounded-md inline-block mt-1">
                                <i data-lucide="calendar" class="w-3 h-3 inline mr-1"></i> {{ $periodeLabel }}
                            </p>
                        </div>

                        <div class="flex bg-gray-50 rounded-xl p-1 border border-gray-100">
                            <a href="{{ route('trackingkalori.index', array_merge(request()->all(), ['chart_filter' => 'mingguan'])) }}"
                                class="px-4 py-2 rounded-lg text-xs font-bold transition-all {{ $chartFilter == 'mingguan' ? 'bg-white text-leaf shadow-sm border border-gray-100' : 'text-slate hover:text-charcoal' }}">
                                Mingguan
                            </a>
                            <a href="{{ route('trackingkalori.index', array_merge(request()->all(), ['chart_filter' => 'bulanan'])) }}"
                                class="px-4 py-2 rounded-lg text-xs font-bold transition-all {{ $chartFilter == 'bulanan' ? 'bg-white text-leaf shadow-sm border border-gray-100' : 'text-slate hover:text-charcoal' }}">
                                Bulanan
                            </a>
                        </div>
                    </div>

                    <div class="flex-grow flex items-center">
                        <x-diagrams.bar :data="$barSeries" :categories="['Target Terpenuhi', 'Belum Terpenuhi']" :colors="['#10B981', '#F59E0B']" height="220" />
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                    <h3 class="font-bold text-charcoal text-lg flex items-center gap-2">
                        <i data-lucide="list" class="w-5 h-5 text-leaf"></i> Detail Riwayat
                    </h3>

                    <div class="flex bg-gray-50 rounded-lg p-1 border border-gray-100">
                        <a href="{{ route('trackingkalori.index', array_merge(request()->all(), ['filter' => 'hari_ini'])) }}"
                            class="px-3 py-1.5 rounded-md text-xs font-bold transition-all {{ $filter == 'hari_ini' ? 'bg-white text-leaf shadow-sm' : 'text-slate hover:text-charcoal' }}">
                            Per Tanggal ({{ \Carbon\Carbon::parse($selectedDate)->format('d M') }})
                        </a>
                        <a href="{{ route('trackingkalori.index', array_merge(request()->all(), ['filter' => 'bulan_ini'])) }}"
                            class="px-3 py-1.5 rounded-md text-xs font-bold transition-all {{ $filter == 'bulan_ini' ? 'bg-white text-leaf shadow-sm' : 'text-slate hover:text-charcoal' }}">
                            Bulan Ini
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-eggshell text-slate text-xs uppercase font-bold">
                            <tr>
                                <th class="px-4 py-3 rounded-l-xl">Waktu</th>
                                <th class="px-4 py-3">Makanan</th>
                                <th class="px-4 py-3">Porsi</th>
                                <th class="px-4 py-3">Kalori</th>
                                <th class="px-4 py-3 text-right rounded-r-xl">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($history as $item)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 text-sm text-slate">
                                        {{ $item->tanggal_konsumsi->format('d M') }}
                                        <span
                                            class="text-xs bg-gray-100 px-1.5 py-0.5 rounded ml-1">{{ \Carbon\Carbon::parse($item->waktu_konsumsi)->format('H:i') }}</span>
                                    </td>
                                    <td class="px-4 py-3 font-bold text-charcoal">{{ $item->makanan->nama }}</td>
                                    <td class="px-4 py-3 text-sm text-slate">{{ $item->jumlah_porsi }}
                                        {{ $item->makanan->satuan }}
                                    </td>
                                    <td class="px-4 py-3 font-bold text-leaf">{{ number_format($item->total_kalori) }} kkal
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('trackingkalori.edit', $item->id) }}"
                                                class="p-1.5 bg-yellow-50 rounded-lg text-yellow-600 hover:bg-yellow-100 transition-colors"><i
                                                    data-lucide="edit-2" class="w-4 h-4"></i></a>
                                            <form action="{{ route('trackingkalori.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus?');">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-1.5 bg-red-50 rounded-lg text-red-600 hover:bg-red-100 transition-colors"><i
                                                        data-lucide="trash" class="w-4 h-4"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-slate text-sm">Tidak ada catatan
                                        pada tanggal ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $history->appends(request()->query())->links() }}</div>
            </div>
        </div>
    </div>
@endsection
