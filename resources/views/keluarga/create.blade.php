@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Buat Keluarga Baru</h1>

            <form action="{{ route('keluarga.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="nama_keluarga" class="block text-gray-700 font-semibold mb-2">
                        Nama Keluarga <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nama_keluarga" 
                           name="nama_keluarga" 
                           value="{{ old('nama_keluarga') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: Keluarga Budi"
                           required>
                    @error('nama_keluarga')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                    <p class="text-blue-700">
                        <strong>Info:</strong> Kamu akan menjadi kepala keluarga dan bisa mengundang anggota lain setelah keluarga dibuat.
                    </p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('keluarga.index') }}" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Buat Keluarga
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection