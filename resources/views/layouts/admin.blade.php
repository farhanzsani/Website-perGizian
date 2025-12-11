<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CarePlate Admin') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-charcoal bg-eggshell antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        @include('components.admin.sidebar')

        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            @include('components.admin.header')

            <main class="w-full flex-grow p-6">
                @yield('content')
            </main>

            <footer class="bg-white p-4 text-center text-xs text-slate border-t border-gray-100">
                &copy; {{ date('Y') }} CarePlate Admin Panel.
            </footer>
        </div>

    </div>

</body>

</html>
