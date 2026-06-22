@extends('layouts.public')

@section('title', 'Tiket QR — TAKHOBAR')

@section('content')
    <div class="max-w-sm mx-auto">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm p-8 text-center">
            <div class="mb-5">
                <div class="h-12 w-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Pendaftaran Berhasil!</h2>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Atas nama</p>
                <p class="text-lg font-semibold text-green-700 dark:text-green-400 mt-0.5">{{ $pendaftar->nama }}</p>
            </div>

            <div class="mb-5 flex justify-center">
                {!! DNS2D::getBarcodeHTML($pendaftar->kode_qr, 'QRCODE', 6, 6) !!}
            </div>

            <div class="bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-lg px-4 py-3 mb-6">
                <p class="text-xs font-mono text-gray-500 dark:text-gray-400">{{ $pendaftar->kode_qr }}</p>
            </div>

            <p class="text-xs text-gray-400 dark:text-gray-500 mb-6">
                Screenshot QR ini sebagai tiket kehadiran. Tunjukkan ke panitia saat registrasi ulang.
            </p>

            <a href="{{ route('dashboard.kajian') }}"
                class="inline-block px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition">
                Kembali ke Daftar Kajian
            </a>
        </div>
    </div>
@endsection
