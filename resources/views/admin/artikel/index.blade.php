@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-charcoal">Kelola Artikel</h1>
                <p class="text-slate text-sm">Daftar semua artikel edukasi dan resep sehat.</p>
            </div>
            <a href="{{ route('admin.artikel.create') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-leaf text-white font-bold rounded-xl hover:bg-green-700 transition-all shadow-md shadow-green-200 hover:shadow-lg transform hover:-translate-y-0.5">
                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                Tulis Artikel Baru
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-2"
                role="alert">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                <form action="{{ route('admin.artikel.index') }}" method="GET" class="flex flex-col sm:flex-row justify-end gap-3">

                    <div class="relative min-w-[200px]">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i data-lucide="filter" class="w-4 h-4 text-slate"></i>
                        </span>
                        <select name="kategori" onchange="this.form.submit()"
                                class="w-full py-2 pl-10 pr-8 text-sm text-charcoal border border-gray-200 rounded-lg focus:outline-none focus:border-leaf focus:ring-1 focus:ring-leaf bg-white appearance-none cursor-pointer">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoriList as $cat)
                                <option value="{{ $cat->id }}" {{ request('kategori') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->kategori }}
                                </option>
                            @endforeach
                        </select>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate"></i>
                        </span>
                    </div>

                    <div class="relative max-w-xs w-full">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i data-lucide="search" class="w-4 h-4 text-slate"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul artikel..."
                            class="w-full py-2 pl-10 pr-4 text-sm text-charcoal border border-gray-200 rounded-lg focus:outline-none focus:border-leaf focus:ring-1 focus:ring-leaf bg-white">
                    </div>

                    <button type="submit" class="hidden sm:inline-flex items-center justify-center px-4 py-2 bg-leaf text-white text-sm font-bold rounded-lg hover:bg-green-700 transition-colors">
                        Cari
                    </button>

                    @if(request('search') || request('kategori'))
                        <a href="{{ route('admin.artikel.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 text-slate text-sm font-bold rounded-lg hover:bg-gray-300 transition-colors" title="Reset Filter">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </a>
                    @endif

                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-slate font-semibold">
                            <th class="px-6 py-4">Artikel</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Tanggal Rilis</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($artikel as $item)
                            <tr class="hover:bg-gray-50/80 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100 border border-gray-200">
                                            @if ($item->foto)
                                                <img src="{{ asset('storage/' . $item->foto) }}" alt="Thumbnail"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate">
                                                    <i data-lucide="image" class="w-6 h-6 opacity-50"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-charcoal text-sm group-hover:text-leaf transition-colors line-clamp-1">
                                                {{ $item->judul }}
                                            </h3>
                                            <p class="text-xs text-slate mt-1 line-clamp-1">
                                                {{ Str::limit(strip_tags($item->content), 50) }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($item->kategori as $cat)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-mint/30 text-leaf border border-mint">
                                                {{ $cat->kategori }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2 text-sm text-slate">
                                        <i data-lucide="calendar" class="w-4 h-4"></i>
                                        {{ $item->created_at->format('d M Y') }}
                                    </div>
                                    <span class="text-xs text-slate/60 ml-6">{{ $item->created_at->format('H:i') }}
                                        WIB</span>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.artikel.show', $item->id) }}"
                                            class="p-2 text-slate hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Lihat di Web">
                                            <i data-lucide="external-link" class="w-4 h-4"></i>
                                        </a>

                                        <a href="{{ route('admin.artikel.edit', $item->id) }}"
                                            class="p-2 text-slate hover:text-orange-500 hover:bg-orange-50 rounded-lg transition-colors"
                                            title="Edit">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>

                                        <form action="{{ route('admin.artikel.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
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
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i data-lucide="file-x" class="w-8 h-8 text-slate/50"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-charcoal">Belum ada artikel</h3>
                                        <p class="text-slate text-sm mb-6">
                                            @if(request('search') || request('kategori'))
                                                Tidak ada artikel yang cocok dengan filter pencarian.
                                            @else
                                                Mulai edukasi pengguna dengan menulis artikel pertamamu.
                                            @endif
                                        </p>

                                        @if(request('search') || request('kategori'))
                                            <a href="{{ route('admin.artikel.index') }}" class="text-leaf font-bold hover:underline text-sm">
                                                Reset Filter
                                            </a>
                                        @else
                                            <a href="{{ route('admin.artikel.create') }}" class="text-leaf font-bold hover:underline text-sm">
                                                Buat Artikel Sekarang
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $artikel->links() }}
            </div>
        </div>
    </div>
@endsection
