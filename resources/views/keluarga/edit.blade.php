@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Keluarga</h1>

            <form action="{{ route('keluarga.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="nama_keluarga" class="block text-gray-700 font-semibold mb-2">
                        Nama Keluarga <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nama_keluarga" 
                           name="nama_keluarga" 
                           value="{{ old('nama_keluarga', $keluarga->nama_keluarga) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                    @error('nama_keluarga')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('keluarga.index') }}" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection