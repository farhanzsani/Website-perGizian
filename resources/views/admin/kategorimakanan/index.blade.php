@extends('layouts.admin')

@section('content')
    {{-- Alpine Data Object untuk Mengontrol Modal --}}
    <div x-data="{
        showModal: false,
        editMode: false,
        modalTitle: '',
        formAction: '',
        kategoriName: '',
    
        // Fungsi Buka Modal Tambah
        openCreate() {
            this.showModal = true;
            this.editMode = false;
            this.modalTitle = 'Tambah Kategori Baru';
            this.formAction = '{{ route('admin.kategorimakanan.store') }}';
            this.kategoriName = '';
        },
    
        // Fungsi Buka Modal Edit
        openEdit(url, name) {
            this.showModal = true;
            this.editMode = true;
            this.modalTitle = 'Edit Kategori';
            this.formAction = url;
            this.kategoriName = name;
        }
    }">

        <div class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-charcoal">Kategori Artikel</h1>
                    <p class="text-slate text-sm">Atur pengelompokan topik artikel kesehatan Anda.</p>
                </div>

                <button @click="openCreate()"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-leaf text-white font-bold rounded-xl hover:bg-green-700 transition-all shadow-md shadow-green-200 hover:shadow-lg transform hover:-translate-y-0.5">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                    Tambah Kategori
                </button>
            </div>

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                    class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center gap-2">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-slate font-semibold">
                                <th class="px-6 py-4 w-10 text-center">No</th>
                                <th class="px-6 py-4">Nama Kategori</th>
                                <th class="px-6 py-4 text-center">Jumlah Artikel</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($kategori as $index => $item)
                                <tr class="hover:bg-gray-50/80 transition-colors">
                                    <td class="px-6 py-4 text-center text-slate text-sm">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-charcoal">{{ $item->kategori }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-slate">
                                            {{ $item->makanan_count }} makanan
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">

                                            <button
                                                @click="openEdit('{{ route('admin.kategorimakanan.update', $item->id) }}', '{{ $item->kategori }}')"
                                                class="p-2 text-slate hover:text-orange-500 hover:bg-orange-50 rounded-lg transition-colors"
                                                title="Edit">
                                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                                            </button>

                                            <form action="{{ route('admin.kategorimakanan.destroy', $item->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-slate hover:text-tomato hover:bg-red-50 rounded-lg transition-colors"
                                                    title="Hapus">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate text-sm">
                                        Belum ada kategori yang dibuat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-charcoal/50 backdrop-blur-sm transition-opacity" @click="showModal = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="showModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                    <form :action="formAction" method="POST" class="p-6">
                        @csrf

                        <template x-if="editMode">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        <div class="flex items-center justify-between mb-5">
                            <h3 class="text-lg font-bold text-charcoal" x-text="modalTitle"></h3>
                            <button type="button" @click="showModal = false"
                                class="text-slate hover:text-charcoal transition-colors">
                                <i data-lucide="x" class="w-5 h-5"></i>
                            </button>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="kategori" class="block text-sm font-bold text-charcoal mb-2">Nama
                                    Kategori</label>
                                <input type="text" name="kategori" id="kategori" x-model="kategoriName"
                                    class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-leaf focus:ring-leaf py-2.5 px-4 text-charcoal transition-colors"
                                    placeholder="Contoh: Diet Keto, Tips Gizi..." required autofocus>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" @click="showModal = false"
                                class="px-4 py-2 bg-white text-slate font-bold border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-6 py-2 bg-leaf text-white font-bold rounded-xl hover:bg-green-700 transition-colors shadow-md">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
