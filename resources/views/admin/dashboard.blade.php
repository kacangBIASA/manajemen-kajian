<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-100">Dashboard Admin</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="text-center mb-10">
            <img src="https://img.icons8.com/color/96/mosque.png" class="mx-auto mb-4 h-16 w-16" alt="Logo">
            <h1 class="text-3xl font-bold text-green-700 dark:text-green-400 tracking-tight">Tadzkirah</h1>
            <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Pengingat Kajian untuk Umat</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <a href="{{ route('event.create') }}"
                class="group bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 hover:border-green-400 dark:hover:border-green-600 rounded-xl p-6 flex flex-col items-center text-center shadow-sm hover:shadow-md transition">
                <div class="h-12 w-12 bg-green-50 dark:bg-green-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:bg-green-100 dark:group-hover:bg-green-900/50 transition">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100">Tambah Event</h3>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Buat event kajian baru</p>
            </a>

            <a href="{{ route('event.manage') }}"
                class="group bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 hover:border-green-400 dark:hover:border-green-600 rounded-xl p-6 flex flex-col items-center text-center shadow-sm hover:shadow-md transition">
                <div class="h-12 w-12 bg-green-50 dark:bg-green-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:bg-green-100 dark:group-hover:bg-green-900/50 transition">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100">Kelola Event</h3>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Lihat dan ubah data event</p>
            </a>

            <a href="{{ route('event.scan') }}"
                class="group bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 hover:border-green-400 dark:hover:border-green-600 rounded-xl p-6 flex flex-col items-center text-center shadow-sm hover:shadow-md transition">
                <div class="h-12 w-12 bg-green-50 dark:bg-green-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:bg-green-100 dark:group-hover:bg-green-900/50 transition">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h6v6H3V3zm0 12h6v6H3v-6zm12-12h6v6h-6V3zm0 12h6v6h-6v-6z"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100">Scan Absensi</h3>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Absensi peserta via QR Code</p>
            </a>
        </div>
    </div>
</x-app-layout>
