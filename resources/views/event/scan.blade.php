<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scan QR Code') }}
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto p-6 bg-white shadow rounded mt-6">
        <h2 class="text-lg font-semibold text-green-700 mb-4">Scan QR Code dengan Kamera</h2>

        <div id="result-message" class="hidden p-3 rounded mb-4 text-sm font-semibold"></div>

        <div id="reader" style="width: 100%;"></div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        const scanner = new Html5Qrcode("reader");

        function showMessage(type, message) {
            const el = document.getElementById('result-message');
            el.classList.remove('hidden', 'bg-green-100', 'bg-red-100', 'bg-yellow-100', 'text-green-700', 'text-red-700', 'text-yellow-700');

            if (type === 'success') {
                el.classList.add('bg-green-100', 'text-green-700');
            } else if (type === 'error') {
                el.classList.add('bg-red-100', 'text-red-700');
            } else {
                el.classList.add('bg-yellow-100', 'text-yellow-700');
            }

            el.innerText = message;

            setTimeout(() => {
                el.classList.add('hidden');
            }, 3000); // auto-hide in 3 sec
        }

        function sendScanResult(kodeQR) {
            fetch("{{ route('event.scan.check') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ kode_qr: kodeQR })
            })
            .then(res => res.json())
            .then(data => {
                showMessage(data.status, data.message);
            })
            .catch(() => {
                showMessage('error', 'Terjadi kesalahan sistem.');
            });
        }

        Html5Qrcode.getCameras().then(cameras => {
            if (cameras.length) {
                scanner.start(
                    cameras[0].id,
                    { fps: 10, qrbox: 250 },
                    qrCodeMessage => {
                        sendScanResult(qrCodeMessage);
                    }
                );
            }
        });
    </script>
</x-app-layout>
