<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TAKHOBAR')</title>

    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;500;600;700&display=swap">

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { fontFamily: { sans: ['Nunito', 'sans-serif'] } } }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Nunito', sans-serif; transition: background-color 0.2s, color 0.2s; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-950 font-sans text-gray-800 dark:text-gray-100 flex flex-col min-h-screen">

    <nav class="bg-green-700 dark:bg-gray-900 border-b border-green-800 dark:border-gray-800 text-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('dashboard.kajian') }}" class="flex items-center gap-2 font-bold text-lg">
                <img src="https://img.icons8.com/color/48/mosque.png" class="h-7 w-7" alt="Logo" />
                <span>TAKHOBAR</span>
            </a>
            <div class="flex items-center gap-3">
                <button onclick="toggleTheme()" class="p-2 rounded-md hover:bg-green-600 dark:hover:bg-gray-700 transition focus:outline-none">
                    <svg id="icon-sun" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    <svg id="icon-moon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"/>
                    </svg>
                </button>
                <a href="{{ route('dashboard.kajian') }}" class="text-sm hover:text-green-200 transition">Home</a>
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-7xl mx-auto w-full py-8 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <footer class="text-center text-sm py-4 bg-green-700 dark:bg-gray-900 border-t border-green-800 dark:border-gray-800 text-white">
        &copy; {{ date('Y') }} TAKHOBAR — Untuk umat, dari umat.
    </footer>

    <script>
        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.theme = isDark ? 'dark' : 'light';
            updateIcons(isDark);
        }
        function updateIcons(isDark) {
            const sun = document.getElementById('icon-sun');
            const moon = document.getElementById('icon-moon');
            if (isDark) { sun?.classList.remove('hidden'); moon?.classList.add('hidden'); }
            else { sun?.classList.add('hidden'); moon?.classList.remove('hidden'); }
        }
        updateIcons(document.documentElement.classList.contains('dark'));
    </script>
</body>
</html>
