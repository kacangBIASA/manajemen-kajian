<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Event Kajian
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-10">
        <form action="{{ route('event.store') }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium">Nama Kajian</label>
                <input type="text" name="nama" class="w-full mt-1 rounded border-gray-300" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium">Tanggal</label>
                <input type="date" name="tanggal" class="w-full mt-1 rounded border-gray-300" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium">Waktu</label>
                <input type="time" name="waktu" class="w-full mt-1 rounded border-gray-300" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium">Tempat</label>
                <input type="text" name="tempat" class="w-full mt-1 rounded border-gray-300" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="w-full mt-1 rounded border-gray-300"></textarea>
            </div>
            <div class="mb-4">
                <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                <select name="metode_pembayaran" id="metode_pembayaran"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-green-200">
                    <option value="Gratis">Gratis</option>
                    <option value="Berbayar">Berbayar</option>
                </select>
            </div>
            <div class="mb-4" id="harga-section" style="display: none;">
                <label for="harga" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                <input type="number" name="harga" id="harga"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-green-200"
                    placeholder="Contoh: 50000">
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
                Simpan
            </button>
        </form>
    </div>
</x-app-layout>
