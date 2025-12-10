@extends('layouts.auth')

@section('content')
    <div
        class="min-h-[calc(100vh-160px)] flex items-center justify-center gap-6 py-12 px-4 sm:px-6 lg:px-8 bg-eggshell">

        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-3xl shadow-xl border border-mint/50">

            <div class="text-center">
                <div class="bg-mint/30 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-leaf">
                    <i data-lucide="log-in" class="w-8 h-8"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-charcoal">
                    Selamat Datang Kembali
                </h2>
                <p class="mt-2 text-sm text-slate">
                    Masuk untuk melanjutkan perjalanan sehatmu
                </p>
            </div>

            @if (session('status'))
                <div class="bg-fresh/10 text-fresh text-sm p-4 rounded-lg mb-4 text-center font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-charcoal mb-1">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="pl-10 block w-full rounded-xl border-gray-200 bg-gray-50 focus:border-leaf focus:ring-leaf sm:text-sm py-3 transition-colors"
                                placeholder="nama@email.com" value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <p class="text-tomato text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-charcoal mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate">
                                <i data-lucide="lock" class="w-5 h-5"></i>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="pl-10 block w-full rounded-xl border-gray-200 bg-gray-50 focus:border-leaf focus:ring-leaf sm:text-sm py-3 transition-colors"
                                placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="text-tomato text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox"
                            class="h-4 w-4 text-leaf focus:ring-leaf border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-slate">
                            Ingat Saya
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}"
                                class="font-medium text-leaf hover:text-green-700 transition-colors">
                                Lupa password?
                            </a>
                        </div>
                    @endif
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-leaf hover:bg-green-700 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-leaf transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i data-lucide="arrow-right-circle"
                                class="w-5 h-5 text-mint group-hover:text-white transition-colors"></i>
                        </span>
                        Masuk Sekarang
                    </button>
                </div>

                <div class="text-center mt-4">
                    <p class="text-sm text-slate">
                        Belum punya akun?
                        <a href="{{ route('register') }}"
                            class="font-bold text-coral hover:text-orange-600 transition-colors">
                            Daftar disini
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
