<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Tadzkirah') }} — Panitia</title>

    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;500;600;700&display=swap">

    <!-- Anti-flash dark mode -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Nunito', 'sans-serif'] },
                }
            }
        }
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Nunito', sans-serif; }
        .transition-theme { transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease; }
    </style>
</head>
<body class="transition-theme font-sans antialiased bg-gray-50 dark:bg-gray-950 text-gray-800 dark:text-gray-100">
    <div class="min-h-screen flex flex-col">
        @include('layouts.panitia-nav')

        @if (isset($header))
            <header class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main class="flex-grow py-6">
            {{ $slot }}
        </main>

        <footer class="bg-teal-700 dark:bg-gray-900 border-t border-teal-800 dark:border-gray-800 text-white text-center py-3 text-sm">
            © {{ date('Y') }} Tadzkirah — Portal Panitia
        </footer>
    </div>
</body>
</html>
