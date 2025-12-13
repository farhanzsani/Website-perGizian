@extends('layouts.app')

@section('content')
    <div class="relative bg-charcoal text-white overflow-hidden pb-32 py-16">
        <img src="{{ asset('/images/sayurshow.jpg') }}" class="absolute inset-0 w-full h-full object-cover opacity-20"
            alt="Background">
        <div
            class="absolute -top-24 -left-24 w-96 h-96 bg-leaf rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
        </div>
        <div
            class="absolute top-0 right-0 w-96 h-96 bg-mint rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 text-center py-10">
            <a href="{{ route('makanan.carikalori.index') }}"
                class="inline-flex items-center gap-2 text-mint hover:text-white transition-colors mb-6 font-bold text-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Pencarian
            </a>
            <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight text-white mb-2">{{ $makanan->nama }}</h1>
            <p class="text-gray-300 text-lg">Informasi nilai gizi per <span
                    class="text-mint font-bold">{{ number_format($makanan->kuantitas, 1) }} {{ $makanan->satuan }}</span>
            </p>
        </div>
    </div>

    <div class="bg-eggshell min-h-screen -mt-24 rounded-t-[3rem] relative z-20 pb-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">

            <div class="bg- rounded-3xl shadow-xl border border-gray-100 overflow-hidden mb-8">
                <div class="grid grid-cols-1 lg:grid-cols-3">

                    <div class="relative h-64 lg:h-auto bg-gray-100">
                        @if ($makanan->foto_makanan && file_exists(public_path('storage/' . $makanan->foto_makanan)))
                            <img src="{{ asset('storage/' . $makanan->foto_makanan) }}" alt="{{ $makanan->nama }}"
                                class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <div
                                class="absolute inset-0 w-full h-full flex flex-col items-center justify-center text-leaf bg-mint/20">
                                <i data-lucide="utensils" class="w-16 h-16 mb-2 opacity-50"></i>
                                <span class="text-sm font-bold opacity-70">No Image</span>
                            </div>
                        @endif
                    </div>

                    <div class="p-8 flex flex-col justify-center border-b lg:border-b-0 lg:border-r border-gray-100">
                        <div class="mb-2 text-slate text-sm font-bold uppercase tracking-wider">Energi Total</div>
                        <div class="flex items-baseline gap-2 mb-6">
                            <span class="text-6xl font-extrabold text-charcoal">{{ $makanan->energi }}</span>
                            <span class="text-2xl font-bold text-leaf">kkal</span>
                        </div>
                        <p class="text-slate text-sm leading-relaxed mb-6">
                            Makanan ini mengandung <strong>{{ $makanan->energi }} kalori</strong> per
                            {{ number_format($makanan->kuantitas, 1) }} {{ $makanan->satuan }}.
                            Pastikan untuk menyesuaikan dengan kebutuhan harian Anda.
                        </p>
                    </div>

                    <div class="p-6 bg-gray-50 flex flex-col items-center justify-center">
                        <h4 class="text-sm font-bold text-charcoal mb-4">Komposisi Makronutrisi</h4>

                        <x-diagrams.donut :series="[$makanan->protein, $makanan->lemak, $makanan->karbohidrat]" :labels="['Protein', 'Lemak', 'Karbohidrat']" satuan="g" :showTotal="false"
                            :colors="['#3b82f6', '#eab308', '#f97316']">
                        </x-diagrams.donut>

                        <div class="flex justify-center gap-4 mt-2 text-xs font-bold text-slate">
                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                Protein</span>
                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                                Lemak</span>
                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-orange-500"></span>
                                Karbo</span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100 hover:shadow-md transition-all group">
                    <div class="flex justify-between items-start mb-2">
                        <p class="text-blue-600 font-bold text-sm uppercase tracking-wider">Protein</p>
                        <i data-lucide="fish" class="w-6 h-6 text-blue-200 group-hover:text-blue-500 transition-colors"></i>
                    </div>
                    <h3 class="text-3xl font-extrabold text-charcoal">{{ $makanan->protein }}<span
                            class="text-lg text-slate ml-1">g</span></h3>
                    <div class="w-full bg-blue-50 rounded-full h-1.5 mt-3">
                        <div class="bg-blue-500 h-1.5 rounded-full"></div>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-yellow-100 hover:shadow-md transition-all group">
                    <div class="flex justify-between items-start mb-2">
                        <p class="text-yellow-600 font-bold text-sm uppercase tracking-wider">Lemak</p>
                        <i data-lucide="droplet"
                            class="w-6 h-6 text-yellow-200 group-hover:text-yellow-500 transition-colors"></i>
                    </div>
                    <h3 class="text-3xl font-extrabold text-charcoal">{{ $makanan->lemak }}<span
                            class="text-lg text-slate ml-1">g</span></h3>
                    <div class="w-full bg-yellow-50 rounded-full h-1.5 mt-3">
                        <div class="bg-yellow-500 h-1.5 rounded-full"></div>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-orange-100 hover:shadow-md transition-all group">
                    <div class="flex justify-between items-start mb-2">
                        <p class="text-orange-600 font-bold text-sm uppercase tracking-wider">Karbohidrat</p>
                        <i data-lucide="wheat"
                            class="w-6 h-6 text-orange-200 group-hover:text-orange-500 transition-colors"></i>
                    </div>
                    <h3 class="text-3xl font-extrabold text-charcoal">{{ $makanan->karbohidrat }}<span
                            class="text-lg text-slate ml-1">g</span></h3>
                    <div class="w-full bg-orange-50 rounded-full h-1.5 mt-3">
                        <div class="bg-orange-500 h-1.5 rounded-full"></div>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-mint/20 rounded-2xl p-6 border border-mint/30 flex gap-4 items-start">
                <div class="bg-white p-2 rounded-full text-leaf shadow-sm shrink-0">
                    <i data-lucide="lightbulb" class="w-6 h-6"></i>
                </div>
                <div>
                    <h4 class="font-bold text-leaf text-lg">Tahukah Anda?</h4>
                    <p class="text-charcoal text-sm mt-1 leading-relaxed">
                        Data nilai gizi di atas merupakan estimasi rata-rata. Kandungan nutrisi sebenarnya dapat bervariasi
                        tergantung pada cara pengolahan, merek bahan, dan tambahan bumbu yang digunakan.
                    </p>
                </div>
            </div>

        </div>
    </div>
@endsection
