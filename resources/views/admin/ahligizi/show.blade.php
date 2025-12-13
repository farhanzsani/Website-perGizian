@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8" x-data="{ deleteModalOpen: false }">

        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.ahligizi.index') }}"
                    class="group p-2.5 bg-white border border-gray-200 rounded-xl hover:border-leaf hover:bg-mint/10 transition-all shadow-sm">
                    <i data-lucide="arrow-left" class="w-5 h-5 text-slate group-hover:text-leaf transition-colors"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-charcoal tracking-tight">Detail Profil</h1>
                    <p class="text-sm text-slate font-medium">Informasi lengkap ahli gizi</p>
                </div>
            </div>

            <a href="{{ route('admin.ahligizi.edit', $ahligizi->id) }}"
                class="flex items-center gap-2 px-5 py-2.5 bg-orange-50 text-orange-600 font-bold rounded-xl hover:bg-orange-100 border border-orange-100 transition-colors shadow-sm">
                <i data-lucide="edit-3" class="w-4 h-4"></i>
                <span>Edit Profil</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Left Column: Profile Card -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Main Profile Card -->
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col items-center text-center relative overflow-hidden">
                    <div class="absolute top-0 inset-x-0 h-24 bg-gradient-to-b from-mint/20 to-transparent pointer-events-none"></div>

                    <!-- Avatar -->
                    <div class="relative w-48 h-48 mb-6 group">
                        <div class="absolute inset-0 bg-leaf rounded-full blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                        <img src="{{ asset('storage/' . $ahligizi->foto) }}" alt="{{ $ahligizi->nama }}"
                            class="relative w-full h-full object-cover rounded-full border-[6px] border-white shadow-2xl shadow-green-100">
                        
                        <!-- Status Badge -->
                        <div class="absolute bottom-4 right-4 bg-green-500 w-7 h-7 rounded-full border-4 border-white shadow-sm"
                             title="Aktif"
                             x-tooltip="'Status: Aktif'"></div>
                    </div>

                    <h2 class="text-2xl font-black text-charcoal mb-2">{{ $ahligizi->nama }}</h2>
                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-mint/20 text-leaf text-sm font-bold rounded-full mb-8">
                        <i data-lucide="award" class="w-4 h-4"></i>
                        {{ $ahligizi->spesialis }}
                    </span>

                    <!-- Contact Actions -->
                    <div class="w-full space-y-3">
                        <a href="https://wa.me/{{ $ahligizi->nomor_hp }}" target="_blank"
                            class="flex items-center justify-center gap-2.5 w-full py-3.5 bg-leaf text-white rounded-2xl font-bold hover:bg-green-700 hover:shadow-lg hover:shadow-green-200 hover:-translate-y-0.5 transition-all">
                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                            Chat WhatsApp
                        </a>
                        <div class="flex items-center justify-center gap-2 py-2 text-slate font-semibold text-sm bg-gray-50 rounded-xl border border-gray-100">
                            <i data-lucide="phone" class="w-4 h-4 text-slate"></i>
                            {{ $ahligizi->nomor_hp }}
                        </div>
                    </div>
                </div>

                <!-- Meta Info Card -->
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate font-medium">Ditambahkan:</span>
                        <span class="font-bold text-charcoal bg-gray-50 px-3 py-1 rounded-lg">{{ $ahligizi->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate font-medium">Update Terakhir:</span>
                        <span class="font-bold text-charcoal bg-gray-50 px-3 py-1 rounded-lg">{{ $ahligizi->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: Details & Delete -->
            <div class="lg:col-span-8 space-y-8">
                
                <!-- Personal Information -->
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 h-full relative">
                    
                    <div class="flex items-center gap-3 mb-8">
                        <div class="p-3 bg-mint/20 rounded-2xl text-leaf">
                            <i data-lucide="user-square" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-charcoal">Informasi Pribadi</h3>
                            <p class="text-xs text-slate font-medium">Detail data diri ahli gizi</p>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div>
                            <label class="block text-xs font-bold text-slate uppercase tracking-wider mb-3">Tentang / Deskripsi</label>
                            <div class="p-6 bg-eggshell rounded-2xl border border-gray-100 text-charcoal leading-relaxed text-sm">
                                {{ $ahligizi->deskripsi ?? 'Belum ada deskripsi yang ditambahkan untuk ahli gizi ini.' }}
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Birth Date -->
                            <div class="group p-5 rounded-2xl border border-gray-100 bg-gray-50/50 hover:bg-white hover:shadow-md hover:border-gray-200 transition-all">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="p-2 bg-pink-100 rounded-lg text-pink-500">
                                        <i data-lucide="cake" class="w-4 h-4"></i>
                                    </div>
                                    <label class="text-xs font-bold text-slate uppercase tracking-wider">Tanggal Lahir</label>
                                </div>
                                <div>
                                    <p class="text-lg font-black text-charcoal">
                                        {{ \Carbon\Carbon::parse($ahligizi->tanggal_lahir)->translatedFormat('d F Y') }}
                                    </p>
                                    <p class="text-sm font-medium text-slate">
                                        {{ \Carbon\Carbon::parse($ahligizi->tanggal_lahir)->age }} Tahun
                                    </p>
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="group p-5 rounded-2xl border border-gray-100 bg-gray-50/50 hover:bg-white hover:shadow-md hover:border-gray-200 transition-all">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="p-2 bg-blue-100 rounded-lg text-blue-500">
                                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                                    </div>
                                    <label class="text-xs font-bold text-slate uppercase tracking-wider">Lokasi Praktik</label>
                                </div>
                                <p class="text-lg font-bold text-charcoal leading-snug">
                                    {{ $ahligizi->alamat }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Trigger -->
                    <div class="mt-12 pt-8 border-t border-gray-100 flex justify-end">
                        <button type="button" @click="deleteModalOpen = true"
                            class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-red-500 bg-red-50 hover:bg-red-100 hover:text-red-700 rounded-xl transition-all">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                            <span>Hapus Ahli Gizi</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Custom Delete Modal -->
        <template x-teleport="body">
            <div x-show="deleteModalOpen" class="fixed inset-0 z-[9999] flex items-center justify-center px-4" style="display: none;">
                <!-- Backdrop -->
                <div x-show="deleteModalOpen" 
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0" 
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200" 
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" 
                    @click="deleteModalOpen = false"
                    class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
    
                <!-- Modal Content -->
                <div x-show="deleteModalOpen" 
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4" 
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="ease-in duration-200" 
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                    class="bg-white rounded-3xl p-8 max-w-md w-full relative z-10 shadow-2xl border border-gray-100">
                    
                    <div class="text-center">
                        <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
                            </div>
                        </div>
                        
                        <h3 class="text-2xl font-black text-charcoal mb-2">Hapus Ahli Gizi?</h3>
                        <p class="text-slate mb-8 leading-relaxed">
                            Anda akan menghapus data <span class="font-bold text-charcoal">{{ $ahligizi->nama }}</span>.
                            Tindakan ini tidak dapat dibatalkan.
                        </p>
    
                        <div class="flex gap-3 justify-center">
                            <button type="button" @click="deleteModalOpen = false"
                                class="px-6 py-3 rounded-xl font-bold text-slate hover:bg-gray-50 border border-transparent hover:border-gray-200 transition-all">
                                Batal
                            </button>
                            <form action="{{ route('admin.ahligizi.destroy', $ahligizi->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-6 py-3 rounded-xl font-bold text-white bg-red-500 hover:bg-red-600 shadow-lg shadow-red-200 hover:-translate-y-0.5 transition-all">
                                    Ya, Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </template>

    </div>
@endsection
