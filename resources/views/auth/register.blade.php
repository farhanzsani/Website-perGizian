@extends('layouts.auth')

@section('content')
    <div class="min-h-[calc(100vh-160px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-eggshell">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-3xl shadow-xl border border-mint/50">

            <div class="text-center">
                <div class="bg-mint/30 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-leaf">
                    <i data-lucide="user-plus" class="w-8 h-8"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-charcoal">
                    Buat Akun Baru
                </h2>
                <p class="mt-2 text-sm text-slate">
                    Bergabunglah dengan komunitas hidup sehat kami
                </p>
            </div>

            <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-charcoal mb-1">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate">
                                <i data-lucide="user" class="w-5 h-5"></i>
                            </div>
                            <input id="name" name="name" type="text" required autofocus autocomplete="name"
                                class="pl-10 block w-full rounded-xl border-gray-200 bg-gray-50 focus:border-leaf focus:ring-leaf sm:text-sm py-3 transition-colors"
                                placeholder="John Doe" value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <p class="text-tomato text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-charcoal mb-1">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                            </div>
                            <input id="email" name="email" type="email" required autocomplete="username"
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
                            <input id="password" name="password" type="password" required autocomplete="new-password"
                                class="pl-10 block w-full rounded-xl border-gray-200 bg-gray-50 focus:border-leaf focus:ring-leaf sm:text-sm py-3 transition-colors"
                                placeholder="Minimal 8 karakter">
                        </div>
                        @error('password')
                            <p class="text-tomato text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-charcoal mb-1">Konfirmasi
                            Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate">
                                <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                autocomplete="new-password"
                                class="pl-10 block w-full rounded-xl border-gray-200 bg-gray-50 focus:border-leaf focus:ring-leaf sm:text-sm py-3 transition-colors"
                                placeholder="Ulangi password">
                        </div>
                        @error('password_confirmation')
                            <p class="text-tomato text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-coral hover:bg-orange-600 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-coral transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                        Daftar Sekarang
                    </button>
                </div>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-slate">Atau lanjutkan dengan</span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('google.login') }}"
                            class="w-full flex items-center justify-center gap-3 px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-white text-sm font-medium text-charcoal hover:bg-gray-50 transition-colors">
                            <svg class="h-5 w-5" aria-hidden="true" viewBox="0 0 24 24">
                                <path
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                    fill="#4285F4" />
                                <path
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                    fill="#34A853" />
                                <path
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                    fill="#FBBC05" />
                                <path
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                    fill="#EA4335" />
                            </svg>
                            Masuk dengan Google
                        </a>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <p class="text-sm text-slate">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-bold text-leaf hover:text-green-700 transition-colors">
                            Masuk disini
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
