@extends('layouts.public')

@section('title', 'Pendaftaran ' . $event->nama)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 font-sans">
    
    <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 p-8 sm:p-10 text-white relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-emerald-500/20 rounded-full blur-3xl"></div>
            <div class="relative z-10">
                <a href="{{ route('dashboard.kajian') }}" class="inline-flex items-center text-sm font-medium text-slate-300 hover:text-white transition-colors mb-6">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
                <h2 class="text-3xl font-extrabold tracking-tight mb-2">Form Pendaftaran</h2>
                <p class="text-slate-300 text-lg">Lengkapi data diri Anda untuk menghadiri kajian ini.</p>
            </div>
        </div>

        <!-- Event Summary Card -->
        <div class="px-8 sm:px-10 pt-8">
            <div class="bg-emerald-50 rounded-2xl p-6 border border-emerald-100 flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-gradient-to-b from-emerald-400 to-teal-500"></div>
                <div class="pl-4">
                    <h3 class="text-xl font-bold text-slate-800 mb-2">{{ $event->nama }}</h3>
                    <div class="space-y-1.5 text-sm text-slate-600">
                        <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d M Y') }} | {{ $event->waktu }}</p>
                        <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> {{ $event->tempat }}</p>
                    </div>
                </div>
                <div class="bg-white px-5 py-4 rounded-xl shadow-sm border border-slate-100 text-center shrink-0">
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tiket Masuk</span>
                    <span class="block text-xl font-black {{ $event->metode_pembayaran === \App\Models\Event::METODE_BERBAYAR ? 'text-slate-800' : 'text-emerald-600' }}">
                        @if ($event->metode_pembayaran === \App\Models\Event::METODE_BERBAYAR)
                            Rp{{ number_format($event->harga, 0, ',', '.') }}
                        @else
                            Gratis
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <form action="{{ route('pendaftaran.submit', $event->id) }}" method="POST" enctype="multipart/form-data" class="p-8 sm:p-10 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" required
                        class="block w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors shadow-sm py-2.5 px-4">
                </div>

                <!-- No HP -->
                <div>
                    <label for="no_hp" class="block text-sm font-semibold text-slate-700 mb-1.5">No WhatsApp/HP</label>
                    <input type="text" name="no_hp" id="no_hp" required
                        class="block w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors shadow-sm py-2.5 px-4">
                </div>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                <input type="email" name="email" id="email" required
                    class="block w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors shadow-sm py-2.5 px-4">
            </div>

            <!-- Alamat -->
            <div>
                <label for="alamat" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Domisili</label>
                <textarea name="alamat" id="alamat" rows="3" required
                    class="block w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors shadow-sm py-2.5 px-4"></textarea>
            </div>

            <!-- Bukti Bayar -->
            @if ($event->metode_pembayaran === \App\Models\Event::METODE_BERBAYAR)
                <div class="p-6 bg-slate-50 rounded-2xl border border-dashed border-slate-300">
                    <label for="bukti_pembayaran" class="block text-sm font-semibold text-slate-700 mb-2">Upload Bukti Transfer</label>
                    <p class="text-xs text-slate-500 mb-4">Format: JPG, PNG, PDF (Maks 2MB)</p>
                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" accept="image/*,application/pdf" required
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-100 file:text-emerald-700 hover:file:bg-emerald-200 transition-colors cursor-pointer">
                </div>
            @endif

            <div class="pt-6">
                <button type="submit" class="w-full flex items-center justify-center px-8 py-4 text-lg font-bold rounded-xl text-white bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 transform active:scale-[0.98]">
                    Selesaikan Pendaftaran
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
