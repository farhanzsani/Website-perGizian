@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-eggshell py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">

            <div class="mb-6">
                <a href="{{ route('admin.keluarga.index') }}"
                    class="inline-flex items-center gap-2 text-slate hover:text-leaf font-bold text-sm transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                <div class="mb-8 flex items-center gap-4">
                    <div class="p-3 bg-leaf/10 rounded-full text-leaf"><i data-lucide="plus-circle" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-charcoal">Buat Keluarga Baru</h1>
                        <p class="text-slate text-sm">Admin menunjuk satu user sebagai ketua.</p>
                    </div>
                </div>

                @if (session('error'))
                    <div class="mb-6 bg-red-50 text-red-700 px-4 py-3 rounded-xl text-sm">{{ session('error') }}</div>
                @endif

                <form action="{{ route('admin.keluarga.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-bold text-charcoal mb-2">Nama Keluarga</label>
                        <input type="text" name="nama_keluarga" placeholder="Contoh: Keluarga Cemara" required
                            class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf bg-gray-50 focus:bg-white transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-charcoal mb-2">Pilih Kepala Keluarga</label>
                        <div class="relative">
                            <select name="kepala_keluarga_id" required
                                class="w-full appearance-none rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf bg-gray-50 focus:bg-white p-3 pr-10 transition-colors ">
                                <option value="" disabled selected>-- Pilih User (Yang Belum Punya Keluarga) --
                                </option>
                                @foreach ($calonKetua as $user)
                                    <option value="{{ $user->id }} " class="overflow-scroll">
                                        {{ $user->user->name }} ({{ $user->user->email }})
                                    </option>
                                @endforeach
                            </select>
                            <i data-lucide="chevron-down"
                                class="w-4 h-4 text-slate absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        </div>

                        @if ($calonKetua->isEmpty())
                            <p class="text-xs text-red-500 mt-2 flex items-center gap-1">
                                <i data-lucide="alert-circle" class="w-3 h-3"></i>
                                Tidak ada user tersedia. Semua user sudah punya keluarga.
                            </p>
                        @else
                            <p class="text-xs text-slate mt-2">Hanya menampilkan user yang status keluarganya kosong.</p>
                        @endif
                    </div>

                    <div class="pt-4 flex gap-3">
                        <a href="{{ route('admin.keluarga.index') }}"
                            class="flex-1 py-3 bg-gray-100 text-charcoal font-bold rounded-xl text-center hover:bg-gray-200 transition-colors">Batal</a>
                        <button type="submit" {{ $calonKetua->isEmpty() ? 'disabled' : '' }}
                            class="flex-1 py-3 bg-leaf text-white font-bold rounded-xl hover:bg-green-700 transition-all shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
