@extends('layouts.public')

@section('title', 'Form Pendaftaran — ' . $event->nama)

@section('content')
    <div class="max-w-xl mx-auto">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm overflow-hidden">

            @if ($event->flyer)
                <img src="{{ asset('storage/' . $event->flyer) }}" alt="Flyer {{ $event->nama }}"
                    class="w-full object-cover max-h-72">
            @endif

            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-1">{{ $event->nama }}</h2>

                @if ($event->pemateri)
                    <p class="text-sm font-medium text-green-700 dark:text-green-400 mb-3">{{ $event->pemateri }}</p>
                @endif

                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 mb-6 space-y-1.5 text-sm text-gray-600 dark:text-gray-400 border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-green-600 dark:text-green-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($event->tanggal)->isoFormat('dddd, D MMMM Y') }} · {{ \Illuminate\Support\Str::substr($event->waktu, 0, 5) }} WIB
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-green-600 dark:text-green-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $event->tempat }}
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-green-600 dark:text-green-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        @if ($event->metode_pembayaran === 'Berbayar')
                            Berbayar — Rp{{ number_format($event->harga, 0, ',', '.') }}
                        @else
                            Gratis
                        @endif
                    </div>
                </div>

                <form action="{{ route('pendaftaran.submit', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama" required
                            class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat</label>
                        <textarea name="alamat" rows="2" required
                            class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition resize-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No HP</label>
                        <input type="text" name="no_hp" required
                            class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" name="email" required
                            class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                    </div>

                    @if ($event->metode_pembayaran === 'Berbayar')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Bukti Pembayaran</label>
                            <input type="file" name="bukti_pembayaran" accept="image/*,application/pdf" required
                                class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-50 dark:file:bg-green-900/30 file:text-green-700 dark:file:text-green-400 hover:file:bg-green-100 transition">
                        </div>
                    @endif

                    <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-2.5 rounded-lg text-sm font-semibold transition mt-2">
                        Kirim Pendaftaran
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
