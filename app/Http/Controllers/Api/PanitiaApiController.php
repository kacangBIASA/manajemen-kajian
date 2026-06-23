<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\InfaqRecord;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PanitiaApiController extends Controller
{
    public function events(Request $request)
    {
        $events = $request->user()->events()->withCount('pendaftarans')->orderBy('tanggal')->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Daftar kajian berhasil diambil.',
            'data'    => $events->map(fn($e) => [
                'id'            => $e->id,
                'nama'          => $e->nama,
                'pemateri'      => $e->pemateri,
                'tanggal'       => $e->tanggal,
                'waktu'         => $e->waktu,
                'tempat'        => $e->tempat,
                'tipe'          => $e->tipe,
                'link_online'   => $e->link_online,
                'total_peserta' => $e->pendaftarans_count,
            ]),
        ]);
    }

    public function peserta(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        if (!$request->user()->events()->where('event_id', $id)->exists()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Anda tidak ditugaskan ke event ini.',
                'data'    => null,
            ], 403);
        }

        $peserta = $event->pendaftarans()->with('scanner')->latest()->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Daftar peserta berhasil diambil.',
            'data'    => [
                'event'       => ['id' => $event->id, 'nama' => $event->nama],
                'total'       => $peserta->count(),
                'hadir'       => $peserta->where('status', 'Hadir')->count(),
                'belum_hadir' => $peserta->where('status', 'Belum Hadir')->count(),
                'peserta'     => $peserta->map(fn($p) => [
                    'id'          => $p->id,
                    'nama'        => $p->nama,
                    'no_hp'       => $p->no_hp,
                    'status'      => $p->status,
                    'scanned_by'  => $p->scanner?->name,
                    'scanned_at'  => $p->scanned_at?->format('Y-m-d H:i:s'),
                ]),
            ],
        ]);
    }

    public function scan(Request $request)
    {
        $request->validate([
            'kode_qr'  => 'required|string',
            'event_id' => 'required|integer|exists:events,id',
        ]);

        if (!$request->user()->events()->where('event_id', $request->event_id)->exists()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Anda tidak ditugaskan ke event ini.',
                'data'    => null,
            ], 403);
        }

        $pendaftar = Pendaftaran::where('kode_qr', $request->kode_qr)
            ->where('event_id', $request->event_id)
            ->first();

        if (!$pendaftar) {
            return response()->json([
                'status'  => 'error',
                'message' => 'QR Code tidak ditemukan untuk event ini.',
                'data'    => null,
            ], 404);
        }

        if ($pendaftar->status === 'Hadir') {
            return response()->json([
                'status'  => 'info',
                'message' => 'Peserta sudah absen sebelumnya.',
                'data'    => [
                    'nama'       => $pendaftar->nama,
                    'status'     => $pendaftar->status,
                    'scanned_at' => $pendaftar->scanned_at?->format('Y-m-d H:i:s'),
                ],
            ]);
        }

        $pendaftar->update([
            'status'     => 'Hadir',
            'scanned_by' => $request->user()->id,
            'scanned_at' => now(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Absensi berhasil dicatat.',
            'data'    => [
                'nama'       => $pendaftar->nama,
                'status'     => 'Hadir',
                'scanned_at' => now()->format('Y-m-d H:i:s'),
            ],
        ]);
    }

    public function storeInfaq(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        if (!$request->user()->events()->where('event_id', $id)->exists()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Anda tidak ditugaskan ke event ini.',
                'data'    => null,
            ], 403);
        }

        $request->validate([
            'nominal' => 'required|integer|min:0',
            'catatan' => 'nullable|string|max:255',
        ]);

        $record = InfaqRecord::create([
            'event_id'   => $id,
            'panitia_id' => $request->user()->id,
            'nominal'    => $request->nominal,
            'catatan'    => $request->catatan,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Infaq berhasil dicatat.',
            'data'    => [
                'id'         => $record->id,
                'nominal'    => $record->nominal,
                'catatan'    => $record->catatan,
                'created_at' => $record->created_at->format('Y-m-d H:i:s'),
            ],
        ], 201);
    }
}
