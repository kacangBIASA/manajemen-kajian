<x-panitia-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('panitia.dashboard') }}"
                class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-100">{{ $event->nama }}</h2>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                    {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d M Y') }} · {{ $event->waktu }} · {{ $event->tempat }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 py-8 space-y-6" x-data="detailPanitia()">

        @if (session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-lg px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Action buttons --}}
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('panitia.event.scan', $event->id) }}"
                class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h6v6H3V3zm0 12h6v6H3v-6zm12-12h6v6h-6V3zm0 12h6v6h-6v-6z"/>
                </svg>
                Scan QR Absensi
            </a>
        </div>

        {{-- Stat cards --}}
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 text-center shadow-sm">
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $peserta->count() }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Total Peserta</p>
            </div>
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 text-center shadow-sm">
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $totalHadir }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Hadir</p>
            </div>
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 text-center shadow-sm">
                <p class="text-2xl font-bold text-amber-500 dark:text-amber-400">{{ $totalBelum }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Belum Hadir</p>
            </div>
        </div>

        {{-- Daftar peserta --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between gap-4 flex-wrap">
                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Daftar Peserta</h3>
                {{-- Filter tabs --}}
                <div class="flex rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden text-xs font-medium">
                    <button @click="filter = 'semua'"
                        :class="filter === 'semua' ? 'bg-teal-600 text-white' : 'bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800'"
                        class="px-3 py-1.5 transition">Semua</button>
                    <button @click="filter = 'hadir'"
                        :class="filter === 'hadir' ? 'bg-green-600 text-white' : 'bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800'"
                        class="px-3 py-1.5 border-l border-gray-200 dark:border-gray-700 transition">Hadir</button>
                    <button @click="filter = 'belum'"
                        :class="filter === 'belum' ? 'bg-amber-500 text-white' : 'bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800'"
                        class="px-3 py-1.5 border-l border-gray-200 dark:border-gray-700 transition">Belum Hadir</button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wide border-b border-gray-100 dark:border-gray-800">
                            <th class="px-5 py-3">#</th>
                            <th class="px-5 py-3">Nama</th>
                            <th class="px-5 py-3">No. HP</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Discan Oleh</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($peserta as $index => $p)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition"
                                x-show="filter === 'semua' || (filter === 'hadir' && '{{ $p->status }}' === 'Hadir') || (filter === 'belum' && '{{ $p->status }}' !== 'Hadir')">
                                <td class="px-5 py-3 text-gray-400 dark:text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-5 py-3 font-medium text-gray-800 dark:text-gray-100">{{ $p->nama }}</td>
                                <td class="px-5 py-3 text-gray-500 dark:text-gray-400">{{ $p->no_hp }}</td>
                                <td class="px-5 py-3">
                                    @if ($p->status === 'Hadir')
                                        <span class="inline-flex items-center gap-1 bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-medium px-2.5 py-1 rounded-full">
                                            <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                            Hadir
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 text-xs font-medium px-2.5 py-1 rounded-full">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                                            Belum Hadir
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-gray-500 dark:text-gray-400">
                                    @if ($p->status === 'Hadir' && $p->scanner)
                                        <span class="text-xs">{{ $p->scanner->name }}</span>
                                        @if ($p->scanned_at)
                                            <br><span class="text-gray-400 dark:text-gray-500 text-xs">{{ $p->scanned_at->format('H:i') }}</span>
                                        @endif
                                    @else
                                        <span class="text-gray-300 dark:text-gray-600">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($peserta->isEmpty())
                    <div class="py-12 text-center text-sm text-gray-400 dark:text-gray-500">
                        Belum ada peserta yang mendaftar.
                    </div>
                @endif
            </div>
        </div>

    </div>

    <script>
        function detailPanitia() {
            return {
                filter: 'semua',
            };
        }
    </script>
</x-panitia-layout>
