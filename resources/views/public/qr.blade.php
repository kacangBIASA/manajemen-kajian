@extends('layouts.public')

@section('title', 'Tiket QR')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow text-center border">
        <h2 class="text-xl font-bold text-green-700 mb-3">Pendaftaran Berhasil</h2>
        <p class="mb-1 text-gray-700">Atas nama:</p>
        <p class="text-lg font-semibold text-green-800 mb-3">{{ $pendaftar->nama }}</p>

        <div class="mb-4">
            {!! DNS2D::getBarcodeHTML($pendaftar->kode_qr, 'QRCODE', 6, 6) !!}
        </div>

        <p class="text-sm text-gray-500">Silakan screenshot QR ini sebagai tiket untuk kehadiran.</p>

        <a href="{{ route('dashboard.kajian') }}" class="mt-6 inline-block text-green-700 text-sm hover:underline">
            Kembali ke Daftar Kajian
        </a>
    </div>
@endsection
