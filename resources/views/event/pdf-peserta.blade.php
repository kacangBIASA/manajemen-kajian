<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Peserta — {{ $event->nama }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1f2937; background: #fff; }

        .header { padding: 16px 0 12px; border-bottom: 2px solid #15803d; margin-bottom: 14px; }
        .header-top { display: flex; justify-content: space-between; align-items: flex-start; }
        .brand h1 { font-size: 18px; font-weight: 700; color: #15803d; }
        .brand p { font-size: 10px; color: #6b7280; margin-top: 2px; }
        .event-info { text-align: right; font-size: 10px; color: #6b7280; line-height: 1.6; }
        .event-info strong { color: #374151; font-size: 12px; display: block; margin-bottom: 2px; }

        .stats { display: flex; gap: 10px; margin-bottom: 12px; }
        .stat-box { flex: 1; border: 1px solid #e5e7eb; border-radius: 6px; padding: 8px 10px; text-align: center; }
        .stat-box .num { font-size: 18px; font-weight: 700; color: #1f2937; }
        .stat-box .lbl { font-size: 9px; color: #9ca3af; margin-top: 1px; }
        .stat-box.hadir .num { color: #16a34a; }
        .stat-box.belum .num { color: #d97706; }
        .stat-box.infaq .num { font-size: 13px; color: #2563eb; }

        table { width: 100%; border-collapse: collapse; }
        thead tr { background-color: #15803d; color: #fff; }
        thead th { padding: 7px 8px; text-align: left; font-size: 10px; font-weight: 600; letter-spacing: 0.4px; }
        tbody tr:nth-child(even) { background-color: #f0fdf4; }
        tbody tr { border-bottom: 1px solid #e5e7eb; }
        tbody td { padding: 6px 8px; vertical-align: middle; font-size: 10px; }

        .badge-hadir { display: inline-block; padding: 1px 7px; border-radius: 9999px; font-size: 9px; font-weight: 700; background: #dcfce7; color: #15803d; }
        .badge-belum { display: inline-block; padding: 1px 7px; border-radius: 9999px; font-size: 9px; font-weight: 700; background: #fef3c7; color: #b45309; }
        .scan-info { font-size: 9px; color: #9ca3af; }

        .footer { margin-top: 14px; padding-top: 8px; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; font-size: 9px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-top">
            <div class="brand">
                <h1>TADZKIRAH</h1>
                <p>Pengingat Kajian untuk Umat</p>
            </div>
            <div class="event-info">
                <strong>{{ $event->nama }}</strong>
                {{ $event->pemateri ? 'Pemateri: ' . $event->pemateri . ' · ' : '' }}
                {{ \Carbon\Carbon::parse($event->tanggal)->isoFormat('D MMMM Y') }} · {{ \Illuminate\Support\Str::substr($event->waktu, 0, 5) }} WIB<br>
                {{ $event->tempat }}
            </div>
        </div>
    </div>

    @php
        $hadir = $peserta->where('status', 'Hadir')->count();
        $belum = $peserta->where('status', 'Belum Hadir')->count();
        $infaq = $peserta->sum('infaq_nominal');
    @endphp

    <div class="stats">
        <div class="stat-box">
            <div class="num">{{ $peserta->count() }}</div>
            <div class="lbl">Total Peserta</div>
        </div>
        <div class="stat-box hadir">
            <div class="num">{{ $hadir }}</div>
            <div class="lbl">Hadir</div>
        </div>
        <div class="stat-box belum">
            <div class="num">{{ $belum }}</div>
            <div class="lbl">Belum Hadir</div>
        </div>
        <div class="stat-box infaq">
            <div class="num">Rp {{ number_format($infaq, 0, ',', '.') }}</div>
            <div class="lbl">Total Infaq Peserta</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:24px">#</th>
                <th>Nama</th>
                <th>No. HP</th>
                <th>Alamat</th>
                <th style="width:70px">Status</th>
                <th>Discan Oleh</th>
                <th>Infaq</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peserta as $i => $p)
                <tr>
                    <td style="color:#9ca3af;text-align:center">{{ $i + 1 }}</td>
                    <td><strong>{{ $p->nama }}</strong></td>
                    <td>{{ $p->no_hp }}</td>
                    <td>{{ $p->alamat }}</td>
                    <td>
                        @if ($p->status === 'Hadir')
                            <span class="badge-hadir">Hadir</span>
                        @else
                            <span class="badge-belum">Belum</span>
                        @endif
                    </td>
                    <td>
                        @if ($p->scanner)
                            {{ $p->scanner->name }}
                            @if ($p->scanned_at)
                                <br><span class="scan-info">{{ $p->scanned_at->format('H:i') }} WIB</span>
                            @endif
                        @else
                            <span style="color:#d1d5db">—</span>
                        @endif
                    </td>
                    <td>
                        @if ($p->infaq_nominal)
                            Rp {{ number_format($p->infaq_nominal, 0, ',', '.') }}
                        @else
                            <span style="color:#d1d5db">—</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;color:#9ca3af;padding:16px">
                        Belum ada peserta yang mendaftar.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <span>Tadzkirah &copy; {{ date('Y') }}</span>
        <span>Dicetak: {{ now()->isoFormat('D MMMM Y, HH:mm') }} WIB</span>
    </div>
</body>
</html>
