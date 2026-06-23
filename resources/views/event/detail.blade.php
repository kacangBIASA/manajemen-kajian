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

    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6" x-data="detailPage()">

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
                <p class="text-xs text-gray-300 dark:text-gray-600 mt-0.5">
                    Peserta Rp{{ number_format($totalInfaqPeserta, 0, ',', '.') }} + Panitia Rp{{ number_format($totalInfaqPanitia, 0, ',', '.') }}
                </p>
            </div>
        </div>

        {{-- Panitia yang Ditugaskan --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Panitia Ditugaskan</h3>
                @if (session('success'))
                    <span class="text-xs text-green-600 dark:text-green-400">{{ session('success') }}</span>
                @endif
            </div>

            <div class="flex flex-wrap gap-2 mb-4">
                @forelse ($event->panitias as $pan)
                    <div class="flex items-center gap-2 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg px-3 py-1.5">
                        <span class="text-sm font-medium text-green-800 dark:text-green-300">{{ $pan->name }}</span>
                        <form action="{{ route('event.remove.panitia', [$event->id, $pan->id]) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-green-400 hover:text-red-500 transition ml-1" title="Lepas panitia">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 dark:text-gray-500">Belum ada panitia ditugaskan.</p>
                @endforelse
            </div>

            {{-- Assign panitia baru --}}
            @php $tersedia = $semuaPanitia->whereNotIn('id', $event->panitias->pluck('id')); @endphp
            @if ($tersedia->isNotEmpty())
                <form action="{{ route('event.assign.panitia', $event->id) }}" method="POST" class="flex gap-2">
                    @csrf
                    <select name="panitia_id"
                        class="flex-1 border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                        @foreach ($tersedia as $pan)
                            <option value="{{ $pan->id }}">{{ $pan->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition">
                        Tugaskan
                    </button>
                </form>
            @else
                <p class="text-xs text-gray-400 dark:text-gray-500">Semua panitia sudah ditugaskan di event ini.</p>
            @endif
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
                {{-- Pre-render QR (hidden) untuk setiap peserta --}}
                @foreach ($peserta as $p)
                    <div id="qr-data-{{ $p->id }}" class="hidden">
                        {!! DNS2D::getBarcodeHTML($p->kode_qr, 'QRCODE', 5, 5) !!}
                    </div>
                @endforeach

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
                                <th class="text-center px-4 py-3 font-semibold text-gray-500 dark:text-gray-400">Tiket</th>
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
                                            @php $ext = pathinfo($p->bukti_infaq, PATHINFO_EXTENSION); @endphp
                                            <button @click="openBukti('{{ asset('storage/' . $p->bukti_infaq) }}', '{{ $p->nama }}', '{{ $ext }}')"
                                                class="text-xs text-blue-500 dark:text-blue-400 hover:underline font-medium">
                                                Lihat
                                            </button>
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
                                        @if ($p->status === 'Hadir' && $p->scanner)
                                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                                oleh {{ $p->scanner->name }}<br>
                                                {{ $p->scanned_at?->format('H:i') }}
                                            </p>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button @click="openQR({{ $p->id }}, '{{ addslashes($p->nama) }}', '{{ $p->kode_qr }}')"
                                            class="inline-flex items-center gap-1 text-xs font-medium text-green-600 dark:text-green-400 hover:underline">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                            </svg>
                                            QR
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Modal Bukti Infaq --}}
        <div x-show="buktiOpen" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            @keydown.escape.window="buktiOpen = false">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="buktiOpen = false"></div>
            <div class="relative bg-white dark:bg-gray-900 rounded-2xl shadow-xl max-w-lg w-full p-5 z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-xs text-gray-400 dark:text-gray-500">Bukti Infaq</p>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100" x-text="buktiNama"></h3>
                    </div>
                    <button @click="buktiOpen = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <template x-if="buktiExt === 'pdf'">
                    <div class="text-center py-6">
                        <svg class="h-12 w-12 text-red-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">File PDF</p>
                        <a :href="buktiUrl" target="_blank"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition">
                            Buka PDF
                        </a>
                    </div>
                </template>
                <template x-if="buktiExt !== 'pdf'">
                    <img :src="buktiUrl" alt="Bukti Infaq" class="w-full rounded-lg max-h-96 object-contain bg-gray-50 dark:bg-gray-800">
                </template>
                <a :href="buktiUrl" target="_blank"
                    class="mt-3 block text-center text-xs text-gray-400 dark:text-gray-500 hover:underline">
                    Buka di tab baru
                </a>
            </div>
        </div>

        {{-- Modal QR Code --}}
        <div x-show="qrOpen" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            @keydown.escape.window="qrOpen = false">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="qrOpen = false"></div>
            <div class="relative bg-white dark:bg-gray-900 rounded-2xl shadow-xl max-w-xs w-full p-6 z-10 text-center">
                <button @click="qrOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">Tiket Peserta</p>
                <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4" x-text="qrNama"></h3>
                <div class="flex justify-center mb-3">
                    <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm inline-block" id="modal-qr-display"></div>
                </div>
                <p class="text-xs font-mono text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-gray-800 rounded-lg px-3 py-2" x-text="qrKode"></p>
            </div>
        </div>

    </div>

    <script>
        function detailPage() {
            return {
                buktiOpen: false,
                buktiUrl: '',
                buktiNama: '',
                buktiExt: '',
                qrOpen: false,
                qrNama: '',
                qrKode: '',

                openBukti(url, nama, ext) {
                    this.buktiUrl = url;
                    this.buktiNama = nama;
                    this.buktiExt = ext.toLowerCase();
                    this.buktiOpen = true;
                },

                openQR(id, nama, kode) {
                    this.qrNama = nama;
                    this.qrKode = kode;
                    this.qrOpen = true;
                    this.$nextTick(() => {
                        const src = document.getElementById('qr-data-' + id);
                        const dst = document.getElementById('modal-qr-display');
                        if (src && dst) dst.innerHTML = src.innerHTML;
                    });
                }
            }
        }
    </script>
</x-app-layout>
