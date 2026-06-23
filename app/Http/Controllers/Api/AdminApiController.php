<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminApiController extends Controller
{
    // ── Events ────────────────────────────────────────────────────────────

    public function events()
    {
        $events = Event::withCount('pendaftarans')->orderBy('tanggal')->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Daftar kajian berhasil diambil.',
            'data'    => $events->map(fn($e) => [
                'id'                => $e->id,
                'nama'              => $e->nama,
                'pemateri'          => $e->pemateri,
                'tanggal'           => $e->tanggal,
                'waktu'             => $e->waktu,
                'tempat'            => $e->tempat,
                'tipe'              => $e->tipe,
                'metode_pembayaran' => $e->metode_pembayaran,
                'total_peserta'     => $e->pendaftarans_count,
            ]),
        ]);
    }

    public function createEvent(Request $request)
    {
        $request->validate([
            'nama'               => 'required|string|max:255',
            'pemateri'           => 'nullable|string|max:255',
            'moderator'          => 'nullable|string|max:255',
            'tanggal'            => 'required|date',
            'waktu'              => 'required',
            'tipe'               => 'required|in:offline,online',
            'tempat'             => 'required|string',
            'link_online'        => 'nullable|url|required_if:tipe,online',
            'deskripsi'          => 'nullable|string',
            'metode_pembayaran'  => 'required|in:Gratis,Berbayar',
            'harga'              => 'nullable|integer|min:0|required_if:metode_pembayaran,Berbayar',
        ]);

        $event = Event::create($request->only([
            'nama', 'pemateri', 'moderator', 'tanggal', 'waktu',
            'tipe', 'tempat', 'link_online', 'deskripsi', 'metode_pembayaran', 'harga',
        ]));

        return response()->json([
            'status'  => 'success',
            'message' => 'Kajian berhasil dibuat.',
            'data'    => $this->eventResource($event),
        ], 201);
    }

    public function updateEvent(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // PATCH: hanya validasi field yang dikirim. PUT: semua required.
        $isPatch = $request->isMethod('PATCH');

        $request->validate([
            'nama'               => ($isPatch ? 'sometimes|' : '') . 'required|string|max:255',
            'pemateri'           => 'nullable|string|max:255',
            'moderator'          => 'nullable|string|max:255',
            'tanggal'            => ($isPatch ? 'sometimes|' : '') . 'required|date',
            'waktu'              => ($isPatch ? 'sometimes|' : '') . 'required',
            'tipe'               => ($isPatch ? 'sometimes|' : '') . 'required|in:offline,online',
            'tempat'             => ($isPatch ? 'sometimes|' : '') . 'required|string',
            'link_online'        => 'nullable|url',
            'deskripsi'          => 'nullable|string',
            'metode_pembayaran'  => ($isPatch ? 'sometimes|' : '') . 'required|in:Gratis,Berbayar',
            'harga'              => 'nullable|integer|min:0',
        ]);

        $event->update($request->only([
            'nama', 'pemateri', 'moderator', 'tanggal', 'waktu',
            'tipe', 'tempat', 'link_online', 'deskripsi', 'metode_pembayaran', 'harga',
        ]));

        return response()->json([
            'status'  => 'success',
            'message' => 'Kajian berhasil diperbarui.',
            'data'    => $this->eventResource($event->fresh()),
        ]);
    }

    public function deleteEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Kajian berhasil dihapus.',
            'data'    => null,
        ]);
    }

    private function eventResource(Event $event): array
    {
        return [
            'id'                => $event->id,
            'nama'              => $event->nama,
            'pemateri'          => $event->pemateri,
            'moderator'         => $event->moderator,
            'tanggal'           => $event->tanggal,
            'waktu'             => $event->waktu,
            'tempat'            => $event->tempat,
            'tipe'              => $event->tipe,
            'link_online'       => $event->link_online,
            'deskripsi'         => $event->deskripsi,
            'metode_pembayaran' => $event->metode_pembayaran,
            'harga'             => $event->harga,
        ];
    }

    // ── Peserta & Infaq ───────────────────────────────────────────────────

    public function peserta($id)
    {
        $event   = Event::findOrFail($id);
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
                    'id'            => $p->id,
                    'nama'          => $p->nama,
                    'no_hp'         => $p->no_hp,
                    'alamat'        => $p->alamat,
                    'status'        => $p->status,
                    'kode_qr'       => $p->kode_qr,
                    'infaq_nominal' => $p->infaq_nominal,
                    'scanned_by'    => $p->scanner?->name,
                    'scanned_at'    => $p->scanned_at?->format('Y-m-d H:i:s'),
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
                'panitia' => $records->first()->panitia->name,
                'total'   => $records->sum('nominal'),
                'catatan' => $records->map(fn($r) => [
                    'nominal'    => $r->nominal,
                    'catatan'    => $r->catatan,
                    'created_at' => $r->created_at->format('Y-m-d H:i:s'),
                ])->values(),
            ])->values();

        return response()->json([
            'status'  => 'success',
            'message' => 'Rekap infaq berhasil diambil.',
            'data'    => [
                'event'              => ['id' => $event->id, 'nama' => $event->nama],
                'total_peserta'      => $totalPeserta,
                'total_panitia'      => $totalPanitia,
                'total_keseluruhan'  => $totalPeserta + $totalPanitia,
                'rekap_per_panitia'  => $rekapPerPanitia,
            ],
        ]);
    }

    // ── Panitia CRUD ──────────────────────────────────────────────────────

    public function listPanitia()
    {
        $panitia = User::where('role', 'panitia')
            ->withCount('events')
            ->latest()
            ->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Daftar panitia berhasil diambil.',
            'data'    => $panitia->map(fn($p) => [
                'id'           => $p->id,
                'name'         => $p->name,
                'email'        => $p->email,
                'total_events' => $p->events_count,
            ]),
        ]);
    }

    public function showPanitia($id)
    {
        $panitia = User::where('role', 'panitia')->with('events')->findOrFail($id);

        return response()->json([
            'status'  => 'success',
            'message' => 'Detail panitia berhasil diambil.',
            'data'    => [
                'id'     => $panitia->id,
                'name'   => $panitia->name,
                'email'  => $panitia->email,
                'events' => $panitia->events->map(fn($e) => [
                    'id'      => $e->id,
                    'nama'    => $e->nama,
                    'tanggal' => $e->tanggal,
                ]),
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

    public function updatePanitia(Request $request, $id)
    {
        $panitia = User::where('role', 'panitia')->findOrFail($id);

        $isPatch = $request->isMethod('PATCH');

        $request->validate([
            'name'     => ($isPatch ? 'sometimes|' : '') . 'required|string|max:255',
            'email'    => ($isPatch ? 'sometimes|' : '') . 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        $data = $request->only(['name', 'email']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $panitia->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data panitia berhasil diperbarui.',
            'data'    => [
                'id'    => $panitia->id,
                'name'  => $panitia->name,
                'email' => $panitia->email,
            ],
        ]);
    }

    public function deletePanitia($id)
    {
        $panitia = User::where('role', 'panitia')->findOrFail($id);
        $panitia->events()->detach();
        $panitia->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Akun panitia berhasil dihapus.',
            'data'    => null,
        ]);
    }

    // ── Assign / Remove Panitia ───────────────────────────────────────────

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

    public function removePanitia($eventId, $panitiaId)
    {
        $event   = Event::findOrFail($eventId);
        $panitia = User::where('role', 'panitia')->findOrFail($panitiaId);

        $event->panitias()->detach($panitia->id);

        return response()->json([
            'status'  => 'success',
            'message' => $panitia->name . ' berhasil dilepas dari ' . $event->nama . '.',
            'data'    => null,
        ]);
    }
}
