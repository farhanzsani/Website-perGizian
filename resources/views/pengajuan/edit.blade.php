@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-eggshell py-12">
        <div class="max-w-2xl mx-auto px-4">

            <div class="mb-6">
                <a href="{{ route('makanan.pengajuan.index') }}"
                    class="inline-flex items-center gap-2 text-slate hover:text-leaf font-bold text-sm transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
                </a>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100">
                <h1 class="text-2xl font-bold text-charcoal mb-6">Edit Pengajuan</h1>

                <form action="{{ route('makanan.pengajuan.update', $pengajuan->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-charcoal mb-1">Nama Makanan</label>
                            <input type="text" name="nama_makanan"
                                value="{{ old('nama_makanan', $pengajuan->nama_makanan) }}"
                                class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-charcoal mb-1">Kategori</label>
                            <select name="kategori_makanan"
                                class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf">
                                @foreach (['Makanan Pokok', 'Lauk Pauk', 'Sayuran', 'Buah-buahan', 'Minuman', 'Camilan'] as $kat)
                                    <option value="{{ $kat }}"
                                        {{ $pengajuan->kategori_makanan == $kat ? 'selected' : '' }}>{{ $kat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-charcoal mb-1">Kuantitas</label>
                            <input type="number" step="0.01" name="kuantitas"
                                value="{{ old('kuantitas', $pengajuan->kuantitas) }}"
                                class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-charcoal mb-1">Satuan</label>
                            <input type="text" name="satuan" value="{{ old('satuan', $pengajuan->satuan) }}"
                                class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf">
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <label class="block text-xs font-bold text-leaf uppercase mb-3">Informasi Nilai Gizi</label>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs text-slate font-bold">Energi</label>
                                <input type="number" step="0.01" name="energi"
                                    value="{{ old('energi', $pengajuan->energi) }}"
                                    class="w-full rounded-xl border-gray-200 text-sm">
                            </div>
                            <div>
                                <label class="text-xs text-slate font-bold">Protein</label>
                                <input type="number" step="0.01" name="protein"
                                    value="{{ old('protein', $pengajuan->protein) }}"
                                    class="w-full rounded-xl border-gray-200 text-sm">
                            </div>
                            <div>
                                <label class="text-xs text-slate font-bold">Lemak</label>
                                <input type="number" step="0.01" name="lemak"
                                    value="{{ old('lemak', $pengajuan->lemak) }}"
                                    class="w-full rounded-xl border-gray-200 text-sm">
                            </div>
                            <div>
                                <label class="text-xs text-slate font-bold">Karbohidrat</label>
                                <input type="number" step="0.01" name="karbohidrat"
                                    value="{{ old('karbohidrat', $pengajuan->karbohidrat) }}"
                                    class="w-full rounded-xl border-gray-200 text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-charcoal mb-2">Foto Makanan</label>
                            <div class="w-full h-32 bg-gray-100 rounded-xl overflow-hidden mb-2 border border-gray-200">
                                <img src="{{ asset('storage/' . $pengajuan->foto_makanan) }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <input type="file" name="foto_makanan" accept="image/*" class="w-full text-xs">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-charcoal mb-2">Foto Label Gizi</label>
                            <div
                                class="w-full h-32 bg-gray-100 rounded-xl overflow-hidden mb-2 border border-gray-200 flex items-center justify-center">
                                @if ($pengajuan->foto_gizi)
                                    <img src="{{ asset('storage/' . $pengajuan->foto_gizi) }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <span class="text-xs text-slate">Tidak ada foto</span>
                                @endif
                            </div>
                            <input type="file" name="foto_gizi" accept="image/*" class="w-full text-xs">
                        </div>
                    </div>

                    <div class="pt-6 flex gap-3">
                        <button type="submit"
                            class="flex-1 py-3 bg-leaf text-white font-bold rounded-xl hover:bg-green-700 transition-colors shadow-md">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('makanan.pengajuan.index') }}"
                            class="py-3 px-6 bg-gray-100 text-slate font-bold rounded-xl hover:bg-gray-200 transition-colors">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
