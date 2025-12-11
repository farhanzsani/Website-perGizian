@extends('layouts.admin')

@section('content')
    <div class="space-y-6">

        <div class="bg-leaf rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
            <div class="absolute right-0 top-0 opacity-10 transform translate-x-10 -translate-y-10">
                <i data-lucide="sprout" class="w-48 h-48"></i>
            </div>
            <h1 class="text-2xl font-bold relative z-10">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-mint relative z-10 mt-1">Berikut adalah ringkasan aktivitas aplikasi CarePlate hari ini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate font-medium">Total Pengguna</p>
                    <h3 class="text-3xl font-extrabold text-charcoal mt-1">1,240</h3>
                </div>
                <div class="p-3 bg-mint/30 rounded-xl text-leaf">
                    <i data-lucide="users" class="w-8 h-8"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate font-medium">Artikel Terbit</p>
                    <h3 class="text-3xl font-extrabold text-charcoal mt-1">45</h3>
                </div>
                <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                    <i data-lucide="file-text" class="w-8 h-8"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate font-medium">Pengajuan Baru</p>
                    <h3 class="text-3xl font-extrabold text-charcoal mt-1">12</h3>
                </div>
                <div class="p-3 bg-orange-50 rounded-xl text-orange-600">
                    <i data-lucide="utensils" class="w-8 h-8"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate font-medium">Kunjungan Hari Ini</p>
                    <h3 class="text-3xl font-extrabold text-charcoal mt-1">3,402</h3>
                </div>
                <div class="p-3 bg-purple-50 rounded-xl text-purple-600">
                    <i data-lucide="bar-chart-3" class="w-8 h-8"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-charcoal">Pengguna Terbaru</h3>
                    <a href="#" class="text-sm text-leaf font-bold hover:underline">Lihat Semua</a>
                </div>
                <div class="space-y-4">
                    @foreach (range(1, 4) as $i)
                        <div class="flex items-center justify-between pb-3 border-b border-gray-50 last:border-0 last:pb-0">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-slate font-bold">
                                    {{ chr(64 + $i) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-charcoal">User Baru {{ $i }}</p>
                                    <p class="text-xs text-slate">user{{ $i }}@example.com</p>
                                </div>
                            </div>
                            <span class="text-xs text-slate">{{ $i }} jam lalu</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-charcoal">Artikel Populer</h3>
                    <a href="#" class="text-sm text-leaf font-bold hover:underline">Kelola Artikel</a>
                </div>
                <div class="space-y-4">
                    @foreach (range(1, 4) as $i)
                        <div class="flex items-start gap-3">
                            <div class="w-16 h-12 bg-gray-200 rounded-lg flex-shrink-0"></div>
                            <div>
                                <p class="text-sm font-bold text-charcoal line-clamp-1">Tips Diet Sehat Menjelang Puasa
                                    untuk Pemula</p>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-xs text-slate flex items-center gap-1"><i data-lucide="eye"
                                            class="w-3 h-3"></i> 1.2k</span>
                                    <span class="text-xs text-slate flex items-center gap-1"><i data-lucide="heart"
                                            class="w-3 h-3"></i> 45</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection
