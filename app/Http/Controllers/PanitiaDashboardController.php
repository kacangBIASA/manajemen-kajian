<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\InfaqRecord;
use App\Models\Pendaftaran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PanitiaDashboardController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today()->toDateString();
        $events = auth()->user()->events()->orderBy('tanggal')->get();
        return view('panitia.dashboard', compact('events', 'today'));
    }

    public function detail($id)
    {
        $event = Event::with(['pendaftarans.scanner', 'infaqRecords.panitia'])->findOrFail($id);
        abort_unless(
            auth()->user()->events()->where('event_id', $id)->exists(),
            403,
            'Anda tidak ditugaskan ke event ini.'
        );

        $peserta = $event->pendaftarans()->latest()->get();
        $totalHadir = $peserta->where('status', 'Hadir')->count();
        $totalBelum = $peserta->where('status', 'Belum Hadir')->count();
        $totalInfaqPeserta = $peserta->sum('infaq_nominal');
        $totalInfaqPanitia = $event->infaqRecords->sum('nominal');
        $totalInfaq = $totalInfaqPeserta + $totalInfaqPanitia;
        $infaqSaya = $event->infaqRecords()->where('panitia_id', auth()->id())->latest()->get();

        return view('panitia.detail', compact(
            'event', 'peserta', 'totalHadir', 'totalBelum',
            'totalInfaq', 'totalInfaqPeserta', 'totalInfaqPanitia', 'infaqSaya'
        ));
    }

    public function scan($id)
    {
        $event = Event::findOrFail($id);
        abort_unless(
            auth()->user()->events()->where('event_id', $id)->exists(),
            403,
            'Anda tidak ditugaskan ke event ini.'
        );
        return view('panitia.scan', compact('event'));
    }

    public function checkScan(Request $request)
    {
        $request->validate([
            'kode_qr'  => 'required|string',
            'event_id' => 'required|integer|exists:events,id',
        ]);

        if (!auth()->user()->events()->where('event_id', $request->event_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Anda tidak ditugaskan ke event ini.']);
        }

        $pendaftar = Pendaftaran::where('kode_qr', $request->kode_qr)
            ->where('event_id', $request->event_id)
            ->first();

        if (!$pendaftar) {
            return response()->json(['status' => 'error', 'message' => 'QR Code tidak ditemukan untuk event ini.']);
        }

        if ($pendaftar->status === 'Hadir') {
            return response()->json([
                'status'  => 'info',
                'message' => 'Sudah absen: ' . $pendaftar->nama,
            ]);
        }

        $pendaftar->update([
            'status'     => 'Hadir',
            'scanned_by' => auth()->id(),
            'scanned_at' => now(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Absensi berhasil: ' . $pendaftar->nama,
        ]);
    }

    public function infaqForm($id)
    {
        $event = Event::findOrFail($id);
        abort_unless(
            auth()->user()->events()->where('event_id', $id)->exists(),
            403,
            'Anda tidak ditugaskan ke event ini.'
        );

        $infaqSaya = InfaqRecord::where('event_id', $id)
            ->where('panitia_id', auth()->id())
            ->latest()
            ->get();

        return view('panitia.infaq', compact('event', 'infaqSaya'));
    }

    public function storeInfaq(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        abort_unless(
            auth()->user()->events()->where('event_id', $id)->exists(),
            403,
            'Anda tidak ditugaskan ke event ini.'
        );

        $request->validate([
            'nominal' => 'required|integer|min:0',
            'catatan' => 'nullable|string|max:255',
        ]);

        InfaqRecord::create([
            'event_id'  => $id,
            'panitia_id' => auth()->id(),
            'nominal'   => $request->nominal,
            'catatan'   => $request->catatan,
        ]);

        return redirect()->route('panitia.event.detail', $id)
            ->with('success', 'Infaq berhasil dicatat.');
    }
}
