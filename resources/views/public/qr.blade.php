@extends('layouts.public')

@section('title', 'Tiket QR — Tadzkirah')

@section('content')
    <div class="max-w-sm mx-auto">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm p-8 text-center">
            <div class="mb-5">
                <div class="h-12 w-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Pendaftaran Berhasil!</h2>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Atas nama</p>
                <p class="text-lg font-semibold text-green-700 dark:text-green-400 mt-0.5">{{ $pendaftar->nama }}</p>
            </div>

            {{-- QR selalu bg putih meski dark mode --}}
            <div class="mb-4 flex justify-center">
                <div class="bg-white p-3 rounded-xl inline-block shadow-sm border border-gray-100">
                    {!! DNS2D::getBarcodeHTML($pendaftar->kode_qr, 'QRCODE', 6, 6) !!}
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-lg px-4 py-3 mb-5">
                <p class="text-xs font-mono text-gray-500 dark:text-gray-400">{{ $pendaftar->kode_qr }}</p>
            </div>

            <p class="text-xs text-gray-400 dark:text-gray-500 mb-5">
                Screenshot atau download QR ini sebagai tiket kehadiran. Tunjukkan ke panitia saat registrasi ulang.
            </p>

            <div class="flex flex-col gap-2">
                <button onclick="downloadQR()"
                    class="w-full px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition flex items-center justify-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download Tiket
                </button>
                <a href="{{ route('dashboard.kajian') }}"
                    class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg text-sm font-medium transition">
                    Kembali ke Daftar Kajian
                </a>
            </div>
        </div>
    </div>

    {{-- Tiket untuk di-download (hidden, off-screen) --}}
    <div id="ticket-download" style="
        position: fixed;
        left: -9999px;
        top: 0;
        width: 420px;
        background: #ffffff;
        font-family: 'Segoe UI', Arial, sans-serif;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(0,0,0,0.10);
    ">
        {{-- Header hijau --}}
        <div style="background: #16a34a; padding: 20px 24px 16px; text-align: center;">
            <div style="color: #bbf7d0; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 2px;">تذكرة</div>
            <div style="color: #ffffff; font-size: 20px; font-weight: 700; letter-spacing: 0.5px;">Tadzkirah</div>
            <div style="color: #bbf7d0; font-size: 11px; margin-top: 2px;">Tiket Kehadiran Kajian</div>
        </div>

        {{-- Nama event --}}
        <div style="background: #f0fdf4; padding: 14px 24px; text-align: center; border-bottom: 1px dashed #86efac;">
            <div style="color: #6b7280; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Kajian</div>
            <div style="color: #111827; font-size: 15px; font-weight: 700; line-height: 1.3;">{{ $event->nama }}</div>
            @if ($event->pemateri)
            <div style="color: #16a34a; font-size: 12px; margin-top: 4px;">{{ $event->pemateri }}</div>
            @endif
        </div>

        {{-- Info event --}}
        <div style="padding: 12px 24px; background: #ffffff; border-bottom: 1px dashed #e5e7eb; display: flex; gap: 12px; justify-content: center;">
            <div style="text-align: center;">
                <div style="color: #9ca3af; font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">Tanggal</div>
                <div style="color: #111827; font-size: 12px; font-weight: 600; margin-top: 2px;">
                    {{ \Carbon\Carbon::parse($event->tanggal)->locale('id')->isoFormat('D MMM Y') }}
                </div>
            </div>
            <div style="width: 1px; background: #e5e7eb;"></div>
            <div style="text-align: center;">
                <div style="color: #9ca3af; font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">Waktu</div>
                <div style="color: #111827; font-size: 12px; font-weight: 600; margin-top: 2px;">
                    {{ \Illuminate\Support\Str::substr($event->waktu, 0, 5) }} WIB
                </div>
            </div>
            <div style="width: 1px; background: #e5e7eb;"></div>
            <div style="text-align: center;">
                <div style="color: #9ca3af; font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">Tempat</div>
                <div style="color: #111827; font-size: 12px; font-weight: 600; margin-top: 2px;">{{ Str::limit($event->tempat, 20) }}</div>
            </div>
        </div>

        {{-- Nama peserta --}}
        <div style="padding: 14px 24px; text-align: center; border-bottom: 1px dashed #e5e7eb;">
            <div style="color: #9ca3af; font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">Atas Nama</div>
            <div style="color: #111827; font-size: 18px; font-weight: 700; margin-top: 4px;">{{ $pendaftar->nama }}</div>
        </div>

        {{-- QR Code --}}
        <div style="padding: 20px 24px; text-align: center; background: #ffffff;">
            <div style="display: inline-block; background: #ffffff; padding: 12px; border-radius: 12px; border: 1px solid #e5e7eb;">
                {!! DNS2D::getBarcodeHTML($pendaftar->kode_qr, 'QRCODE', 5, 5) !!}
            </div>
            <div style="margin-top: 10px; color: #9ca3af; font-size: 10px; font-family: monospace; letter-spacing: 1px;">{{ $pendaftar->kode_qr }}</div>
        </div>

        {{-- Footer --}}
        <div style="background: #f9fafb; padding: 10px 24px; text-align: center; border-top: 1px solid #e5e7eb;">
            <div style="color: #9ca3af; font-size: 10px;">Tunjukkan tiket ini kepada panitia saat registrasi ulang</div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        function downloadQR() {
            const ticket = document.getElementById('ticket-download');
            html2canvas(ticket, {
                backgroundColor: '#ffffff',
                scale: 3,
                useCORS: true,
                allowTaint: true
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = 'tiket-{{ Str::slug($pendaftar->nama) }}.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        }
    </script>
@endsection
