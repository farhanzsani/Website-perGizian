@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-beige flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-charcoal">
                Lupa Password?
            </h2>
            <p class="mt-2 text-center text-sm text-slate px-4">
                Jangan khawatir. Masukkan email Anda dan kami akan mengirimkan link untuk mereset password Anda.
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-xl rounded-3xl sm:px-10 border border-gray-100">

                @if (session('status'))
                    <div
                        class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-bold text-charcoal mb-1">Email</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="mail" class="h-5 w-5 text-gray-400"></i>
                            </div>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                autofocus
                                class="block w-full pl-10 px-4 py-3 border border-gray-200 rounded-xl focus:ring-leaf focus:border-leaf sm:text-sm placeholder-gray-400"
                                placeholder="nama@email.com">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-tomato">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-leaf hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-leaf transition-colors">
                            Kirim Link Reset Password
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-slate hover:text-leaf transition-colors">
                            Kembali ke halaman login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
