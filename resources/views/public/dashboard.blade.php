@extends('layouts.public')

@section('title', 'Daftar Kajian')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 font-sans">
    <!-- Hero Section -->
    <div class="relative py-16 mb-16 rounded-[2rem] overflow-hidden bg-gradient-to-br from-slate-900 via-emerald-900 to-slate-900 shadow-2xl">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-emerald-500/20 blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-teal-500/20 blur-3xl"></div>
        
        <div class="relative z-10 text-center px-4">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-4 drop-shadow-lg">
                Temukan <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 to-teal-300">Kajian</span> Anda
            </h1>
            <p class="text-lg md:text-xl text-emerald-100/80 max-w-2xl mx-auto font-light tracking-wide">
                Mari tingkatkan keilmuan dan ketaqwaan dengan menghadiri majelis ilmu. Daftar dengan mudah dan dapatkan tiket QR secara otomatis.
            </p>
        </div>
    </div>

    <!-- Event Grid -->
    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($events as $event)
            <div class="group relative bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] hover:-translate-y-2 transition-all duration-300 flex flex-col h-full overflow-hidden">
                
                <!-- Decorative Top Gradient Line -->
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-emerald-400 to-teal-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>

                <!-- Date & Time Badges -->
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold tracking-wide border border-emerald-100">
                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d M Y') }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-50 text-slate-600 text-xs font-semibold border border-slate-100">
                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $event->waktu }}
                    </span>
                </div>

                <!-- Title & Location -->
                <h2 class="text-2xl font-bold text-slate-800 mb-2 leading-tight group-hover:text-emerald-600 transition-colors duration-300">
                    {{ $event->nama }}
                </h2>
                
                <div class="flex items-start text-slate-500 text-sm mb-6 flex-grow">
                    <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="line-clamp-2 leading-relaxed">{{ $event->tempat }}</span>
                </div>

                <!-- Pricing & Action -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                    <div class="flex flex-col">
                        <span class="text-xs text-slate-400 font-medium uppercase tracking-wider mb-1">Tiket Masuk</span>
                        <span class="font-bold text-lg {{ $event->metode_pembayaran === \App\Models\Event::METODE_BERBAYAR ? 'text-slate-800' : 'text-emerald-600' }}">
                            @if ($event->metode_pembayaran === \App\Models\Event::METODE_BERBAYAR)
                                Rp{{ number_format($event->harga, 0, ',', '.') }}
                            @else
                                Gratis
                            @endif
                        </span>
                    </div>

                    <a href="{{ route('pendaftaran.form', $event->id) }}"
                        class="inline-flex items-center justify-center px-6 py-2.5 bg-slate-900 text-white font-medium text-sm rounded-xl hover:bg-emerald-600 transition-all duration-300 transform active:scale-95 shadow-md hover:shadow-emerald-500/30">
                        Daftar
                        <svg class="w-4 h-4 ml-2 -mr-1 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-100 text-emerald-500 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Belum ada jadwal kajian</h3>
                <p class="text-slate-500">Silakan kembali lagi nanti untuk melihat jadwal terbaru.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
