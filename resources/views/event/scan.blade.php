<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-100">Scan QR Code</h2>
    </x-slot>

    <div class="max-w-lg mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm p-6">
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-5 text-center">Arahkan kamera ke QR Code peserta untuk absensi otomatis.</p>

            <div id="result-message" class="hidden px-4 py-3 rounded-lg mb-5 text-sm font-medium text-center"></div>

            <div id="reader" class="rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700" style="width: 100%;"></div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        const scanner = new Html5Qrcode("reader");

        function showMessage(type, message) {
            const el = document.getElementById('result-message');
            el.classList.remove('hidden', 'bg-green-100', 'bg-red-100', 'bg-yellow-100',
                'text-green-700', 'text-red-700', 'text-yellow-700',
                'dark:bg-green-900/30', 'dark:bg-red-900/30', 'dark:bg-yellow-900/30',
                'dark:text-green-400', 'dark:text-red-400', 'dark:text-yellow-400');

            if (type === 'success') {
                el.classList.add('bg-green-100', 'text-green-700', 'dark:bg-green-900/30', 'dark:text-green-400');
            } else if (type === 'error') {
                el.classList.add('bg-red-100', 'text-red-700', 'dark:bg-red-900/30', 'dark:text-red-400');
            } else {
                el.classList.add('bg-yellow-100', 'text-yellow-700', 'dark:bg-yellow-900/30', 'dark:text-yellow-400');
            }
            el.innerText = message;
            setTimeout(() => el.classList.add('hidden'), 3000);
        }

        function sendScanResult(kodeQR) {
            fetch("{{ route('event.scan.check') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify({ kode_qr: kodeQR })
            })
            .then(res => res.json())
            .then(data => showMessage(data.status, data.message))
            .catch(() => showMessage('error', 'Terjadi kesalahan sistem.'));
        }

        Html5Qrcode.getCameras().then(cameras => {
            if (cameras.length) {
                scanner.start(cameras[0].id, { fps: 10, qrbox: 250 }, qrCodeMessage => {
                    sendScanResult(qrCodeMessage);
                });
            }
        });
    </script>
</x-app-layout>
