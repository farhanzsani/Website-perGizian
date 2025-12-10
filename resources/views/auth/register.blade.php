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
