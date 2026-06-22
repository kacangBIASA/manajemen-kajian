<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('event.manage') }}" class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-100 truncate">{{ $event->nama }}</h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

        {{-- Metadata Event --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm overflow-hidden">
            <div class="flex flex-col sm:flex-row">
                @if ($event->flyer)
                    <div class="sm:w-48 shrink-0">
                        <img src="{{ asset('storage/' . $event->flyer) }}" alt="Flyer"
                            class="w-full h-full object-cover object-top sm:max-h-48">
                    </div>
                @endif
                <div class="p-5 flex-1">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-1">{{ $event->nama }}</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1.5 text-sm text-gray-600 dark:text-gray-400 mt-3">
                        @if ($event->pemateri)
                            <div><span class="text-gray-400 dark:text-gray-500">Pemateri:</span> <span class="font-medium text-gray-800 dark:text-gray-200">{{ $event->pemateri }}</span></div>
                        @endif
                        @if ($event->moderator)
                            <div><span class="text-gray-400 dark:text-gray-500">Moderator:</span> <span class="font-medium text-gray-800 dark:text-gray-200">{{ $event->moderator }}</span></div>
                        @endif
                        <div><span class="text-gray-400 dark:text-gray-500">Tanggal:</span> {{ \Carbon\Carbon::parse($event->tanggal)->isoFormat('dddd, D MMMM Y') }}</div>
                        <div><span class="text-gray-400 dark:text-gray-500">Waktu:</span> {{ \Illuminate\Support\Str::substr($event->waktu, 0, 5) }} WIB</div>
                        <div class="sm:col-span-2"><span class="text-gray-400 dark:text-gray-500">Tempat:</span> {{ $event->tempat }}</div>
                        <div>
                            <span class="text-gray-400 dark:text-gray-500">Pembayaran:</span>
                            <span class="ml-1 px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $event->metode_pembayaran === 'Gratis' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400' }}">
                                {{ $event->metode_pembayaran === 'Gratis' ? 'Gratis' : 'Rp' . number_format($event->harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistik --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 text-center shadow-sm">
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $peserta->count() }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Total Pendaftar</p>
            </div>
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 text-center shadow-sm">
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $totalHadir }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Hadir</p>
            </div>
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 text-center shadow-sm">
                <p class="text-2xl font-bold text-amber-500 dark:text-amber-400">{{ $totalBelum }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Belum Hadir</p>
            </div>
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 text-center shadow-sm">
                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">Rp{{ number_format($totalInfaq, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Total Infaq</p>
            </div>
        </div>

        {{-- Tabel Peserta --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Daftar Peserta</h3>
                <span class="text-xs text-gray-400 dark:text-gray-500">{{ $peserta->count() }} orang terdaftar</span>
            </div>

            @if ($peserta->isEmpty())
                <div class="py-12 text-center text-gray-400 dark:text-gray-500 text-sm">
                    Belum ada peserta yang mendaftar.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
                                <th class="text-left px-4 py-3 font-semibold text-gray-500 dark:text-gray-400">#</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-500 dark:text-gray-400">Nama</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-500 dark:text-gray-400">No HP</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-500 dark:text-gray-400">Alamat</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-500 dark:text-gray-400">Motivasi</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-500 dark:text-gray-400">Infaq</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-500 dark:text-gray-400">Bukti Infaq</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-500 dark:text-gray-400">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach ($peserta as $i => $p)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition">
                                    <td class="px-4 py-3 text-gray-400 dark:text-gray-500">{{ $i + 1 }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-800 dark:text-gray-100">{{ $p->nama }}</td>
                                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $p->no_hp }}</td>
                                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400 max-w-[160px] truncate">{{ $p->alamat }}</td>
                                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400 max-w-[160px]">
                                        @if ($p->motivasi_kajian)
                                            <span class="truncate block" title="{{ $p->motivasi_kajian }}">{{ \Illuminate\Support\Str::limit($p->motivasi_kajian, 40) }}</span>
                                        @else
                                            <span class="text-gray-300 dark:text-gray-600">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($p->infaq_nominal)
                                            <span class="text-blue-600 dark:text-blue-400 font-medium">Rp{{ number_format($p->infaq_nominal, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-gray-300 dark:text-gray-600">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($p->bukti_infaq)
                                            <a href="{{ asset('storage/' . $p->bukti_infaq) }}" target="_blank"
                                                class="text-xs text-blue-500 dark:text-blue-400 hover:underline">Lihat</a>
                                        @else
                                            <span class="text-gray-300 dark:text-gray-600">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                            {{ $p->status === 'Hadir'
                                                ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400'
                                                : 'bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400' }}">
                                            {{ $p->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
