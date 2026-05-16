<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">
            {{ __('Scan Kehadiran (QR Code)') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 font-sans">
        
        <!-- Floating Result Message -->
        <div id="result-message" class="hidden transform transition-all duration-500 -translate-y-4 opacity-0 p-4 rounded-xl mb-6 flex items-center shadow-lg font-medium">
            <svg id="result-icon-success" class="hidden w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <svg id="result-icon-error" class="hidden w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <svg id="result-icon-info" class="hidden w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span id="result-text"></span>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl border border-slate-100 overflow-hidden text-center relative">
            <div class="bg-slate-900 text-white p-6 relative overflow-hidden">
                <div class="absolute -top-12 -right-12 w-32 h-32 bg-emerald-500/20 rounded-full blur-xl"></div>
                <h3 class="text-xl font-bold relative z-10">Kamera Scanner Aktif</h3>
                <p class="text-slate-400 text-sm mt-1 relative z-10">Arahkan tiket QR peserta ke kotak kamera di bawah ini</p>
            </div>
            
            <div class="p-8 bg-slate-50 relative">
                <div class="max-w-md mx-auto rounded-3xl overflow-hidden border-4 border-slate-200 shadow-inner relative z-10 bg-black">
                    <div id="reader" style="width: 100%; min-height: 300px;"></div>
                </div>
                
                <!-- Scanner Decoration -->
                <div class="absolute inset-0 pointer-events-none flex items-center justify-center">
                    <div class="w-64 h-64 border-2 border-dashed border-emerald-400/50 rounded-3xl animate-[pulse_2s_ease-in-out_infinite]"></div>
                </div>
            </div>
            
            <div class="p-4 bg-white border-t border-slate-100">
                <p class="text-xs font-semibold tracking-wider text-slate-400 uppercase">Sistem Absensi Otomatis</p>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        const scanner = new Html5Qrcode("reader");

        function showMessage(type, message) {
            const el = document.getElementById('result-message');
            const textEl = document.getElementById('result-text');
            const iconSuccess = document.getElementById('result-icon-success');
            const iconError = document.getElementById('result-icon-error');
            const iconInfo = document.getElementById('result-icon-info');
            
            // Reset state
            el.className = 'p-4 rounded-xl mb-6 flex items-center shadow-lg font-medium transform transition-all duration-300 translate-y-0 opacity-100';
            iconSuccess.classList.add('hidden');
            iconError.classList.add('hidden');
            iconInfo.classList.add('hidden');

            if (type === 'success') {
                el.classList.add('bg-emerald-50', 'text-emerald-800', 'border', 'border-emerald-200');
                iconSuccess.classList.remove('hidden');
                iconSuccess.classList.add('text-emerald-500');
            } else if (type === 'error') {
                el.classList.add('bg-red-50', 'text-red-800', 'border', 'border-red-200');
                iconError.classList.remove('hidden');
                iconError.classList.add('text-red-500');
            } else {
                el.classList.add('bg-blue-50', 'text-blue-800', 'border', 'border-blue-200');
                iconInfo.classList.remove('hidden');
                iconInfo.classList.add('text-blue-500');
            }

            textEl.innerText = message;

            setTimeout(() => {
                el.classList.add('-translate-y-4', 'opacity-0');
                setTimeout(() => el.classList.add('hidden'), 500); // Wait for transition
            }, 4000); 
        }

        function sendScanResult(kodeQR) {
            // Optional: Pause scanner while processing to prevent duplicate sends instantly
            scanner.pause();
            
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
                setTimeout(() => scanner.resume(), 2000); // Resume after 2 sec
            })
            .catch(() => {
                showMessage('error', 'Terjadi kesalahan sistem.');
                setTimeout(() => scanner.resume(), 2000);
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
