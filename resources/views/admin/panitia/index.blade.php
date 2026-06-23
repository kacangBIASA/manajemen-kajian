<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-100">Kelola Panitia</h2>
            <a href="{{ route('admin.panitia.create') }}"
                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition">
                + Tambah Panitia
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 py-6">
        @if (session('success'))
            <div class="mb-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm overflow-hidden">
            @if ($panitias->isEmpty())
                <div class="py-12 text-center text-gray-400 dark:text-gray-500 text-sm">
                    Belum ada akun panitia. <a href="{{ route('admin.panitia.create') }}" class="text-green-600 hover:underline">Tambah sekarang</a>.
                </div>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
                            <th class="text-left px-4 py-3 font-semibold text-gray-500 dark:text-gray-400">#</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-500 dark:text-gray-400">Nama</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-500 dark:text-gray-400">Email</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-500 dark:text-gray-400">Event Ditugaskan</th>
                            <th class="text-left px-4 py-3 font-semibold text-gray-500 dark:text-gray-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($panitias as $i => $p)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition">
                                <td class="px-4 py-3 text-gray-400 dark:text-gray-500">{{ $i + 1 }}</td>
                                <td class="px-4 py-3 font-medium text-gray-800 dark:text-gray-100">{{ $p->name }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $p->email }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-full text-xs font-medium">
                                        {{ $p->events_count }} event
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('admin.panitia.edit', $p->id) }}"
                                            class="text-sm text-blue-600 dark:text-blue-400 hover:underline font-medium">Edit</a>
                                        <form action="{{ route('admin.panitia.destroy', $p->id) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Hapus akun panitia {{ $p->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-500 dark:text-red-400 hover:underline font-medium">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
