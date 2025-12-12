@extends('layouts.admin')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.artikel.index') }}"
                    class="p-2 bg-white border border-gray-200 rounded-xl text-slate hover:text-leaf hover:border-leaf transition-colors shadow-sm">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-charcoal">Preview Artikel</h1>
                    <p class="text-xs text-slate">Lihat detail konten sebelum dipublikasikan.</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('artikel.show', $artikel->id) }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 text-slate font-bold rounded-xl hover:text-leaf hover:border-leaf transition-all shadow-sm">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Buka di Web</span>
                </a>

                <a href="{{ route('admin.artikel.edit', $artikel->id) }}"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-leaf text-white font-bold rounded-xl hover:bg-green-700 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                    Edit Artikel
                </a>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="relative h-64 md:h-96 w-full bg-gray-100 group">
                @if ($artikel->foto)
                    <img src="{{ asset('storage/' . $artikel->foto) }}" alt="{{ $artikel->judul }}"
                        class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate">
                        <i data-lucide="image" class="w-16 h-16 opacity-20 mb-2"></i>
                        <span class="text-sm font-medium opacity-50">Tidak ada gambar unggulan</span>
                    </div>
                @endif

                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                <div class="absolute bottom-0 left-0 w-full p-6 md:p-10 text-white">
                    <div class="flex flex-wrap gap-2 mb-3">
                        @foreach ($artikel->kategori as $cat)
                            <span
                                class="bg-leaf/90 backdrop-blur-md text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg border border-white/20">
                                {{ $cat->kategori }}
                            </span>
                        @endforeach
                    </div>
                    <h1 class="text-3xl md:text-4xl font-extrabold leading-tight shadow-black drop-shadow-md">
                        {{ $artikel->judul }}
                    </h1>
                </div>
            </div>

            <div
                class="px-6 md:px-10 py-4 bg-gray-50 border-b border-gray-100 flex flex-wrap items-center gap-6 text-sm text-slate">
                <div class="flex items-center gap-2">
                    <i data-lucide="calendar" class="w-4 h-4 text-leaf"></i>
                    <span>Dibuat: <strong>{{ $artikel->created_at->format('d F Y, H:i') }}</strong></span>
                </div>
                <div class="flex items-center gap-2">
                    <i data-lucide="clock" class="w-4 h-4 text-leaf"></i>
                    <span>Terakhir Update: <strong>{{ $artikel->updated_at->diffForHumans() }}</strong></span>
                </div>
                <div class="flex items-center gap-2">
                    <i data-lucide="book-open" class="w-4 h-4 text-leaf"></i>
                    <span>Estimasi Baca: <strong>{{ ceil(str_word_count(strip_tags($artikel->content)) / 200) }}
                            Menit</strong></span>
                </div>
            </div>

            <div class="p-6 md:p-10">
                <div
                    class="trix-content prose prose-lg prose-headings:text-charcoal prose-p:text-slate prose-a:text-leaf prose-strong:text-charcoal prose-img:rounded-xl max-w-none">
                    {!! $artikel->content !!}
                </div>
            </div>
        </div>

        <div
            class="bg-red-50 rounded-2xl border border-red-100 p-6 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-start gap-4">
                <div class="p-3 bg-red-100 rounded-full text-red-600 hidden sm:block">
                    <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-red-700">Hapus Artikel Ini?</h3>
                    <p class="text-sm text-red-600/80 mt-1">
                        Tindakan ini tidak dapat dibatalkan. Artikel akan hilang permanen dari database.
                    </p>
                </div>
            </div>

            <div x-data="{ open: false }">
                <button @click="open = true"
                    class="px-6 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all shadow-md whitespace-nowrap">
                    Hapus Permanen
                </button>

                <div x-show="open" style="display: none;" class="fixed inset-0 z-[60] overflow-y-auto"
                    aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="open = false">
                    </div>

                    <div class="flex min-h-full items-center justify-center p-4 text-center">
                        <div x-show="open" x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md p-6">

                            <div class="text-center">
                                <div
                                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 mb-4">
                                    <i data-lucide="trash-2" class="w-6 h-6 text-red-600"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Konfirmasi Hapus</h3>
                                <p class="text-sm text-gray-500 mt-2">
                                    Apakah Anda yakin ingin menghapus artikel <strong>"{{ $artikel->judul }}"</strong>?
                                </p>
                            </div>

                            <div class="mt-6 flex gap-3 justify-center">
                                <button type="button" @click="open = false"
                                    class="px-4 py-2 bg-white text-slate font-bold border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                    Batal
                                </button>
                                <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition-colors">
                                        Ya, Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
