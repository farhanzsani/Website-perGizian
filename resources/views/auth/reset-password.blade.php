@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-beige flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-charcoal">
                Buat Password Baru
            </h2>
            <p class="mt-2 text-center text-sm text-slate">
                Silakan masukkan password baru untuk akun Anda.
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-xl rounded-3xl sm:px-10 border border-gray-100">
                <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div>
                        <label for="email" class="block text-sm font-bold text-charcoal mb-1">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}"
                            required autofocus
                            class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-leaf focus:border-leaf sm:text-sm bg-gray-50 text-gray-500"
                            readonly>
                        @error('email')
                            <p class="mt-2 text-sm text-tomato">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-charcoal mb-1">Password Baru</label>
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                            class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-leaf focus:border-leaf sm:text-sm">
                        @error('password')
                            <p class="mt-2 text-sm text-tomato">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-charcoal mb-1">Konfirmasi
                            Password Baru</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            autocomplete="new-password"
                            class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-leaf focus:border-leaf sm:text-sm">
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-tomato">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-leaf hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-leaf transition-colors">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
