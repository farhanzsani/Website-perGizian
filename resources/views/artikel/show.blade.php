@extends('layouts.app')

@section('content')
    <div class="bg-white min-h-screen">

        <div class="relative h-[400px] md:h-[500px] w-full bg-charcoal group">
            @if ($article->foto)
                <img src="{{ asset('storage/' . $article->foto) }}" alt="{{ $article->judul }}"
                    class="w-full h-full object-cover opacity-80">
                <div class="absolute inset-0 bg-gradient-to-t from-charcoal via-charcoal/50 to-transparent"></div>
            @else
                <div class="w-full h-full bg-leaf flex items-center justify-center opacity-20">
                    <i data-lucide="book-open" class="w-32 h-32 text-white"></i>
                </div>
            @endif

            <div class="absolute bottom-0 left-0 w-full p-6 md:p-12 lg:p-20 max-w-7xl mx-auto">
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach ($article->kategori as $k)
                        <span
                            class="bg-leaf text-white font-bold px-3 py-1 rounded-full text-xs uppercase tracking-wide shadow-lg">
                            {{ $k->kategori }}
                        </span>
                    @endforeach
                </div>

                <h1 class="text-3xl md:text-5xl font-extrabold text-white leading-tight mb-6 drop-shadow-md max-w-4xl">
                    {{ $article->judul }}
                </h1>

                <div class="flex flex-wrap items-center gap-6 text-sm md:text-base font-medium text-white/90">
                    <span class="flex items-center gap-2 bg-black/20 px-3 py-1.5 rounded-lg backdrop-blur-sm">
                        <i data-lucide="calendar" class="w-4 h-4 text-mint"></i>
                        {{ $article->created_at->format('d F Y') }}
                    </span>
                    <span class="flex items-center gap-2 bg-black/20 px-3 py-1.5 rounded-lg backdrop-blur-sm">
                        <i data-lucide="clock" class="w-4 h-4 text-mint"></i>
                        {{ ceil(str_word_count(strip_tags($article->content)) / 200) }} menit baca
                    </span>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16 grid grid-cols-1 lg:grid-cols-3 gap-12">

            <div class="lg:col-span-2">
                <div class="bg-white">
                    <div class="trix-content max-w-none text-charcoal leading-relaxed text-lg">
                        {!! $article->content !!}
                    </div>
                </div>

                <div
                    class="mt-12 pt-8 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                    <a href="{{ route('artikel.index') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-gray-50 text-charcoal font-bold rounded-xl hover:bg-gray-100 transition-colors">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i> Kembali ke Daftar
                    </a>

                </div>
            </div>

            <div class="lg:col-span-1 space-y-8">

                <div class="bg-eggshell p-6 rounded-3xl border border-gray-100 sticky top-24">
                    <h3 class="font-bold text-xl text-charcoal mb-6 flex items-center gap-2 pb-4 border-b border-gray-200">
                        <i data-lucide="sparkles" class="text-leaf w-5 h-5"></i> Artikel Terkait
                    </h3>

                    <div class="space-y-6">
                        @forelse($related as $item)
                            <a href="{{ route('artikel.show', $item->id) }}" class="group flex gap-4 items-start">
                                <div class="w-20 h-20 flex-shrink-0 rounded-xl overflow-hidden bg-gray-200 shadow-sm">
                                    @if ($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate">
                                            <i data-lucide="image" class="w-6 h-6"></i>
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <h4
                                        class="font-bold text-charcoal text-sm leading-snug group-hover:text-leaf transition-colors mb-1 line-clamp-2">
                                        {{ $item->judul }}
                                    </h4>
                                    <span
                                        class="text-xs text-slate font-medium">{{ $item->created_at->format('d M Y') }}</span>
                                </div>
                            </a>
                        @empty
                            <p class="text-sm text-slate italic">Belum ada artikel terkait lainnya.</p>
                        @endforelse
                    </div>

                    <div class="mt-8 bg-white p-5 rounded-2xl border border-mint text-center">
                        <h4 class="font-bold text-leaf mb-2">Ingin Konsultasi?</h4>
                        <p class="text-xs text-slate mb-4">Dapatkan saran gizi personal langsung dari ahlinya.</p>
                        <a href="/#consultation"
                            class="block w-full py-2 bg-leaf text-white text-xs font-bold rounded-lg hover:bg-green-700 transition-colors">
                            Hubungi Ahli Gizi
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
