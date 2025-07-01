<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-10 bg-green-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <img src="https://img.icons8.com/color/96/mosque.png" class="mx-auto mb-6" alt="Logo Kajian" />
            <h1 class="text-3xl font-bold text-green-800">Sistem Manajemen Kajian</h1>
            <p class="text-green-600 text-sm mb-10">Kelola event dan absensi kajian dengan mudah dan cepat</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 justify-center">
                <!-- Tambah Event -->
                <a href="{{route('event.create')}}"
                   class="bg-white border border-green-300 hover:border-green-500 shadow-md rounded-lg p-6 flex flex-col items-center text-center hover:shadow-lg transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <h3 class="text-lg font-semibold text-green-800">Tambah Event</h3>
                    <p class="text-sm text-gray-500">Buat event kajian baru</p>
                </a>

                <!-- Kelola Event -->
                <a href="{{route('event.manage')}}"
                   class="bg-white border border-green-300 hover:border-green-500 shadow-md rounded-lg p-6 flex flex-col items-center text-center hover:shadow-lg transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <h3 class="text-lg font-semibold text-green-800">Kelola Event</h3>
                    <p class="text-sm text-gray-500">Lihat dan ubah data event</p>
                </a>

                <!-- Scan Absensi -->
                <a href=""
                   class="bg-white border border-green-300 hover:border-green-500 shadow-md rounded-lg p-6 flex flex-col items-center text-center hover:shadow-lg transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h6v6H3V3zm0 12h6v6H3v-6zm12-12h6v6h-6V3zm0 12h6v6h-6v-6z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-green-800">Scan Absensi</h3>
                    <p class="text-sm text-gray-500">Absensi peserta via QR Code</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
