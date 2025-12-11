@extends('layouts.profile')

@section('content')
    <div class="max-w-2xl mx-auto space-y-8">

        <a href="{{ route('profile.index') }}"
            class="inline-flex items-center gap-2 text-slate hover:text-leaf transition-colors font-medium">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke Profile
        </a>

        <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100">
            <header class="mb-6 border-b border-gray-100 pb-4">
                <h2 class="text-xl font-bold text-charcoal flex items-center gap-2">
                    <i data-lucide="activity" class="w-6 h-6 text-leaf"></i>
                    {{ optional($pengguna)->id ? 'Edit Data Fisik' : 'Lengkapi Data Fisik' }}
                </h2>
                <p class="mt-1 text-sm text-slate">
                    Data ini digunakan untuk menghitung BMI dan Kalori harian Anda secara otomatis.
                </p>
            </header>

            <form method="post" action="{{ route('profile.update.data') }}" class="space-y-6">
                @csrf
                @method('patch')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-medium text-charcoal mb-2">Jenis Kelamin</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="jenis_kelamin" value="Laki-laki" class="peer sr-only"
                                    {{ old('jenis_kelamin', optional($pengguna)->jenis_kelamin) == 'Laki-laki' ? 'checked' : '' }}>
                                <div
                                    class="p-4 rounded-xl border-2 border-gray-200 bg-gray-50 peer-checked:border-leaf peer-checked:bg-mint/30 hover:border-leaf/50 transition-all text-center flex flex-col items-center gap-2">
                                    <i data-lucide="user" class="w-6 h-6 text-slate peer-checked:text-leaf"></i>
                                    <span class="font-semibold text-slate peer-checked:text-leaf">Laki-laki</span>
                                </div>
                            </label>

                            <label class="relative cursor-pointer group">
                                <input type="radio" name="jenis_kelamin" value="Perempuan" class="peer sr-only"
                                    {{ old('jenis_kelamin', optional($pengguna)->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}>
                                <div
                                    class="p-4 rounded-xl border-2 border-gray-200 bg-gray-50 peer-checked:border-leaf peer-checked:bg-mint/30 hover:border-leaf/50 transition-all text-center flex flex-col items-center gap-2">
                                    <i data-lucide="user" class="w-6 h-6 text-slate peer-checked:text-leaf"></i>
                                    <span class="font-semibold text-slate peer-checked:text-leaf">Perempuan</span>
                                </div>
                            </label>
                        </div>
                        @error('jenis_kelamin')
                            <p class="text-tomato text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="berat_badan" class="block text-sm font-medium text-charcoal mb-1">Berat Badan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate">
                                <i data-lucide="scale" class="w-5 h-5"></i>
                            </div>
                            <input type="number" name="berat_badan" id="berat_badan" step="0.1"
                                value="{{ old('berat_badan', optional($pengguna)->berat_badan) }}" required
                                class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:border-leaf focus:ring-leaf sm:text-sm py-3 pl-10 pr-12 transition-colors">
                            <div
                                class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate font-bold">
                                kg</div>
                        </div>
                        @error('berat_badan')
                            <p class="text-tomato text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tinggi_badan" class="block text-sm font-medium text-charcoal mb-1">Tinggi Badan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate">
                                <i data-lucide="ruler" class="w-5 h-5"></i>
                            </div>
                            <input type="number" name="tinggi_badan" id="tinggi_badan"
                                value="{{ old('tinggi_badan', optional($pengguna)->tinggi_badan) }}" required
                                class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:border-leaf focus:ring-leaf sm:text-sm py-3 pl-10 pr-12 transition-colors">
                            <div
                                class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate font-bold">
                                cm</div>
                        </div>
                        @error('tinggi_badan')
                            <p class="text-tomato text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-charcoal mb-1">Tanggal
                            Lahir</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate">
                                <i data-lucide="calendar" class="w-5 h-5"></i>
                            </div>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                value="{{ old('tanggal_lahir', optional($pengguna)->tanggal_lahir) }}" required
                                class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:border-leaf focus:ring-leaf sm:text-sm py-3 pl-10 pr-4 transition-colors">
                        </div>
                        @error('tanggal_lahir')
                            <p class="text-tomato text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="aktivitas_fisik" class="block text-sm font-medium text-charcoal mb-1">Aktivitas
                            Fisik</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate">
                                <i data-lucide="zap" class="w-5 h-5"></i>
                            </div>
                            <select name="aktivitas_fisik" id="aktivitas_fisik"
                                class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:border-leaf focus:ring-leaf sm:text-sm py-3 pl-10 pr-10 appearance-none transition-colors cursor-pointer">
                                <option value="" disabled
                                    {{ old('aktivitas_fisik', optional($pengguna)->aktivitas_fisik) ? '' : 'selected' }}>--
                                    Pilih Aktivitas --</option>
                                <option value="Ringan"
                                    {{ old('aktivitas_fisik', optional($pengguna)->aktivitas_fisik) == 'Ringan' ? 'selected' : '' }}>
                                    Ringan (Jarang Olahraga)</option>
                                <option value="Sedang"
                                    {{ old('aktivitas_fisik', optional($pengguna)->aktivitas_fisik) == 'Sedang' ? 'selected' : '' }}>
                                    Sedang (1-3x Seminggu)</option>
                                <option value="Berat"
                                    {{ old('aktivitas_fisik', optional($pengguna)->aktivitas_fisik) == 'Berat' ? 'selected' : '' }}>
                                    Berat (Rutin/Kerja Fisik)</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>
                        @error('aktivitas_fisik')
                            <p class="text-tomato text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="pt-6 border-t border-gray-100 flex items-center gap-4">
                    <button type="submit"
                        class="px-8 py-3 bg-leaf text-white font-bold rounded-xl hover:bg-green-700 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center gap-2">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        Simpan Data
                    </button>
                    <a href="{{ route('profile.index') }}"
                        class="px-6 py-3 text-slate font-semibold hover:text-charcoal transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
