@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-eggshell py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-charcoal">Jadwal Makan</h1>
                    <p class="text-slate text-sm">Atur pengingat agar jam makanmu teratur.</p>
                </div>

                <button x-data @click="$dispatch('open-add-modal')"
                    class="inline-flex items-center gap-2 bg-leaf text-white font-bold py-2.5 px-5 rounded-xl hover:bg-green-700 transition-all shadow-md transform hover:-translate-y-0.5">
                    <i data-lucide="alarm-clock-plus" class="w-5 h-5"></i> Tambah Jadwal
                </button>
            </div>

            @if (session('success'))
                <div
                    class="mb-6 bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-5 h-5"></i> {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($jadwal as $item)
                    <div
                        class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex justify-between items-center hover:shadow-md transition-all group relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-16 h-full bg-gradient-to-l from-gray-50 to-transparent"></div>

                        <div class="flex items-center gap-4 z-10">
                            <div
                                class="w-14 h-14 bg-mint/20 text-leaf rounded-2xl flex flex-col items-center justify-center border border-mint/20">
                                <span class="text-xs font-bold text-leaf/70">JAM</span>
                                <span class="font-black text-xl leading-none">
                                    {{ \Carbon\Carbon::parse($item->waktu_jadwal)->format('H:i') }}
                                </span>
                            </div>
                            <div>
                                <h3 class="font-bold text-charcoal text-lg">{{ $item->nama_jadwal }}</h3>
                                <p class="text-xs text-slate">Pengingat Aktif</p>
                            </div>
                        </div>

                        <form action="{{ route('jadwal.destroy', $item->id) }}" method="POST"
                            onsubmit="return confirm('Hapus jadwal ini?');" class="z-10">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="p-2 text-slate hover:text-red-500 hover:bg-red-50 rounded-xl transition-colors"
                                title="Hapus">
                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-16 bg-white rounded-3xl border border-dashed border-gray-300">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="bell-off" class="w-8 h-8 text-slate/40"></i>
                        </div>
                        <h3 class="text-lg font-bold text-charcoal">Belum ada jadwal</h3>
                        <p class="text-slate text-sm">Tambahkan jam makanmu sekarang agar tidak lupa.</p>
                    </div>
                @endforelse
            </div>

        </div>

        <audio id="alarm-sound" src="{{ asset('sounds/alarm.mp3') }}" preload="auto" loop></audio>


        <div x-data="{ show: false, label: '' }" @trigger-alarm.window="show = true; label = $event.detail.label" x-show="show"
            {{-- 1. Mencegah tombol ESC menutup modal --}} @keydown.escape.window.prevent="return false;"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100" {{-- 2. Pastikan tidak ada @click="show=false" di sini --}}
            class="fixed inset-0 z-50 flex items-center justify-center px-4 bg-black/80 backdrop-blur-sm"
            style="display: none;">

            <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-sm p-8 text-center relative overflow-hidden"
                {{-- 3. Opsional: Mencegah event click tembus ke belakang --}} @click.stop>

                <div class="absolute top-0 left-0 w-full h-2 bg-leaf animate-pulse"></div>

                <div
                    class="w-24 h-24 bg-yellow-50 text-yellow-500 rounded-full flex items-center justify-center mx-auto mb-6 relative">
                    <div class="absolute inset-0 rounded-full bg-yellow-400 opacity-20 animate-ping"></div>
                    <i data-lucide="bell-ring" class="w-10 h-10 animate-bounce"></i>
                </div>

                <h2 class="text-3xl font-black text-charcoal mb-2">Waktunya Makan!</h2>
                <p class="text-lg text-leaf font-bold mb-6 uppercase tracking-wider" x-text="label"></p>

                <p class="text-sm text-slate mb-8 bg-gray-50 p-3 rounded-xl">
                    "Kesehatan bermula dari pola makan yang teratur. Selamat makan!"
                </p>

                {{-- SATU-SATUNYA cara menutup modal ada di tombol ini --}}
                <button @click="show = false; stopAlarm();"
                    class="w-full py-4 bg-leaf text-white font-bold rounded-2xl hover:bg-green-700 transition-all shadow-lg transform active:scale-95">
                    Matikan Reminder
                </button>
            </div>
        </div>


        <div x-data="{ open: false }" @open-add-modal.window="open = true" x-show="open"
            class="fixed inset-0 z-40 flex items-end sm:items-center justify-center px-4 bg-black/50 backdrop-blur-sm"
            style="display: none;">

            <div class="bg-white rounded-t-3xl sm:rounded-3xl shadow-xl w-full max-w-md p-8 relative"
                @click.away="open = false">
                <h3 class="text-xl font-bold text-charcoal mb-6 flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-5 h-5 text-leaf"></i> Tambah Pengingat
                </h3>

                <form action="{{ route('jadwal.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate uppercase mb-1">Nama Jadwal</label>
                        <input type="text" name="nama_jadwal" placeholder="Contoh: Makan Siang" required
                            class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf bg-gray-50 focus:bg-white transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate uppercase mb-1">Pukul Berapa?</label>
                        <input type="time" name="waktu_jadwal" required
                            class="w-full rounded-xl border-gray-200 focus:border-leaf focus:ring-leaf text-2xl font-black text-center py-4 bg-gray-50 focus:bg-white text-charcoal">
                    </div>
                    <div class="flex gap-3 mt-8">
                        <button type="button" @click="open = false"
                            class="flex-1 py-3 bg-gray-100 text-slate font-bold rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                        <button type="submit"
                            class="flex-1 py-3 bg-leaf text-white font-bold rounded-xl hover:bg-green-700 shadow-md transition-colors">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        // Fungsi Stop Audio Global
        function stopAlarm() {
            const audio = document.getElementById('alarm-sound');
            if (audio) {
                audio.pause();
                audio.currentTime = 0;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // 1. Ambil data jadwal dari Backend ke JS
            const schedules = @json($jadwal);
            const alarmSound = document.getElementById('alarm-sound');

            // Bersihkan data jadwal (ambil jam:menit saja, misal "12:30")
            const cleanSchedules = schedules.map(item => ({
                label: item.nama_jadwal,
                // substring(0,5) mengambil "12:30" dari "12:30:00"
                time: item.waktu_jadwal.substring(0, 5)
            }));

            // 2. Fungsi Pengecekan Waktu
            function checkAlarm() {
                const now = new Date();

                // Format waktu sekarang jadi HH:MM (24 jam)
                // Menggunakan teknik manual agar kompatibel semua browser
                const h = String(now.getHours()).padStart(2, '0');
                const m = String(now.getMinutes()).padStart(2, '0');
                const currentTime = `${h}:${m}`;
                const currentSeconds = now.getSeconds();

                // Cek hanya saat detik ke-0 (agar alarm tidak bunyi 60x dalam satu menit)
                if (currentSeconds === 0) {

                    cleanSchedules.forEach(schedule => {
                        // Jika waktu sekarang SAMA DENGAN waktu jadwal
                        if (schedule.time === currentTime) {

                            console.log("ALARM TRIGGERED: " + schedule.label);

                            // A. Bunyikan Suara
                            try {
                                alarmSound.play().catch(error => {
                                    console.warn(
                                        "Autoplay dicegah browser. User harus interaksi dulu di halaman ini."
                                    );
                                });
                            } catch (e) {
                                console.error("Audio error", e);
                            }

                            // B. Munculkan Modal (Kirim Event ke AlpineJS)
                            window.dispatchEvent(new CustomEvent('trigger-alarm', {
                                detail: {
                                    label: schedule.label
                                }
                            }));
                        }
                    });
                }
            }

            // 3. Jalankan pengecekan setiap 1 detik (1000ms)
            setInterval(checkAlarm, 1000);
        });
    </script>
@endsection
