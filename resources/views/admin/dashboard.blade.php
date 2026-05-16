<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-[80vh] font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Welcome Header -->
            <div class="mb-12 relative rounded-3xl overflow-hidden bg-gradient-to-r from-emerald-600 to-teal-500 shadow-xl p-8 sm:p-12 text-center sm:text-left flex flex-col sm:flex-row items-center justify-between">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-32 h-32 bg-teal-300 opacity-20 rounded-full blur-xl"></div>
                
                <div class="relative z-10 text-white">
                    <h1 class="text-3xl sm:text-4xl font-extrabold mb-2 drop-shadow-md">Sistem Manajemen Kajian</h1>
                    <p class="text-emerald-50 text-lg font-medium opacity-90">Kelola event, pendaftaran, dan absensi kajian dalam satu pintu.</p>
                </div>
                
                <div class="relative z-10 mt-6 sm:mt-0 hidden sm:block">
                    <div class="w-24 h-24 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center border border-white/30 shadow-lg">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Dashboard Menu -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Tambah Event -->
                <a href="{{ route('event.create') }}" class="group relative bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 p-6 opacity-5 transform group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-24 h-24 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-emerald-600 transition-colors">Buat Event Baru</h3>
                    <p class="text-slate-500 text-sm">Tambahkan jadwal kajian baru untuk publikasi dan buka pendaftaran.</p>
                </a>

                <!-- Kelola Event -->
                <a href="{{ route('event.manage') }}" class="group relative bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 p-6 opacity-5 transform group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-24 h-24 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-500 group-hover:text-white transition-colors duration-300 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-blue-600 transition-colors">Kelola Event</h3>
                    <p class="text-slate-500 text-sm">Lihat, edit, atau hapus data event kajian yang sedang atau telah berjalan.</p>
                </a>

                <!-- Scan Absensi -->
                <a href="{{ route('event.scan') }}" class="group relative bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 p-6 opacity-5 transform group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-24 h-24 text-purple-500" fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h6v6H3V3zm0 12h6v6H3v-6zm12-12h6v6h-6V3zm0 12h6v6h-6v-6z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-purple-500 group-hover:text-white transition-colors duration-300 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-1m-1-4v4m-4-11h4m-4 4h4m-4-8v4m-4 8v4" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-purple-600 transition-colors">Scan Absensi</h3>
                    <p class="text-slate-500 text-sm">Buka kamera scanner untuk validasi kehadiran peserta via QR Code.</p>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
