@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-eggshell py-12 flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-3xl shadow-xl p-8 border border-gray-100 relative overflow-hidden">

            <div class="absolute top-0 left-0 w-full h-2 bg-leaf"></div>
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-mint/20 rounded-full blur-2xl"></div>

            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center p-3 bg-leaf/10 rounded-full text-leaf mb-4">
                    <i data-lucide="user-plus" class="w-8 h-8"></i>
                </div>
                <h1 class="text-2xl font-bold text-charcoal">Undang Anggota</h1>
                <p class="text-slate text-sm mt-2">Bagikan kode atau link ini kepada anggota keluarga.</p>
            </div>

            <div class="bg-charcoal text-white rounded-2xl p-6 text-center mb-6 relative group cursor-pointer hover:shadow-lg transition-all"
                onclick="copyKode()">
                <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Kode Keluarga</p>
                <div class="text-4xl font-black tracking-wider font-mono text-leaf" id="kodeDisplay">
                    {{ $keluarga->kode_keluarga }}
                </div>

                <div
                    class="absolute inset-0 bg-black/50 flex items-center justify-center rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity backdrop-blur-sm">
                    <span class="text-white font-bold flex items-center gap-2">
                        <i data-lucide="copy" class="w-4 h-4"></i> Salin Kode
                    </span>
                </div>
            </div>

            <div class="relative flex py-2 items-center mb-6">
                <div class="flex-grow border-t border-gray-200"></div>
                <span class="flex-shrink-0 mx-4 text-slate text-xs uppercase font-bold">Atau via Link</span>
                <div class="flex-grow border-t border-gray-200"></div>
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mb-8">
                <div class="flex items-center justify-between gap-3">
                    <div class="truncate text-sm text-slate font-mono w-full" id="linkDisplay">
                        {{-- Generate Link: domain.com/keluarga/join?code=XYZ123 --}}
                        {{ route('keluarga.join.form', ['code' => $keluarga->kode_keluarga]) }}
                    </div>
                    <button onclick="copyLink()"
                        class="p-2 bg-white border border-gray-200 text-leaf rounded-lg hover:bg-leaf hover:text-white transition-colors shadow-sm"
                        title="Salin Link">
                        <i data-lucide="link" class="w-4 h-4"></i>
                    </button>
                </div>
                <p class="text-[10px] text-slate/60 mt-2 text-center">
                    Link ini akan otomatis mengisi kode saat dibuka.
                </p>
            </div>

            <a href="{{ route('keluarga.index') }}"
                class="block w-full py-3 bg-gray-100 text-charcoal font-bold rounded-xl hover:bg-gray-200 transition-colors text-center">
                Kembali
            </a>
        </div>
    </div>

    <script>
        function copyKode() {
            const kode = document.getElementById('kodeDisplay').innerText.trim();
            navigator.clipboard.writeText(kode);
            // Optional: Tampilkan toast/alert yang lebih cantik
            alert('Kode ' + kode + ' berhasil disalin!');
        }

        function copyLink() {
            const link = document.getElementById('linkDisplay').innerText.trim();
            navigator.clipboard.writeText(link);
            alert('Link undangan berhasil disalin!');
        }
    </script>
@endsection
