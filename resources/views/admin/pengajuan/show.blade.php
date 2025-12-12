@extends('layouts.admin')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">

        <div class="flex items-center gap-2 text-slate mb-2">
            <a href="{{ route('admin.pengajuan.index') }}"
                class="p-2 bg-white border border-gray-200 rounded-xl hover:text-leaf hover:border-leaf transition-colors shadow-sm">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h1 class="text-xl font-bold text-charcoal">Review Pengajuan</h1>
                <p class="text-xs text-slate">Detail data yang dikirimkan pengguna.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="space-y-6">
                <div class="bg-white p-4 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-sm font-bold text-charcoal mb-3">Foto Makanan</h3>
                    <div class="aspect-square rounded-2xl overflow-hidden bg-gray-100 border border-gray-200 relative">
                        @if ($pengajuan->foto_makanan)
                            <img src="{{ asset('storage/' . $pengajuan->foto_makanan) }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate"><i
                                    data-lucide="image-off"></i></div>
                        @endif
                    </div>
                </div>

                <div class="bg-white p-4 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-sm font-bold text-charcoal mb-3">Foto Label Gizi (Bukti)</h3>
                    <div class="aspect-video rounded-2xl overflow-hidden bg-gray-100 border border-gray-200 relative">
                        @if ($pengajuan->foto_gizi)
                            <img src="{{ asset('storage/' . $pengajuan->foto_gizi) }}" class="w-full h-full object-cover">
                            <a href="{{ asset('storage/' . $pengajuan->foto_gizi) }}" target="_blank"
                                class="absolute bottom-2 right-2 bg-black/50 text-white p-2 rounded-lg hover:bg-black/70 backdrop-blur-sm"
                                title="Lihat Full">
                                <i data-lucide="maximize-2" class="w-4 h-4"></i>
                            </a>
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate">
                                <i data-lucide="file-x" class="w-8 h-8 opacity-30 mb-1"></i>
                                <span class="text-xs">Tidak dilampirkan</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">

                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-2xl font-extrabold text-charcoal">{{ $pengajuan->nama_makanan }}</h2>
                            <span class="text-sm text-slate">Kategori: <span
                                    class="font-bold text-leaf">{{ $pengajuan->kategori_makanan }}</span></span>
                        </div>
                        @if ($pengajuan->status_pengajuan == 'pending')
                            <span
                                class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold border border-yellow-200">Menunggu
                                Review</span>
                        @elseif($pengajuan->status_pengajuan == 'approved')
                            <span
                                class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold border border-green-200">Disetujui</span>
                        @else
                            <span
                                class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-bold border border-red-200">Ditolak</span>
                        @endif
                    </div>

                    <hr class="border-gray-100 mb-6">

                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div>
                            <p class="text-xs font-bold text-slate uppercase mb-1">Diajukan Oleh</p>
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-8 h-8 rounded-full bg-leaf text-white flex items-center justify-center text-xs font-bold">
                                    {{ substr($pengajuan->pengguna->user->name ?? 'U', 0, 1) }}
                                </div>
                                <p class="font-bold text-charcoal">{{ $pengajuan->pengguna->user->name ?? 'Unknown' }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate uppercase mb-1">Takaran Saji</p>
                            <p class="font-bold text-charcoal text-lg">{{ $pengajuan->kuantitas }} <span
                                    class="text-sm font-normal text-slate">{{ $pengajuan->satuan }}</span></p>
                        </div>
                    </div>

                    <div class="bg-eggshell rounded-2xl p-6 border border-gray-100">
                        <h3 class="text-sm font-bold text-leaf mb-4 uppercase tracking-wider">Informasi Nilai Gizi</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                                <p class="text-[10px] text-slate font-bold uppercase">Energi</p>
                                <p class="text-xl font-black text-charcoal">{{ $pengajuan->energi }}</p>
                                <p class="text-[10px] text-slate">kkal</p>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                                <p class="text-[10px] text-slate font-bold uppercase">Protein</p>
                                <p class="text-xl font-black text-charcoal">{{ $pengajuan->protein }}</p>
                                <p class="text-[10px] text-slate">g</p>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                                <p class="text-[10px] text-slate font-bold uppercase">Lemak</p>
                                <p class="text-xl font-black text-charcoal">{{ $pengajuan->lemak }}</p>
                                <p class="text-[10px] text-slate">g</p>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                                <p class="text-[10px] text-slate font-bold uppercase">Karbo</p>
                                <p class="text-xl font-black text-charcoal">{{ $pengajuan->karbohidrat }}</p>
                                <p class="text-[10px] text-slate">g</p>
                            </div>
                        </div>
                    </div>

                </div>

                @if ($pengajuan->status_pengajuan == 'pending')
                    <div class="bg-white p-6 rounded-3xl shadow-lg border border-gray-100">
                        <h3 class="font-bold text-charcoal mb-4">Tindakan Admin</h3>
                        <div class="flex gap-3">

                            <form action="{{ route('admin.pengajuan.setuju', $pengajuan->id) }}" method="POST"
                                class="flex-1"
                                onsubmit="return confirm('Yakin setujui? Data akan masuk ke database Makanan Utama.');">
                                @csrf
                                @method('PUT') {{-- Atau POST sesuai route Anda --}}
                                <button type="submit"
                                    class="w-full py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition-all shadow-md flex items-center justify-center gap-2">
                                    <i data-lucide="check-circle" class="w-5 h-5"></i> Setujui & Publikasikan
                                </button>
                            </form>

                            <form action="{{ route('admin.pengajuan.tolak', $pengajuan->id) }}" method="POST"
                                class="flex-1" onsubmit="return confirm('Yakin tolak pengajuan ini?');">
                                @csrf
                                @method('PUT') {{-- Atau DELETE sesuai route Anda --}}
                                <button type="submit"
                                    class="w-full py-3 bg-white border-2 border-red-100 text-red-600 font-bold rounded-xl hover:bg-red-50 hover:border-red-200 transition-all flex items-center justify-center gap-2">
                                    <i data-lucide="x-circle" class="w-5 h-5"></i> Tolak Pengajuan
                                </button>
                            </form>

                        </div>
                        <p class="text-xs text-slate mt-3 text-center">
                            *Menyetujui akan menyalin data ini ke tabel <strong>Makanan</strong> secara otomatis.
                        </p>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
