<nav x-data="{ open: false }" class="bg-green-700 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo + Menu -->
            <div class="flex items-center gap-10">
                <!-- Logo -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-semibold text-xl">
                    <img src="https://img.icons8.com/color/48/mosque.png" class="h-8 w-8" alt="Mosque Icon" />
                    <span class="ml-2 font-semibold text-xl">Sistem Kajian</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:flex">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-white hover:underline">
                        Dashboard
                    </x-nav-link>
                    <x-nav-link :href="route('event.create')" :active="request()->routeIs('event.create')" class="text-white hover:underline">
                        Tambah Event
                    </x-nav-link>
                    <x-nav-link :href="route('event.manage')" :active="request()->routeIs('event.manage')" class="text-white hover:underline">
                        Kelola
                    </x-nav-link>
                    <x-nav-link :href="route('event.scan')" :active="request()->routeIs('event.scan')" class="text-white hover:underline">
                        Scan
                    </x-nav-link>
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center gap-4">
                <span class="text-sm">Halo, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-white text-green-700 px-3 py-1 rounded text-sm hover:bg-green-100" type="submit">
                        Logout
                    </button>
                </form>
            </div>

            <!-- Hamburger (mobile) -->
            <div class="sm:hidden flex items-center">
                <button @click="open = ! open" class="text-white focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{ 'block': open, 'hidden': !open }"
        class="sm:hidden hidden px-4 pt-2 pb-4 space-y-2 bg-green-600 text-white">
        <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">Dashboard</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('event.create')" :active="request()->routeIs('event.create')">Tambah Event</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('event.manage')" :active="request()->routeIs('event.manage')">Kelola</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('event.scan')" :active="request()->routeIs('event.scan')">Scan</x-responsive-nav-link>

        <!-- Mobile User Info -->
        <div class="border-t border-green-500 pt-3">
            <div class="text-sm mb-2">Halo, {{ Auth::user()->name }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    Logout
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>
