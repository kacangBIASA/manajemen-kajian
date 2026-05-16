<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo + Menu -->
            <div class="flex items-center gap-10">
                <!-- Logo -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-inner">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <span class="font-extrabold text-xl text-slate-800 tracking-tight">Kajian<span class="text-emerald-500">App</span></span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:flex h-16 items-center">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('event.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ request()->routeIs('event.create') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">
                        Tambah Event
                    </a>
                    <a href="{{ route('event.manage') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ request()->routeIs('event.manage') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">
                        Kelola
                    </a>
                    <a href="{{ route('event.scan') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ request()->routeIs('event.scan') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">
                        Scan
                    </a>
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <span class="text-sm font-semibold text-slate-700">{{ Auth::user()->name }}</span>
                </div>
                <div class="h-6 w-px bg-slate-200 mx-1"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex items-center text-slate-500 hover:text-red-600 font-medium text-sm transition-colors" type="submit">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>

            <!-- Hamburger (mobile) -->
            <div class="sm:hidden flex items-center">
                <button @click="open = ! open" class="text-slate-500 hover:text-slate-700 focus:outline-none transition-colors">
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
        class="sm:hidden hidden bg-white border-t border-slate-100 shadow-lg absolute w-full">
        <div class="px-4 pt-2 pb-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600' }}">Dashboard</a>
            <a href="{{ route('event.create') }}" class="block px-4 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('event.create') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600' }}">Tambah Event</a>
            <a href="{{ route('event.manage') }}" class="block px-4 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('event.manage') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600' }}">Kelola</a>
            <a href="{{ route('event.scan') }}" class="block px-4 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('event.scan') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600' }}">Scan</a>
        </div>

        <!-- Mobile User Info -->
        <div class="border-t border-slate-100 px-4 py-4 bg-slate-50">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="text-sm font-semibold text-slate-700">{{ Auth::user()->name }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>
