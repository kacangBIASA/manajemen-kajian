<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-100">Scan QR Code</h2>
    </x-slot>

    <div class="max-w-lg mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm p-6">
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-5 text-center">Arahkan kamera ke QR Code peserta untuk absensi otomatis.</p>
            <div id="reader" class="rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700" style="width: 100%;"></div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const scanner = new Html5Qrcode("reader");
        let isProcessing = false;

        function sendScanResult(kodeQR) {
            if (isProcessing) return;
            isProcessing = true;

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
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Presensi Berhasil!',
                        text: data.message,
                        confirmButtonColor: '#16a34a',
                        timer: 3000,
                        timerProgressBar: true,
                    });
                } else if (data.status === 'info') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Sudah Presensi',
                        text: data.message,
                        confirmButtonColor: '#16a34a',
                        confirmButtonText: 'Oke, mengerti',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'QR Tidak Valid',
                        text: data.message,
                        confirmButtonColor: '#16a34a',
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Terjadi kesalahan sistem. Coba lagi.',
                    confirmButtonColor: '#16a34a',
                });
            })
            .finally(() => {
                setTimeout(() => { isProcessing = false; }, 3000);
            });
        }

        Html5Qrcode.getCameras().then(cameras => {
            if (cameras.length) {
                scanner.start(
                    cameras[0].id,
                    { fps: 10, qrbox: 250 },
                    qrCodeMessage => { sendScanResult(qrCodeMessage); }
                );
            }
        });
    </script>
</x-app-layout>
