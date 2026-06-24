@extends('layouts.public')

@section('title', 'Form Pendaftaran — ' . $event->nama)

@section('content')
    <div class="max-w-xl mx-auto">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm overflow-hidden">

            @if ($event->flyer)
                <div class="w-full aspect-[4/3] overflow-hidden">
                    <img src="{{ asset('storage/' . $event->flyer) }}" alt="Flyer {{ $event->nama }}"
                        class="w-full h-full object-cover object-top">
                </div>
            @endif

            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-1">{{ $event->nama }}</h2>

                @if ($event->pemateri)
                    <p class="text-sm font-medium text-green-700 dark:text-green-400">Pemateri: {{ $event->pemateri }}</p>
                @endif
                @if ($event->moderator)
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Moderator: {{ $event->moderator }}</p>
                @endif

                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 mb-6 space-y-1.5 text-sm text-gray-600 dark:text-gray-400 border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-green-600 dark:text-green-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($event->tanggal)->isoFormat('dddd, D MMMM Y') }} · {{ \Illuminate\Support\Str::substr($event->waktu, 0, 5) }} WIB
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-green-600 dark:text-green-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $event->tempat }}
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-green-600 dark:text-green-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        {{ $event->metode_pembayaran === 'Berbayar' ? 'Berbayar — Rp' . number_format($event->harga, 0, ',', '.') : 'Gratis' }}
                    </div>
                </div>

                @if (session('error'))
                    <div class="mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('pendaftaran.submit', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama" required
                            class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat</label>
                        <textarea name="alamat" rows="2" required
                            class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition resize-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No HP</label>
                        <input type="text" name="no_hp" required
                            class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Motivasi Kajian</label>
                        <textarea name="motivasi_kajian" rows="2" placeholder="Tuliskan motivasi kajian kamu..."
                            class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition resize-none"></textarea>
                    </div>

                    @if ($event->metode_pembayaran === 'Berbayar')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Bukti Pembayaran</label>
                            <input type="file" name="bukti_pembayaran" accept="image/*,application/pdf" required
                                class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-50 dark:file:bg-green-900/30 file:text-green-700 dark:file:text-green-400 hover:file:bg-green-100 transition">
                        </div>
                    @endif

                    {{-- Infaq Section --}}
                    <div class="border border-green-100 dark:border-green-900/50 bg-green-50 dark:bg-green-900/10 rounded-xl p-4 space-y-3">
                        <div class="flex items-center gap-2 mb-1">
                            <svg class="h-4 w-4 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <span class="text-sm font-semibold text-green-800 dark:text-green-300">Infaq Kajian (Opsional)</span>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-lg px-4 py-3 text-sm border border-green-100 dark:border-gray-700">
                            <p class="text-gray-600 dark:text-gray-300 font-medium mb-0.5">Transfer ke:</p>
                            <p class="text-gray-800 dark:text-gray-100 font-semibold">BCA Syariah</p>
                            <p class="text-green-700 dark:text-green-400 font-bold text-base tracking-wider">0530051523</p>
                            <p class="text-gray-500 dark:text-gray-400 text-xs">An. Suci IndraWati</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Pilih nominal infaq:</p>
                            <div class="grid grid-cols-2 gap-2" id="infaq-options">
                                @foreach ([20000, 30000, 50000] as $nominal)
                                    <button type="button" onclick="pilihInfaq({{ $nominal }}, this)"
                                        class="infaq-btn border-2 border-gray-200 dark:border-gray-700 rounded-lg py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:border-green-500 hover:text-green-700 dark:hover:text-green-400 transition">
                                        Rp {{ number_format($nominal, 0, ',', '.') }}
                                    </button>
                                @endforeach
                                <button type="button" onclick="pilihInfaqLain(this)"
                                    class="infaq-btn border-2 border-gray-200 dark:border-gray-700 rounded-lg py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:border-green-500 hover:text-green-700 dark:hover:text-green-400 transition">
                                    Nominal Lain
                                </button>
                            </div>
                            <input type="number" id="infaq-lain" name="infaq_nominal" placeholder="Masukkan nominal (Rp)"
                                class="hidden mt-2 w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                        </div>

                        <input type="hidden" name="infaq_is_custom" id="infaq-is-custom" value="0">

                        <div id="bukti-infaq-wrap" class="hidden">
                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                Upload bukti transfer infaq
                                <span class="required-star text-red-500">*</span>
                                <span class="optional-text text-gray-400">(opsional)</span>
                            </label>
                            <input type="file" name="bukti_infaq" id="bukti-infaq-input" accept="image/*,application/pdf"
                                class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-green-50 dark:file:bg-green-900/30 file:text-green-700 dark:file:text-green-400 hover:file:bg-green-100 transition">
                            @error('bukti_infaq')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-2.5 rounded-lg text-sm font-semibold transition mt-2">
                        Kirim Pendaftaran
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let activeBtn = null;

        function resetInfaq() {
            document.querySelectorAll('.infaq-btn').forEach(b => {
                b.classList.remove('border-green-500', 'text-green-700', 'bg-green-50', 'dark:bg-green-900/20');
            });
            const lain = document.getElementById('infaq-lain');
            lain.classList.add('hidden');
            lain.value = '';
            const wrap = document.getElementById('bukti-infaq-wrap');
            const fileInput = document.getElementById('bukti-infaq-input');
            const flag = document.getElementById('infaq-is-custom');
            wrap.classList.add('hidden');
            fileInput.required = false;
            fileInput.value = '';
            flag.value = '0';
            activeBtn = null;
        }

        function showBuktiInfaq(required) {
            const wrap = document.getElementById('bukti-infaq-wrap');
            const fileInput = document.getElementById('bukti-infaq-input');
            const flag = document.getElementById('infaq-is-custom');
            wrap.classList.remove('hidden');
            fileInput.required = required;
            flag.value = required ? '1' : '0';
            const star = wrap.querySelector('.required-star');
            const opt = wrap.querySelector('.optional-text');
            if (star) star.style.display = required ? 'inline' : 'none';
            if (opt) opt.style.display = required ? 'none' : 'inline';
        }

        function pilihInfaq(nominal, el) {
            if (activeBtn === el) { resetInfaq(); return; }
            activeBtn = el;
            document.querySelectorAll('.infaq-btn').forEach(b => {
                b.classList.remove('border-green-500', 'text-green-700', 'bg-green-50', 'dark:bg-green-900/20');
            });
            el.classList.add('border-green-500', 'text-green-700', 'bg-green-50', 'dark:bg-green-900/20');
            const lain = document.getElementById('infaq-lain');
            lain.classList.add('hidden');
            lain.name = 'infaq_nominal';
            lain.value = nominal;
            showBuktiInfaq(false);
        }

        function pilihInfaqLain(el) {
            if (activeBtn === el) { resetInfaq(); return; }
            activeBtn = el;
            document.querySelectorAll('.infaq-btn').forEach(b => {
                b.classList.remove('border-green-500', 'text-green-700', 'bg-green-50', 'dark:bg-green-900/20');
            });
            el.classList.add('border-green-500', 'text-green-700', 'bg-green-50', 'dark:bg-green-900/20');
            const lain = document.getElementById('infaq-lain');
            lain.classList.remove('hidden');
            lain.name = 'infaq_nominal';
            lain.value = '';
            lain.focus();
            showBuktiInfaq(true);
        }

        // Restore state jika validasi gagal
        @if (old('infaq_nominal') || old('infaq_is_custom'))
            document.addEventListener('DOMContentLoaded', function () {
                const isCustom = '{{ old('infaq_is_custom') }}' === '1';
                const oldNominal = parseInt('{{ old('infaq_nominal') }}') || 0;
                const btns = document.querySelectorAll('.infaq-btn');
                if (isCustom) {
                    activeBtn = btns[btns.length - 1];
                    activeBtn.classList.add('border-green-500', 'text-green-700', 'bg-green-50');
                    const lain = document.getElementById('infaq-lain');
                    lain.classList.remove('hidden');
                    lain.value = oldNominal || '';
                    showBuktiInfaq(true);
                } else if (oldNominal) {
                    btns.forEach(btn => {
                        if (btn.textContent.replace(/\D/g, '') == String(oldNominal)) {
                            activeBtn = btn;
                            btn.classList.add('border-green-500', 'text-green-700', 'bg-green-50');
                        }
                    });
                    document.getElementById('infaq-lain').value = oldNominal;
                    showBuktiInfaq(false);
                }
            });
        @endif
    </script>
@endsection
