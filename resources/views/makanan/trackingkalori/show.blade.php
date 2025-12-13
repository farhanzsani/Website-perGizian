@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-eggshell py-12">
        <div class="max-w-xl mx-auto px-4">

            <div class="mb-6">
                <a href="{{ route('trackingkalori.index') }}"
                    class="inline-flex items-center gap-2 text-slate hover:text-leaf font-bold text-sm transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke List
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden relative">

                <div class="h-24 bg-gradient-to-r from-leaf to-mint relative">
                    <div class="absolute -bottom-10 left-1/2 transform -translate-x-1/2">
                        <div class="w-20 h-20 bg-white rounded-full p-1 shadow-md">
                            <div class="w-full h-full bg-eggshell rounded-full flex items-center justify-center text-leaf">
                                <i data-lucide="utensils" class="w-8 h-8"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-12 pb-8 px-8 text-center">
                    <h1 class="text-2xl font-black text-charcoal mb-1">{{ $tracking->makanan->nama }}</h1>
                    <p class="text-sm text-slate">
                        {{ \Carbon\Carbon::parse($tracking->tanggal_konsumsi)->format('d F Y') }} &bull;
                        {{ \Carbon\Carbon::parse($tracking->waktu_konsumsi)->format('H:i') }}
                    </p>

                    <div class="mt-8 grid grid-cols-2 gap-4">
                        <div class="p-4 bg-mint/10 rounded-2xl border border-mint/20">
                            <p class="text-xs font-bold text-slate uppercase mb-1">Total Energi</p>
                            <p class="text-3xl font-black text-leaf">{{ number_format($tracking->total_kalori) }}</p>
                            <p class="text-xs text-leaf font-medium">kkal</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <p class="text-xs font-bold text-slate uppercase mb-1">Porsi Dimakan</p>
                            <p class="text-3xl font-black text-charcoal">{{ $tracking->jumlah_porsi }}</p>
                            <p class="text-xs text-slate font-medium">{{ $tracking->satuan }}</p>
                        </div>
                    </div>

                    <div class="mt-6 text-xs text-slate/60 bg-gray-50 py-2 px-4 rounded-lg inline-block">
                        Data dicatat pada {{ $tracking->created_at->diffForHumans() }}
                    </div>
                </div>

                <div class="p-6 bg-gray-50 border-t border-gray-100 grid grid-cols-2 gap-4">
                    <a href="{{ route('trackingkalori.edit', $tracking->id) }}"
                        class="flex items-center justify-center gap-2 py-3 px-4 bg-white border border-gray-200 rounded-xl font-bold text-charcoal hover:border-leaf hover:text-leaf transition-colors shadow-sm">
                        <i data-lucide="edit-3" class="w-4 h-4"></i> Edit
                    </a>

                    <form action="{{ route('trackingkalori.destroy', $tracking->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus catatan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-white border border-red-100 text-red-600 rounded-xl font-bold hover:bg-red-50 transition-colors shadow-sm">
                            <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
