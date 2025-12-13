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
                        <div class="relative" x-data="{ 
                            open: false, 
                            selected: '{{ old('kategori_makanan_id') }}',
                            label: '{{ $kategori->firstWhere('id', old('kategori_makanan_id'))->kategori ?? 'Pilih Kategori' }}'
                        }">
                            <input type="hidden" name="kategori_makanan_id" :value="selected">
                            
                            <button type="button" @click="open = !open" @click.outside="open = false"
                                class="w-full flex items-center justify-between px-4 py-3 text-sm text-charcoal border border-gray-200 rounded-xl focus:outline-none focus:border-leaf focus:ring-1 focus:ring-leaf bg-white"
                                :class="open ? 'border-leaf ring-1 ring-leaf' : ''">
                                <span x-text="label" :class="selected ? 'text-charcoal' : 'text-gray-500'"></span>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-slate transition-transform duration-200"
                                   :class="{'rotate-180': open}"></i>
                            </button>

                            <div x-show="open" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-2"
                                class="absolute top-full left-0 mt-2 w-full bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden ring-1 ring-black ring-opacity-5"
                                style="display: none;">
                                
                                <div class="py-1 max-h-60 overflow-y-auto">
                                    <button type="button" 
                                        @click="selected = ''; label = 'Pilih Kategori'; open = false" 
                                        class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-left hover:bg-mint/30 transition-colors text-slate">
                                        Pilih Kategori
                                    </button>

                                    @foreach ($kategori as $kat)
                                        <button type="button" 
                                            @click="selected = '{{ $kat->id }}'; label = '{{ $kat->kategori }}'; open = false" 
                                            class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-left hover:bg-mint/30 transition-colors"
                                            :class="selected == '{{ $kat->id }}' ? 'text-leaf bg-mint/10 font-bold' : 'text-slate'">
                                            {{ $kat->kategori }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
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
