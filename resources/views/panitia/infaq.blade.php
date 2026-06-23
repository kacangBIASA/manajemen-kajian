<x-panitia-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('panitia.event.detail', $event->id) }}"
                class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-100">Catat Infaq</h2>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $event->nama }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 py-8 space-y-6">

        @if (session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-lg px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form catat infaq --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-5">Tambah Catatan Infaq</h3>

            <form action="{{ route('panitia.event.infaq.store', $event->id) }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Nominal Infaq <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400 dark:text-gray-500 font-medium">Rp</span>
                        <input type="number" name="nominal" id="nominal" min="0" step="1000"
                            value="{{ old('nominal') }}"
                            placeholder="50000"
                            class="w-full pl-10 pr-4 border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent outline-none transition"
                            required>
                    </div>
                    @error('nominal') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Catatan <span class="text-gray-400 dark:text-gray-500 font-normal">(opsional)</span>
                    </label>
                    <input type="text" name="catatan" value="{{ old('catatan') }}"
                        placeholder="Contoh: Infaq dari jamaah baris belakang"
                        class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent outline-none transition">
                    @error('catatan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-teal-600 hover:bg-teal-700 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                        Simpan Catatan Infaq
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-panitia-layout>
