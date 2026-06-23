<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Panitia — Tadzkirah</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #1f2937; background: #fff; }

        .header { text-align: center; padding: 24px 0 16px; border-bottom: 2px solid #15803d; margin-bottom: 20px; }
        .header h1 { font-size: 20px; font-weight: 700; color: #15803d; letter-spacing: 1px; }
        .header p { font-size: 11px; color: #6b7280; margin-top: 4px; }
        .header .meta { margin-top: 8px; font-size: 10px; color: #9ca3af; }

        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        thead tr { background-color: #15803d; color: #fff; }
        thead th { padding: 9px 10px; text-align: left; font-size: 11px; font-weight: 600; letter-spacing: 0.5px; }
        tbody tr:nth-child(even) { background-color: #f0fdf4; }
        tbody tr { border-bottom: 1px solid #e5e7eb; }
        tbody td { padding: 8px 10px; vertical-align: top; font-size: 11px; }

        .no { width: 28px; color: #9ca3af; text-align: center; }
        .events-list { color: #374151; }
        .events-list span { display: block; font-size: 10px; color: #6b7280; }
        .badge { display: inline-block; padding: 1px 6px; border-radius: 9999px; font-size: 9px; font-weight: 600; background: #dcfce7; color: #15803d; }
        .no-events { color: #9ca3af; font-style: italic; font-size: 10px; }

        .footer { margin-top: 24px; padding-top: 12px; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; font-size: 10px; color: #9ca3af; }
        .summary { margin-top: 16px; padding: 10px 14px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 6px; font-size: 11px; color: #166534; }
    </style>
</head>
<body>
    <div class="header">
        <h1>TADZKIRAH</h1>
        <p>Pengingat Kajian untuk Umat</p>
        <div class="meta">
            Laporan Daftar Panitia &nbsp;·&nbsp; Dicetak: {{ now()->isoFormat('D MMMM Y, HH:mm') }} WIB
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="no">#</th>
                <th>Nama Panitia</th>
                <th>Email</th>
                <th>Event yang Ditugaskan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($panitias as $i => $p)
                <tr>
                    <td class="no">{{ $i + 1 }}</td>
                    <td><strong>{{ $p->name }}</strong></td>
                    <td>{{ $p->email }}</td>
                    <td class="events-list">
                        @if ($p->events->isEmpty())
                            <span class="no-events">Belum ada penugasan</span>
                        @else
                            @foreach ($p->events as $e)
                                <span>
                                    <span class="badge">{{ \Carbon\Carbon::parse($e->tanggal)->format('d M Y') }}</span>
                                    {{ $e->nama }}
                                </span>
                            @endforeach
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center; color:#9ca3af; padding:20px;">
                        Belum ada data panitia.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        Total Panitia: <strong>{{ $panitias->count() }} orang</strong>
        &nbsp;·&nbsp;
        Total Penugasan Event: <strong>{{ $panitias->sum(fn($p) => $p->events->count()) }}</strong>
    </div>

    <div class="footer">
        <span>Tadzkirah &copy; {{ date('Y') }}</span>
        <span>Dokumen ini digenerate secara otomatis oleh sistem.</span>
    </div>
</body>
</html>
