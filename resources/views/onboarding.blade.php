@extends('layouts.app')
@section('content')
    <section id="home"
        class="relative overflow-hidden flex flex-col justify-center items-center bg-beige mt-5 md:-mt-10 pb-20  min-h-screen">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-10 items-center">
                <div class="text-center lg:text-left" data-aos="fade-right" data-aos-easing="ease-out-cubic"
                    data-aos-duration="1000" data-aos-once="true">
                    <span class="inline-block py-1 px-3 rounded-full bg-sunshine/30 text-yellow-700 text-sm font-bold mb-4">
                        ✨ Hidup Sehat Dimulai dari Piringmu
                    </span>
                    <h1 class="text-4xl lg:text-6xl font-extrabold text-charcoal leading-tight mb-6">
                        Pantau Gizi, <br>
                        <span class="text-leaf relative">
                            Jaga Diri.
                            <svg class="absolute w-full h-3 -bottom-1 left-0 text-mint -z-10" viewBox="0 0 100 10"
                                preserveAspectRatio="none">
                                <path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="8" fill="none" />
                            </svg>
                        </span>
                    </h1>
                    <p class="text-lg text-slate mb-8 leading-relaxed max-w-lg mx-auto lg:mx-0">
                        CarePlate membantu Anda melacak kalori, memantau BMI, dan merencanakan menu makan sehat untuk
                        keluarga tercinta.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}"
                            class="py-3 px-8 inline-flex justify-center items-center gap-x-2 text-base font-bold rounded-full border border-transparent bg-coral text-white hover:bg-orange-600 focus:outline-hidden focus:bg-orange-600 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Mulai Sekarang
                            <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </a>
                        <a href="#about"
                            class="py-3 px-8 inline-flex justify-center items-center gap-x-2 text-base font-semibold rounded-full border border-gray-200 bg-white text-charcoal hover:bg-gray-50 focus:outline-hidden transition-all shadow-sm">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>

                <div class="relative" data-aos="fade-left" data-aos-easing="ease-out-cubic" data-aos-duration="1000"
                    data-aos-once="true">
                    <div class="absolute top-0 right-0 -z-10 bg-mint rounded-full w-[400px] h-[400px] blur-3xl opacity-50">
                    </div>

                    <img class="rounded-3xl shadow-2xl border-4 border-white transform rotate-2 hover:rotate-0 transition-transform duration-500"
                        src="{{ asset('/images/hero.avif') }}" alt="Healthy Food">
                    <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-lg border border-gray-100 flex items-center gap-3 animate-bounce"
                        style="animation-duration: 4s;">
                        <div class="bg-fresh/20 p-2 rounded-full text-fresh">
                            <i data-lucide="check-circle" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate">Status Harian</p>
                            <p class="font-bold text-charcoal">Kalori Terpenuhi!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="py-40 bg-white">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 ">
            <div class="text-center max-w-2xl mx-auto mb-24" data-aos="fade-up" data-aos-easing="ease-out-cubic"
                data-aos-duration="1000" data-aos-once="true">
                <h2 class="text-4xl font-bold text-charcoal mb-4">Tentang <span class="text-leaf">CarePlate</span></h2>
                <p class="text-slate">
                    Kami percaya bahwa kesehatan bermula dari apa yang kita makan. CarePlate hadir sebagai asisten gizi
                    pribadi yang mudah digunakan untuk segala usia.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 text-center">
                <div class="p-6 bg-eggshell rounded-2xl hover:bg-mint/70 hover:-translate-y-2 transition-colors duration-300"
                    data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="800" data-aos-once="true">
                    <div
                        class="w-14 h-14 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-leaf">
                        <i data-lucide="heart-pulse" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold text-charcoal mb-2">Pantau Kesehatan</h3>
                    <p class="text-slate text-sm">Hitung BMI dan kebutuhan kalori harian secara otomatis dan akurat.</p>
                </div>

                <div class="p-6 bg-eggshell rounded-2xl hover:bg-mint/70 hover:-translate-y-2 transition-colors duration-300"
                    data-aos="flip-right" data-aos-easing="ease-out-cubic" data-aos-duration="800" data-aos-once="true">
                    <div
                        class="w-14 h-14 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-leaf">
                        <i data-lucide="utensils" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold text-charcoal mb-2">Pelacakan Makanan</h3>
                    <p class="text-slate text-sm">Catat sarapan, makan siang, dan malam dengan database makanan lengkap.
                    </p>
                </div>

                <div class="p-6 bg-eggshell rounded-2xl hover:bg-mint/70 hover:-translate-y-2 transition-colors duration-300"
                    data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="800" data-aos-once="true">
                    <div
                        class="w-14 h-14 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-leaf">
                        <i data-lucide="users" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold text-charcoal mb-2">Untuk Keluarga</h3>
                    <p class="text-slate text-sm">Kelola gizi seluruh anggota keluarga dalam satu akun yang
                        terintegrasi.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-40 bg-beige">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1" data-aos="fade-down" data-aos-easing="ease-out-cubic"
                    data-aos-duration="800" data-aos-once="true">
                    <img class="rounded-2xl shadow-xl" src="{{ asset('/images/sayur.jpg') }}" alt="Fitur Aplikasi">
                </div>
                <div class="order-1 lg:order-2" data-aos="fade-up" data-aos-easing="ease-out-cubic" data-aos-duration="800"
                    data-aos-once="true">
                    <span class="text-coral font-bold tracking-wider uppercase text-sm">Fitur Unggulan</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-charcoal mt-2 mb-6">
                        Kelola Gizi Harian Keluargamu
                    </h2>
                    <p class="text-slate mb-6">
                        CarePlate Hadir sebagai sarana untuk memonitoring gizi harian keluarga, dengan hadirnya CarePlate
                        diharapkan seluruh keluarga yang berada di Indonesia Bisa memenuhi kebutuhan kalori hariannya
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-charcoal">
                            <i data-lucide="check" class="text-fresh w-5 h-5"></i>
                            Buat Keluarga dan Tambahkan Anggota
                        </li>
                        <li class="flex items-center gap-3 text-charcoal">
                            <i data-lucide="check" class="text-fresh w-5 h-5"></i>
                            Lihat Konsumsi Kalori Harian Anggota Keluarga
                        </li>
                        <li class="flex items-center gap-3 text-charcoal">
                            <i data-lucide="check" class="text-fresh w-5 h-5"></i>
                            Laporan dan Rekomendasi
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="consultation" class="py-24 bg-leaf relative overflow-hidden">
        <div class="absolute inset-0 opacity-10"
            style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;"></div>

        <div class="max-w-4xl mx-auto px-4 relative z-10 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                Butuh Saran Gizi Profesional?
            </h2>
            <p class="text-mint text-lg mb-10 max-w-2xl mx-auto">
                Jangan ragu untuk berkonsultasi dengan ahli gizi kami. Dapatkan saran personal yang disesuaikan dengan
                kebutuhan tubuh Anda.
            </p>

            <a href="https://wa.me/6282145295436?text=Halo%20CarePlate,%20saya%20ingin%20konsultasi%20gizi"
                target="_blank"
                class="inline-flex items-center gap-3 bg-white text-leaf font-bold py-4 px-8 rounded-full shadow-lg hover:bg-gray-100 transition-all hover:scale-105">
                <i data-lucide="message-circle" class="w-6 h-6"></i>
                Chat Ahli Gizi via WhatsApp
            </a>
        </div>
    </section>
@endsection
