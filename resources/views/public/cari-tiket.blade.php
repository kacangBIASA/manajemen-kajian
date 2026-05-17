@extends('layouts.public')

@section('title', 'Cari Tiket Saya')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-xl w-full">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-black text-slate-800 tracking-tight mb-3">Cari Tiket <span class="text-emerald-500">Saya</span></h1>
            <p class="text-slate-500 text-base">Masukkan email yang Anda gunakan saat mendaftar untuk melihat kembali QR Code tiket Anda.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/40 p-8 border border-slate-100 mb-8 relative overflow-hidden">
            <!-- Decorative circle -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-50 rounded-full blur-2xl opacity-60"></div>
            
            <form action="{{ route('tiket.submit') }}" method="POST" class="relative">
                @csrf
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                        </div>
                        <input type="email" name="email" id="email" required placeholder="contoh@email.com" class="pl-11 w-full rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50 focus:bg-white transition-colors duration-200">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-emerald-500/30 text-base font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-300 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Cari Tiket
                </button>
            </form>
        </div>

        <!-- Hasil Pencarian -->
        @if(isset($pendaftarans))
            @if($pendaftarans->count() > 0)
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-slate-800 mb-4 px-2">Tiket Ditemukan ({{ $pendaftarans->count() }})</h3>
                    @foreach($pendaftarans as $tiket)
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 transition-all hover:shadow-md hover:border-emerald-100">
                            <div>
                                <h4 class="font-bold text-slate-800 text-lg">{{ $tiket->event->nama }}</h4>
                                <p class="text-sm text-slate-500">{{ \Carbon\Carbon::parse($tiket->event->tanggal)->translatedFormat('l, d F Y') }} &bull; {{ $tiket->event->waktu }}</p>
                                <p class="text-xs font-semibold mt-2 inline-block px-2.5 py-1 rounded-full {{ $tiket->status === 'hadir' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    Status: {{ ucfirst($tiket->status ?? 'Terdaftar') }}
                                </p>
                            </div>
                            <a href="{{ route('tiket.show', $tiket->kode_qr) }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-slate-900 text-white text-sm font-semibold rounded-xl hover:bg-slate-800 transition-colors w-full sm:w-auto">
                                Lihat QR Code
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-red-50 text-red-600 p-6 rounded-2xl border border-red-100 text-center">
                    <svg class="w-12 h-12 mx-auto mb-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="font-bold text-lg mb-1">Tiket Tidak Ditemukan</h3>
                    <p class="text-sm opacity-90">Kami tidak menemukan tiket yang terdaftar dengan email tersebut.</p>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
