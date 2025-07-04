@extends('layouts.public')

@section('title', 'Daftar Kajian')

@section('content')
    <h2 class="text-2xl font-bold mb-6 text-green-800 text-center">Event Kajian Terbuka</h2>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($events as $event)
            <div class="bg-white p-4 shadow rounded-lg">
                <h2 class="text-xl font-semibold">{{ $event->nama }}</h2>
                <p class="text-sm text-gray-600">{{ $event->tanggal }} - {{ $event->waktu }}</p>
                <p class="text-sm text-gray-600">Tempat: {{ $event->tempat }}</p>

                <p class="mt-2 font-medium text-green-700">
                    @if ($event->metode_pembayaran === 'Berbayar')
                        Biaya: Rp{{ number_format($event->harga, 0, ',', '.') }}
                    @else
                        Gratis
                    @endif
                </p>

                <a href="{{ route('pendaftaran.form', $event->id) }}"
                    class="mt-3 inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                    Daftar
                </a>
            </div>
        @endforeach
    </div>
@endsection
