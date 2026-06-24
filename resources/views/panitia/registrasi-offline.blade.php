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
                <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-100">Registrasi Peserta Offline</h2>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $event->nama }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-lg mx-auto px-4 py-8">

        {{-- Info banner --}}
        <div class="flex items-start gap-3 bg-teal-50 dark:bg-teal-900/20 border border-teal-200 dark:border-teal-800 rounded-xl px-4 py-3 mb-6 text-sm text-teal-700 dark:text-teal-400">
            <svg class="h-4 w-4 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Peserta yang diregistrasi di sini akan langsung tercatat sebagai <strong>Hadir</strong> dan terdaftar sebagai <strong>On The Spot (OTS)</strong>.</span>
        </div>

        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm p-6 space-y-5">

            @if (session('error'))
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 rounded-lg px-4 py-3 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('panitia.event.registrasi-offline.store', $event->id) }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required autofocus
                        class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent outline-none transition
                            @error('nama') border-red-400 @enderror">
                    @error('nama')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        No HP <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
                        class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent outline-none transition
                            @error('no_hp') border-red-400 @enderror">
                    @error('no_hp')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Infaq --}}
                <div class="border border-teal-100 dark:border-teal-900/50 bg-teal-50/50 dark:bg-teal-900/10 rounded-xl p-4 space-y-3">
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-teal-600 dark:text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span class="text-sm font-semibold text-teal-800 dark:text-teal-300">Infaq (Opsional)</span>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Pilih nominal infaq:</p>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach ([20000, 30000, 50000] as $nominal)
                                <button type="button" onclick="pilihInfaq({{ $nominal }}, this)"
                                    class="infaq-btn border-2 border-gray-200 dark:border-gray-700 rounded-lg py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:border-teal-500 hover:text-teal-700 dark:hover:text-teal-400 transition">
                                    Rp {{ number_format($nominal, 0, ',', '.') }}
                                </button>
                            @endforeach
                            <button type="button" onclick="pilihInfaqLain(this)"
                                class="infaq-btn border-2 border-gray-200 dark:border-gray-700 rounded-lg py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:border-teal-500 hover:text-teal-700 dark:hover:text-teal-400 transition">
                                Nominal Lain
                            </button>
                        </div>
                        <input type="number" id="infaq-lain" name="infaq_nominal" placeholder="Masukkan nominal (Rp)"
                            value="{{ old('infaq_nominal') }}"
                            class="hidden mt-2 w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent outline-none transition">
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-teal-600 hover:bg-teal-700 text-white py-2.5 rounded-lg text-sm font-semibold transition flex items-center justify-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Daftarkan & Tandai Hadir
                </button>
            </form>
        </div>
    </div>

    <script>
        let activeBtn = null;

        function resetInfaq() {
            document.querySelectorAll('.infaq-btn').forEach(b => {
                b.classList.remove('border-teal-500', 'text-teal-700', 'bg-teal-50', 'dark:bg-teal-900/20');
            });
            const lain = document.getElementById('infaq-lain');
            lain.classList.add('hidden');
            lain.value = '';
            activeBtn = null;
        }

        function pilihInfaq(nominal, el) {
            if (activeBtn === el) { resetInfaq(); return; }
            activeBtn = el;
            document.querySelectorAll('.infaq-btn').forEach(b => {
                b.classList.remove('border-teal-500', 'text-teal-700', 'bg-teal-50', 'dark:bg-teal-900/20');
            });
            el.classList.add('border-teal-500', 'text-teal-700', 'bg-teal-50', 'dark:bg-teal-900/20');
            const lain = document.getElementById('infaq-lain');
            lain.classList.add('hidden');
            lain.name = 'infaq_nominal';
            lain.value = nominal;
        }

        function pilihInfaqLain(el) {
            if (activeBtn === el) { resetInfaq(); return; }
            activeBtn = el;
            document.querySelectorAll('.infaq-btn').forEach(b => {
                b.classList.remove('border-teal-500', 'text-teal-700', 'bg-teal-50', 'dark:bg-teal-900/20');
            });
            el.classList.add('border-teal-500', 'text-teal-700', 'bg-teal-50', 'dark:bg-teal-900/20');
            const lain = document.getElementById('infaq-lain');
            lain.classList.remove('hidden');
            lain.name = 'infaq_nominal';
            lain.value = '';
            lain.focus();
        }

        // Restore saat validasi gagal
        @if (old('infaq_nominal'))
            document.addEventListener('DOMContentLoaded', function () {
                const oldNominal = parseInt('{{ old('infaq_nominal') }}') || 0;
                const btns = document.querySelectorAll('.infaq-btn');
                let matched = false;
                btns.forEach(btn => {
                    if (btn.textContent.replace(/\D/g, '') == String(oldNominal)) {
                        activeBtn = btn;
                        btn.classList.add('border-teal-500', 'text-teal-700', 'bg-teal-50');
                        matched = true;
                    }
                });
                if (!matched && oldNominal) {
                    const lastBtn = btns[btns.length - 1];
                    activeBtn = lastBtn;
                    lastBtn.classList.add('border-teal-500', 'text-teal-700', 'bg-teal-50');
                    const lain = document.getElementById('infaq-lain');
                    lain.classList.remove('hidden');
                    lain.value = oldNominal;
                }
            });
        @endif
    </script>
</x-panitia-layout>
