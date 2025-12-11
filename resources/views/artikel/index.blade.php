@extends('layouts.app') {{-- Sesuaikan dengan layout utama Anda --}}

@section('content')
    <div class="relative bg-charcoal text-white overflow-hidden">
        <img src="{{ asset('/images/artikel.avif') }}" class="absolute inset-0 w-full h-full object-cover opacity-20"
            alt="Background">

        <div
            class="absolute -top-24 -left-24 w-96 h-96 bg-leaf rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
        </div>
        <div
            class="absolute -bottom-24 -right-24 w-96 h-96 bg-mint rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28 text-center">

            <span
                class="inline-block py-1 px-3 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-mint font-bold text-sm tracking-wider uppercase mb-6">
                Blog & Edukasi Gizi
            </span>

            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-white mb-6">
                Jelajahi Dunia <span class="text-transparent bg-clip-text bg-gradient-to-r from-mint to-leaf">Gizi
                    Sehat</span>
            </h1>

            <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto mb-10 leading-relaxed">
                Temukan ribuan artikel, tips diet, dan resep sehat yang telah dikurasi oleh para ahli untuk menunjang gaya
                hidup sehatmu.
            </p>

            <div class="max-w-2xl mx-auto relative z-10">
                <form action="{{ route('artikel.index') }}" method="GET" class="relative group">
                    <div
                        class="absolute inset-0 bg-mint opacity-20 blur-xl rounded-full group-hover:opacity-30 transition-opacity duration-500">
                    </div>
                    <div class="relative bg-white rounded-full p-2 flex shadow-2xl items-center">
                        <div class="pl-4 text-slate">
                            <i data-lucide="search" class="w-6 h-6"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari artikel, tips, atau resep..."
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

    <div class="bg-eggshell min-h-screen py-16 -mt-10 rounded-t-[3rem] relative z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-wrap justify-center gap-3 mb-16">
                <a href="{{ route('artikel.index') }}"
                    class="px-6 py-2.5 rounded-full text-sm font-bold transition-all border
                    {{ !request('category') ? 'bg-charcoal text-white shadow-lg scale-105' : 'bg-white text-slate border-gray-200 hover:border-leaf hover:text-leaf hover:shadow-md' }}">
                    Semua Topik
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('artikel.index', ['category' => $cat->kategori]) }}"
                        class="px-6 py-2.5 rounded-full text-sm font-bold transition-all border
                        {{ request('category') == $cat->kategori ? 'bg-charcoal text-white shadow-lg scale-105' : 'bg-white text-slate border-gray-200 hover:border-leaf hover:text-leaf hover:shadow-md' }}">
                        {{ $cat->kategori }}
                    </a>
                @endforeach
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($articles as $article)
                    <article
                        class="bg-white rounded-3xl shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col h-full group">

                        <div class="relative h-60 overflow-hidden bg-gray-100">
                            @if ($article->foto)
                                <img src="{{ asset('storage/' . $article->foto) }}" alt="{{ $article->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate bg-mint/20">
                                    <i data-lucide="image" class="w-12 h-12 mb-2 opacity-50"></i>
                                    <span class="text-xs font-medium">No Image</span>
                                </div>
                            @endif

                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>

                            <div class="absolute top-4 left-4 flex gap-1">
                                @foreach ($article->kategori as $k)
                                    <span
                                        class="bg-white/95 backdrop-blur-md text-charcoal text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm border border-gray-100">
                                        {{ $k->kategori }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="p-7 flex flex-col flex-grow">
                            <div class="flex items-center gap-3 text-xs text-slate mb-3 font-medium">
                                <span class="flex items-center gap-1 bg-gray-50 px-2 py-1 rounded text-gray-500">
                                    <i data-lucide="calendar" class="w-3 h-3"></i>
                                    {{ $article->created_at->format('d M Y') }}
                                </span>
                                <span class="flex items-center gap-1 bg-gray-50 px-2 py-1 rounded text-gray-500">
                                    <i data-lucide="clock" class="w-3 h-3"></i>
                                    {{ ceil(str_word_count(strip_tags($article->content)) / 200) }} min read
                                </span>
                            </div>

                            <h3
                                class="text-xl font-bold text-charcoal mb-3 line-clamp-2 group-hover:text-leaf transition-colors leading-tight">
                                <a href="{{ route('artikel.show', $article->id) }}">
                                    {{ $article->judul }}
                                </a>
                            </h3>

                            <p class="text-slate text-sm line-clamp-3 mb-6 flex-grow leading-relaxed">
                                {{ Str::limit(strip_tags($article->content), 120) }}
                            </p>

                            <a href="{{ route('artikel.show', $article->id) }}"
                                class="w-full inline-flex items-center justify-center gap-2 text-charcoal bg-gray-50 hover:bg-leaf hover:text-white font-bold py-3 rounded-xl transition-all duration-300 group/btn">
                                Baca Selengkapnya
                                <i data-lucide="arrow-right"
                                    class="w-4 h-4 transition-transform group-hover/btn:translate-x-1"></i>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-24 text-center">
                        <div
                            class="bg-white w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 shadow-md border border-gray-100 animate-bounce">
                            <i data-lucide="file-search" class="w-10 h-10 text-slate/50"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-charcoal mb-2">Artikel tidak ditemukan</h3>
                        <p class="text-slate max-w-md mx-auto mb-8">Maaf, kami tidak dapat menemukan artikel dengan kata
                            kunci "<span class="font-bold text-charcoal">{{ request('search') }}</span>". Coba gunakan kata
                            kunci lain.</p>
                        <a href="{{ route('artikel.index') }}"
                            class="inline-block px-8 py-3 bg-leaf text-white font-bold rounded-full hover:bg-green-700 transition-colors shadow-lg hover:shadow-xl">
                            Lihat Semua Artikel
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-20 flex justify-center">
                {{ $articles->links() }}
            </div>

        </div>
    </div>
@endsection
