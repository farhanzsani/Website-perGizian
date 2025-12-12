@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2 text-slate">
                <a href="{{ route('admin.kelolamakanan.index') }}"
                    class="p-2 bg-white border border-gray-200 rounded-xl hover:text-leaf hover:border-leaf transition-colors shadow-sm">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <h1 class="text-xl font-bold text-charcoal">Detail Makanan</h1>
            </div>
            <a href="{{ route('admin.kelolamakanan.edit', $makanan->id) }}"
                class="px-5 py-2.5 bg-orange-50 text-orange-600 font-bold rounded-xl hover:bg-orange-100 border border-orange-200 flex items-center gap-2">
                <i data-lucide="edit-3" class="w-4 h-4"></i> Edit
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="relative h-64 bg-gray-100">
                @if ($makanan->foto_makanan)
                    <img src="{{ asset('storage/' . $makanan->foto_makanan) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate"><i
                            data-lucide="utensils" class="w-12 h-12 mb-2 opacity-50"></i>No Image</div>
                @endif
                <div class="absolute bottom-4 left-4">
                    <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-lg text-sm font-bold text-charcoal shadow-sm">
                        {{ $makanan->kategori->nama ?? 'Umum' }}
                    </span>
                </div>
            </div>

            <div class="p-8">
                <h2 class="text-3xl font-extrabold text-charcoal mb-2">{{ $makanan->nama }}</h2>
                <p class="text-slate text-lg mb-8">Takaran: <span class="font-bold text-leaf">{{ $makanan->kuantitas }}
                        {{ $makanan->satuan }}</span></p>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-eggshell p-4 rounded-2xl text-center border border-gray-100">
                        <p class="text-xs font-bold text-slate uppercase mb-1">Energi</p>
                        <p class="text-2xl font-black text-charcoal">{{ $makanan->energi }}</p>
                        <p class="text-[10px] text-slate">Kkal</p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-2xl text-center border border-blue-100">
                        <p class="text-xs font-bold text-blue-600 uppercase mb-1">Protein</p>
                        <p class="text-2xl font-black text-charcoal">{{ $makanan->protein }}</p>
                        <p class="text-[10px] text-slate">Gram</p>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-2xl text-center border border-yellow-100">
                        <p class="text-xs font-bold text-yellow-600 uppercase mb-1">Lemak</p>
                        <p class="text-2xl font-black text-charcoal">{{ $makanan->lemak }}</p>
                        <p class="text-[10px] text-slate">Gram</p>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-2xl text-center border border-orange-100">
                        <p class="text-xs font-bold text-orange-600 uppercase mb-1">Karbo</p>
                        <p class="text-2xl font-black text-charcoal">{{ $makanan->karbohidrat }}</p>
                        <p class="text-[10px] text-slate">Gram</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
