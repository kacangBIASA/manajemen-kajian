<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Event Kajian
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
            <form action="{{ route('event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium">Nama Kajian</label>
                    <input type="text" name="nama" value="{{ $event->nama }}"
                        class="w-full mt-1 rounded border-gray-300" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Pemateri</label>
                    <input type="text" name="pemateri" value="{{ $event->pemateri }}"
                        class="w-full mt-1 rounded border-gray-300" placeholder="Contoh: Ustadz Ahmad Zainuddin">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ $event->tanggal }}"
                        class="w-full mt-1 rounded border-gray-300" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Waktu</label>
                    <input type="time" name="waktu" value="{{ $event->waktu }}"
                        class="w-full mt-1 rounded border-gray-300" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Tempat</label>
                    <input type="text" name="tempat" value="{{ $event->tempat }}"
                        class="w-full mt-1 rounded border-gray-300" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" class="w-full mt-1 rounded border-gray-300">{{ $event->deskripsi }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Metode Pembayaran</label>
                    <select name="metode_pembayaran" id="metode_pembayaran"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="Gratis" {{ $event->metode_pembayaran === 'Gratis' ? 'selected' : '' }}>Gratis
                        </option>
                        <option value="Berbayar" {{ $event->metode_pembayaran === 'Berbayar' ? 'selected' : '' }}>
                            Berbayar</option>
                    </select>
                </div>
                <div class="mb-4" id="harga-section"
                    style="{{ $event->metode_pembayaran === 'Berbayar' ? '' : 'display: none;' }}">
                    <label for="harga" class="block text-sm font-medium">Harga (Rp)</label>
                    <input type="number" name="harga" id="harga" value="{{ $event->harga }}"
                        class="mt-1 block w-full rounded-md border-gray-300" placeholder="Contoh: 50000">
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const metodeSelect = document.getElementById('metode_pembayaran');
                        const hargaSection = document.getElementById('harga-section');
                        metodeSelect.addEventListener('change', function() {
                            if (this.value === 'Berbayar') {
                                hargaSection.style.display = 'block';
                            } else {
                                hargaSection.style.display = 'none';
                                document.getElementById('harga').value = '';
                            }
                        });
                    });
                </script>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Flyer / Poster Kajian</label>
                    @if ($event->flyer)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $event->flyer) }}" alt="Flyer saat ini"
                                class="w-40 rounded shadow border">
                            <p class="text-xs text-gray-400 mt-1">Flyer saat ini. Upload baru untuk mengganti.</p>
                        </div>
                    @endif
                    <input type="file" name="flyer" accept="image/*"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                </div>
                <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
                    Update
                </button>
            </form>
        </div>

    </div>
</x-app-layout>
