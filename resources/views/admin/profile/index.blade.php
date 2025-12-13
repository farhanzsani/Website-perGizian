@extends('layouts.profile')

@section('content')
    <div class="space-y-6">

        <div class="relative px-4 sm:px-6 mt-10 pb-10">
            <div class="bg-white rounded-3xl shadow-xl p-6 sm:p-10 border border-gray-100">

                <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                    <div class="relative">
                        <img class="w-32 h-32 rounded-full border-4 border-white shadow-md object-cover"
                            src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=CFF4E1&color=2E9A62&size=128"
                            alt="{{ $user->name }}">
                        <div class="absolute bottom-2 right-2 bg-fresh w-6 h-6 rounded-full border-2 border-white"
                            title="Active"></div>
                    </div>

                    <div class="flex-1 w-full">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                            <div>
                                <h1 class="text-3xl font-bold text-charcoal">{{ $user->name }}</h1>
                                <div class="flex items-center gap-2 text-slate mt-1">
                                    <i data-lucide="mail" class="w-4 h-4"></i>
                                    <span>{{ $user->email }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-slate mt-1">
                                    <i data-lucide="calendar" class="w-4 h-4"></i>
                                    <span>Bergabung sejak {{ $user->created_at->format('d M Y') }}</span>
                                </div>
                            </div>

                            <a href="{{ route('admin.profile.edit') }}"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-leaf text-white font-semibold rounded-xl hover:bg-green-700 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                                <i data-lucide="edit-3" class="w-5 h-5"></i>
                                Edit Akun
                            </a>
                        </div>
                    </div>
                </div>

                <hr class="my-8 border-gray-100">
            </div>
        </div>
    </div>
@endsection
