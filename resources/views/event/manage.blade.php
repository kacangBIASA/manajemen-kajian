<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-100">Kelola Event Kajian</h2>
            <a href="{{ route('event.create') }}"
                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition">
                + Tambah Event
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6">
        @if (session('success'))
            <div class="mb-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                            <th class="text-left px-4 py-3 font-semibold text-gray-600 dark:text-gray-400">Nama Kajian</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-600 dark:text-gray-400">Pemateri</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-600 dark:text-gray-400">Tanggal</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-600 dark:text-gray-400">Waktu</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-600 dark:text-gray-400">Tempat</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-600 dark:text-gray-400">Metode</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-600 dark:text-gray-400">Harga</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-600 dark:text-gray-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse ($events as $event)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition">
                                <td class="px-4 py-3 font-medium text-gray-800 dark:text-gray-100">{{ $event->nama }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $event->pemateri ?? '-' }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $event->tanggal }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $event->waktu }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $event->tempat }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                        {{ $event->metode_pembayaran === 'Gratis'
                                            ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400'
                                            : 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400' }}">
                                        {{ $event->metode_pembayaran }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                    {{ $event->metode_pembayaran === 'Berbayar' ? 'Rp' . number_format($event->harga, 0, ',', '.') : '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('event.edit', $event->id) }}"
                                            class="text-sm text-blue-600 dark:text-blue-400 hover:underline font-medium">Edit</a>
                                        <form action="{{ route('event.destroy', $event->id) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Yakin hapus event ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-500 dark:text-red-400 hover:underline font-medium">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-gray-400 dark:text-gray-500">
                                    Belum ada event kajian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($events->hasPages())
                <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-800">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
