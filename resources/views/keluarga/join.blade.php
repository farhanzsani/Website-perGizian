@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-eggshell py-12 flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-3xl shadow-xl p-8 border border-gray-100 text-center">

            <div class="mb-8">
                <div class="inline-flex items-center justify-center p-3 bg-coral/10 rounded-full text-coral mb-4">
                    <i data-lucide="users" class="w-8 h-8"></i>
                </div>
                <h1 class="text-2xl font-bold text-charcoal">Gabung Keluarga</h1>
                <p class="text-slate text-sm mt-2">Masukkan 6 digit kode unik yang Anda terima.</p>
            </div>

            @if (session('error'))
                <div
                    class="mb-6 bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl text-sm flex items-center gap-2 text-left">
                    <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('keluarga.join.process') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <input type="text" name="kode_keluarga" placeholder="Contoh: A1B2C3" maxlength="6"
                        value="{{ $prefillCode ?? old('kode_keluarga') }}"
                        class="w-full text-center text-2xl font-bold tracking-widest uppercase py-4 border-2 border-gray-200 rounded-xl focus:border-leaf focus:ring-leaf placeholder-gray-300 transition-colors"
                        required autofocus>
                </div>

                <button type="submit"
                    class="w-full py-3 bg-leaf text-white font-bold rounded-xl hover:bg-green-700 transition-all shadow-lg transform hover:-translate-y-1 mb-4">
                    Gabung Sekarang
                </button>

                <a href="{{ route('keluarga.index') }}"
                    class="block w-full py-3 text-slate font-bold text-sm hover:text-charcoal transition-colors">
                    Batal
                </a>
            </form>
        </div>
    </div>
@endsection
