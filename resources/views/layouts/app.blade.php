<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Sistem Kajian') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-green-50 text-gray-800">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        @include('layouts.navigation')

        <!-- Page Header -->
        @if (isset($header))
            <header class="bg-white shadow mt-2">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Main Content -->
        <main class="flex-grow py-6">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-green-700 text-white text-center py-3 text-sm">
            © {{ date('Y') }} Sistem Manajemen Kajian – All rights reserved.
        </footer>
    </div>
</body>
</html>
