@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-beige flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="text-center mb-6">
                <i data-lucide="mail-check" class="mx-auto h-12 w-12 text-leaf"></i>
            </div>
            <h2 class="text-center text-3xl font-extrabold text-charcoal">
                Verifikasi Email Anda
            </h2>
            <p class="mt-4 text-center text-sm text-slate px-4">
                Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan mengklik
                link yang baru saja kami kirimkan ke email Anda?
            </p>
            <p class="mt-2 text-center text-sm text-slate">
                Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkan yang baru.
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-xl rounded-3xl sm:px-10 border border-gray-100">

                @if (session('status') == 'verification-link-sent')
                    <div
                        class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
                        <span>Link verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.</span>
                    </div>
                @endif

                <div class="flex flex-col gap-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-leaf hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-leaf transition-colors">
                            Kirim Ulang Email Verifikasi
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-gray-200 rounded-xl shadow-sm text-sm font-bold text-charcoal bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-colors">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
