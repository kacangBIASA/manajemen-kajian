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
            <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
                Simpan
            </button>
        </form>
    </div>
</x-app-layout>
