<x-panitia-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-100">Dashboard Panitia</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 py-8">

        {{-- Greeting --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                Assalamu'alaikum, {{ Auth::user()->name }} 👋
            </h1>
            <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">
                Berikut daftar kajian yang kamu ditugaskan.
            </p>
        </div>

        @if ($events->isEmpty())
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-12 text-center shadow-sm">
                <div class="h-16 w-16 bg-teal-50 dark:bg-teal-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada kajian yang ditugaskan.</p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Hubungi admin untuk mendapatkan penugasan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                @foreach ($events as $event)
                    @php
                        $isToday = $event->tanggal === $today;
                        $isPast = $event->tanggal < $today;
                    @endphp

                    <div class="relative bg-white dark:bg-gray-900 border {{ $isToday ? 'border-teal-400 dark:border-teal-600 ring-1 ring-teal-400 dark:ring-teal-600' : 'border-gray-200 dark:border-gray-800' }} rounded-xl shadow-sm hover:shadow-md transition overflow-hidden">

                        {{-- Today badge --}}
                        @if ($isToday)
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center gap-1 bg-teal-500 text-white text-xs font-bold px-2.5 py-1 rounded-full animate-pulse">
                                    🕌 Hari Ini!
                                </span>
                            </div>
                        @endif

                        <div class="p-5">
                            {{-- Tipe badge --}}
                            <div class="flex items-center gap-2 mb-3">
                                @if ($event->tipe === 'online')
                                    <span class="inline-flex items-center gap-1 text-xs font-medium bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 px-2 py-0.5 rounded-full">
                                        🌐 Online
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 px-2 py-0.5 rounded-full">
                                        📍 Offline
                                    </span>
                                @endif
                                @if ($isPast && !$isToday)
                                    <span class="text-xs text-gray-400 dark:text-gray-500">Selesai</span>
                                @endif
                            </div>

                            <h3 class="font-bold text-gray-800 dark:text-gray-100 text-base leading-snug mb-1">
                                {{ $event->nama }}
                            </h3>
                            @if ($event->pemateri)
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                                    <span class="font-medium">Pemateri:</span> {{ $event->pemateri }}
                                </p>
                            @endif
                            <div class="flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 mt-2">
                                <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d M Y') }}
                                @if ($event->waktu)
                                    <span class="text-gray-300 dark:text-gray-600">·</span>
                                    {{ $event->waktu }}
                                @endif
                            </div>
                            <div class="flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 mt-1">
                                <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $event->tempat }}
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="border-t border-gray-100 dark:border-gray-800 px-5 py-3 flex items-center gap-2 bg-gray-50 dark:bg-gray-900/50">
                            <a href="{{ route('panitia.event.detail', $event->id) }}"
                                class="flex-1 text-center py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold rounded-lg transition">
                                Detail
                            </a>
                            <a href="{{ route('panitia.event.scan', $event->id) }}"
                                class="flex-1 text-center py-2 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 text-xs font-semibold rounded-lg transition">
                                Scan QR
                            </a>
                            <a href="{{ route('panitia.event.infaq', $event->id) }}"
                                class="flex-1 text-center py-2 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 text-xs font-semibold rounded-lg transition">
                                Catat Infaq
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-panitia-layout>
