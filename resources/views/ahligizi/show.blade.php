@extends('layouts.app')

@section('content')
    <div class="bg-beige min-h-screen pt-20 ">


        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 ">
            <div class="mb-8">
                <a href="{{ url('/#consultation') }}"
                    class="inline-flex items-center gap-2 text-slate font-bold hover:text-leaf transition-colors">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden relative">

                <div class="absolute top-0 left-0 w-full h-48 bg-leaf "></div>
                <div class="absolute top-0 left-0 w-full h-48 opacity-10"
                    style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;"></div>

                <div class="relative z-10 px-8 pt-12 pb-8 md:px-12">

                    <div class="flex flex-col md:flex-row items-center md:items-end gap-8 -mt-6">
                        <div class="relative flex-shrink-0">
                            <div
                                class="w-40 h-40 md:w-48 md:h-48 rounded-full border-4 border-white shadow-lg overflow-hidden bg-white">
                                @php
                                    $path = 'storage/' . $ahliGizi->foto;
                                    $fileExists = file_exists(public_path($path));
                                    $avatarSrc =
                                        $ahliGizi->foto && $fileExists
                                            ? asset($path)
                                            : 'https://ui-avatars.com/api/?name=' .
                                                urlencode($ahliGizi->nama) .
                                                '&background=CFF4E1&color=2E9A62&size=256';
                                @endphp
                                <img src="{{ $avatarSrc }}" alt="{{ $ahliGizi->nama }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="absolute bottom-2 right-2 bg-blue-500 text-white p-1.5 rounded-full border-4 border-white shadow-sm"
                                title="Verified Expert">
                                <i data-lucide="check" class="w-5 h-5"></i>
                            </div>
                        </div>

                        <div class="text-center md:text-left flex-grow pb-4">
                            <h1 class="text-3xl md:text-4xl font-extrabold text-charcoal mb-2">
                                {{ $ahliGizi->nama }}
                            </h1>
                            <span
                                class="inline-block px-4 py-1.5 bg-leaf text-white text-sm font-bold rounded-full shadow-sm shadow-green-200">
                                {{ $ahliGizi->spesialis }}
                            </span>
                        </div>


                    </div>

                    <hr class="my-10 border-gray-100">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                        <div class="md:col-span-1 space-y-6">


                            <div class="bg-eggshell p-5 rounded-2xl">
                                <div class="flex items-center gap-3 text-leaf mb-2">
                                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                                    <h3 class="font-bold text-charcoal">Lokasi Praktik</h3>
                                </div>
                                <p class="text-sm text-slate leading-relaxed">
                                    {{ $ahliGizi->alamat }}
                                </p>
                            </div>

                            <div class="bg-eggshell p-5 rounded-2xl">
                                <div class="flex items-center gap-3 text-leaf mb-2">
                                    <i data-lucide="clock" class="w-5 h-5"></i>
                                    <h3 class="font-bold text-charcoal">Respon Chat</h3>
                                </div>
                                <p class="text-sm text-slate">± 1 Jam (Jam Kerja)</p>
                            </div>

                        </div>

                        <div class="md:col-span-2">
                            <h3 class="text-xl font-bold text-charcoal mb-4 flex items-center gap-2">
                                <i data-lucide="user" class="text-leaf w-6 h-6"></i> Tentang Ahli Gizi
                            </h3>
                            <div class="prose prose-slate max-w-none text-slate leading-relaxed">
                                <p>
                                    {{ $ahliGizi->deskripsi ?? 'Belum ada deskripsi yang ditambahkan.' }}
                                </p>

                            </div>

                            <div class="mt-8 p-6 bg-mint/20 rounded-2xl border border-mint/50">
                                <h4 class="font-bold text-leaf mb-2">Topik Konsultasi:</h4>
                                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-charcoal">
                                    <li class="flex items-center gap-2"><i data-lucide="check-circle"
                                            class="w-4 h-4 text-leaf"></i> Penurunan Berat Badan</li>
                                    <li class="flex items-center gap-2"><i data-lucide="check-circle"
                                            class="w-4 h-4 text-leaf"></i> Gizi Ibu & Anak</li>
                                    <li class="flex items-center gap-2"><i data-lucide="check-circle"
                                            class="w-4 h-4 text-leaf"></i> Program Diet Medis</li>
                                    <li class="flex items-center gap-2"><i data-lucide="check-circle"
                                            class="w-4 h-4 text-leaf"></i> Pola Makan Sehat</li>
                                </ul>
                            </div>
                        </div>

                    </div>

                    <div class="block mt-8">
                        <a href="https://wa.me/{{ $ahliGizi->nomor_hp }}?text=Halo%20{{ urlencode($ahliGizi->nama) }},%20saya%20pengguna%20CarePlate%20ingin%20konsultasi%20gizi."
                            target="_blank"
                            class="flex items-center justify-center gap-2 w-full py-4 bg-green-600 text-white font-bold rounded-xl shadow-lg hover:bg-green-700 transition-all">
                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                            Chat via WhatsApp
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
