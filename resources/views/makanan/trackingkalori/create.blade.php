@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-eggshell py-12">
        <div class="max-w-2xl mx-auto px-4">

            <div class="mb-6">
                <a href="{{ route('trackingkalori.index') }}"
                    class="inline-flex items-center gap-2 text-slate hover:text-leaf font-bold text-sm transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
                </a>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100">
                <h1 class="text-2xl font-bold text-charcoal mb-6">Tambah Catatan Makan</h1>

                <div id="info-box" class="hidden bg-mint/10 border border-mint/30 p-5 rounded-2xl mb-6 transition-all">
                    <h3 class="text-leaf font-bold text-xs uppercase mb-3 flex items-center gap-2">
                        <i data-lucide="zap" class="w-4 h-4"></i> Estimasi Nutrisi
                    </h3>
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                            <p class="text-[10px] text-slate uppercase font-bold">Total Kalori</p>
                            <p class="text-2xl font-black text-leaf"><span id="prev-kalori">0</span> <span
                                    class="text-xs font-normal text-slate">kkal</span></p>
                        </div>
                        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                            <p class="text-[10px] text-slate uppercase font-bold">Jumlah Porsi</p>
                            <p class="text-2xl font-black text-charcoal"><span id="prev-jumlah">0</span> <span
                                    id="prev-satuan" class="text-xs font-normal text-slate">unit</span></p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('trackingkalori.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-bold text-charcoal mb-1">Waktu Makan</label>
                        <input type="datetime-local" name="waktu" value="{{ now()->format('Y-m-d\TH:i') }}"
                            class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf bg-gray-50">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-charcoal mb-1">Menu Makanan</label>
                        <select name="makanan_id" id="makanan-select"
                            class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf bg-white" required>
                            <option value="" data-kalori="0" data-satuan="">-- Pilih Makanan --</option>
                            @foreach ($makanan as $item)
                                <option value="{{ $item->id }}" data-kalori="{{ $item->energi }}"
                                    data-satuan="{{ $item->satuan }}" data-ref="{{ $item->kuantitas }}">
                                    {{ $item->nama }} ({{ $item->kuantitas }} {{ $item->satuan }} = {{ $item->energi }}
                                    kkal)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-charcoal mb-1">
                            Banyaknya dimakan (<span id="label-satuan">satuan</span>)
                        </label>
                        <input type="number" step="0.1" name="jumlah" id="input-jumlah" placeholder="Contoh: 1.5"
                            required class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf">
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="submit"
                            class="flex-1 py-3 bg-leaf text-white font-bold rounded-xl hover:bg-green-700 transition-colors shadow-md">
                            Simpan
                        </button>
                        <a href="{{ route('trackingkalori.index') }}"
                            class="py-3 px-6 bg-gray-100 text-slate font-bold rounded-xl hover:bg-gray-200 transition-colors text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('makanan-select');
            const input = document.getElementById('input-jumlah');
            const label = document.getElementById('label-satuan');
            const box = document.getElementById('info-box');

            const txtKalori = document.getElementById('prev-kalori');
            const txtJumlah = document.getElementById('prev-jumlah');
            const txtSatuan = document.getElementById('prev-satuan');

            function hitung() {
                const opt = select.options[select.selectedIndex];
                const val = parseFloat(input.value) || 0;

                if (opt.value) {
                    box.classList.remove('hidden');

                    const energi = parseFloat(opt.getAttribute('data-kalori'));
                    const ref = parseFloat(opt.getAttribute('data-ref')) || 1;
                    const sat = opt.getAttribute('data-satuan');

                    // Update UI Labels
                    label.innerText = sat;
                    txtSatuan.innerText = sat;
                    txtJumlah.innerText = val;

                    // Rumus: (Kalori DB / Kuantitas Referensi) * Input User
                    const total = (energi / ref) * val;
                    txtKalori.innerText = total.toFixed(1);
                } else {
                    box.classList.add('hidden');
                    label.innerText = 'satuan';
                }
            }

            select.addEventListener('change', hitung);
            input.addEventListener('input', hitung);
        });
    </script>
@endsection
