@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data" x-data="{ title: '{{ old('judul') }}' }">
        @csrf

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <div class="flex items-center gap-2 text-slate mb-1">
                    <a href="{{ route('admin.artikel.index') }}" class="hover:text-leaf transition-colors">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    </a>
                    <span class="text-xs font-bold uppercase tracking-wider">Editor Artikel</span>
                </div>
                <h1 class="text-2xl font-bold text-charcoal line-clamp-1" x-text="title ? title : 'Judul Artikel Baru...'">
                    Judul Artikel Baru...
                </h1>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.artikel.index') }}"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate hover:bg-gray-100 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-leaf text-white font-bold rounded-xl hover:bg-green-700 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    Terbitkan
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <label class="block text-sm font-bold text-charcoal mb-2">Judul Artikel</label>
                    <input type="text" name="judul" x-model="title"
                        class="w-full text-lg font-bold placeholder-gray-300 border-0 border-b-2 border-gray-100 focus:border-leaf focus:ring-0 px-0 py-2 transition-colors"
                        placeholder="Ketik judul artikel yang menarik..." required>
                    @error('judul')
                        <p class="text-tomato text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <label class="text-sm font-bold text-charcoal mb-4 flex justify-between">
                        <span>Isi Konten</span>
                    </label>

                    <input id="x" type="hidden" name="content" value="{{ old('content') }}">

                    <trix-editor input="x" class="trix-content"
                        placeholder="Tuliskan isi artikel, resep, atau tips kesehatan di sini..."></trix-editor>

                    @error('content')
                        <p class="text-tomato text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100" x-data="imagePreview()">
                    <label class="block text-sm font-bold text-charcoal mb-4">Gambar Unggulan</label>
                    <div
                        class="relative w-full h-48 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 hover:border-leaf hover:bg-mint/10 transition-all flex flex-col items-center justify-center cursor-pointer overflow-hidden group">
                        <input type="file" name="foto"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="fileChosen"
                            accept="image/*" required>
                        <div x-show="!imageUrl" class="text-center p-4">
                            <div
                                class="bg-white w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2 shadow-sm text-leaf">
                                <i data-lucide="image-plus" class="w-5 h-5"></i>
                            </div>
                            <p class="text-xs font-bold text-charcoal">Klik untuk upload</p>
                        </div>
                        <img x-show="imageUrl" :src="imageUrl" class="absolute inset-0 w-full h-full object-cover"
                            style="display: none;">
                    </div>
                    @error('foto')
                        <p class="text-tomato text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <label class="block text-sm font-bold text-charcoal mb-4">Kategori</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($kategori as $cat)
                            <label class="cursor-pointer relative">
                                <input type="checkbox" name="kategori_id[]" value="{{ $cat->id }}"
                                    class="peer sr-only">
                                <span
                                    class="inline-block px-3 py-1.5 rounded-lg text-xs font-bold border border-gray-200 text-slate bg-white peer-checked:bg-leaf peer-checked:text-white peer-checked:border-leaf hover:border-leaf transition-all select-none">
                                    {{ $cat->kategori }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('kategori_id')
                        <p class="text-tomato text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>
    </form>

    <script>
        function imagePreview() {
            return {
                imageUrl: null,
                fileChosen(event) {
                    this.fileToDataUrl(event, src => this.imageUrl = src)
                },
                fileToDataUrl(event, callback) {
                    if (!event.target.files.length) return
                    let file = event.target.files[0],
                        reader = new FileReader()
                    reader.readAsDataURL(file)
                    reader.onload = e => callback(e.target.result)
                },
            }
        }
    </script>
@endsection
