<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function events()
    {
        $events = Event::withCount('pendaftarans')->orderBy('tanggal')->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Daftar kajian berhasil diambil.',
            'data'    => $events->map(fn($e) => [
                'id'                 => $e->id,
                'nama'               => $e->nama,
                'pemateri'           => $e->pemateri,
                'moderator'          => $e->moderator,
                'tanggal'            => $e->tanggal,
                'waktu'              => $e->waktu,
                'tempat'             => $e->tempat,
                'tipe'               => $e->tipe,
                'link_online'        => $e->link_online,
                'deskripsi'          => $e->deskripsi,
                'metode_pembayaran'  => $e->metode_pembayaran,
                'harga'              => $e->harga,
                'flyer_url'          => $e->flyer ? asset('storage/' . $e->flyer) : null,
                'total_peserta'      => $e->pendaftarans_count,
            ]),
        ]);
    }

    public function eventDetail($id)
    {
        $event = Event::withCount('pendaftarans')->findOrFail($id);

        return response()->json([
            'status'  => 'success',
            'message' => 'Detail kajian berhasil diambil.',
            'data'    => [
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
                'flyer_url'         => $event->flyer ? asset('storage/' . $event->flyer) : null,
                'total_peserta'     => $event->pendaftarans_count,
            ],
        ]);
    }

    public function daftar(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $rules = [
            'nama'             => 'required|string|max:255',
            'alamat'           => 'required|string',
            'no_hp'            => 'required|string|max:20',
            'infaq_nominal'    => 'nullable|integer|min:0',
            'bukti_infaq'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'motivasi_kajian'  => 'nullable|string',
        ];

        if ($event->metode_pembayaran === 'Berbayar') {
            $rules['bukti_pembayaran'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
        }

        $validated = $request->validate($rules);

        $existing = Pendaftaran::where('event_id', $event->id)
            ->where('no_hp', $validated['no_hp'])
            ->first();

        if ($existing) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Nomor HP ini sudah terdaftar atas nama "' . $existing->nama . '" di kajian ini.',
                'data'    => ['kode_qr' => $existing->kode_qr],
            ], 409);
        }

        $buktiPath = null;
        if ($event->metode_pembayaran === 'Berbayar' && $request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        $buktiInfaqPath = null;
        if ($request->hasFile('bukti_infaq')) {
            $buktiInfaqPath = $request->file('bukti_infaq')->store('bukti_infaq', 'public');
        }

        $kodeQR = 'QR-' . strtoupper(substr(md5($validated['no_hp'] . $event->id), 0, 8)) . '-' . $event->id;

        $pendaftar = Pendaftaran::create([
            'event_id'        => $event->id,
            'nama'            => $validated['nama'],
            'alamat'          => $validated['alamat'],
            'no_hp'           => $validated['no_hp'],
            'kode_qr'         => $kodeQR,
            'bukti_pembayaran' => $buktiPath,
            'infaq_nominal'   => $request->infaq_nominal ?? null,
            'bukti_infaq'     => $buktiInfaqPath,
            'motivasi_kajian' => $request->motivasi_kajian ?? null,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Pendaftaran berhasil.',
            'data'    => [
                'kode_qr'   => $pendaftar->kode_qr,
                'nama'      => $pendaftar->nama,
                'tiket_url' => url('/tiket/' . $pendaftar->kode_qr),
            ],
        ], 201);
    }

    public function tiket($kode)
    {
        $pendaftar = Pendaftaran::with('event')->where('kode_qr', $kode)->firstOrFail();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data tiket berhasil diambil.',
            'data'    => [
                'kode_qr'  => $pendaftar->kode_qr,
                'nama'     => $pendaftar->nama,
                'no_hp'    => $pendaftar->no_hp,
                'status'   => $pendaftar->status,
                'event'    => [
                    'id'       => $pendaftar->event->id,
                    'nama'     => $pendaftar->event->nama,
                    'pemateri' => $pendaftar->event->pemateri,
                    'tanggal'  => $pendaftar->event->tanggal,
                    'waktu'    => $pendaftar->event->waktu,
                    'tempat'   => $pendaftar->event->tempat,
                    'tipe'     => $pendaftar->event->tipe,
                    'link_online' => $pendaftar->event->link_online,
                ],
            ],
        ]);
    }
}
