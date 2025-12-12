@extends('layouts.app')

@section('content')
    <div class="relative bg-charcoal text-white overflow-hidden pb-32">

        <img src="{{ asset('/images/carikalori.jpg') }}" class="absolute inset-0 w-full h-full object-cover opacity-20"
            alt="Background">

        <div
            class="absolute -top-24 -left-24 w-96 h-96 bg-leaf rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
        </div>
        <div
            class="absolute -bottom-24 -right-24 w-96 h-96 bg-mint rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 text-center">
            <span
                class="inline-block py-1 px-3 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-mint font-bold text-sm tracking-wider uppercase mb-6">
                Database Nutrisi
            </span>

            <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight text-white mb-6">
                Cari Kandungan <span class="text-transparent bg-clip-text bg-leaf">Gizi &
                    Kalori</span>
            </h1>

            <p class="text-gray-300 text-lg max-w-2xl mx-auto mb-10">
                Temukan informasi nilai gizi lengkap dari ribuan jenis makanan untuk membantu menjaga pola makan sehatmu.
            </p>

            <div class="max-w-2xl mx-auto relative z-10">
                <form action="{{ route('makanan.carikalori.index') }}" method="GET" class="relative group">
                    <div
                        class="absolute inset-0 bg-mint opacity-20 blur-xl rounded-full group-hover:opacity-30 transition-opacity duration-500">
                    </div>
                    <div class="relative bg-white rounded-full p-2 flex shadow-2xl items-center">
                        <div class="pl-4 text-slate">
                            <i data-lucide="search" class="w-6 h-6"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari makanan (misal: Nasi Goreng, Apel)..."
                            class="w-full bg-transparent border-0 focus:ring-0 text-charcoal placeholder-slate/60 text-lg py-3 px-4">
                        <button type="submit"
                            class="bg-leaf text-white px-8 py-3 rounded-full font-bold hover:bg-green-700 transition-all transform hover:scale-105 shadow-md">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="bg-eggshell min-h-screen -mt-20 rounded-t-[3rem] relative z-20 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($makanan as $item)
                    <a href="{{ route('makanan.carikalori.show', $item->id) }}" class="group block h-full">
                        <div
                            class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col h-full relative overflow-hidden">

                            <div
                                class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-leaf to-mint transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300">
                            </div>

                            <div class="flex items-start gap-4 mb-4">
                                <div class="relative w-16 h-16 flex-shrink-0 rounded-2xl overflow-hidden bg-gray-50">
                                    @if ($item->foto_makanan && file_exists(public_path('storage/' . $item->foto_makanan)))
                                        <img src="{{ asset('storage/' . $item->foto_makanan) }}" alt="{{ $item->nama }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-mint/20 flex items-center justify-center text-leaf">
                                            <i data-lucide="utensils" class="w-7 h-7"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow">
                                    <h3
                                        class="font-bold text-charcoal text-lg leading-tight line-clamp-2 group-hover:text-leaf transition-colors">
                                        {{ $item->nama }}
                                    </h3>
                                    <p class="text-xs text-slate mt-1">
                                        {{ number_format($item->kuantitas, 0) . ' ' . $item->satuan }}</p>
                                </div>
                            </div>

                            <div class="mb-5 bg-eggshell rounded-xl p-3 flex justify-between items-center">
                                <span class="text-xs font-bold text-slate uppercase">Energi</span>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-xl font-extrabold text-charcoal">{{ $item->energi }}</span>
                                    <span class="text-[10px] font-bold text-leaf">kkal</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div
                            class="bg-white w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 shadow-md border border-gray-100 animate-bounce">
                            <i data-lucide="search-x" class="w-10 h-10 text-slate/50"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-charcoal mb-2">Makanan tidak ditemukan</h3>
                        <p class="text-slate max-w-md mx-auto mb-8">
                            Maaf, kami tidak menemukan makanan dengan kata kunci "<span
                                class="font-bold text-charcoal">{{ request('search') }}</span>".
                        </p>

                        <div class="bg-white p-6 rounded-2xl border border-gray-100 max-w-lg mx-auto shadow-sm">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-mint/20 rounded-full text-leaf">
                                    <i data-lucide="plus" class="w-6 h-6"></i>
                                </div>
                                <div class="text-left flex-grow">
                                    <h4 class="font-bold text-charcoal">Makanan belum ada?</h4>
                                    <p class="text-xs text-slate">Bantu kami melengkapi database nutrisi ini.</p>
                                </div>
                                <a href="/"
                                    class="px-5 py-2 bg-leaf text-white text-xs font-bold rounded-lg hover:bg-green-700 transition-colors">
                                    Ajukan Data
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-16 ">
                {{ $makanan->links() }}
            </div>

        </div>
    </div>
@endsection
