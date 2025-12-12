@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-beige flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-charcoal">
                Konfirmasi Password
            </h2>
            <p class="mt-2 text-center text-sm text-slate">
                Ini adalah area aman aplikasi. Harap konfirmasi password Anda sebelum melanjutkan.
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-xl rounded-3xl sm:px-10 border border-gray-100">
                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="password" class="block text-sm font-bold text-charcoal mb-1">Password</label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" required autocomplete="current-password"
                                class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-leaf focus:border-leaf sm:text-sm">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-tomato">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-leaf hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-leaf transition-colors">
                            Konfirmasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
