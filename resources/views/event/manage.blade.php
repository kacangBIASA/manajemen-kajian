<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Event Kajian
        </h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-4">
        @if (session('success'))
            <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded p-6">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b font-semibold text-gray-700">
                        <th class="pb-2">Nama</th>
                        <th class="pb-2">Tanggal</th>
                        <th class="pb-2">Waktu</th>
                        <th class="pb-2">Tempat</th>
                        <th class="pb-2">Aksi</th>
                        <th class="pb-2">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2">{{ $event->nama }}</td>
                            <td class="py-2">{{ $event->tanggal }}</td>
                            <td class="py-2">{{ $event->waktu }}</td>
                            <td class="py-2">{{ $event->tempat }}</td>
                            <td>{{ $event->metode_pembayaran }}</td>
                            <td>
                                @if ($event->metode_pembayaran === 'Berbayar')
                                    Rp{{ number_format($event->harga, 0, ',', '.') }}
                                @else
                                    Gratis
                                @endif
                            </td>
                            <td class="py-2 space-x-2">
                                <a href="{{ route('event.edit', $event->id) }}"
                                    class="text-blue-600 hover:underline">Edit</a>

                                <form action="{{ route('event.destroy', $event->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin hapus event ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
