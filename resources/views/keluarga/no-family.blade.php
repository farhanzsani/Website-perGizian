@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-eggshell py-12 flex items-center justify-center">
        <div class="max-w-4xl w-full px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden relative">

                <div class="absolute top-0 left-0 w-full h-3 bg-gradient-to-r from-leaf to-mint"></div>
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-leaf/5 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-mint/10 rounded-full blur-3xl pointer-events-none">
                </div>

                <div class="p-8 md:p-12 relative z-10 text-center">

                    <div
                        class="inline-flex items-center justify-center w-24 h-24 bg-eggshell rounded-full mb-6 animate-bounce-slight">
                        <div class="bg-white p-4 rounded-full shadow-sm">
                            <i data-lucide="users" class="w-10 h-10 text-leaf"></i>
                        </div>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-black text-charcoal mb-4">
                        Kamu Belum Tergabung dalam Keluarga
                    </h1>

                    <p class="text-slate text-lg max-w-2xl mx-auto mb-10 leading-relaxed">
                        Fitur Keluarga memungkinkan kamu memantau asupan gizi anggota keluarga tercinta.
                        Silakan pilih salah satu opsi di bawah ini untuk memulai.
                    </p>

                    @if (session('success'))
                        <div
                            class="mb-8 max-w-lg mx-auto bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2 text-sm text-left">
                            <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div
                            class="mb-8 max-w-lg mx-auto bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-2 text-sm text-left">
                            <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl mx-auto">

                        <div
                            class="group bg-white border-2 border-gray-100 hover:border-leaf p-6 rounded-3xl transition-all duration-300 hover:shadow-lg hover:-translate-y-1 flex flex-col items-center">
                            <div
                                class="w-14 h-14 bg-leaf/10 text-leaf rounded-2xl flex items-center justify-center mb-4 group-hover:bg-leaf group-hover:text-white transition-colors">
                                <i data-lucide="home" class="w-7 h-7"></i>
                            </div>
                            <h3 class="text-xl font-bold text-charcoal mb-2">Buat Keluarga Baru</h3>
                            <p class="text-sm text-slate mb-6 flex-grow">
                                Cocok jika kamu adalah kepala keluarga. Kamu akan mendapatkan Kode Invite untuk mengundang
                                anggota lain.
                            </p>
                            <a href="{{ route('keluarga.create') }}"
                                class="w-full py-3 bg-leaf text-white font-bold rounded-xl hover:bg-green-700 transition-colors shadow-md">
                                Buat Sekarang
                            </a>
                        </div>

                        <div
                            class="group bg-white border-2 border-gray-100 hover:border-coral p-6 rounded-3xl transition-all duration-300 hover:shadow-lg hover:-translate-y-1 flex flex-col items-center">
                            <div
                                class="w-14 h-14 bg-coral/10 text-coral rounded-2xl flex items-center justify-center mb-4 group-hover:bg-coral group-hover:text-white transition-colors">
                                <i data-lucide="user-plus" class="w-7 h-7"></i>
                            </div>
                            <h3 class="text-xl font-bold text-charcoal mb-2">Gabung Keluarga</h3>
                            <p class="text-sm text-slate mb-6 flex-grow">
                                Pilih ini jika kamu sudah menerima 6 digit <strong>Kode Unik</strong> dari kepala
                                keluargamu.
                            </p>
                            <a href="{{ route('keluarga.join.form') }}"
                                class="w-full py-3 bg-white border-2 border-coral text-coral font-bold rounded-xl hover:bg-coral hover:text-white transition-colors">
                                Masukkan Kode
                            </a>
                        </div>

                    </div>

                </div>
            </div>

            <p class="text-center text-slate/50 text-sm mt-8">
                &copy; {{ date('Y') }} CarePlate Family Monitor
            </p>

        </div>
    </div>
@endsection
