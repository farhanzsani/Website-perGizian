@extends('layouts.admin')

@section('content')
    <div class="space-y-8">

        <div class="bg-gradient-to-r from-leaf to-emerald-600 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden">
            <div class="absolute right-0 top-0 opacity-10 transform translate-x-10 -translate-y-10">
                <i data-lucide="sprout" class="w-64 h-64"></i>
            </div>
            <div class="relative z-10 max-w-2xl">
                <h1 class="text-3xl font-black mb-2">Halo, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-emerald-100 text-lg leading-relaxed">
                    Selamat datang kembali di panel admin CarePlate. Ada <span
                        class="font-bold text-white underline decoration-wavy">{{ $pengajuanPending }} pengajuan
                        makanan</span> yang menunggu persetujuan Anda hari ini.
                </p>
                <div class="mt-6 flex gap-3">
                    <a href="{{ route('admin.pengajuan.index') }}"
                        class="px-5 py-2.5 bg-white text-leaf font-bold rounded-xl shadow-lg hover:bg-gray-50 transition-all">
                        Cek Pengajuan
                    </a>
                    <a href="{{ route('admin.artikel.create') }}"
                        class="px-5 py-2.5 bg-emerald-700 text-white font-bold rounded-xl hover:bg-emerald-800 transition-all border border-emerald-600">
                        Tulis Artikel
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="p-3 bg-blue-50 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </div>
                    @if ($newUserThisMonth > 0)
                        <span
                            class="inline-flex items-center gap-1 bg-green-50 text-green-700 px-2 py-1 rounded-lg text-xs font-bold">
                            <i data-lucide="trending-up" class="w-3 h-3"></i> +{{ $newUserThisMonth }}
                        </span>
                    @endif
                </div>
                <p class="text-slate text-sm font-medium">Total Pengguna</p>
                <h3 class="text-3xl font-black text-charcoal mt-1">{{ number_format($totalUser) }}</h3>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="p-3 bg-purple-50 text-purple-600 rounded-xl group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        <i data-lucide="file-text" class="w-6 h-6"></i>
                    </div>
                    <span class="bg-purple-50 text-purple-700 px-2 py-1 rounded-lg text-xs font-bold">
                        {{ $artikelBaru }} Baru
                    </span>
                </div>
                <p class="text-slate text-sm font-medium">Artikel Terbit</p>
                <h3 class="text-3xl font-black text-charcoal mt-1">{{ number_format($totalArtikel) }}</h3>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="p-3 bg-orange-50 text-orange-600 rounded-xl group-hover:bg-orange-600 group-hover:text-white transition-colors">
                        <i data-lucide="utensils" class="w-6 h-6"></i>
                    </div>
                </div>
                <p class="text-slate text-sm font-medium">Database Makanan</p>
                <h3 class="text-3xl font-black text-charcoal mt-1">{{ number_format($totalMakanan) }}</h3>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="p-3 bg-teal-50 text-teal-600 rounded-xl group-hover:bg-teal-600 group-hover:text-white transition-colors">
                        <i data-lucide="home" class="w-6 h-6"></i>
                    </div>
                </div>
                <p class="text-slate text-sm font-medium">Grup Keluarga</p>
                <h3 class="text-3xl font-black text-charcoal mt-1">{{ number_format($totalKeluarga) }}</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-charcoal">Statistik Pendaftaran</h3>
                        <p class="text-sm text-slate">Tren pengguna baru 7 hari terakhir</p>
                    </div>
                    <div class="p-2 bg-gray-50 rounded-lg">
                        <i data-lucide="bar-chart-2" class="w-5 h-5 text-slate"></i>
                    </div>
                </div>

                <div id="userChart" style="height: 300px;"></div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-charcoal">Artikel Terbaru</h3>
                    <a href="{{ route('admin.artikel.index') }}"
                        class="text-xs font-bold text-leaf bg-leaf/10 px-3 py-1.5 rounded-lg hover:bg-leaf hover:text-white transition-colors">
                        Kelola
                    </a>
                </div>

                <div class="space-y-5 flex-grow">
                    @forelse($popularArtikel as $artikel)
                        <div class="group flex gap-4 items-start">
                            <div
                                class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-slate font-bold text-xs flex-shrink-0 group-hover:bg-leaf group-hover:text-white transition-colors">
                                #{{ $loop->iteration }}
                            </div>
                            <div>
                                <a href="#"
                                    class="text-sm font-bold text-charcoal line-clamp-2 hover:text-leaf transition-colors">
                                    {{ $artikel->judul }}
                                </a>
                                <div class="flex items-center gap-3 mt-1 text-xs text-slate">
                                    <span class="flex items-center gap-1"><i data-lucide="eye" class="w-3 h-3"></i>
                                        {{ $artikel->views_count ?? 0 }}</span>
                                    <span class="flex items-center gap-1"><i data-lucide="calendar" class="w-3 h-3"></i>
                                        {{ $artikel->created_at->format('d M') }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 text-slate text-sm">Belum ada artikel populer.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-charcoal">Pengguna Terbaru</h3>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-slate hover:text-leaf font-medium flex items-center gap-1">
                    Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-slate uppercase font-bold text-xs">
                        <tr>
                            <th class="px-6 py-4">Nama User</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($latestUsers as $user)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gradient-to-br from-leaf to-emerald-600 text-white flex items-center justify-center font-bold text-xs">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <span class="font-bold text-charcoal">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1 bg-green-50 text-green-700 px-2 py-1 rounded-full text-xs font-bold border border-green-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-slate font-mono text-xs">
                                    {{ $user->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate">Belum ada user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var options = {
                series: [{
                    name: 'User Baru',
                    data: @json($chartData)
                }],
                chart: {
                    type: 'area',
                    height: 300,
                    toolbar: {
                        show: false
                    },
                    fontFamily: 'inherit'
                },
                colors: ['#10B981'], // Warna Leaf/Emerald
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.1, // Efek fade ke bawah
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                xaxis: {
                    categories: @json($chartLabels), // Label Tanggal
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    show: false
                },
                grid: {
                    borderColor: '#f3f4f6',
                    strokeDashArray: 4,
                },
                tooltip: {
                    theme: 'light',
                    y: {
                        formatter: function(val) {
                            return val + " User"
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#userChart"), options);
            chart.render();
        });
    </script>
@endsection
