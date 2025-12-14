@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-eggshell py-10 px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-charcoal">Kelola Keluarga</h1>
                <p class="text-slate text-sm">Daftar grup keluarga yang terdaftar.</p>
            </div>

            <div class="flex gap-2 w-full md:w-auto">
                <form action="{{ route('admin.keluarga.index') }}" method="GET"
                    class="relative flex-grow md:flex-grow-0 md:w-64">
                    <input type="text" name="search" placeholder="Cari Nama / Kode..." value="{{ request('search') }}"
                        class="w-full pl-10 pr-4 py-2 rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf text-sm">
                    <i data-lucide="search" class="w-4 h-4 text-slate absolute left-3 top-1/2 -translate-y-1/2"></i>
                </form>

                <a href="{{ route('admin.keluarga.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-leaf text-white rounded-xl font-bold hover:bg-green-700 transition-all shadow-md whitespace-nowrap">
                    <i data-lucide="plus" class="w-5 h-5"></i> Buat Baru
                </a>
            </div>
        </div>

        @if (session('success'))
            <div
                class="mb-6 bg-green-50 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2 border border-green-200">
                <i data-lucide="check-circle" class="w-5 h-5"></i> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white  rounded-2xl shadow-sm border border-gray-100 overflow-x-scroll">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-gray-50 text-slate uppercase font-bold text-xs">
                    <tr>
                        <th class="px-6 py-4">Nama Keluarga</th>
                        <th class="px-6 py-4">Kode</th>
                        <th class="px-6 py-4">Ketua</th>
                        <th class="px-6 py-4 text-center">Anggota</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($keluarga as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-charcoal">{{ $item->nama_keluarga }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="bg-gray-100 text-charcoal px-2 py-1 rounded font-mono font-bold text-xs border border-gray-200">
                                    {{ $item->kode_keluarga }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate">
                                {{ $item->kepalaKeluarga->user->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex items-center gap-1 bg-leaf/10 text-leaf px-2 py-1 rounded-full text-xs font-bold">
                                    <i data-lucide="users" class="w-3 h-3"></i> {{ $item->anggota_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.keluarga.show', $item->id) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-xs font-bold text-slate hover:text-leaf hover:border-leaf transition-colors shadow-sm">
                                    <i data-lucide="eye" class="w-3 h-3"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate">Data kosong.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $keluarga->withQueryString()->links() }}</div>
    </div>
@endsection
