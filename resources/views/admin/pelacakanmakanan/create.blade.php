@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center gap-2 text-slate mb-4">
            <a href="{{ route('admin.pelacakan-makanan.index') }}" class="hover:text-leaf transition-colors"><i
                    data-lucide="arrow-left" class="w-5 h-5"></i></a>
            <h1 class="text-xl font-bold text-charcoal">Catat Konsumsi Makanan</h1>
        </div>

        <form action="{{ route('admin.pelacakan-makanan.store') }}" method="POST"
            class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100"
            x-data="foodRepeater()">
            @csrf

            <!-- Header Section: User & Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-bold text-charcoal mb-1">Pengguna</label>
                    <div class="relative" x-data="{ 
                        open: false, 
                        selected: '', 
                        label: 'Pilih Pengguna'
                    }">
                        <input type="hidden" name="pengguna_id" :value="selected">
                        
                        <button type="button" @click="open = !open" @click.outside="open = false"
                            class="w-full flex items-center justify-between px-4 py-3 text-sm text-charcoal border border-gray-200 rounded-xl focus:outline-none focus:border-leaf focus:ring-1 focus:ring-leaf bg-white"
                            :class="open ? 'border-leaf ring-1 ring-leaf' : ''">
                            <span x-text="label" :class="selected ? 'text-charcoal' : 'text-gray-500'"></span>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate transition-transform duration-200"
                               :class="{'rotate-180': open}"></i>
                        </button>

                        <div x-show="open" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="absolute top-full left-0 mt-2 w-full bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden ring-1 ring-black ring-opacity-5 max-h-60 overflow-y-auto"
                            style="display: none;">
                            
                            @foreach ($users as $user)
                                <button type="button" 
                                    @click="selected = '{{ $user->id }}'; label = '{{ $user->user->name ?? 'Tanpa Nama' }}'; open = false" 
                                    class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-left hover:bg-mint/30 transition-colors text-slate">
                                    <div class="w-8 h-8 rounded-full bg-mint/30 flex items-center justify-center text-leaf font-bold text-xs shrink-0">
                                        {{ substr($user->user->name ?? '?', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-charcoal">{{ $user->user->name ?? 'Tanpa Nama' }}</div>
                                        <div class="text-xs text-slate">{{ $user->user->email ?? '-' }}</div>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-charcoal mb-1">Tanggal Konsumsi</label>
                    <input type="date" name="tanggal_konsumsi" value="{{ date('Y-m-d') }}"
                        class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf" required>
                </div>
            </div>

            <hr class="border-gray-100 mb-6">

            <!-- Repeater Section -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-charcoal">Daftar Makanan</h3>
                    <button type="button" @click="addItem()"
                        class="text-sm font-bold text-leaf hover:bg-mint/20 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Item
                    </button>
                </div>

                <template x-for="(item, index) in items" :key="index">
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 relative group transition-all hover:bg-white hover:shadow-sm" style="z-index: 1;">
                        
                        <!-- Remove Button -->
                        <button type="button" @click="removeItem(index)" x-show="items.length > 1"
                            class="absolute top-2 right-2 text-slate hover:text-tomato p-1 rounded-full hover:bg-red-50 transition-colors">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                            <!-- Food Select (Custom Dropdown) -->
                            <div class="md:col-span-8">
                                <label class="block text-xs font-bold text-slate mb-1">Menu Makanan</label>
                                
                                <div class="relative" x-data="{ open: false }">
                                    <input type="hidden" :name="`items[${index}][makanan_id]`" :value="item.makanan_id">
                                    
                                    <button type="button" @click="open = !open" @click.outside="open = false"
                                        class="w-full flex items-center justify-between px-4 py-2.5 text-sm text-charcoal border border-gray-200 rounded-lg focus:outline-none focus:border-leaf focus:ring-1 focus:ring-leaf bg-white"
                                        :class="open ? 'border-leaf ring-1 ring-leaf' : ''">
                                        <span x-text="item.makanan_name || 'Pilih Makanan...'" :class="item.makanan_id ? 'text-charcoal' : 'text-gray-500'"></span>
                                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate transition-transform duration-200"
                                           :class="{'rotate-180': open}"></i>
                                    </button>

                                    <div x-show="open" 
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 translate-y-2"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        class="absolute top-full left-0 mt-2 w-full bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden ring-1 ring-black ring-opacity-5 max-h-60 overflow-y-auto"
                                        style="display: none; z-index: 100;">
                                        
                                        @foreach ($makanan as $m)
                                            <button type="button" 
                                                @click="
                                                    item.makanan_id = '{{ $m->id }}'; 
                                                    item.makanan_name = '{{ $m->nama }}'; 
                                                    item.kalori_per_porsi = {{ $m->energi }}; 
                                                    open = false;
                                                " 
                                                class="flex items-center justify-between w-full px-4 py-2.5 text-sm text-left hover:bg-mint/30 transition-colors text-slate">
                                                <span>{{ $m->nama }}</span>
                                                <span class="text-xs font-bold text-leaf bg-mint/20 px-2 py-0.5 rounded-full">{{ $m->energi }} Kkal</span>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Quantity Input -->
                            <div class="md:col-span-4">
                                <label class="block text-xs font-bold text-slate mb-1">Jumlah Porsi</label>
                                <div class="flex items-center gap-2">
                                    <input type="number" :name="`items[${index}][kuantitas]`" x-model="item.kuantitas" step="0.1" min="0.1"
                                        class="w-full rounded-lg border-gray-200 text-sm focus:border-leaf focus:ring-leaf" required>
                                    <span class="text-xs text-slate whitespace-nowrap">Porsi</span>
                                </div>
                            </div>
                        </div>

                        <!-- Live Calculation Preview -->
                        <div class="mt-2 text-xs text-slate flex gap-4" x-show="item.makanan_id">
                            <span class="flex items-center gap-1">
                                <i data-lucide="flame" class="w-3 h-3 text-orange-500"></i>
                                Total: <span class="font-bold text-charcoal" x-text="(item.kalori_per_porsi * item.kuantitas).toFixed(1)">0</span> Kkal
                            </span>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Footer Summary -->
            <div class="mt-8 bg-mint/10 p-4 rounded-xl flex justify-between items-center z-0 relative">
                <div>
                    <span class="text-sm text-slate">Total Estimasi Kalori</span>
                    <div class="text-2xl font-bold text-leaf" x-text="calculateTotalCalories()">0</div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.pelacakan-makanan.index') }}"
                        class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate bg-white hover:bg-gray-50 border border-gray-200">Batal</a>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-leaf hover:bg-green-700 shadow-md">
                        Simpan Data
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function foodRepeater() {
            return {
                items: [{ 
                    makanan_id: '', 
                    makanan_name: '', 
                    kuantitas: 1, 
                    kalori_per_porsi: 0 
                }],
                
                addItem() {
                    this.items.push({ 
                        makanan_id: '', 
                        makanan_name: '', 
                        kuantitas: 1, 
                        kalori_per_porsi: 0 
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
                }
            }
        }
    </script>
@endsection
