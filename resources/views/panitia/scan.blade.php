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
                <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-100">Scan Absensi</h2>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $event->nama }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-lg mx-auto px-4 py-8 space-y-4">

        {{-- Event info chip --}}
        <div class="flex items-center gap-2 text-sm text-teal-700 dark:text-teal-400 bg-teal-50 dark:bg-teal-900/20 border border-teal-200 dark:border-teal-800 rounded-lg px-4 py-2.5">
            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="font-medium">{{ $event->nama }}</span>
            <span class="text-teal-500 dark:text-teal-500">·</span>
            <span>{{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}</span>
        </div>

        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm p-6">

            {{-- Placeholder saat kamera mati --}}
            <div id="camera-off" class="flex flex-col items-center justify-center py-10 gap-4">
                <div class="h-16 w-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                    <svg class="h-8 w-8 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.723v6.554a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                    </svg>
                </div>
                <p class="text-sm text-gray-400 dark:text-gray-500 text-center">
                    Kamera belum aktif.<br>Tekan tombol di bawah untuk mulai scan.
                </p>
            </div>

            {{-- Area kamera --}}
            <div id="reader" class="rounded-lg border border-gray-200 dark:border-gray-700 hidden" style="width: 100%; min-height: 300px;"></div>

            {{-- Status indicator --}}
            <div id="status-indicator" class="hidden mt-4 flex items-center justify-center gap-2 text-sm text-teal-600 dark:text-teal-400">
                <span class="inline-block h-2 w-2 rounded-full bg-teal-500 animate-pulse"></span>
                Kamera aktif — arahkan ke QR Code peserta
            </div>
        </div>

        {{-- Tombol toggle --}}
        <button id="toggle-btn" onclick="toggleCamera()"
            class="w-full py-3 rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2
                   bg-teal-600 hover:bg-teal-700 text-white">
            <svg id="btn-icon-on" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.723v6.554a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
            </svg>
            <svg id="btn-icon-off" class="h-4 w-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
            </svg>
            <span id="btn-label">Aktifkan Kamera</span>
        </button>
    </div>

    <style>
        #reader video {
            width: 100% !important;
            height: auto !important;
            border-radius: 8px;
        }
        #reader__scan_region {
            background: transparent !important;
        }
        #reader__dashboard {
            display: none !important;
        }
    </style>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const scanner = new Html5Qrcode("reader");
        let isProcessing = false;
        let cameraOn = false;
        const EVENT_ID = {{ $event->id }};

        function toggleCamera() {
            if (cameraOn) {
                stopCamera();
            } else {
                startCamera();
            }
        }

        function startCamera() {
            scanner.start(
                    { facingMode: { ideal: "environment" } },
                    { fps: 10, qrbox: { width: 250, height: 250 } },
                    qrCodeMessage => { sendScanResult(qrCodeMessage); }
                ).then(() => {
                    cameraOn = true;
                    document.getElementById('camera-off').classList.add('hidden');
                    document.getElementById('reader').classList.remove('hidden');
                    document.getElementById('status-indicator').classList.remove('hidden');
                    document.getElementById('btn-label').textContent = 'Matikan Kamera';
                    document.getElementById('btn-icon-on').classList.add('hidden');
                    document.getElementById('btn-icon-off').classList.remove('hidden');
                    document.getElementById('toggle-btn').classList.replace('bg-teal-600', 'bg-red-500');
                    document.getElementById('toggle-btn').classList.replace('hover:bg-teal-700', 'hover:bg-red-600');
                }).catch(() => {
                    Swal.fire({ icon: 'error', title: 'Gagal mengakses kamera', text: 'Pastikan izin kamera sudah diberikan.', confirmButtonColor: '#0d9488' });
                });
        }

        function stopCamera() {
            scanner.stop().then(() => {
                cameraOn = false;
                document.getElementById('camera-off').classList.remove('hidden');
                document.getElementById('reader').classList.add('hidden');
                document.getElementById('status-indicator').classList.add('hidden');
                document.getElementById('btn-label').textContent = 'Aktifkan Kamera';
                document.getElementById('btn-icon-on').classList.remove('hidden');
                document.getElementById('btn-icon-off').classList.add('hidden');
                document.getElementById('toggle-btn').classList.replace('bg-red-500', 'bg-teal-600');
                document.getElementById('toggle-btn').classList.replace('hover:bg-red-600', 'hover:bg-teal-700');
            });
        }

        function sendScanResult(kodeQR) {
            if (isProcessing) return;
            isProcessing = true;

            fetch("{{ route('panitia.scan.check') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ kode_qr: kodeQR, event_id: EVENT_ID })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Presensi Berhasil!',
                        text: data.message,
                        confirmButtonColor: '#0d9488',
                        timer: 3000,
                        timerProgressBar: true,
                    });
                } else if (data.status === 'info') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Sudah Presensi',
                        text: data.message,
                        confirmButtonColor: '#0d9488',
                        confirmButtonText: 'Oke, mengerti',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'QR Tidak Valid',
                        text: data.message,
                        confirmButtonColor: '#0d9488',
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Terjadi kesalahan sistem. Coba lagi.',
                    confirmButtonColor: '#0d9488',
                });
            })
            .finally(() => {
                setTimeout(() => { isProcessing = false; }, 3000);
            });
        }
    </script>
</x-panitia-layout>
