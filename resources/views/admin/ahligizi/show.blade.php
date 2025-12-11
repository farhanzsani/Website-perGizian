@extends('layouts.admin')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 text-slate">
                <a href="{{ route('admin.ahligizi.index') }}"
                    class="p-2 bg-white border border-gray-200 rounded-xl hover:text-leaf hover:border-leaf transition-colors shadow-sm">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-charcoal">Detail Profil</h1>
                    <p class="text-xs text-slate">Informasi lengkap ahli gizi.</p>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.ahligizi.edit', $ahligizi->id) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-50 text-orange-600 font-bold rounded-xl hover:bg-orange-100 transition-colors border border-orange-200">
                    <i data-lucide="edit-3" class="w-4 h-4"></i> Edit
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 text-center">

                    <div class="relative w-40 h-40 mx-auto mb-6">
                        <img src="{{ asset('storage/' . $ahligizi->foto) }}" alt="{{ $ahligizi->nama }}"
                            class="w-full h-full object-cover rounded-full border-4 border-mint shadow-md">
                        <div class="absolute bottom-2 right-2 bg-green-500 w-6 h-6 rounded-full border-4 border-white"
                            title="Active"></div>
                    </div>

                    <h2 class="text-2xl font-bold text-charcoal">{{ $ahligizi->nama }}</h2>
                    <span class="inline-block mt-2 px-3 py-1 bg-mint/30 text-leaf text-sm font-bold rounded-full">
                        {{ $ahligizi->spesialis }}
                    </span>

                    <hr class="my-6 border-gray-100">

                    <div class="space-y-3">
                        <a href="https://wa.me/{{ $ahligizi->nomor_hp }}" target="_blank"
                            class="flex items-center justify-center gap-2 w-full py-3 bg-leaf text-white rounded-xl font-bold hover:bg-green-700 transition-colors shadow-md shadow-green-100">
                            <i data-lucide="message-circle" class="w-5 h-5"></i> Chat WhatsApp
                        </a>
                        <div class="flex items-center justify-center gap-2 text-slate text-sm font-medium">
                            <i data-lucide="phone" class="w-4 h-4"></i> {{ $ahligizi->nomor_hp }}
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-5 rounded-2xl border border-gray-200 text-xs text-slate space-y-2">
                    <div class="flex justify-between">
                        <span>Ditambahkan:</span>
                        <span class="font-bold">{{ $ahligizi->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Terakhir Update:</span>
                        <span class="font-bold">{{ $ahligizi->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 h-full">
                    <h3 class="text-lg font-bold text-charcoal mb-6 flex items-center gap-2">
                        <i data-lucide="user-circle" class="text-leaf"></i> Informasi Pribadi
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <label class="text-xs font-bold text-slate uppercase tracking-wider">Tentang / Deskripsi</label>
                            <div
                                class="mt-2 text-charcoal leading-relaxed bg-eggshell p-4 rounded-xl border border-gray-100">
                                {{ $ahligizi->deskripsi ?? 'Tidak ada deskripsi.' }}
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50">
                                <label class="flex items-center gap-2 text-sm font-bold text-slate mb-1">
                                    <i data-lucide="cake" class="w-4 h-4 text-leaf"></i> Tanggal Lahir
                                </label>
                                <p class="text-lg font-bold text-charcoal">
                                    {{ \Carbon\Carbon::parse($ahligizi->tanggal_lahir)->translatedFormat('d F Y') }}
                                </p>
                                <p class="text-sm text-leaf mt-1">
                                    {{ \Carbon\Carbon::parse($ahligizi->tanggal_lahir)->age }} Tahun
                                </p>
                            </div>

                            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50">
                                <label class="flex items-center gap-2 text-sm font-bold text-slate mb-1">
                                    <i data-lucide="map-pin" class="w-4 h-4 text-coral"></i> Lokasi Praktik
                                </label>
                                <p class="text-lg font-bold text-charcoal break-words">
                                    {{ $ahligizi->alamat }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 pt-8 border-t border-gray-100 flex justify-end">
                        <form action="{{ route('admin.ahligizi.destroy', $ahligizi->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus data ini secara permanen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="flex items-center gap-2 text-sm font-bold text-red-500 hover:text-red-700 transition-colors">
                                <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus Ahli Gizi Ini
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
