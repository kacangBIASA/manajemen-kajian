<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KajianApp')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 font-sans text-slate-800 flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('dashboard.kajian') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-inner">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <span class="font-extrabold text-xl text-slate-800 tracking-tight">Kajian<span class="text-emerald-500">App</span></span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden sm:flex items-center gap-4">
                    <a href="{{ route('dashboard.kajian') }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors">Beranda</a>
                    <a href="{{ route('tiket.cari') }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors">Tiket Saya</a>
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold px-4 py-2 bg-emerald-50 text-emerald-700 rounded-lg hover:bg-emerald-100 transition-colors">Dashboard Admin</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800 transition-colors shadow-sm">Masuk Panitia</a>
                    @endauth
                </div>

                <!-- Hamburger (Mobile) -->
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
        <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden hidden bg-white border-t border-slate-100 shadow-lg absolute w-full">
            <div class="px-4 pt-2 pb-4 space-y-2">
                <a href="{{ route('dashboard.kajian') }}" class="block px-4 py-3 rounded-lg text-sm font-semibold text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                    Beranda
                </a>
                <a href="{{ route('tiket.cari') }}" class="block px-4 py-3 rounded-lg text-sm font-semibold text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                    Tiket Saya
                </a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-lg text-sm font-semibold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-colors">
                        Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-3 rounded-lg text-sm font-semibold bg-slate-900 text-white hover:bg-slate-800 transition-colors">
                        Masuk Panitia
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 w-full relative">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center text-sm py-8 bg-slate-900 text-slate-400 mt-auto border-t border-slate-800">
        <p class="font-medium text-slate-300 mb-1">&copy; {{ date('Y') }} Sistem Manajemen Kajian.</p>
        <p>Menghubungkan jamaah dengan majelis ilmu.</p>
    </footer>

</body>

</html>
