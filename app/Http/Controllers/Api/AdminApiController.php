<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminApiController extends Controller
{
    public function peserta($id)
    {
        $event = Event::with(['pendaftarans.scanner'])->findOrFail($id);
        $peserta = $event->pendaftarans()->with('scanner')->latest()->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Daftar peserta berhasil diambil.',
            'data'    => [
                'event'       => ['id' => $event->id, 'nama' => $event->nama, 'tanggal' => $event->tanggal],
                'total'       => $peserta->count(),
                'hadir'       => $peserta->where('status', 'Hadir')->count(),
                'belum_hadir' => $peserta->where('status', 'Belum Hadir')->count(),
                'peserta'     => $peserta->map(fn($p) => [
                    'id'               => $p->id,
                    'nama'             => $p->nama,
                    'no_hp'            => $p->no_hp,
                    'alamat'           => $p->alamat,
                    'status'           => $p->status,
                    'kode_qr'          => $p->kode_qr,
                    'infaq_nominal'    => $p->infaq_nominal,
                    'scanned_by'       => $p->scanner?->name,
                    'scanned_at'       => $p->scanned_at?->format('Y-m-d H:i:s'),
                ]),
            ],
        ]);
    }

    public function infaq($id)
    {
        $event = Event::with(['infaqRecords.panitia', 'pendaftarans'])->findOrFail($id);

        $totalPeserta = $event->pendaftarans->sum('infaq_nominal');
        $totalPanitia = $event->infaqRecords->sum('nominal');

        $rekapPerPanitia = $event->infaqRecords
            ->groupBy('panitia_id')
            ->map(fn($records) => [
                'panitia'  => $records->first()->panitia->name,
                'total'    => $records->sum('nominal'),
                'catatan'  => $records->map(fn($r) => [
                    'nominal'    => $r->nominal,
                    'catatan'    => $r->catatan,
                    'created_at' => $r->created_at->format('Y-m-d H:i:s'),
                ])->values(),
            ])->values();

        return response()->json([
            'status'  => 'success',
            'message' => 'Rekap infaq berhasil diambil.',
            'data'    => [
                'event'            => ['id' => $event->id, 'nama' => $event->nama],
                'total_peserta'    => $totalPeserta,
                'total_panitia'    => $totalPanitia,
                'total_keseluruhan' => $totalPeserta + $totalPanitia,
                'rekap_per_panitia' => $rekapPerPanitia,
            ],
        ]);
    }

    public function createPanitia(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $panitia = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'panitia',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Akun panitia berhasil dibuat.',
            'data'    => [
                'id'    => $panitia->id,
                'name'  => $panitia->name,
                'email' => $panitia->email,
                'role'  => $panitia->role,
            ],
        ], 201);
    }

    public function assignPanitia(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'panitia_id' => 'required|exists:users,id',
        ]);

        $panitia = User::findOrFail($request->panitia_id);

        if ($panitia->role !== 'panitia') {
            return response()->json([
                'status'  => 'error',
                'message' => 'User yang dipilih bukan panitia.',
                'data'    => null,
            ], 422);
        }

        $event->panitias()->syncWithoutDetaching([$request->panitia_id]);

        return response()->json([
            'status'  => 'success',
            'message' => $panitia->name . ' berhasil ditugaskan ke ' . $event->nama . '.',
            'data'    => null,
        ]);
    }
}
