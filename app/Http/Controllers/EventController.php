<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $validated = $request->validate([
            'nama' => 'required',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'tempat' => 'required',
            'deskripsi' => 'nullable',
            'metode_pembayaran' => 'required|in:' . Event::METODE_GRATIS . ',' . Event::METODE_BERBAYAR,
            'harga' => 'nullable|integer|min:0|required_if:metode_pembayaran,' . Event::METODE_BERBAYAR,
        ]);

        Event::create($validated);

        return redirect()->route('event.manage')->with('success', 'Event berhasil ditambahkan.');
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
        $validated = $request->validate([
            'nama' => 'required',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'tempat' => 'required',
            'deskripsi' => 'nullable',
            'metode_pembayaran' => 'required|in:' . Event::METODE_GRATIS . ',' . Event::METODE_BERBAYAR,
            'harga' => 'nullable|integer|min:0|required_if:metode_pembayaran,' . Event::METODE_BERBAYAR,
        ]);

        $event->update($validated);

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

        // Atur validasi dasar
        $rules = [
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ];

        // Jika event berbayar, tambahkan validasi file bukti pembayaran
        if ($event->metode_pembayaran === Event::METODE_BERBAYAR) {
            $rules['bukti_pembayaran'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
        }

        $validatedData = $request->validate($rules);

        $pendaftar = DB::transaction(function () use ($request, $event, $validatedData) {
            // Proses upload file jika event berbayar
            $buktiPath = null;
            if ($event->metode_pembayaran === Event::METODE_BERBAYAR && $request->hasFile('bukti_pembayaran')) {
                $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            }

            // Generate kode QR unik
            $kodeQR = 'QR-' . uniqid() . '-' . $event->id;

            // Simpan pendaftaran
            return Pendaftaran::create([
                'event_id' => $event->id,
                'nama' => $validatedData['nama'],
                'alamat' => $validatedData['alamat'],
                'no_hp' => $validatedData['no_hp'],
                'email' => $validatedData['email'],
                'kode_qr' => $kodeQR,
                'bukti_pembayaran' => $buktiPath,
            ]);
        });

        return view('public.qr', compact('event', 'pendaftar'));
    }
}
