<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-100">Edit Event Kajian</h2>
    </x-slot>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm p-6">
            <form action="{{ route('event.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5"
                x-data="{ tipe: '{{ $event->tipe ?? 'offline' }}' }">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Kajian</label>
                    <input type="text" name="nama" value="{{ $event->nama }}" required
                        class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pemateri</label>
                        <input type="text" name="pemateri" value="{{ $event->pemateri }}" placeholder="Nama pemateri"
                            class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Moderator</label>
                        <input type="text" name="moderator" value="{{ $event->moderator }}" placeholder="Nama moderator"
                            class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal</label>
                        <input type="text" id="tanggal" name="tanggal" value="{{ $event->tanggal }}" required readonly
                            class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Waktu</label>
                        <input type="text" id="waktu" name="waktu" value="{{ \Illuminate\Support\Str::substr($event->waktu, 0, 5) }}" required readonly
                            class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition cursor-pointer">
                    </div>
                </div>

                {{-- Tipe Kajian --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipe Kajian</label>
                    <div class="flex gap-3">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="tipe" value="offline" x-model="tipe" class="sr-only">
                            <div :class="tipe === 'offline' ? 'border-green-500 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400' : 'border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400'"
                                class="flex items-center gap-2 border-2 rounded-lg px-4 py-2.5 text-sm font-medium transition">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Offline
                            </div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="tipe" value="online" x-model="tipe" class="sr-only">
                            <div :class="tipe === 'online' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400' : 'border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400'"
                                class="flex items-center gap-2 border-2 rounded-lg px-4 py-2.5 text-sm font-medium transition">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.723v6.554a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                                Online
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        <span x-text="tipe === 'online' ? 'Nama Platform' : 'Tempat'"></span>
                    </label>
                    <input type="text" name="tempat" value="{{ $event->tempat }}" required
                        :placeholder="tipe === 'online' ? 'Contoh: Zoom, Google Meet, YouTube Live' : 'Nama masjid / gedung / lokasi'"
                        class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                </div>

                <div x-show="tipe === 'online'" x-cloak>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Link Bergabung</label>
                    <input type="url" name="link_online" value="{{ $event->link_online }}" :required="tipe === 'online'"
                        placeholder="https://zoom.us/j/... atau link platform lain"
                        class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Link ini akan ditampilkan di tiket peserta.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                        class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition resize-none">{{ $event->deskripsi }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Metode Pembayaran</label>
                    <select name="metode_pembayaran" id="metode_pembayaran"
                        class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                        <option value="Gratis" {{ $event->metode_pembayaran === 'Gratis' ? 'selected' : '' }}>Gratis</option>
                        <option value="Berbayar" {{ $event->metode_pembayaran === 'Berbayar' ? 'selected' : '' }}>Berbayar</option>
                    </select>
                </div>

                <div id="harga-section" class="{{ $event->metode_pembayaran === 'Berbayar' ? '' : 'hidden' }}">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga (Rp)</label>
                    <input type="number" name="harga" id="harga" value="{{ $event->harga }}" placeholder="Contoh: 50000"
                        class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Flyer / Poster Kajian</label>
                    @if ($event->flyer)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $event->flyer) }}" alt="Flyer saat ini"
                                class="w-32 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Flyer saat ini. Upload baru untuk mengganti.</p>
                        </div>
                    @endif
                    <input type="file" name="flyer" accept="image/*"
                        class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-50 dark:file:bg-green-900/30 file:text-green-700 dark:file:text-green-400 hover:file:bg-green-100 transition">
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        flatpickr("#tanggal", {
            locale: "id",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d F Y",
        });

        flatpickr("#waktu", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            minuteIncrement: 5,
        });

        const metodeSelect = document.getElementById('metode_pembayaran');
        const hargaSection = document.getElementById('harga-section');
        metodeSelect.addEventListener('change', function () {
            hargaSection.classList.toggle('hidden', this.value !== 'Berbayar');
            if (this.value !== 'Berbayar') document.getElementById('harga').value = '';
        });
    </script>
</x-app-layout>
