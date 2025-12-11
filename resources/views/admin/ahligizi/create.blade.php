@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center gap-2 text-slate mb-4">
            <a href="{{ route('admin.ahligizi.index') }}" class="hover:text-leaf transition-colors"><i data-lucide="arrow-left"
                    class="w-5 h-5"></i></a>
            <h1 class="text-xl font-bold text-charcoal">Tambah Ahli Gizi</h1>
        </div>

        <form action="{{ route('admin.ahligizi.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 grid grid-cols-1 md:grid-cols-3 gap-8">
            @csrf

            <div class="md:col-span-1 space-y-4">
                <label class="block text-sm font-bold text-charcoal">Foto Profil</label>
                <div x-data="imagePreview()"
                    class="relative w-full aspect-square bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 hover:border-leaf flex flex-col items-center justify-center cursor-pointer overflow-hidden group">
                    <input type="file" name="foto" class="absolute inset-0 opacity-0 cursor-pointer z-10"
                        @change="fileChosen" accept="image/*" required>
                    <div x-show="!imageUrl" class="text-center p-4">
                        <i data-lucide="camera" class="w-8 h-8 text-slate mx-auto mb-2"></i>
                        <p class="text-xs text-slate">Upload Foto</p>
                    </div>
                    <img x-show="imageUrl" :src="imageUrl" class="absolute inset-0 w-full h-full object-cover">
                </div>
                @error('foto')
                    <p class="text-tomato text-xs">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2 space-y-5">
                <div>
                    <label class="block text-sm font-bold text-charcoal mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                        class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf"
                        placeholder="Contoh: Dr. Sari Rahmawati" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-charcoal mb-1">Spesialisasi</label>
                        <input type="text" name="spesialis" value="{{ old('spesialis') }}"
                            class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf"
                            placeholder="Ahli Gizi Klinik" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-charcoal mb-1">Nomor WhatsApp</label>
                        <input type="number" name="nomor_hp" value="{{ old('nomor_hp') }}"
                            class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf" placeholder="628..."
                            required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-charcoal mb-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                        class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-charcoal mb-1">Alamat Praktik</label>
                    <textarea name="alamat" rows="2" class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf"
                        required>{{ old('alamat') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-charcoal mb-1">Deskripsi Singkat</label>
                    <textarea name="deskripsi" rows="3" class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf"
                        placeholder="Keahlian khusus atau bio singkat...">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <a href="{{ route('admin.ahligizi.index') }}"
                        class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate bg-gray-100 hover:bg-gray-200">Batal</a>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-leaf hover:bg-green-700 shadow-md">Simpan
                        Data</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function imagePreview() {
            return {
                imageUrl: null,
                fileChosen(event) {
                    if (!event.target.files.length) return;
                    let file = event.target.files[0],
                        reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = e => this.imageUrl = e.target.result;
                }
            }
        }
    </script>
@endsection
