@extends('layouts.app')

@section('content')
    <div class="bg-beige min-h-screen pt-24 pb-24">

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-8">
                <a href="{{ url('/#consultation') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-sm rounded-xl text-slate font-bold hover:text-leaf hover:bg-white transition-all shadow-sm">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i> Kembali ke Daftar
                </a>
            </div>

            <!-- Main Card -->
            <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden relative">

                <!-- Decorative Header -->
                <div class="absolute top-0 left-0 w-full h-52 bg-gradient-to-r from-leaf to-emerald-600"></div>
                <div class="absolute top-0 left-0 w-full h-52 opacity-20"
                    style="background-image: radial-gradient(#fff 2px, transparent 2px); background-size: 24px 24px;"></div>

                <!-- Wave Decoration (Optional, nice to have) -->
                <svg class="absolute top-40 left-0 w-full text-white" viewBox="0 0 1440 120" fill="currentColor">
                    <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                </svg>

                <div class="relative z-10 px-8 md:px-12 pt-16 pb-12">

                    <div class="flex flex-col md:flex-row items-center md:items-end gap-8 -mt-8">
                        <!-- Avatar -->
                        <div class="relative flex-shrink-0">
                            <div class="w-40 h-40 md:w-48 md:h-48 rounded-full border-[6px] border-white shadow-xl overflow-hidden bg-white group">
                                @php
                                    $path = 'storage/' . $ahliGizi->foto;
                                    $fileExists = file_exists(public_path($path));
                                    $avatarSrc = $ahliGizi->foto && $fileExists
                                            ? asset($path)
                                            : 'https://ui-avatars.com/api/?name=' . urlencode($ahliGizi->nama) . '&background=CFF4E1&color=2E9A62&size=256';
                                @endphp
                                <img src="{{ $avatarSrc }}" alt="{{ $ahliGizi->nama }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                            
                            <!-- Checkmark Badge -->
                            <div class="absolute bottom-3 right-3 bg-blue-500 text-white p-1.5 rounded-full border-4 border-white shadow-md transform hover:scale-110 transition-transform"
                                title="Terverifikasi" x-tooltip="'Terverifikasi'">
                                <i data-lucide="check" class="w-5 h-5"></i>
                            </div>
                        </div>

                        <!-- Name & Badge -->
                        <div class="text-center md:text-left flex-grow pb-6">
                            <h1 class="text-3xl md:text-5xl font-black text-charcoal mb-3 tracking-tight">
                                {{ $ahliGizi->nama }}
                            </h1>
                            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-mint/20 text-leaf text-sm font-bold rounded-full border border-mint/20">
                                <i data-lucide="award" class="w-4 h-4"></i>
                                {{ $ahliGizi->spesialis }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-10 grid grid-cols-1 md:grid-cols-12 gap-10">

                        <!-- Left Info Column -->
                        <div class="md:col-span-4 space-y-6">
                            <div class="bg-eggshell/50 p-6 rounded-3xl border border-gray-100 hover:border-leaf/30 transition-colors group">
                                <div class="flex items-center gap-3 text-leaf mb-3">
                                    <div class="p-2 bg-white rounded-xl shadow-sm group-hover:bg-leaf group-hover:text-white transition-colors">
                                        <i data-lucide="map-pin" class="w-5 h-5"></i>
                                    </div>
                                    <h3 class="font-bold text-charcoal">Lokasi Praktik</h3>
                                </div>
                                <p class="text-slate leading-relaxed font-medium pl-14">
                                    {{ $ahliGizi->alamat }}
                                </p>
                            </div>

                            <div class="bg-eggshell/50 p-6 rounded-3xl border border-gray-100 hover:border-leaf/30 transition-colors group">
                                <div class="flex items-center gap-3 text-leaf mb-3">
                                    <div class="p-2 bg-white rounded-xl shadow-sm group-hover:bg-leaf group-hover:text-white transition-colors">
                                        <i data-lucide="clock" class="w-5 h-5"></i>
                                    </div>
                                    <h3 class="font-bold text-charcoal">Respon Chat</h3>
                                </div>
                                <p class="text-slate font-medium pl-14">± 1 Jam (Jam Kerja)</p>
                            </div>
                        </div>

                        <!-- Right Details Column -->
                        <div class="md:col-span-8 space-y-8">
                            
                            <!-- About -->
                            <div>
                                <h3 class="text-xl font-bold text-charcoal mb-4 flex items-center gap-2">
                                    <i data-lucide="user-square" class="text-leaf w-6 h-6"></i> 
                                    Tentang Ahli Gizi
                                </h3>
                                <div class="prose prose-slate max-w-none text-slate leading-relaxed bg-white p-6 rounded-3xl border border-gray-100">
                                    <p class="mb-0">
                                        {{ $ahliGizi->deskripsi ?? 'Belum ada deskripsi yang ditambahkan oleh ahli gizi ini.' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Topics -->
                            <div class="p-8 bg-gradient-to-br from-mint/10 to-transparent rounded-[2rem] border border-mint/20">
                                <h4 class="font-bold text-leaf mb-4 flex items-center gap-2">
                                    <i data-lucide="sparkles" class="w-5 h-5"></i>
                                    Topik Konsultasi:
                                </h4>
                                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-6">
                                    <li class="flex items-center gap-3 text-charcoal font-medium">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-leaf flex-shrink-0"></i> 
                                        Penurunan Berat Badan
                                    </li>
                                    <li class="flex items-center gap-3 text-charcoal font-medium">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-leaf flex-shrink-0"></i> 
                                        Gizi Ibu & Anak
                                    </li>
                                    <li class="flex items-center gap-3 text-charcoal font-medium">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-leaf flex-shrink-0"></i> 
                                        Program Diet Medis
                                    </li>
                                    <li class="flex items-center gap-3 text-charcoal font-medium">
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-leaf flex-shrink-0"></i> 
                                        Pola Makan Sehat
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>

                    <!-- Action Button -->
                    <div class="mt-12">
                        <a href="https://wa.me/{{ $ahliGizi->nomor_hp }}?text=Halo%20{{ urlencode($ahliGizi->nama) }},%20saya%20pengguna%20CarePlate%20ingin%20konsultasi%20gizi."
                            target="_blank"
                            class="group relative w-full flex items-center justify-center gap-3 py-5 bg-leaf text-white font-bold text-lg rounded-2xl shadow-xl shadow-green-200 hover:shadow-2xl hover:bg-green-700 hover:-translate-y-1 transition-all overflow-hidden">
                            <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                            <i data-lucide="message-circle" class="w-6 h-6 relative z-10"></i>
                            <span class="relative z-10">Chat via WhatsApp</span>
                        </a>
                        <p class="text-center text-xs text-slate mt-4">
                            *Anda akan diarahkan ke aplikasi WhatsApp untuk memulai chat.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
