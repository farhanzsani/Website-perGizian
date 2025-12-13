<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CarePlate Admin') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <style>
        /* Sembunyikan tombol upload file jika belum handle upload via Trix (Opsional) */
        .trix-button--icon-attach {
            display: none;
        }

        /* Ubah warna toolbar menjadi Leaf Green */
        .trix-button.trix-active {
            color: #2E9A62 !important;
        }

        /* Styling area editor */
        trix-editor {
            border-radius: 0.75rem;
            /* rounded-xl */
            border-color: #E5E7EB;
            /* gray-200 */
            min-height: 400px;
            background-color: #ffffff;
            /* bg-white */
            padding: 1rem;
        }

        /* Fokus state */
        trix-editor:focus {
            border-color: #2E9A62 !important;
            /* leaf */
            box-shadow: 0 0 0 1px #2E9A62 !important;
            outline: none;
        }

        /* Typography di dalam editor */
        .trix-content h1 {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 0.5em;
        }

        .trix-content ul {
            list-style-type: disc;
            margin-left: 1.5em;
        }

        .trix-content ol {
            list-style-type: decimal;
            margin-left: 1.5em;
        }

        .trix-content blockquote {
            border-left: 4px solid #2E9A62;
            padding-left: 1em;
            color: #6B7A7A;
            font-style: italic;
        }
    </style>

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

    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    @stack('scripts')
</body>

</html>
