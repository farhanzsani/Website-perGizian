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
                    <select name="pengguna_id" class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf" required>
                        <option value="">Pilih Pengguna</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->user->name ?? 'Tanpa Nama' }} ({{ $user->user->email ?? '-' }})</option>
                        @endforeach
                    </select>
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
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 relative group transition-all hover:bg-white hover:shadow-sm">
                        
                        <!-- Remove Button -->
                        <button type="button" @click="removeItem(index)" x-show="items.length > 1"
                            class="absolute top-2 right-2 text-slate hover:text-tomato p-1 rounded-full hover:bg-red-50 transition-colors">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                            <!-- Food Select -->
                            <div class="md:col-span-8">
                                <label class="block text-xs font-bold text-slate mb-1">Menu Makanan</label>
                                <select :name="`items[${index}][makanan_id]`" x-model="item.makanan_id" @change="updateNutrition(index)"
                                    class="w-full rounded-lg border-gray-200 text-sm focus:border-leaf focus:ring-leaf" required>
                                    <option value="">Pilih Makanan...</option>
                                    @foreach ($makanan as $m)
                                        <option value="{{ $m->id }}" 
                                            data-kalori="{{ $m->energi }}" 
                                            data-unit="{{ $m->satuan }}">
                                            {{ $m->nama }} ({{ $m->energi }} Kkal / {{ $m->kuantitas }} {{ $m->satuan }})
                                        </option>
                                    @endforeach
                                </select>
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
                                Total: <span class="font-bold text-charcoal" x-text="calculateCalories(index)">0</span> Kkal
                            </span>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Footer Summary -->
            <div class="mt-8 bg-mint/10 p-4 rounded-xl flex justify-between items-center">
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
                items: [{ makanan_id: '', kuantitas: 1, kalori_per_porsi: 0 }],
                
                addItem() {
                    this.items.push({ makanan_id: '', kuantitas: 1, kalori_per_porsi: 0 });
                },
                
                removeItem(index) {
                    this.items.splice(index, 1);
                },

                updateNutrition(index) {
                    // Logic to find selected option and get data-kalori
                    // This is a bit tricky with x-model binding on select, usually access via event or refs.
                    // Simplified: We rely on the DOM element for data attribute.
                    
                    let select = document.getElementsByName(`items[${index}][makanan_id]`)[0];
                    if(select && select.selectedOptions.length > 0) {
                        let option = select.selectedOptions[0];
                        let kalori = parseFloat(option.getAttribute('data-kalori')) || 0;
                        this.items[index].kalori_per_porsi = kalori;
                    }
                },

                calculateCalories(index) {
                    let item = this.items[index];
                    return (item.kalori_per_porsi * item.kuantitas).toFixed(1);
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
