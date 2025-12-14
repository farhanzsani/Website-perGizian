@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-eggshell py-10 px-4 sm:px-6 lg:px-8" x-data="{ showDeleteModal: false }">

        <div class="mb-6">
            <a href="{{ route('admin.keluarga.index') }}"
                class="inline-flex items-center gap-2 text-slate hover:text-leaf font-bold text-sm transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </div>

        @if (session('error'))
            <div class="mb-6 bg-red-50 text-red-700 px-4 py-3 rounded-xl flex items-center gap-2 border border-red-200">
                <i data-lucide="x-circle" class="w-5 h-5"></i> {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="space-y-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 text-center">
                    <div class="w-20 h-20 bg-leaf/20 text-leaf rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="users" class="w-10 h-10"></i>
                    </div>
                    <h1 class="text-2xl font-black text-charcoal">{{ $keluarga->nama_keluarga }}</h1>

                    <div class="mt-6 bg-charcoal text-white p-4 rounded-xl">
                        <p class="text-xs text-gray-400 uppercase mb-1">Kode Unik Keluarga</p>
                        <p class="text-2xl font-mono font-bold tracking-widest text-leaf select-all">
                            {{ $keluarga->kode_keluarga }}
                        </p>
                    </div>

                    <div class="mt-6 text-left space-y-3 text-sm">
                        <div class="flex justify-between border-b border-gray-50 pb-2">
                            <span class="text-slate">Kepala Keluarga</span>
                            <span class="font-bold text-charcoal">{{ $keluarga->kepalaKeluarga->user->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-50 pb-2">
                            <span class="text-slate">Total Anggota</span>
                            <span class="font-bold text-charcoal">{{ $keluarga->anggota->count() }} Orang</span>
                        </div>
                    </div>
                </div>

                <button @click="showDeleteModal = true"
                    class="w-full py-3 bg-white border-2 border-red-100 text-red-600 font-bold rounded-xl hover:bg-red-50 hover:border-red-200 transition-all shadow-sm flex items-center justify-center gap-2">
                    <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus Keluarga Ini
                </button>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-charcoal">Daftar Anggota Keluarga</h2>
                    </div>
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-gray-50 text-slate uppercase font-bold text-xs">
                            <tr>
                                <th class="px-6 py-4">Nama</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Bergabung</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($keluarga->anggota as $member)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-bold text-charcoal flex items-center gap-2">
                                        {{ $member->user->name }}
                                        @if ($member->id == $keluarga->kepala_keluarga_id)
                                            <i data-lucide="crown" class="w-3 h-3 text-orange-500"></i>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-slate">{{ $member->user->email }}</td>
                                    <td class="px-6 py-4">
                                        @if ($member->id == $keluarga->kepala_keluarga_id)
                                            <span
                                                class="px-2 py-1 bg-orange-100 text-orange-700 rounded text-xs font-bold">Ketua</span>
                                        @else
                                            <span
                                                class="px-2 py-1 bg-gray-100 text-slate rounded text-xs font-bold">Anggota</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right text-slate">
                                        {{ $member->created_at->format('d M Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div x-show="showDeleteModal" x-cloak
            class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
            @click.self="showDeleteModal = false">

            <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl transform transition-all">
                <div class="text-center mb-6">
                    <div
                        class="inline-flex items-center justify-center p-3 bg-red-100 rounded-full text-red-600 mb-4 animate-pulse">
                        <i data-lucide="shield-alert" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-charcoal mb-2">Hapus Permanen?</h3>
                    <p class="text-slate text-sm">
                        Tindakan ini tidak bisa dibatalkan. Anggota akan dikeluarkan dari keluarga ini.
                    </p>
                </div>

                <form action="{{ route('admin.keluarga.destroy', $keluarga->id) }}" method="POST">
                    @csrf @method('DELETE')

                    <div class="mb-6 text-left">
                        <label class="block text-xs font-bold text-slate uppercase mb-1">Konfirmasi Kode</label>
                        <p class="text-xs text-slate mb-2">
                            Ketik kode: <span
                                class="font-mono font-bold text-charcoal bg-gray-100 px-1 rounded">{{ $keluarga->kode_keluarga }}</span>
                        </p>
                        <input type="text" name="kode_konfirmasi" required placeholder="Masukkan kode..."
                            class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500 font-mono text-center uppercase tracking-widest">
                    </div>

                    <div class="flex gap-3">
                        <button type="button" @click="showDeleteModal = false"
                            class="flex-1 px-4 py-3 bg-gray-100 text-charcoal rounded-xl font-bold hover:bg-gray-200">Batal</button>
                        <button type="submit"
                            class="flex-1 px-4 py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 shadow-lg shadow-red-600/30">Hapus
                            Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection
