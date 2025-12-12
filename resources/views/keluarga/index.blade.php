@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ showDeleteModal: false, showKickModal: false, selectedMember: null }">
    
    <!-- Header Section -->
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center p-3 bg-leaf/20 rounded-full text-leaf mb-4">
            <i data-lucide="users" class="w-8 h-8"></i>
        </div>
        <h1 class="text-3xl font-bold text-charcoal">{{ $keluarga->nama_keluarga }}</h1>
        <p class="text-slate mt-2">
            @if($isKepala)
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-yellow-100 to-orange-100 text-orange-700 rounded-full text-sm font-bold shadow-sm">
                    <i data-lucide="crown" class="w-4 h-4"></i>
                    Kamu adalah Kepala Keluarga
                </span>
            @else
                <span class="text-slate">Anggota Keluarga</span>
            @endif
        </p>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-wrap justify-center gap-3 mb-8">
        @if($isKepala)
            <a href="{{ route('keluarga.edit') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-leaf text-white rounded-xl font-bold shadow-lg shadow-leaf/30 hover:bg-green-700 hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                <i data-lucide="edit" class="w-4 h-4"></i>
                Edit Keluarga
            </a>
            <a href="{{ route('keluarga.invite') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-coral text-white rounded-xl font-bold shadow-lg shadow-coral/30 hover:bg-orange-600 hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                Undang Anggota
            </a>
            <button @click="showDeleteModal = true" 
                    class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 text-white rounded-xl font-bold shadow-lg shadow-red-600/30 hover:bg-red-700 hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
                Hapus Keluarga
            </button>
        @else
            <form action="{{ route('keluarga.leave') }}" method="POST">
                @csrf
                <button type="submit" 
                        class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 text-white rounded-xl font-bold shadow-lg shadow-red-600/30 hover:bg-red-700 hover:shadow-xl transition-all transform hover:-translate-y-0.5"
                        onclick="return confirm('Yakin ingin keluar dari keluarga?')">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    Keluar dari Keluarga
                </button>
            </form>
        @endif
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-leaf p-4 rounded-r-2xl shadow-sm animate-pulse-once">
            <div class="flex items-center gap-3">
                <div class="bg-leaf/20 p-2 rounded-lg">
                    <i data-lucide="check-circle" class="w-5 h-5 text-leaf"></i>
                </div>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 p-4 rounded-r-2xl shadow-sm animate-pulse-once">
            <div class="flex items-center gap-3">
                <div class="bg-red-500/20 p-2 rounded-lg">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-600"></i>
                </div>
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Member Count Card -->
    <div class="bg-charcoal text-white p-6 rounded-2xl shadow-lg flex items-center justify-between mb-6">
        <div>
            <h2 class="font-bold text-xl">Anggota Keluarga</h2>
            <p class="text-xs text-gray-400">Total {{ $anggota->count() }} orang tergabung</p>
        </div>
        <div class="bg-white/10 p-3 rounded-xl">
            <i data-lucide="users" class="w-8 h-8 text-white"></i>
        </div>
    </div>

    <!-- Members Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($anggota as $member)
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 hover:shadow-xl hover:border-leaf transition-all transform hover:-translate-y-1 group">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-4">
                        <!-- Avatar with gradient -->
                        <div class="relative">
                            <div class="w-16 h-16 rounded-full bg-leaf flex items-center justify-center text-charcoal font-bold text-2xl shadow-lg">
                                {{ substr($member->user->name, 0, 1) }}
                            </div>
                            @if($member->id == $keluarga->kepala_keluarga_id)
                                <div class="absolute -top-1 -right-1 bg-gradient-to-r from-yellow-400 to-orange-400 p-1.5 rounded-full shadow-md">
                                    <i data-lucide="crown" class="w-3 h-3 text-white"></i>
                                </div>
                            @endif
                        </div>

                        <div>
                            <h3 class="font-bold text-charcoal text-lg group-hover:text-leaf transition-colors">
                                {{ $member->user->name }}
                            </h3>
                            <p class="text-sm text-slate flex items-center gap-1">
                                <i data-lucide="mail" class="w-3 h-3"></i>
                                {{ $member->user->email }}
                            </p>
                            @if($member->id == $keluarga->keluarga_id)
                                <span class="inline-flex items-center gap-1 text-xs text-orange-600 font-bold mt-1 bg-orange-50 px-2 py-0.5 rounded-full">
                                    <i data-lucide="crown" class="w-3 h-3"></i>
                                    Kepala Keluarga
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($isKepala)
                        <button @click="showKickModal = true; selectedMember = {{ $member->id }}" 
                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors group/btn">
                            <i data-lucide="x-circle" class="w-5 h-5 group-hover/btn:scale-110 transition-transform"></i>
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal Hapus Keluarga -->
    <div x-show="showDeleteModal" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
         @click.self="showDeleteModal = false">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl transform"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100">
            
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center p-3 bg-red-100 rounded-full text-red-600 mb-4">
                    <i data-lucide="alert-triangle" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold text-charcoal mb-2">Hapus Keluarga?</h3>
                <p class="text-slate leading-relaxed">
                    Semua anggota akan dikeluarkan dan data keluarga akan dihapus permanen. Tindakan ini tidak bisa dibatalkan!
                </p>
            </div>

            <div class="flex gap-3">
                <button @click="showDeleteModal = false" 
                        class="flex-1 px-6 py-3 bg-gray-100 text-charcoal rounded-xl font-bold hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <form action="{{ route('keluarga.destroy') }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full px-6 py-3 bg-red-600 text-white rounded-xl font-bold shadow-lg shadow-red-600/30 hover:bg-red-700 transition-all">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Kick Member -->
    <div x-show="showKickModal" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
         @click.self="showKickModal = false">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl transform"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100">
            
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center p-3 bg-orange-100 rounded-full text-coral mb-4">
                    <i data-lucide="user-minus" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold text-charcoal mb-2">Keluarkan Anggota?</h3>
                <p class="text-slate leading-relaxed">
                    Anggota ini akan dikeluarkan dari keluarga dan kehilangan akses ke data keluarga.
                </p>
            </div>

            <div class="flex gap-3">
                <button @click="showKickModal = false" 
                        class="flex-1 px-6 py-3 bg-gray-100 text-charcoal rounded-xl font-bold hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <form :action="`/keluarga/kick/${selectedMember}`" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full px-6 py-3 bg-red-600 text-white rounded-xl font-bold shadow-lg shadow-red-600/30 hover:bg-red-700 transition-all">
                        Ya, Keluarkan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    
    @keyframes pulse-once {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }
    
    .animate-pulse-once {
        animation: pulse-once 0.5s ease-in-out;
    }
</style>
@endsection

