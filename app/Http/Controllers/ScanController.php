<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;

class ScanController extends Controller
{
    public function index()
    {
        return view('event.scan');
    }

    public function check(Request $request)
    {
        $request->validate([
            'kode_qr' => 'required|string',
        ]);

        $pendaftar = Pendaftaran::where('kode_qr', $request->kode_qr)->first();

        if (!$pendaftar) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR Code tidak ditemukan.'
            ]);
        }

        if ($pendaftar->status === 'Hadir') {
            return response()->json([
                'status' => 'info',
                'message' => 'Peserta sudah absen sebelumnya: ' . $pendaftar->nama
            ]);
        }

        $pendaftar->status = 'Hadir';
        $pendaftar->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Absensi berhasil untuk: ' . $pendaftar->nama
        ]);
    }
}
