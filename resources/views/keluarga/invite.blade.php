@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Undang Anggota Keluarga</h1>

            <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg p-6 text-white mb-6">
                <h3 class="text-xl font-semibold mb-2">Link Undangan</h3>
                <p class="text-sm mb-4 opacity-90">Bagikan link ini ke anggota keluarga yang ingin bergabung</p>
                
                <div class="bg-white bg-opacity-20 rounded-lg p-4 flex items-center justify-between" x-data="{ copied: false }">
                    <code class="text-white font-mono text-sm">
                        {{ route('keluarga.join') }}?keluarga_id={{ $keluarga->id }}
                    </code>
                    <button @click="navigator.clipboard.writeText('{{ route('keluarga.join') }}?keluarga_id={{ $keluarga->id }}'); copied = true; setTimeout(() => copied = false, 2000)"
                            class="ml-4 px-4 py-2 bg-white text-blue-600 rounded-lg hover:bg-gray-100 transition font-semibold text-sm">
                        <span x-show="!copied">Salin</span>
                        <span x-show="copied" x-cloak>✓ Tersalin!</span>
                    </button>
                </div>
            </div>

            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
                <p class="text-yellow-700">
                    <strong>Tips:</strong> Kamu bisa share link ini via WhatsApp, email, atau cara lainnya. Anggota cukup klik link dan akan langsung bergabung!
                </p>
            </div>

            <a href="{{ route('keluarga.index') }}" class="inline-block px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                Kembali
            </a>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection