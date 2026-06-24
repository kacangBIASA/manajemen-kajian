<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Pendaftaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest()->get();
        return view('event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'pemateri' => 'nullable|string|max:255',
            'moderator' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'tipe' => 'required|in:offline,online',
            'tempat' => 'required',
            'link_online' => 'nullable|url|required_if:tipe,online',
            'deskripsi' => 'nullable',
            'metode_pembayaran' => 'required|in:Gratis,Berbayar',
            'harga' => 'nullable|integer|min:0|required_if:metode_pembayaran,Berbayar',
            'flyer' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('flyer');

        if ($request->hasFile('flyer')) {
            $data['flyer'] = $request->file('flyer')->store('flyer', 'public');
        }

        Event::create($data);

        return redirect()->route('event.manage')->with('success', 'Event berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'nama' => 'required',
            'pemateri' => 'nullable|string|max:255',
            'moderator' => 'nullable|string|max:255',
            'tanggal' => 'required',
            'waktu' => 'required',
            'tipe' => 'required|in:offline,online',
            'tempat' => 'required',
            'link_online' => 'nullable|url|required_if:tipe,online',
            'deskripsi' => 'nullable',
            'metode_pembayaran' => 'required|in:Gratis,Berbayar',
            'harga' => 'nullable|integer|min:0|required_if:metode_pembayaran,Berbayar',
            'flyer' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('flyer');

        if ($request->hasFile('flyer')) {
            if ($event->flyer) {
                \Storage::disk('public')->delete($event->flyer);
            }
            $data['flyer'] = $request->file('flyer')->store('flyer', 'public');
        }

        $event->update($data);

        return redirect()->route('event.manage')->with('success', 'Event berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return back()->with('success', 'Event berhasil dihapus.');
    }

    public function manage()
    {
        $events = Event::latest()->paginate(10); // pakai pagination biar rapi
        return view('event.manage', compact('events'));
    }

    public function detail($id)
    {
        $event = Event::with(['pendaftarans.scanner', 'panitias', 'infaqRecords.panitia'])->findOrFail($id);
        $peserta = $event->pendaftarans()->latest()->get();
        $totalHadir = $peserta->where('status', 'Hadir')->count();
        $totalBelum = $peserta->where('status', 'Belum Hadir')->count();
        $totalInfaqPeserta = $peserta->sum('infaq_nominal');
        $totalInfaqPanitia = $event->infaqRecords->sum('nominal');
        $totalInfaq = $totalInfaqPeserta + $totalInfaqPanitia;
        $semuaPanitia = \App\Models\User::where('role', 'panitia')->get();
        return view('event.detail', compact(
            'event', 'peserta', 'totalHadir', 'totalBelum',
            'totalInfaq', 'totalInfaqPeserta', 'totalInfaqPanitia', 'semuaPanitia'
        ));
    }

    public function assignPanitia(Request $request, \App\Models\Event $event)
    {
        $request->validate(['panitia_id' => 'required|exists:users,id']);
        $event->panitias()->syncWithoutDetaching([$request->panitia_id]);
        return back()->with('success', 'Panitia berhasil ditugaskan.');
    }

    public function removePanitia(\App\Models\Event $event, \App\Models\User $panitia)
    {
        $event->panitias()->detach($panitia->id);
        return back()->with('success', 'Panitia berhasil dilepas dari event ini.');
    }

    public function publicIndex()
    {
        $events = Event::orderBy('tanggal')->get();
        return view('public.dashboard', compact('events'));
    }

    public function showForm($id)
    {
        $event = Event::findOrFail($id);
        return view('public.form', compact('event'));
    }

    public function submitForm(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $rules = [
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'infaq_nominal' => 'nullable|integer|min:0',
            'infaq_is_custom' => 'nullable|in:0,1',
            'bukti_infaq' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048|required_if:infaq_is_custom,1',
            'motivasi_kajian' => 'nullable|string',
        ];

        if ($event->metode_pembayaran === 'Berbayar') {
            $rules['bukti_pembayaran'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
        }

        $validatedData = $request->validate($rules);

        // Cegah duplikat: no_hp yang sama untuk event yang sama → redirect ke tiket lama
        $existing = Pendaftaran::where('event_id', $event->id)
            ->where('no_hp', $validatedData['no_hp'])
            ->first();

        if ($existing) {
            return redirect()->route('pendaftaran.form', $event->id)
                ->with('error', 'Nomor HP ini sudah terdaftar atas nama "' . $existing->nama . '" di kajian ini. Gunakan nomor HP lain untuk mendaftar.');
        }

        $buktiPath = null;
        if ($event->metode_pembayaran === 'Berbayar' && $request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        $buktiInfaqPath = null;
        if ($request->hasFile('bukti_infaq')) {
            $buktiInfaqPath = $request->file('bukti_infaq')->store('bukti_infaq', 'public');
        }

        $kodeQR = 'QR-' . strtoupper(substr(md5($validatedData['no_hp'] . $event->id), 0, 8)) . '-' . $event->id;

        $pendaftar = Pendaftaran::create([
            'event_id' => $event->id,
            'nama' => $validatedData['nama'],
            'alamat' => $validatedData['alamat'],
            'no_hp' => $validatedData['no_hp'],
            'kode_qr' => $kodeQR,
            'bukti_pembayaran' => $buktiPath,
            'infaq_nominal' => $request->infaq_nominal ?? null,
            'bukti_infaq' => $buktiInfaqPath,
            'motivasi_kajian' => $request->motivasi_kajian ?? null,
            'jenis_registrasi' => 'online',
        ]);

        return redirect()->route('tiket.show', $pendaftar->kode_qr);
    }

    public function exportPesertaPdf(Event $event)
    {
        $peserta = $event->pendaftarans()->with('scanner')->latest()->get();
        $pdf = Pdf::loadView('event.pdf-peserta', compact('event', 'peserta'))
            ->setPaper('a4', 'landscape');
        $filename = 'peserta-' . \Illuminate\Support\Str::slug($event->nama) . '-' . now()->format('Ymd') . '.pdf';
        return $pdf->download($filename);
    }

    public function clearPeserta(Request $request, Event $event)
    {
        $request->validate(['password' => 'required|string']);

        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->with('error', 'Password salah. Data peserta tidak dihapus.');
        }

        $jumlah = $event->pendaftarans()->count();
        $event->pendaftarans()->delete();

        return back()->with('success', $jumlah . ' data peserta berhasil dihapus.');
    }

    public function showTicket($kode)
    {
        $pendaftar = Pendaftaran::where('kode_qr', $kode)->firstOrFail();
        $event = $pendaftar->event;
        return view('public.qr', compact('event', 'pendaftar'));
    }
}
