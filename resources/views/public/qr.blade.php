@extends('layouts.public')

@section('title', 'Tiket Elektronik')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-md w-full bg-white rounded-[2rem] shadow-[0_20px_50px_rgb(0,0,0,0.1)] border border-slate-100 overflow-hidden relative text-center">
        
        <!-- Decorative Header -->
        <div class="h-32 bg-gradient-to-br from-emerald-500 to-teal-600 relative flex items-center justify-center">
            <div class="absolute -bottom-8 w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </div>

        <div class="px-8 pt-12 pb-8">
            <h2 class="text-2xl font-black text-slate-800 mb-1">Pendaftaran Berhasil!</h2>
            <p class="text-slate-500 text-sm mb-6">Berikut adalah tiket elektronik Anda.</p>
            
            <div class="bg-slate-50 rounded-2xl p-4 mb-8 border border-slate-100">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-1">Nama Peserta</p>
                <p class="text-lg font-bold text-slate-800">{{ $pendaftar->nama }}</p>
            </div>

            <!-- QR Code -->
            <div class="inline-block p-4 bg-white rounded-2xl shadow-sm border border-slate-100 mb-6 relative">
                <!-- Corner Decorations -->
                <div class="absolute top-0 left-0 w-4 h-4 border-t-4 border-l-4 border-emerald-500 rounded-tl-lg"></div>
                <div class="absolute top-0 right-0 w-4 h-4 border-t-4 border-r-4 border-emerald-500 rounded-tr-lg"></div>
                <div class="absolute bottom-0 left-0 w-4 h-4 border-b-4 border-l-4 border-emerald-500 rounded-bl-lg"></div>
                <div class="absolute bottom-0 right-0 w-4 h-4 border-b-4 border-r-4 border-emerald-500 rounded-br-lg"></div>
                
                <div class="overflow-hidden">
                    {!! DNS2D::getBarcodeHTML($pendaftar->kode_qr, 'QRCODE', 6, 6) !!}
                </div>
            </div>

            <p class="text-sm font-medium text-slate-500 mb-8 max-w-[250px] mx-auto">
                Silakan <span class="text-slate-800 font-bold">screenshot halaman ini</span> dan tunjukkan kepada panitia saat kedatangan.
            </p>

            <a href="{{ route('dashboard.kajian') }}" class="inline-flex items-center justify-center w-full px-6 py-3 border-2 border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 hover:border-slate-300 transition-all duration-300 active:scale-95">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
