@extends('layouts.admin')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-charcoal">Kelola Data Makanan</h1>
                <p class="text-slate text-sm">Database nutrisi dan kalori makanan.</p>
            </div>
            <a href="{{ route('admin.kelolamakanan.create') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-leaf text-white font-bold rounded-xl hover:bg-green-700 transition-all shadow-md shadow-green-200 hover:shadow-lg transform hover:-translate-y-0.5">
                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                Tambah Makanan
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-2"
                role="alert">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">

            <div class="p-4 border-b border-gray-100 bg-gray-50/50 rounded-t-2xl">
                <form action="{{ route('admin.kelolamakanan.index') }}" method="GET"
                    class="flex flex-col sm:flex-row justify-end gap-3">

                    <div class="relative min-w-[200px]" x-data="{ 
                        open: false, 
                        selected: '{{ request('kategori') ?? '' }}',
                        label: '{{ $kategoriList->firstWhere('id', request('kategori'))->kategori ?? 'Semua Kategori' }}'
                    }">
                        <!-- Hidden Input for Form Submission -->
                        <input type="hidden" name="kategori" :value="selected">

                        <!-- Dropdown Button -->
                        <button type="button" @click="open = !open" @click.outside="open = false" 
                            class="w-full flex items-center justify-between py-2 pl-4 pr-3 text-sm text-charcoal border border-gray-200 rounded-lg hover:border-leaf hover:ring-2 hover:ring-leaf/20 transition-all shadow-sm bg-white focus:outline-none">
                            <div class="flex items-center gap-2 truncate">
                                <i data-lucide="filter" class="w-4 h-4 text-leaf"></i>
                                <span x-text="label" class="font-medium truncate"></span>
                            </div>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate transition-transform duration-200" 
                               :class="{'rotate-180': open}"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute top-full left-0 mt-2 w-full bg-white rounded-xl shadow-xl border border-gray-100 z-30 overflow-hidden ring-1 ring-black ring-opacity-5"
                            style="display: none;">
                            
                            <div class="py-1 max-h-60 overflow-y-auto">
                                <!-- Option: Semua Kategori -->
                                <button type="button" 
                                    @click="selected = ''; label = 'Semua Kategori'; open = false; $nextTick(() => { $el.closest('form').submit() })" 
                                    class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-left hover:bg-mint/30 transition-colors"
                                    :class="selected === '' ? 'text-leaf bg-mint/10 font-bold' : 'text-slate'">
                                    <div class="w-1.5 h-1.5 rounded-full" :class="selected === '' ? 'bg-leaf' : 'bg-transparent'"></div>
                                    Semua Kategori
                                </button>

                                @foreach($kategoriList as $cat)
                                    <button type="button" 
                                        @click="selected = '{{ $cat->id }}'; label = '{{ $cat->kategori }}'; open = false; $nextTick(() => { $el.closest('form').submit() })" 
                                        class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-left hover:bg-mint/30 transition-colors"
                                        :class="selected == '{{ $cat->id }}' ? 'text-leaf bg-mint/10 font-bold' : 'text-slate'">
                                        <div class="w-1.5 h-1.5 rounded-full" :class="selected == '{{ $cat->id }}' ? 'bg-leaf' : 'bg-transparent'"></div>
                                        {{ $cat->kategori }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="relative max-w-xs w-full">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i data-lucide="search" class="w-4 h-4 text-slate"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama makanan..."
                            class="w-full py-2 pl-10 pr-4 text-sm text-charcoal border border-gray-200 rounded-lg focus:outline-none focus:border-leaf focus:ring-1 focus:ring-leaf bg-white">
                    </div>

                    <button type="submit"
                        class="hidden sm:inline-flex items-center justify-center px-4 py-2 bg-leaf text-white text-sm font-bold rounded-lg hover:bg-green-700 transition-colors">
                        Cari
                    </button>

                    @if (request('search') || request('kategori'))
                        <a href="{{ route('admin.kelolamakanan.index') }}"
                            class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 text-slate text-sm font-bold rounded-lg hover:bg-gray-300 transition-colors"
                            title="Reset Filter">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </a>
                    @endif

                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-slate font-semibold">
                            <th class="px-6 py-4">Produk</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Energi</th>
                            <th class="px-6 py-4">Porsi</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($makanan as $item)
                            <tr class="hover:bg-gray-50/80 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100 border border-gray-200">
                                            @if ($item->foto_makanan)
                                                <img src="{{ asset('storage/' . $item->foto_makanan) }}" alt="Foto"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate">
                                                    <i data-lucide="utensils" class="w-5 h-5 opacity-50"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h3
                                                class="font-bold text-charcoal text-sm group-hover:text-leaf transition-colors line-clamp-1">
                                                {{ $item->nama }}
                                            </h3>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-mint/30 text-leaf border border-mint">
                                        {{ $item->kategori->kategori ?? 'Umum' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-bold text-charcoal">{{ $item->energi }}</span>
                                    <span class="text-xs text-slate">Kkal</span>
                                </td>

                                <td class="px-6 py-4 text-sm text-slate">
                                    {{ $item->kuantitas }} {{ $item->satuan }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.kelolamakanan.show', $item->id) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-gray-50 text-slate hover:bg-gray-100 transition"
                                            title="Lihat Detail">
                                            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                            Detail
                                        </a>

                                        <a href="{{ route('admin.kelolamakanan.edit', $item->id) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-50 text-blue-600 hover:bg-blue-100 transition"
                                            title="Edit">
                                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.kelolamakanan.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data makanan ini?');"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-red-50 text-tomato hover:bg-red-100 transition"
                                                title="Hapus">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i data-lucide="search-x" class="w-8 h-8 text-slate/50"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-charcoal">Data tidak ditemukan</h3>
                                        <p class="text-slate text-sm mb-6">
                                            @if (request('search') || request('kategori'))
                                                Tidak ada makanan yang cocok dengan filter pencarian.
                                            @else
                                                Belum ada data makanan di database.
                                            @endif
                                        </p>

                                        @if (request('search') || request('kategori'))
                                            <a href="{{ route('admin.kelolamakanan.index') }}"
                                                class="text-leaf font-bold hover:underline text-sm">
                                                Reset Filter
                                            </a>
                                        @else
                                            <a href="{{ route('admin.kelolamakanan.create') }}"
                                                class="text-leaf font-bold hover:underline text-sm">
                                                Tambah Makanan Sekarang
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 rounded-b-2xl">
                {{ $makanan->links() }}
            </div>
        </div>
    </div>
@endsection
