<nav x-data="{ open: false }" class="bg-green-700 dark:bg-gray-900 border-b border-green-800 dark:border-gray-800 text-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo + Menu -->
            <div class="flex items-center gap-8">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-bold text-lg tracking-tight">
                    <img src="https://img.icons8.com/color/48/mosque.png" class="h-7 w-7" alt="Logo" />
                    <span>TAKHOBAR</span>
                </a>

                <div class="hidden space-x-1 sm:flex">
                    <a href="{{ route('admin.dashboard') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium transition
                               {{ request()->routeIs('admin.dashboard') ? 'bg-green-800 dark:bg-gray-700' : 'hover:bg-green-600 dark:hover:bg-gray-700' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('event.create') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium transition
                               {{ request()->routeIs('event.create') ? 'bg-green-800 dark:bg-gray-700' : 'hover:bg-green-600 dark:hover:bg-gray-700' }}">
                        Tambah Event
                    </a>
                    <a href="{{ route('event.manage') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium transition
                               {{ request()->routeIs('event.manage') ? 'bg-green-800 dark:bg-gray-700' : 'hover:bg-green-600 dark:hover:bg-gray-700' }}">
                        Kelola
                    </a>
                    <a href="{{ route('event.scan') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium transition
                               {{ request()->routeIs('event.scan') ? 'bg-green-800 dark:bg-gray-700' : 'hover:bg-green-600 dark:hover:bg-gray-700' }}">
                        Scan
                    </a>
                </div>
            </div>

            <!-- Right side -->
            <div class="hidden sm:flex sm:items-center gap-3">
                <!-- Dark mode toggle -->
                <button onclick="toggleTheme()" id="theme-toggle"
                    class="p-2 rounded-md hover:bg-green-600 dark:hover:bg-gray-700 transition focus:outline-none"
                    title="Toggle dark/light mode">
                    <!-- Sun icon (show in dark mode) -->
                    <svg id="icon-sun" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    <!-- Moon icon (show in light mode) -->
                    <svg id="icon-moon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"/>
                    </svg>
                </button>

                <span class="text-sm text-green-200 dark:text-gray-400">{{ Auth::user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="px-3 py-1.5 bg-white/10 hover:bg-white/20 rounded-md text-sm font-medium transition">
                        Logout
                    </button>
                </form>
            </div>

            <!-- Hamburger -->
            <div class="sm:hidden flex items-center gap-2">
                <button onclick="toggleTheme()" class="p-2 rounded-md hover:bg-green-600 transition">
                    <svg id="icon-sun-mobile" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    <svg id="icon-moon-mobile" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"/>
                    </svg>
                </button>
                <button @click="open = !open" class="text-white focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden hidden border-t border-green-600 dark:border-gray-700">
        <div class="px-3 py-2 space-y-1 bg-green-700 dark:bg-gray-900">
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-sm hover:bg-green-600 dark:hover:bg-gray-700">Dashboard</a>
            <a href="{{ route('event.create') }}" class="block px-3 py-2 rounded-md text-sm hover:bg-green-600 dark:hover:bg-gray-700">Tambah Event</a>
            <a href="{{ route('event.manage') }}" class="block px-3 py-2 rounded-md text-sm hover:bg-green-600 dark:hover:bg-gray-700">Kelola</a>
            <a href="{{ route('event.scan') }}" class="block px-3 py-2 rounded-md text-sm hover:bg-green-600 dark:hover:bg-gray-700">Scan</a>
            <div class="border-t border-green-600 dark:border-gray-700 pt-2 mt-2">
                <p class="px-3 text-xs text-green-300 dark:text-gray-400 mb-1">{{ Auth::user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-sm hover:bg-green-600 dark:hover:bg-gray-700">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    function toggleTheme() {
        const html = document.documentElement;
        const isDark = html.classList.toggle('dark');
        localStorage.theme = isDark ? 'dark' : 'light';
        updateIcons(isDark);
    }

    function updateIcons(isDark) {
        const sun = document.getElementById('icon-sun');
        const moon = document.getElementById('icon-moon');
        const sunM = document.getElementById('icon-sun-mobile');
        const moonM = document.getElementById('icon-moon-mobile');
        if (isDark) {
            sun?.classList.remove('hidden');
            moon?.classList.add('hidden');
            sunM?.classList.remove('hidden');
            moonM?.classList.add('hidden');
        } else {
            sun?.classList.add('hidden');
            moon?.classList.remove('hidden');
            sunM?.classList.add('hidden');
            moonM?.classList.remove('hidden');
        }
    }

    updateIcons(document.documentElement.classList.contains('dark'));
</script>
