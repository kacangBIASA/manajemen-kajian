@extends('layouts.public')

@section('title', 'Daftar Kajian — TAKHOBAR')

@section('content')
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Event Kajian</h2>
        <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Daftar kajian yang tersedia untuk umum</p>
    </div>

    @if($events->isEmpty())
        <div class="text-center py-16 text-gray-400 dark:text-gray-500">
            <svg class="mx-auto h-12 w-12 mb-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p>Belum ada event kajian tersedia.</p>
        </div>
    @else
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($events as $event)
                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm hover:shadow-md hover:border-green-300 dark:hover:border-green-700 transition overflow-hidden">
                    @if ($event->flyer)
                        <img src="{{ asset('storage/' . $event->flyer) }}" alt="Flyer"
                            class="w-full h-44 object-cover">
                    @endif
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <h3 class="font-semibold text-gray-800 dark:text-gray-100 text-base leading-snug">{{ $event->nama }}</h3>
                            <span class="shrink-0 px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $event->metode_pembayaran === 'Gratis'
                                    ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400'
                                    : 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400' }}">
                                {{ $event->metode_pembayaran === 'Gratis' ? 'Gratis' : 'Rp' . number_format($event->harga, 0, ',', '.') }}
                            </span>
                        </div>

                        @if ($event->pemateri)
                            <p class="text-sm font-medium text-green-700 dark:text-green-400 mb-2">{{ $event->pemateri }}</p>
                        @endif

                        <div class="space-y-1 text-xs text-gray-500 dark:text-gray-400">
                            <div class="flex items-center gap-1.5">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ \Carbon\Carbon::parse($event->tanggal)->isoFormat('dddd, D MMMM Y') }} · {{ \Illuminate\Support\Str::substr($event->waktu, 0, 5) }} WIB
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $event->tempat }}
                            </div>
                        </div>

                        <a href="{{ route('pendaftaran.form', $event->id) }}"
                            class="mt-4 block text-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition">
                            Daftar Sekarang
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
