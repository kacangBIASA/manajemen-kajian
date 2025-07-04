@extends('layouts.public')

@section('title', 'Form Pendaftaran')

@section('content')
    <h2 class="text-2xl font-bold mb-6 text-green-800 text-center">Form Pendaftaran</h2>

    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow border border-green-100">
        <h3 class="text-lg font-semibold mb-4 text-green-700">{{ $event->nama }}</h3>
        <div class="mb-6 p-4 bg-gray-100 border-l-4 border-green-500">
            <h2 class="text-lg font-semibold">{{ $event->nama }}</h2>
            <p class="text-sm text-gray-700">Tanggal: {{ $event->tanggal }} | Waktu: {{ $event->waktu }}</p>
            <p class="text-sm text-gray-700">Tempat: {{ $event->tempat }}</p>
            <p class="text-sm mt-2 text-green-700 font-medium">
                Metode Pembayaran: {{ $event->metode_pembayaran }}
                @if ($event->metode_pembayaran === 'Berbayar')
                    <br>Biaya: Rp{{ number_format($event->harga, 0, ',', '.') }}
                @endif
            </p>
        </div>
        <form action="{{ route('pendaftaran.submit', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nama -->
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>

            <!-- Alamat -->
            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="alamat" id="alamat" rows="2" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500"></textarea>
            </div>

            <!-- No HP -->
            <div class="mb-4">
                <label for="no_hp" class="block text-sm font-medium text-gray-700">No HP</label>
                <input type="text" name="no_hp" id="no_hp" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>

            <!-- Bukti Bayar (hanya jika berbayar) -->
            @if ($event->metode_pembayaran === 'Berbayar')
                <div class="mb-4">
                    <label for="bukti_pembayaran" class="block text-sm font-medium text-gray-700">Upload Bukti
                        Pembayaran</label>
                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" accept="image/*,application/pdf"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>
            @endif

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition w-full">
                Kirim Pendaftaran
            </button>
        </form>
    </div>
@endsection
