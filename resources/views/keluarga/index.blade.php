@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ showDeleteModal: false, showKickModal: false, selectedMember: null }">

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div class="text-center md:text-left">
                <h1 class="text-3xl font-bold text-charcoal flex items-center gap-2 justify-center md:justify-start">
                    <i data-lucide="users" class="w-8 h-8 text-leaf"></i>
                    {{ $keluarga->nama_keluarga }}
                </h1>
                <p class="text-slate text-sm mt-1">
                    @if ($isKepala)
                        <span
                            class="inline-flex items-center gap-1 bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full text-xs font-bold border border-orange-200">
                            <i data-lucide="crown" class="w-3 h-3"></i> Kepala Keluarga
                        </span>
                    @else
                        <span
                            class="bg-gray-100 text-slate px-2 py-0.5 rounded-full text-xs font-bold border border-gray-200">Anggota</span>
                    @endif
                </p>
            </div>

            <form action="{{ route('keluarga.index') }}" method="GET"
                class="flex items-center gap-2 bg-white p-1 rounded-xl shadow-sm border border-gray-200">
                <div class="relative">
                    <input type="date" name="date" value="{{ $selectedDate }}" onchange="this.form.submit()"
                        class="pl-10 pr-4 py-2 border-none rounded-lg text-sm font-bold text-charcoal focus:ring-0 cursor-pointer hover:bg-gray-50 transition-colors">
                    <i data-lucide="calendar"
                        class="w-4 h-4 text-leaf absolute left-3 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
                </div>
            </form>
        </div>

        @if (session('success'))
            <div
                class="mb-6 bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-2">
                <i data-lucide="check-circle" class="w-5 h-5"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-100 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center gap-2">
                <i data-lucide="alert-triangle" class="w-5 h-5"></i> {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <div
                class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 flex flex-col items-center justify-center relative">
                <h3 class="text-charcoal font-bold text-sm uppercase mb-2 tracking-wide">Pencapaian Keluarga</h3>

                <x-diagrams.donut :series="$donutSeriesKeluarga" :labels="['Terpenuhi', 'Sisa']" :colors="['#2E9A62', '#E5E7EB']" height="220" satuan="kkal"
                    :showTotal="false" />

                <div
                    class="absolute top-[58%] left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center pointer-events-none">
                    <p class="text-[10px] text-slate uppercase font-bold">Total</p>
                    <p class="text-xl font-black text-leaf">{{ number_format($totalTerpenuhiKalori) }}</p>
                    <p class="text-[10px] text-slate">/ {{ number_format($totalTargetKalori) }}</p>
                </div>
            </div>

            <div class="md:col-span-2 bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                <h3 class="font-bold text-charcoal mb-4">Perbandingan Asupan Anggota</h3>
                <x-diagrams.bar :data="$chartData" :categories="$chartLabels" :colors="['#2E9A62', '#F59E0B', '#3B82F6', '#EF4444', '#8B5CF6']" height="200" satuan="kkal" />
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 mb-8 overflow-hidden">
            <h2 class="text-lg font-bold text-charcoal mb-6 flex items-center gap-2">
                <i data-lucide="list" class="w-5 h-5 text-leaf"></i> Detail Anggota
                ({{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }})
            </h2>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-slate uppercase text-xs font-bold">
                        <tr>
                            <th class="px-6 py-4 rounded-l-xl">Anggota</th>
                            <th class="px-6 py-4">Status Kalori</th>
                            <th class="px-6 py-4 rounded-r-xl text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($detailAnggota as $anggota)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-leaf text-white flex items-center justify-center font-bold shadow-sm">
                                            {{ substr($anggota['nama'], 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-charcoal">{{ $anggota['nama'] }}</p>
                                            <p class="text-xs text-slate">{{ $anggota['email'] }}</p>
                                            @if ($anggota['id'] == $keluarga->kepala_keluarga_id)
                                                <span
                                                    class="text-[10px] bg-orange-100 text-orange-600 px-1.5 py-0.5 rounded font-bold border border-orange-200">Ketua</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 w-1/2">
                                    <div class="flex justify-between text-xs mb-1">
                                        <span
                                            class="font-bold {{ $anggota['terpenuhi_kalori'] > $anggota['target_kalori'] ? 'text-red-500' : 'text-leaf' }}">
                                            {{ number_format($anggota['terpenuhi_kalori']) }} kkal
                                        </span>
                                        <span class="text-slate">Target:
                                            {{ number_format($anggota['target_kalori']) }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div class="bg-leaf h-2 rounded-full transition-all duration-500 {{ $anggota['terpenuhi_kalori'] > $anggota['target_kalori'] ? 'bg-red-500' : '' }}"
                                            style="width: {{ $anggota['progress_persen'] }}%"></div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('keluarga.showdetails', ['id' => $anggota['id'], 'date' => $selectedDate]) }}"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-xs font-bold text-slate hover:text-leaf hover:border-leaf transition-colors shadow-sm">
                                            <i data-lucide="eye" class="w-3 h-3"></i> Detail
                                        </a>

                                        @if ($isKepala && $anggota['id'] != Auth::user()->pengguna->id)
                                            <form action="{{ route('keluarga.kick', $anggota['id']) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin mengeluarkan {{ $anggota['nama'] }} dari keluarga?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-1.5 bg-white border border-red-100 text-red-400 rounded-lg hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors shadow-sm"
                                                    title="Keluarkan Anggota">
                                                    <i data-lucide="user-minus" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex flex-wrap justify-center gap-3 mb-8">
            @if ($isKepala)
                <a href="{{ route('keluarga.edit') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-charcoal rounded-xl font-bold hover:bg-gray-50 transition-all shadow-sm">
                    <i data-lucide="edit" class="w-4 h-4"></i> Edit Nama
                </a>
                <a href="{{ route('keluarga.invite') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-leaf text-white rounded-xl font-bold hover:bg-green-700 transition-all shadow-md">
                    <i data-lucide="user-plus" class="w-4 h-4"></i> Undang Anggota
                </a>

                @if (count($detailAnggota) > 1)
                    {{-- Jika ada anggota lain, tombol disabled --}}
                    <button type="button"
                        onclick="alert('TIDAK BISA MEMBUBARKAN!\n\nMasih ada anggota lain di keluarga ini. Harap keluarkan semua anggota terlebih dahulu atau transfer jabatan Ketua Keluarga ke orang lain sebelum membubarkan.')"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-gray-400 border border-gray-200 rounded-xl font-bold cursor-not-allowed transition-all">
                        <i data-lucide="lock" class="w-4 h-4"></i> Bubarkan
                    </button>
                @else
                    {{-- Jika sendirian, boleh bubarkan --}}
                    <button @click="showDeleteModal = true"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-red-200 text-red-600 rounded-xl font-bold hover:bg-red-50 transition-all shadow-sm">
                        <i data-lucide="trash-2" class="w-4 h-4"></i> Bubarkan
                    </button>
                @endif
            @else
                <form action="{{ route('keluarga.leave') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-red-200 text-red-600 rounded-xl font-bold hover:bg-red-50 transition-all shadow-sm"
                        onclick="return confirm('Yakin ingin keluar dari keluarga?')">
                        <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                    </button>
                </form>
            @endif
        </div>

        <div x-show="showDeleteModal" x-cloak
            class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
            @click.self="showDeleteModal = false">
            <div
                class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl text-center transform transition-all scale-100">
                <div
                    class="inline-flex items-center justify-center p-3 bg-red-100 rounded-full text-red-600 mb-4 animate-bounce">
                    <i data-lucide="alert-triangle" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold text-charcoal mb-2">Bubarkan Keluarga?</h3>
                <p class="text-slate text-sm mb-6 leading-relaxed">
                    Tindakan ini akan menghapus data keluarga secara permanen. Anda akan kembali menjadi pengguna tanpa
                    keluarga.
                </p>
                <div class="flex gap-3">
                    <button @click="showDeleteModal = false"
                        class="flex-1 px-4 py-3 bg-gray-100 text-charcoal rounded-xl font-bold hover:bg-gray-200 transition-colors">Batal</button>
                    <form action="{{ route('keluarga.destroy') }}" method="POST" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="w-full px-4 py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition-colors shadow-lg shadow-red-600/30">Ya,
                            Hapus</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection
