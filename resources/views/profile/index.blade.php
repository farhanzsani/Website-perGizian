@extends('layouts.profile')

@section('content')
    <div class="space-y-6">

        <div class="relative px-4 sm:px-6 mt-10 pb-10">
            <div class="bg-white rounded-3xl shadow-xl p-6 sm:p-10 border border-gray-100">

                <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                    <div class="relative">
                        <img class="w-32 h-32 rounded-full border-4 border-white shadow-md object-cover"
                            src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=CFF4E1&color=2E9A62&size=128"
                            alt="{{ $user->name }}">
                        <div class="absolute bottom-2 right-2 bg-fresh w-6 h-6 rounded-full border-2 border-white"
                            title="Active"></div>
                    </div>

                    <div class="flex-1 w-full">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                            <div>
                                <h1 class="text-3xl font-bold text-charcoal">{{ $user->name }}</h1>
                                <div class="flex items-center gap-2 text-slate mt-1">
                                    <i data-lucide="mail" class="w-4 h-4"></i>
                                    <span>{{ $user->email }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-slate mt-1">
                                    <i data-lucide="calendar" class="w-4 h-4"></i>
                                    <span>Bergabung sejak {{ $user->created_at->format('d M Y') }}</span>
                                </div>
                            </div>

                            <a href="{{ route('profile.edit') }}"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-leaf text-white font-semibold rounded-xl hover:bg-green-700 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                                <i data-lucide="edit-3" class="w-5 h-5"></i>
                                Edit Akun
                            </a>
                        </div>
                    </div>
                </div>

                <hr class="my-8 border-gray-100">

                <div class="space-y-6">

                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-charcoal flex items-center gap-2">
                            <i data-lucide="activity" class="text-leaf"></i>
                            Data Fisik & Kesehatan
                        </h3>

                        @if ($user->pengguna)
                            <a href="{{ route('profile.edit.data') }}"
                                class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-bold text-leaf bg-mint/30 hover:bg-mint hover:text-green-800 rounded-lg transition-colors border border-mint">
                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                                Edit Data
                            </a>
                        @else
                            <span
                                class="text-xs font-bold text-tomato bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                Data Belum Lengkap
                            </span>
                        @endif
                    </div>

                    @if ($user->pengguna)
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                            <div
                                class="bg-eggshell p-4 rounded-2xl border border-mint/50 hover:border-leaf transition-colors group">
                                <div class="flex items-center gap-2 mb-1 text-slate text-sm">
                                    <i data-lucide="scale" class="w-4 h-4 text-leaf"></i> Berat Badan
                                </div>
                                <p class="text-2xl font-bold text-charcoal group-hover:text-leaf transition-colors">
                                    {{ $user->pengguna->berat_badan }} <span
                                        class="text-sm font-medium text-slate">kg</span>
                                </p>
                            </div>

                            <div
                                class="bg-eggshell p-4 rounded-2xl border border-mint/50 hover:border-leaf transition-colors group">
                                <div class="flex items-center gap-2 mb-1 text-slate text-sm">
                                    <i data-lucide="ruler" class="w-4 h-4 text-leaf"></i> Tinggi Badan
                                </div>
                                <p class="text-2xl font-bold text-charcoal group-hover:text-leaf transition-colors">
                                    {{ $user->pengguna->tinggi_badan }} <span
                                        class="text-sm font-medium text-slate">cm</span>
                                </p>
                            </div>

                            <div
                                class="bg-eggshell p-4 rounded-2xl border border-mint/50 hover:border-leaf transition-colors group">
                                <div class="flex items-center gap-2 mb-1 text-slate text-sm">
                                    <i data-lucide="cake" class="w-4 h-4 text-leaf"></i> Usia
                                </div>
                                <p class="text-2xl font-bold text-charcoal group-hover:text-leaf transition-colors">
                                    {{ \Carbon\Carbon::parse($user->pengguna->tanggal_lahir)->age }} <span
                                        class="text-sm font-medium text-slate">th</span>
                                </p>
                            </div>

                            <div
                                class="bg-eggshell p-4 rounded-2xl border border-mint/50 hover:border-leaf transition-colors group">
                                <div class="flex items-center gap-2 mb-1 text-slate text-sm">
                                    <i data-lucide="users" class="w-4 h-4 text-leaf"></i> Gender
                                </div>
                                <p class="text-lg font-bold text-charcoal group-hover:text-leaf transition-colors mt-1">
                                    {{ $user->pengguna->jenis_kelamin }}
                                </p>
                            </div>

                            <div
                                class="col-span-2 md:col-span-2 bg-eggshell p-4 rounded-2xl border border-mint/50 hover:border-leaf transition-colors group">
                                <div class="flex items-center gap-2 mb-1 text-slate text-sm">
                                    <i data-lucide="zap" class="w-4 h-4 text-coral"></i> Aktivitas Fisik
                                </div>
                                <p class="text-lg font-bold text-charcoal group-hover:text-leaf transition-colors">
                                    {{ $user->pengguna->aktivitas_fisik }}
                                </p>
                            </div>

                            <div
                                class="col-span-2 md:col-span-2 bg-eggshell p-4 rounded-2xl border border-mint/50 hover:border-leaf transition-colors group">
                                <div class="flex items-center gap-2 mb-1 text-slate text-sm">
                                    <i data-lucide="shield-check" class="w-4 h-4 text-sunshine"></i> Role Akun
                                </div>
                                <p class="text-lg font-bold text-charcoal capitalize">
                                    {{ $user->getRoleNames()->first() ?? 'User' }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                            @php
                                $skorBmi = $user->pengguna->bmi; // Ambil langsung dari kolom bmi
                                $keterangan = 'Tidak diketahui';
                                $colorBmi = 'text-slate';
                                $bgBmi = 'bg-eggshell';

                                if ($skorBmi) {
                                    if ($skorBmi < 18.5) {
                                        $keterangan = 'Kekurangan Berat Badan';
                                        $colorBmi = 'text-sunshine';
                                        $bgBmi = 'bg-yellow-50 border-yellow-200';
                                    } elseif ($skorBmi >= 18.5 && $skorBmi <= 24.9) {
                                        $keterangan = 'Normal';
                                        $colorBmi = 'text-fresh';
                                        $bgBmi = 'bg-green-50 border-green-200';
                                    } elseif ($skorBmi >= 25 && $skorBmi <= 29.9) {
                                        $keterangan = 'Kelebihan Berat Badan';
                                        $colorBmi = 'text-orange-500';
                                        $bgBmi = 'bg-orange-50 border-orange-200';
                                    } else {
                                        $keterangan = 'Obesitas';
                                        $colorBmi = 'text-tomato';
                                        $bgBmi = 'bg-red-50 border-red-200';
                                    }
                                }
                            @endphp

                            <div class="p-6 rounded-3xl border {{ $bgBmi }} shadow-sm">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="font-bold text-charcoal flex items-center gap-2">
                                        <i data-lucide="gauge" class="{{ $colorBmi }}"></i> Indeks Massa Tubuh (BMI)
                                    </h4>
                                    <span class="text-xs font-bold px-2 py-1 rounded bg-white/50 border border-gray-100">
                                        Update: {{ $user->pengguna->updated_at->format('d M Y') }}
                                    </span>
                                </div>
                                <div class="flex items-end gap-3">
                                    <span class="text-4xl font-extrabold {{ $colorBmi }}">
                                        {{ $skorBmi ? number_format($skorBmi, 1) : '-' }}
                                    </span>
                                    <span
                                        class="text-sm font-semibold text-charcoal mb-1.5 pb-0.5 border-b-2 border-dashed border-gray-300">
                                        {{ $skorBmi ? $keterangan : 'Belum ada data' }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate mt-2">
                                    Skor BMI dihitung otomatis berdasarkan berat & tinggi badan Anda saat ini.
                                </p>
                            </div>

                            <div class="p-6 rounded-3xl border border-blue-100 bg-blue-50 shadow-sm">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="font-bold text-charcoal flex items-center gap-2">
                                        <i data-lucide="flame" class="text-blue-500"></i> Kebutuhan Kalori Harian
                                    </h4>
                                </div>
                                <div class="flex items-end gap-3">
                                    <span class="text-4xl font-extrabold text-blue-600">
                                        {{ $user->pengguna->kalori ? number_format($user->pengguna->kalori) : '-' }}
                                    </span>
                                    <span class="text-sm font-semibold text-charcoal mb-1.5">kkal / hari</span>
                                </div>
                                <p class="text-xs text-slate mt-2">
                                    Estimasi energi harian berdasarkan aktivitas:
                                    <strong class="text-charcoal">{{ $user->pengguna->aktivitas_fisik }}</strong>.
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 text-center">
                            <div
                                class="bg-yellow-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3 text-yellow-600">
                                <i data-lucide="alert-circle" class="w-6 h-6"></i>
                            </div>
                            <h3 class="text-lg font-bold text-charcoal">Data Kesehatan Belum Diisi</h3>
                            <p class="text-slate mb-4 text-sm">
                                Lengkapi data berat badan, tinggi badan, dan aktivitas fisik Anda untuk mendapatkan
                                rekomendasi gizi yang akurat.
                            </p>
                            <a href="{{ route('profile.edit.data') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-coral text-white text-sm font-bold rounded-lg hover:bg-orange-600 transition-colors shadow-md">
                                Isi Data Sekarang <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
