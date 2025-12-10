@extends('layouts.kalkulator')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center p-3 bg-mint/30 rounded-full text-leaf mb-4">
                <i data-lucide="activity" class="w-8 h-8"></i>
            </div>
            <h1 class="text-3xl font-bold text-charcoal">Kalkulator Kesehatan</h1>
            <p class="text-slate mt-2 text-lg">Pantau kondisi tubuh dan kebutuhan energimu secara berkala.</p>
        </div>

        <div x-data="{ tab: '{{ session('active_tab', 'bmi') }}' }" class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">

                <div class="flex p-1.5 bg-gray-100 rounded-2xl">
                    <button @click="tab = 'bmi'"
                        :class="tab === 'bmi' ? 'bg-white text-leaf shadow-sm' : 'text-slate hover:text-charcoal'"
                        class="flex-1 py-3 px-4 rounded-xl text-sm font-bold transition-all flex items-center justify-center gap-2">
                        <i data-lucide="scale" class="w-4 h-4"></i> Kalkulator BMI
                    </button>
                    <button @click="tab = 'kalori'"
                        :class="tab === 'kalori' ? 'bg-white text-coral shadow-sm' : 'text-slate hover:text-charcoal'"
                        class="flex-1 py-3 px-4 rounded-xl text-sm font-bold transition-all flex items-center justify-center gap-2">
                        <i data-lucide="flame" class="w-4 h-4"></i> Kebutuhan Kalori
                    </button>
                </div>

                @if (session('result_bmi'))
                    <div x-show="tab === 'bmi'"
                        class="bg-white border-l-4 border-leaf shadow-md p-6 rounded-r-2xl flex flex-col items-center justify-center text-center animate-pulse-once relative overflow-hidden">
                        <div class="absolute right-0 top-0 p-4 opacity-10">
                            <i data-lucide="scale" class="w-24 h-24 text-leaf"></i>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate">Hasil BMI Anda</span>
                        <span
                            class="text-5xl font-extrabold my-2 text-leaf">{{ number_format(session('result_bmi')['skor'], 1) }}</span>
                        <span class="px-4 py-1.5 bg-leaf text-white rounded-full text-sm font-bold shadow-sm">
                            {{ session('result_bmi')['keterangan'] }}
                        </span>
                    </div>
                @endif

                @if (session('result_kalori'))
                    <div x-show="tab === 'kalori'"
                        class="bg-white border-l-4 border-coral shadow-md p-6 rounded-r-2xl flex flex-col items-center justify-center text-center animate-pulse-once relative overflow-hidden">
                        <div class="absolute right-0 top-0 p-4 opacity-10">
                            <i data-lucide="flame" class="w-24 h-24 text-coral"></i>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate">Target Kalori Harian</span>
                        <span
                            class="text-5xl font-extrabold my-2 text-coral">{{ number_format(session('result_kalori')) }}</span>
                        <span class="text-sm font-medium text-charcoal bg-orange-50 px-3 py-1 rounded-lg">
                            kkal / hari
                        </span>
                    </div>
                @endif

                <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                    <form action="{{ route('kalkulator.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" x-model="tab">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label class="block text-sm font-bold text-charcoal mb-2">Berat Badan</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate">
                                        <i data-lucide="scale" class="w-5 h-5"></i>
                                    </div>
                                    <input type="number" name="berat_badan" step="0.1" required
                                        value="{{ old('berat_badan', $defaults->berat_badan) }}"
                                        class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-leaf focus:ring-leaf py-3 pl-10 pr-12 transition-colors">
                                    <span class="absolute right-4 top-3.5 text-slate text-sm font-bold">kg</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-charcoal mb-2">Tinggi Badan</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate">
                                        <i data-lucide="ruler" class="w-5 h-5"></i>
                                    </div>
                                    <input type="number" name="tinggi_badan" required
                                        value="{{ old('tinggi_badan', $defaults->tinggi_badan) }}"
                                        class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-leaf focus:ring-leaf py-3 pl-10 pr-12 transition-colors">
                                    <span class="absolute right-4 top-3.5 text-slate text-sm font-bold">cm</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-charcoal mb-2">Usia</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate">
                                        <i data-lucide="cake" class="w-5 h-5"></i>
                                    </div>
                                    <input type="number" name="usia" required
                                        value="{{ \Carbon\Carbon::parse($defaults->tanggal_lahir)->age }}"
                                        class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-leaf focus:ring-leaf py-3 pl-10 pr-4 transition-colors">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-charcoal mb-2">Jenis Kelamin</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate">
                                        <i data-lucide="users" class="w-5 h-5"></i>
                                    </div>
                                    <select name="jenis_kelamin"
                                        class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-leaf focus:ring-leaf py-3 pl-10 pr-4 appearance-none">
                                        <option value="Laki-laki"
                                            {{ $defaults->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                        </option>
                                        <option value="Perempuan"
                                            {{ $defaults->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                        </option>
                                    </select>
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate">
                                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                    </div>
                                </div>
                            </div>

                            <div x-show="tab === 'kalori'" class="md:col-span-2"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100">

                                <label class="block text-sm font-bold text-charcoal mb-3">Tingkat Aktivitas Fisik</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <label class="cursor-pointer group">
                                        <input type="radio" name="aktivitas_fisik" value="Ringan" class="peer sr-only"
                                            {{ $defaults->aktivitas_fisik == 'Ringan' ? 'checked' : '' }}>
                                        <div
                                            class="p-4 rounded-xl border-2 border-gray-200 bg-white peer-checked:border-coral peer-checked:bg-orange-50 hover:border-coral/50 text-center transition-all h-full flex flex-col items-center justify-center gap-2">
                                            <i data-lucide="coffee" class="w-6 h-6 text-slate peer-checked:text-coral"></i>
                                            <div>
                                                <span
                                                    class="block font-bold text-sm text-charcoal peer-checked:text-coral">Ringan</span>
                                                <span class="text-xs text-slate">Jarang olahraga</span>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="cursor-pointer group">
                                        <input type="radio" name="aktivitas_fisik" value="Sedang" class="peer sr-only"
                                            {{ $defaults->aktivitas_fisik == 'Sedang' ? 'checked' : '' }}>
                                        <div
                                            class="p-4 rounded-xl border-2 border-gray-200 bg-white peer-checked:border-coral peer-checked:bg-orange-50 hover:border-coral/50 text-center transition-all h-full flex flex-col items-center justify-center gap-2">
                                            <i data-lucide="person-standing"
                                                class="w-6 h-6 text-slate peer-checked:text-coral"></i>
                                            <div>
                                                <span
                                                    class="block font-bold text-sm text-charcoal peer-checked:text-coral">Sedang</span>
                                                <span class="text-xs text-slate">1-3x seminggu</span>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="cursor-pointer group">
                                        <input type="radio" name="aktivitas_fisik" value="Berat" class="peer sr-only"
                                            {{ $defaults->aktivitas_fisik == 'Berat' ? 'checked' : '' }}>
                                        <div
                                            class="p-4 rounded-xl border-2 border-gray-200 bg-white peer-checked:border-coral peer-checked:bg-orange-50 hover:border-coral/50 text-center transition-all h-full flex flex-col items-center justify-center gap-2">
                                            <i data-lucide="dumbbell"
                                                class="w-6 h-6 text-slate peer-checked:text-coral"></i>
                                            <div>
                                                <span
                                                    class="block font-bold text-sm text-charcoal peer-checked:text-coral">Berat</span>
                                                <span class="text-xs text-slate">Rutin/Kerja fisik</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <button type="submit"
                                :class="tab === 'bmi' ? 'bg-leaf hover:bg-green-700 shadow-leaf/30' :
                                    'bg-coral hover:bg-orange-600 shadow-coral/30'"
                                class="w-full text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <i data-lucide="calculator" class="w-5 h-5"></i>
                                <span x-text="tab === 'bmi' ? 'Hitung BMI Sekarang' : 'Hitung Kebutuhan Kalori'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">

                <div class="bg-charcoal text-white p-6 rounded-2xl shadow-lg flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-lg">Riwayat <span x-text="tab === 'bmi' ? 'BMI' : 'Kalori'"></span></h3>
                        <p class="text-xs text-gray-400">5 data perhitungan terakhir</p>
                    </div>
                    <div class="bg-white/10 p-2 rounded-lg">
                        <i data-lucide="history" class="w-6 h-6 text-white"></i>
                    </div>
                </div>

                <div class="space-y-4 max-h-[600px] overflow-y-auto pr-1 custom-scrollbar">

                    <div x-show="tab === 'bmi'" x-transition>
                        @forelse($historyBMI as $item)
                            <div
                                class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm mb-3 hover:border-leaf transition-colors group relative">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-bold text-slate bg-gray-100 px-2 py-1 rounded">
                                        {{ $item->created_at->format('d M Y') }}
                                    </span>
                                    <span class="text-xs text-gray-400">{{ $item->created_at->format('H:i') }}</span>
                                </div>

                                <div class="flex justify-between items-end">
                                    <div>
                                        <div
                                            class="text-2xl font-bold text-charcoal group-hover:text-leaf transition-colors">
                                            {{ number_format($item->skor, 1) }}
                                        </div>
                                        <p class="text-xs text-slate">Berat: {{ $item->berat_badan }}kg</p>
                                    </div>

                                    <span
                                        class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide
                                    {{ $item->keterangan == 'Normal' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $item->keterangan }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-200">
                                <div class="inline-flex bg-gray-50 p-3 rounded-full mb-3">
                                    <i data-lucide="clipboard-x" class="w-6 h-6 text-slate"></i>
                                </div>
                                <p class="text-slate text-sm">Belum ada riwayat BMI.</p>
                            </div>
                        @endforelse
                    </div>

                    <div x-show="tab === 'kalori'" x-transition style="display: none;">
                        @forelse($historyKalori as $item)
                            <div
                                class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm mb-3 hover:border-coral transition-colors group">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-bold text-slate bg-gray-100 px-2 py-1 rounded">
                                        {{ $item->created_at->format('d M Y') }}
                                    </span>
                                    <span class="text-xs text-gray-400">{{ $item->created_at->format('H:i') }}</span>
                                </div>

                                <div class="flex justify-between items-end">
                                    <div>
                                        <div
                                            class="text-2xl font-bold text-charcoal group-hover:text-coral transition-colors">
                                            {{ number_format($item->skor) }} <span class="text-sm font-medium">kkal</span>
                                        </div>
                                        <p class="text-xs text-slate">Aktivitas: {{ $item->aktivitas_fisik }}</p>
                                    </div>
                                    <div class="bg-orange-50 p-2 rounded-full text-coral">
                                        <i data-lucide="flame" class="w-4 h-4"></i>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-200">
                                <div class="inline-flex bg-gray-50 p-3 rounded-full mb-3">
                                    <i data-lucide="clipboard-x" class="w-6 h-6 text-slate"></i>
                                </div>
                                <p class="text-slate text-sm">Belum ada riwayat Kalori.</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
