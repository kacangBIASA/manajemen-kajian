<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Event Kajian
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
            <form action="{{ route('event.update', $event->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium">Nama Kajian</label>
                    <input type="text" name="nama" value="{{ $event->nama }}"
                        class="w-full mt-1 rounded border-gray-300" required>
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
                <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
                    Update
                </button>
            </form>
        </div>

    </div>
</x-app-layout>
