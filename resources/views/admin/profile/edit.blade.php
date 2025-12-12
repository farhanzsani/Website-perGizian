@extends('layouts.profile')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">

        <a href="{{ route('admin.profile.index') }}"
            class="inline-flex items-center gap-2 text-slate hover:text-leaf transition-colors font-medium">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke Profile
        </a>

        <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100">
            <header class="mb-6">
                <h2 class="text-xl font-bold text-charcoal flex items-center gap-2">
                    <i data-lucide="user-cog" class="w-6 h-6 text-leaf"></i>
                    Informasi Profil
                </h2>
                <p class="mt-1 text-sm text-slate">
                    Perbarui informasi profil akun dan alamat email Anda.
                </p>
            </header>

            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('admin.profile.update') }}" class="space-y-6">
                @csrf
                @method('patch')

                <div>
                    <label for="name" class="block text-sm font-medium text-charcoal mb-1">Nama Lengkap</label>
                    <div class="relative">
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            autofocus autocomplete="name"
                            class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:border-leaf focus:ring-leaf sm:text-sm py-3 transition-colors pl-4">
                    </div>
                    @error('name')
                        <p class="text-tomato text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-charcoal mb-1">Email</label>
                    <div class="relative">
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            required autocomplete="username"
                            class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:border-leaf focus:ring-leaf sm:text-sm py-3 transition-colors pl-4">
                    </div>
                    @error('email')
                        <p class="text-tomato text-xs mt-1">{{ $message }}</p>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                        <div class="mt-2 p-4 bg-yellow-50 rounded-lg text-sm text-yellow-800">
                            <p>
                                Alamat email Anda belum diverifikasi.
                                <button form="send-verification"
                                    class="underline hover:text-yellow-900 font-bold focus:outline-none">
                                    Klik di sini untuk mengirim ulang email verifikasi.
                                </button>
                            </p>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-fresh">
                                    Tautan verifikasi baru telah dikirim ke alamat email Anda.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit"
                        class="px-6 py-2.5 bg-leaf text-white font-bold rounded-xl hover:bg-green-700 transition-all shadow-md">
                        Simpan Perubahan
                    </button>

                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-fresh font-medium flex items-center gap-1">
                            <i data-lucide="check" class="w-4 h-4"></i> Tersimpan.
                        </p>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100">
            <header class="mb-6">
                <h2 class="text-xl font-bold text-charcoal flex items-center gap-2">
                    <i data-lucide="lock" class="w-6 h-6 text-coral"></i>
                    Perbarui Password
                </h2>
                <p class="mt-1 text-sm text-slate">
                    Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.
                </p>
            </header>

            <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                @method('put')

                <div>
                    <label for="update_password_current_password"
                        class="block text-sm font-medium text-charcoal mb-1">Password Saat Ini</label>
                    <input type="password" name="current_password" id="update_password_current_password"
                        autocomplete="current-password"
                        class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:border-leaf focus:ring-leaf sm:text-sm py-3 transition-colors pl-4">
                    @error('current_password', 'updatePassword')
                        <p class="text-tomato text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="update_password_password" class="block text-sm font-medium text-charcoal mb-1">Password
                        Baru</label>
                    <input type="password" name="password" id="update_password_password" autocomplete="new-password"
                        class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:border-leaf focus:ring-leaf sm:text-sm py-3 transition-colors pl-4">
                    @error('password', 'updatePassword')
                        <p class="text-tomato text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="update_password_password_confirmation"
                        class="block text-sm font-medium text-charcoal mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="update_password_password_confirmation"
                        autocomplete="new-password"
                        class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:border-leaf focus:ring-leaf sm:text-sm py-3 transition-colors pl-4">
                    @error('password_confirmation', 'updatePassword')
                        <p class="text-tomato text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit"
                        class="px-6 py-2.5 bg-coral text-white font-bold rounded-xl hover:bg-orange-600 transition-all shadow-md">
                        Simpan Password
                    </button>

                    @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-fresh font-medium flex items-center gap-1">
                            <i data-lucide="check" class="w-4 h-4"></i> Tersimpan.
                        </p>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-red-50 p-8 rounded-3xl border border-red-100">
            <header class="mb-6">
                <h2 class="text-xl font-bold text-tomato flex items-center gap-2">
                    <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                    Hapus Akun
                </h2>
                <p class="mt-1 text-sm text-slate">
                    Setelah akun Anda dihapus, semua data akan hilang secara permanen. Tindakan ini tidak dapat dibatalkan.
                </p>
            </header>

            <div x-data="{ open: false }">
                <button @click="open = true"
                    class="px-6 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all shadow-md">
                    Hapus Akun Saya
                </button>

                <div x-show="open" style="display: none;" class="fixed inset-0 z-[60] overflow-y-auto"
                    aria-labelledby="modal-title" role="dialog" aria-modal="true">

                    <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="open = false"></div>

                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div x-show="open" x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                                @csrf
                                @method('delete')

                                <div class="sm:flex sm:items-start">
                                    <div
                                        class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
                                    </div>
                                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Hapus
                                            Akun Permanen?</h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                Apakah Anda yakin ingin menghapus akun? Masukkan password Anda untuk
                                                mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.
                                            </p>
                                        </div>
                                        <div class="mt-4">
                                            <label for="password_deletion" class="sr-only">Password</label>
                                            <input type="password" id="password_deletion" name="password"
                                                placeholder="Password Anda"
                                                class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-3">
                                            @error('password', 'userDeletion')
                                                <p class="text-tomato text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                    <button type="submit"
                                        class="inline-flex w-full justify-center rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                                        Ya, Hapus Akun
                                    </button>
                                    <button type="button" @click="open = false"
                                        class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
