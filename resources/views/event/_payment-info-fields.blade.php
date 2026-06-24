{{--
    Partial: Info Pembayaran / Infaq (QRIS + Transfer)
    Variabel: $event (nullable, untuk edit)
    Selalu tampil — untuk Gratis = info rekening infaq, untuk Berbayar = info cara bayar
--}}
@php $currentMetode = old('metode_pembayaran', isset($event) ? $event->metode_pembayaran : 'Gratis'); @endphp

<div id="payment-info-section" class="space-y-4 border border-amber-200 dark:border-amber-800/50 bg-amber-50 dark:bg-amber-900/10 rounded-xl p-4">

    <div id="label-gratis" class="{{ $currentMetode === 'Berbayar' ? 'hidden' : '' }}">
        <p class="text-xs font-semibold text-amber-700 dark:text-amber-400 uppercase tracking-wide">Info Rekening Infaq (Opsional)</p>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Isi jika ingin peserta tahu kemana transfer infaq. Yang diisi ditampilkan di form pendaftaran.</p>
    </div>
    <div id="label-berbayar" class="{{ $currentMetode !== 'Berbayar' ? 'hidden' : '' }}">
        <p class="text-xs font-semibold text-amber-700 dark:text-amber-400 uppercase tracking-wide">Info Cara Pembayaran (Opsional)</p>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Isi salah satu atau keduanya. Akan ditampilkan ke peserta di form pendaftaran.</p>
    </div>

    {{-- QRIS --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-4 space-y-2">
        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center gap-2">
            <span class="inline-block w-2 h-2 rounded-full bg-purple-500"></span> QRIS
        </p>
        @if (isset($event) && $event->qris_image)
            <div class="flex items-center gap-3 mb-2">
                <img src="{{ asset('storage/' . $event->qris_image) }}" alt="QRIS" class="w-24 h-24 object-contain border border-gray-200 dark:border-gray-700 rounded-lg bg-white p-1">
                <p class="text-xs text-gray-400">QRIS saat ini. Upload baru untuk mengganti.</p>
            </div>
        @endif
        <input type="file" name="qris_image" accept="image/*"
            class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-purple-50 dark:file:bg-purple-900/30 file:text-purple-700 dark:file:text-purple-400 hover:file:bg-purple-100 transition">
        <p class="text-xs text-gray-400">Format: JPG, PNG, WEBP. Maks 2MB.</p>
        @error('qris_image') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
    </div>

    {{-- Transfer Bank --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-4 space-y-3">
        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center gap-2">
            <span class="inline-block w-2 h-2 rounded-full bg-blue-500"></span> Transfer Bank
        </p>
        <div>
            <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Nama Bank</label>
            <input type="text" name="nama_bank" value="{{ old('nama_bank', isset($event) ? $event->nama_bank : '') }}"
                placeholder="Contoh: BCA, BRI, Mandiri, BSI"
                class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
            @error('nama_bank') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">No. Rekening</label>
                <input type="text" name="no_rekening" value="{{ old('no_rekening', isset($event) ? $event->no_rekening : '') }}"
                    placeholder="Contoh: 1234567890"
                    class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                @error('no_rekening') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Nama Pemilik Rekening</label>
                <input type="text" name="nama_rekening" value="{{ old('nama_rekening', isset($event) ? $event->nama_rekening : '') }}"
                    placeholder="Nama sesuai rekening"
                    class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                @error('nama_rekening') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</div>
