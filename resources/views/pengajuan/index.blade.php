@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-eggshell py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-10 text-center md:text-left">
                <h1 class="text-3xl font-bold text-charcoal">Pengajuan Makanan Baru</h1>
                <p class="text-slate mt-2">Kontribusikan data makanan lengkap beserta informasi gizinya.</p>
            </div>

            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-green-100 border border-green-200 text-green-800 rounded-2xl flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-5 h-5"></i> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-200 text-green-800 rounded-2xl flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-5 h-5"></i> {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-3xl shadow-lg border border-gray-100 sticky top-24">
                        <h2 class="text-xl font-bold text-charcoal mb-4 flex items-center gap-2">
                            <i data-lucide="plus-circle" class="text-leaf"></i> Isi Data Makanan
                        </h2>

                        <form action="{{ route('makanan.pengajuan.store') }}" method="POST" enctype="multipart/form-data"
                            class="space-y-4">
                            @csrf

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-bold text-charcoal mb-1">Nama Makanan</label>
                                    <input type="text" name="nama_makanan" value="{{ old('nama_makanan') }}"
                                        class="w-full rounded-xl border-gray-200 text-sm focus:border-leaf focus:ring-leaf"
                                        placeholder="Cth: Nasi Goreng Spesial" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-charcoal mb-1">Kategori</label>
                                    <select name="kategori_makanan"
                                        class="w-full rounded-xl border-gray-200 text-sm focus:border-leaf focus:ring-leaf"
                                        required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="Makanan Pokok">Makanan Pokok</option>
                                        <option value="Lauk Pauk">Lauk Pauk</option>
                                        <option value="Sayuran">Sayuran</option>
                                        <option value="Buah-buahan">Buah-buahan</option>
                                        <option value="Minuman">Minuman</option>
                                        <option value="Camilan">Camilan</option>
                                    </select>
                                </div>
                            </div>

                            <hr class="border-gray-100">

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-charcoal mb-1">Kuantitas</label>
                                    <input type="number" step="0.01" name="kuantitas" value="{{ old('kuantitas') }}"
                                        class="w-full rounded-xl border-gray-200 text-sm focus:border-leaf focus:ring-leaf"
                                        placeholder="100" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-charcoal mb-1">Satuan</label>
                                    <input type="text" name="satuan" value="{{ old('satuan') }}"
                                        class="w-full rounded-xl border-gray-200 text-sm focus:border-leaf focus:ring-leaf"
                                        placeholder="gram/porsi" required>
                                </div>
                            </div>

                            <hr class="border-gray-100">

                            <div>
                                <label class="block text-xs font-bold text-leaf uppercase mb-2">Informasi Nilai Gizi</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="text-[10px] text-slate font-bold">Energi (kkal)</label>
                                        <input type="number" step="0.01" name="energi" value="{{ old('energi') }}"
                                            class="w-full rounded-xl border-gray-200 text-sm focus:border-leaf focus:ring-leaf"
                                            required>
                                    </div>
                                    <div>
                                        <label class="text-[10px] text-slate font-bold">Protein (g)</label>
                                        <input type="number" step="0.01" name="protein" value="{{ old('protein') }}"
                                            class="w-full rounded-xl border-gray-200 text-sm focus:border-leaf focus:ring-leaf"
                                            required>
                                    </div>
                                    <div>
                                        <label class="text-[10px] text-slate font-bold">Lemak (g)</label>
                                        <input type="number" step="0.01" name="lemak" value="{{ old('lemak') }}"
                                            class="w-full rounded-xl border-gray-200 text-sm focus:border-leaf focus:ring-leaf"
                                            required>
                                    </div>
                                    <div>
                                        <label class="text-[10px] text-slate font-bold">Karbohidrat (g)</label>
                                        <input type="number" step="0.01" name="karbohidrat"
                                            value="{{ old('karbohidrat') }}"
                                            class="w-full rounded-xl border-gray-200 text-sm focus:border-leaf focus:ring-leaf"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-gray-100">

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-bold text-charcoal mb-1">Foto Makanan (Wajib)</label>
                                    <input type="file" name="foto_makanan" accept="image/*"
                                        class="w-full text-xs text-slate file:mr-2 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-mint/20 file:text-leaf hover:file:bg-mint/30"
                                        required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-charcoal mb-1">Foto Label Gizi
                                        (Opsional)</label>
                                    <input type="file" name="foto_gizi" accept="image/*"
                                        class="w-full text-xs text-slate file:mr-2 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-slate hover:file:bg-gray-200">
                                    <p class="text-[10px] text-slate mt-1">Upload jika Anda mengambil data dari kemasan.</p>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full py-3 bg-leaf text-white font-bold rounded-xl hover:bg-green-700 transition-all shadow-md transform hover:-translate-y-1">
                                Kirim Pengajuan
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <h2 class="text-xl font-bold text-charcoal mb-4 flex items-center gap-2">
                        <i data-lucide="history" class="text-leaf"></i> Riwayat Pengajuan
                    </h2>

                    <div class="space-y-4">
                        @forelse($pengajuan as $item)
                            <div
                                class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-5 hover:shadow-md transition-shadow">

                                <div
                                    class="w-full md:w-32 h-32 flex-shrink-0 bg-gray-100 rounded-2xl overflow-hidden relative border border-gray-200">
                                    @if ($item->foto_makanan)
                                        <img src="{{ asset('storage/' . $item->foto_makanan) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full text-slate"><i
                                                data-lucide="utensils"></i></div>
                                    @endif
                                </div>

                                <div class="flex-grow">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="text-lg font-bold text-charcoal">{{ $item->nama_makanan }}</h3>
                                            <span
                                                class="text-xs font-bold text-slate bg-gray-100 px-2 py-0.5 rounded">{{ $item->kategori_makanan }}</span>
                                        </div>

                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-bold capitalize
                                        {{ $item->status_pengajuan == 'approved'
                                            ? 'bg-green-100 text-green-700'
                                            : ($item->status_pengajuan == 'rejected'
                                                ? 'bg-red-100 text-red-700'
                                                : 'bg-yellow-100 text-yellow-700') }}">
                                            {{ $item->status_pengajuan }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-4 gap-2 text-center bg-eggshell rounded-xl p-2 mb-3">
                                        <div>
                                            <p class="text-[10px] text-slate">Energi</p>
                                            <p class="text-xs font-bold">{{ $item->energi }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-slate">Prot</p>
                                            <p class="text-xs font-bold">{{ $item->protein }}g</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-slate">Lemak</p>
                                            <p class="text-xs font-bold">{{ $item->lemak }}g</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-slate">Karbo</p>
                                            <p class="text-xs font-bold">{{ $item->karbohidrat }}g</p>
                                        </div>
                                    </div>

                                    <p class="text-xs text-slate/50">Diajukan pada:
                                        {{ $item->created_at->format('d M Y') }}</p>
                                </div>

                                <div class="flex md:flex-col gap-2 w-full md:w-auto justify-center">
                                    @if ($item->status_pengajuan == 'pending')
                                        <a href="{{ route('makanan.pengajuan.edit', $item->id) }}"
                                            class="py-2 px-4 bg-gray-100 hover:bg-gray-200 text-slate rounded-xl text-xs font-bold text-center transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('makanan.pengajuan.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus pengajuan ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="w-full py-2 px-4 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-xs font-bold transition-colors">
                                                Batal
                                            </button>
                                        </form>
                                    @else
                                        <button disabled
                                            class="py-2 px-4 bg-gray-50 text-gray-400 rounded-xl text-xs font-bold cursor-not-allowed">
                                            Terkunci
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 bg-white rounded-3xl border border-dashed border-gray-300">
                                <p class="text-slate font-medium">Belum ada pengajuan.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">{{ $pengajuan->links() }}</div>
                </div>

            </div>
        </div>
    </div>
@endsection
