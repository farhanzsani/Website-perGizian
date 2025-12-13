<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CarePlate') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        .trix-content {
            font-family: 'Figtree', sans-serif;
            color: #374151;
            /* gray-700 */
        }

        /* Heading */
        .trix-content h1 {
            font-size: 2.25rem;
            font-weight: 800;
            color: #243233;
            margin-top: 2rem;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .trix-content h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #243233;
            margin-top: 1.75rem;
            margin-bottom: 0.75rem;
        }

        .trix-content h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2E9A62;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }

        /* Paragraph & Text */
        .trix-content p {
            margin-bottom: 1.25rem;
            line-height: 1.8;
        }

        .trix-content strong {
            font-weight: 700;
            color: #111827;
        }

        .trix-content em {
            font-style: italic;
            color: #4B5563;
        }

        .trix-content a {
            color: #2E9A62;
            text-decoration: underline;
            text-underline-offset: 4px;
            font-weight: 600;
            transition: color 0.2s;
        }

        .trix-content a:hover {
            color: #1f6b43;
        }

        /* Lists */
        .trix-content ul {
            list-style-type: disc;
            padding-left: 1.5rem;
            margin-bottom: 1.25rem;
        }

        .trix-content ol {
            list-style-type: decimal;
            padding-left: 1.5rem;
            margin-bottom: 1.25rem;
        }

        .trix-content li {
            margin-bottom: 0.5rem;
        }

        /* Blockquote */
        .trix-content blockquote {
            border-left: 4px solid #2E9A62;
            padding-left: 1.25rem;
            margin: 1.5rem 0;
            font-style: italic;
            color: #6B7A7A;
            background-color: #F3F7F4;
            /* eggshell */
            padding: 1.5rem;
            border-radius: 0 0.75rem 0.75rem 0;
        }

        /* Images */
        .trix-content img {
            border-radius: 1rem;
            margin: 2rem 0;
            width: 100%;
            height: auto;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Code Block */
        .trix-content pre {
            background-color: #1F2937;
            color: #F3F4F6;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin-bottom: 1.25rem;
            font-family: monospace;
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .scrollbar-hide {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-charcoal bg-white antialiased flex flex-col min-h-screen">

    @include('components.navbar')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('components.footer')

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>
