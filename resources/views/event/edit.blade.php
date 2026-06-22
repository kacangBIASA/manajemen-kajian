<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-100">Edit Event Kajian</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm p-6">
            <form action="{{ route('event.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Kajian</label>
                    <input type="text" name="nama" value="{{ $event->nama }}" required
                        class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pemateri</label>
                    <input type="text" name="pemateri" value="{{ $event->pemateri }}"
                        placeholder="Contoh: Ustadz Ahmad Zainuddin"
                        class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ $event->tanggal }}" required
                            class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Waktu</label>
                        <input type="time" name="waktu" value="{{ $event->waktu }}" required
                            class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tempat</label>
                    <input type="text" name="tempat" value="{{ $event->tempat }}" required
                        class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
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
        const metodeSelect = document.getElementById('metode_pembayaran');
        const hargaSection = document.getElementById('harga-section');
        metodeSelect.addEventListener('change', function () {
            hargaSection.classList.toggle('hidden', this.value !== 'Berbayar');
            if (this.value !== 'Berbayar') document.getElementById('harga').value = '';
        });
    </script>
</x-app-layout>
