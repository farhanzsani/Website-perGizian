@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center gap-2 text-slate mb-4">
            <a href="{{ route('admin.kelolamakanan.index') }}" class="hover:text-leaf transition-colors"><i
                    data-lucide="arrow-left" class="w-5 h-5"></i></a>
            <h1 class="text-xl font-bold text-charcoal">Tambah Makanan Baru</h1>
        </div>

        <form action="{{ route('admin.kelolamakanan.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-charcoal mb-1">Nama Makanan</label>
                        <input type="text" name="nama"
                            class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-charcoal mb-1">Kategori</label>
                        <select name="kategori_makanan_id"
                            class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-charcoal mb-1">Foto Makanan</label>
                        <input type="file" name="foto_makanan" accept="image/*"
                            class="w-full text-sm text-slate file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-mint/20 file:text-leaf hover:file:bg-mint/30"
                            required>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-charcoal mb-1">Kuantitas</label>
                            <input type="number" name="kuantitas" step="0.01"
                                class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-charcoal mb-1">Satuan</label>
                            <input type="text" name="satuan" placeholder="gram/porsi"
                                class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-charcoal mb-1">Energi (Kkal)</label>
                        <input type="number" name="energi" step="0.01"
                            class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf" required>
                    </div>
                </div>
            </div>

            <hr class="my-6 border-gray-100">
            <h3 class="text-sm font-bold text-leaf uppercase tracking-wider mb-4">Informasi Makronutrisi</h3>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate mb-1">Protein (g)</label>
                    <input type="number" name="protein" step="0.01"
                        class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate mb-1">Lemak (g)</label>
                    <input type="number" name="lemak" step="0.01"
                        class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate mb-1">Karbohidrat (g)</label>
                    <input type="number" name="karbohidrat" step="0.01"
                        class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf" required>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('admin.kelolamakanan.index') }}"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate bg-gray-100 hover:bg-gray-200">Batal</a>
                <button type="submit"
                    class="px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-leaf hover:bg-green-700 shadow-md">Simpan
                    Data</button>
            </div>
        </form>
    </div>
@endsection
