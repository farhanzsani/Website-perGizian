@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="flex items-center gap-3 mb-8">
            <a href="{{ route('admin.pelacakan-makanan.index') }}" 
               class="w-10 h-10 rounded-full bg-white border border-gray-100 flex items-center justify-center text-slate hover:text-leaf hover:border-leaf transition-all shadow-sm">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h1 class="text-xl font-bold text-charcoal">Catat Konsumsi Baru</h1>
                <p class="text-slate text-sm">Masukkan data konsumsi harian pengguna.</p>
            </div>
        </div>

        <form action="{{ route('admin.pelacakan-makanan.store') }}" method="POST"
            class="space-y-6"
            x-data="foodRepeater()"
            @submit.prevent="submitForm">
            @csrf

            <!-- Main Info Card -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Pengguna Select -->
                    <div>
                        <label class="block text-xs font-bold text-slate uppercase tracking-wider mb-2">Pengguna <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="hidden" name="pengguna_id" :value="userSelected">
                            
                            <button type="button" @click="userDropdownOpen = !userDropdownOpen" @click.outside="userDropdownOpen = false"
                                class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium text-charcoal bg-gray-50 border border-transparent rounded-xl focus:ring-2 focus:ring-leaf transition-all hover:bg-gray-100"
                                :class="{'!border-red-500 bg-red-50': errors.user, 'text-slate': !userSelected, 'text-charcoal': userSelected}">
                                <span x-text="userLabel"></span>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-slate transition-transform duration-200"
                                   :class="{'rotate-180': userDropdownOpen}"></i>
                            </button>
    
                            <div x-show="userDropdownOpen" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="absolute top-full left-0 mt-2 w-full bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden ring-1 ring-black ring-opacity-5 max-h-60 overflow-y-auto"
                                style="display: none;">
                                
                                <div class="p-2 space-y-1">
                                    @foreach ($users as $user)
                                        <button type="button" 
                                            @click="userSelected = '{{ $user->id }}'; userLabel = '{{ $user->user->name ?? 'Tanpa Nama' }}'; userDropdownOpen = false; errors.user = false;" 
                                            class="flex items-center gap-3 w-full px-3 py-2 text-sm text-left hover:bg-mint/10 rounded-lg transition-colors group">
                                            <div class="w-8 h-8 rounded-full bg-gray-100 group-hover:bg-white flex items-center justify-center text-slate group-hover:text-leaf font-bold text-xs shrink-0 transition-colors">
                                                {{ substr($user->user->name ?? '?', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-charcoal group-hover:text-leaf transition-colors">{{ $user->user->name ?? 'Tanpa Nama' }}</div>
                                                <div class="text-xs text-slate">{{ $user->user->email ?? '-' }}</div>
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <p x-show="errors.user" class="text-xs text-red-500 mt-1 font-bold" x-transition>Wajib pilih pengguna.</p>
                    </div>

                    <!-- Tanggal Input -->
                    <div>
                        <label class="block text-xs font-bold text-slate uppercase tracking-wider mb-2">Tanggal</label>
                        <div class="relative">
                            <input type="date" name="tanggal_konsumsi" value="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-3 text-sm font-medium text-charcoal bg-gray-50 border-0 rounded-xl focus:ring-2 focus:ring-leaf transition-all hover:bg-gray-100" required>
                            <i data-lucide="calendar" class="absolute right-4 top-3 w-4 h-4 text-slate pointer-events-none"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Food Items Section -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-charcoal">Menu Makanan</h3>
                        <p class="text-slate text-xs">Tambahkan detail makanan yang dikonsumsi.</p>
                    </div>
                    <div class="flex flex-col items-end">
                        <button type="button" @click="addItem()"
                            class="text-xs font-bold text-leaf bg-mint/20 hover:bg-mint/30 px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Item
                        </button>
                        <p x-show="errors.items" class="text-xs text-red-500 mt-1 font-bold" x-transition>Minimal pilih satu menu makanan.</p>
                    </div>
                </div>
    
                <div class="space-y-4">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="bg-gray-50 rounded-2xl border relative group transition-all"
                             :class="[
                                item.error ? 'border-red-300 bg-red-50' : 'border-gray-100 bg-gray-50',
                                item.dropdownOpen ? 'z-50' : 'z-0'
                             ]">
                            
                            <!-- Item Header -->
                            <div class="px-5 py-3 border-b border-gray-200/50 flex justify-between items-center bg-gray-100/50 rounded-t-2xl">
                                <span class="text-xs font-bold text-slate uppercase tracking-wider">Item <span x-text="index + 1"></span></span>
                                
                                <button type="button" @click="removeItem(index)" x-show="items.length > 1"
                                    class="text-xs font-bold text-red-500 hover:text-red-600 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1.5"
                                    title="Hapus Item">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    <span>Hapus</span>
                                </button>
                            </div>
    
                            <div class="p-5 grid grid-cols-1 md:grid-cols-12 gap-5 items-start">
                                <!-- Food Select -->
                                <div class="md:col-span-8">
                                    <label class="block text-xs font-bold text-slate uppercase tracking-wider mb-2">Pilih Makanan <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input type="hidden" :name="`items[${index}][makanan_id]`" :value="item.makanan_id">
                                        
                                        <button type="button" @click="item.dropdownOpen = !item.dropdownOpen" @click.outside="item.dropdownOpen = false"
                                            class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium text-charcoal bg-white border rounded-xl focus:outline-none focus:border-leaf focus:ring-1 focus:ring-leaf hover:border-gray-300 transition-colors shadow-sm"
                                            :class="item.error ? 'border-red-300' : 'border-gray-200'">
                                            <span x-text="item.makanan_name || 'Cari menu makanan...'" :class="item.makanan_id ? 'text-charcoal' : 'text-slate'"></span>
                                            <i data-lucide="search" class="w-4 h-4 text-slate"></i>
                                        </button>
    
                                        <div x-show="item.dropdownOpen" 
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 translate-y-2"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            class="absolute top-full left-0 mt-2 w-full bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden ring-1 ring-black ring-opacity-5 max-h-60 overflow-y-auto"
                                            style="display: none; z-index: 100;">
                                            
                                            <div class="p-2 space-y-1">
                                                @foreach ($makanan as $m)
                                                    <button type="button" 
                                                        @click="
                                                            item.makanan_id = '{{ $m->id }}'; 
                                                            item.makanan_name = '{{ $m->nama }}'; 
                                                            item.kalori_per_porsi = {{ $m->energi }}; 
                                                            item.error = false;
                                                            item.dropdownOpen = false;
                                                        " 
                                                        class="flex items-center justify-between w-full px-3 py-2.5 text-sm text-left hover:bg-mint/10 rounded-lg transition-colors group">
                                                        <div>
                                                            <div class="font-bold text-charcoal group-hover:text-leaf transition-colors">{{ $m->nama }}</div>
                                                            <div class="text-[10px] text-slate uppercase tracking-wider">{{ $m->kategori->kategori ?? 'Umum' }}</div>
                                                        </div>
                                                        <span class="text-xs font-bold text-leaf bg-mint/20 px-2 py-1 rounded-md">{{ $m->energi }} Kkal</span>
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <p x-show="item.error" class="text-xs text-red-500 mt-1" x-transition>Menu makanan wajib dipilih.</p>
                                </div>
    
                                <!-- Quantity Input -->
                                <div class="md:col-span-4">
                                    <label class="block text-xs font-bold text-slate uppercase tracking-wider mb-2">Jumlah Porsi</label>
                                    <div class="flex items-center">
                                        <input type="number" :name="`items[${index}][kuantitas]`" x-model="item.kuantitas" step="0.1" min="0.1"
                                            class="w-full px-4 py-3 text-sm font-bold text-center text-charcoal bg-white border border-gray-200 rounded-l-xl focus:border-leaf focus:ring-1 focus:ring-leaf hover:border-gray-300 transition-colors shadow-sm" required placeholder="1">
                                        <div class="px-4 py-3 bg-gray-100 border border-gray-200 border-l-0 rounded-r-xl text-xs font-bold text-slate uppercase tracking-wider">
                                            Porsi
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <!-- Subtotal -->
                            <div class="px-5 pb-5 pt-0 flex justify-end items-center gap-2" x-show="item.makanan_id">
                                <span class="text-xs text-slate uppercase tracking-wider font-bold">Subtotal:</span>
                                <div class="text-sm font-black text-charcoal">
                                    <span x-text="(item.kalori_per_porsi * item.kuantitas).toFixed(1)">0</span> Kkal
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Footer Action (Static) -->
            <div class="bg-white p-4 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div class="px-4">
                    <div class="text-[10px] font-bold text-slate uppercase tracking-wider mb-0.5">Total Kalori</div>
                    <div class="text-2xl font-black text-leaf drop-shadow-sm leading-none" x-text="calculateTotalCalories()">0 Kkal</div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.pelacakan-makanan.index') }}"
                        class="px-6 py-3 rounded-xl text-sm font-bold text-slate hover:bg-gray-50 transition-colors">Batal</a>
                    <button type="submit"
                        class="px-8 py-3 rounded-xl text-sm font-bold text-white bg-leaf hover:bg-green-700 shadow-lg shadow-green-100 transition-all hover:-translate-y-0.5 active:translate-y-0">
                        Simpan Data
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
             // Re-initialize lucide icons when new elements are added
        });

        function foodRepeater() {
            return {
                userSelected: '',
                userLabel: 'Pilih Pengguna...',
                userDropdownOpen: false,

                items: [{ 
                    makanan_id: '', 
                    makanan_name: '', 
                    kuantitas: 1, 
                    kalori_per_porsi: 0,
                    error: false,
                    dropdownOpen: false
                }],

                errors: {
                    user: false,
                    items: false
                },
                
                addItem() {
                    this.items.push({ 
                        makanan_id: '', 
                        makanan_name: '', 
                        kuantitas: 1, 
                        kalori_per_porsi: 0,
                        error: false,
                        dropdownOpen: false
                    });
                },
                
                removeItem(index) {
                    this.items.splice(index, 1);
                },

                calculateTotalCalories() {
                    let total = 0;
                    this.items.forEach(item => {
                        total += (item.kalori_per_porsi * item.kuantitas);
                    });
                    return total.toFixed(1) + ' Kkal';
                },

                submitForm(e) {
                    // Reset errors
                    this.errors.user = !this.userSelected;
                    this.errors.items = false;
                    let hasItemError = false;

                    this.items.forEach(item => {
                        if (!item.makanan_id) {
                            item.error = true;
                            hasItemError = true;
                        } else {
                            item.error = false;
                        }
                    });

                    if (this.errors.user || hasItemError) {
                        return;
                    }

                    // If valid, submit
                    e.target.submit();
                }
            }
        }
    </script>
@endsection
