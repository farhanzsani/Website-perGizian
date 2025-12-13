@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-eggshell py-12">
        <div class="max-w-3xl mx-auto px-4">

            <div class="mb-6">
                <a href="{{ route('keluarga.index', ['date' => $selectedDate]) }}"
                    class="inline-flex items-center gap-2 text-slate hover:text-leaf font-bold text-sm transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Keluarga
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">

                <div class="bg-leaf/10 p-8 text-center">
                    <div
                        class="w-20 h-20 bg-leaf text-white rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-4 shadow-md">
                        {{ substr($member->user->name, 0, 1) }}
                    </div>
                    <h1 class="text-2xl font-bold text-charcoal">{{ $member->user->name }}</h1>
                    <p class="text-slate text-sm">Laporan Makan •
                        {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}</p>
                </div>

                <div class="grid grid-cols-2 border-b border-gray-100">
                    <div class="p-6 text-center border-r border-gray-100">
                        <p class="text-xs text-slate uppercase font-bold mb-1">Total Kalori</p>
                        <p class="text-3xl font-black text-leaf">{{ number_format($totalKalori) }}</p>
                        <p class="text-xs text-slate">kkal</p>
                    </div>
                    <div class="p-6 text-center">
                        <p class="text-xs text-slate uppercase font-bold mb-1">Jumlah Makan</p>
                        <p class="text-3xl font-black text-charcoal">{{ $riwayatMakan->count() }}</p>
                        <p class="text-xs text-slate">kali</p>
                    </div>
                </div>

                <div class="p-6">
                    <h3 class="font-bold text-charcoal mb-4">Rincian Menu</h3>

                    @if ($riwayatMakan->count() > 0)
                        <div class="space-y-4">
                            @foreach ($riwayatMakan as $item)
                                <div
                                    class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="bg-white p-2 rounded-lg border border-gray-200 text-slate font-bold text-xs">
                                            {{ \Carbon\Carbon::parse($item->waktu_konsumsi)->format('H:i') }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-charcoal">{{ $item->makanan->nama }}</p>
                                            <p class="text-xs text-slate">{{ $item->jumlah_porsi }} {{ $item->satuan }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="block font-bold text-leaf">{{ number_format($item->total_kalori) }}
                                            kkal</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10">
                            <div class="inline-flex bg-gray-100 p-4 rounded-full mb-3 text-slate">
                                <i data-lucide="utensils-crossed" class="w-6 h-6"></i>
                            </div>
                            <p class="text-slate font-medium">Tidak ada data makan pada tanggal ini.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
