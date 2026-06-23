<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PanitiaController extends Controller
{
    public function index()
    {
        $panitias = User::where('role', 'panitia')->withCount('events')->latest()->get();
        return view('admin.panitia.index', compact('panitias'));
    }

    public function create()
    {
        return view('admin.panitia.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'panitia',
        ]);

        return redirect()->route('admin.panitia.index')->with('success', 'Akun panitia berhasil dibuat.');
    }

    public function edit(User $panitia)
    {
        abort_if($panitia->role !== 'panitia', 404);
        return view('admin.panitia.edit', compact('panitia'));
    }

    public function update(Request $request, User $panitia)
    {
        abort_if($panitia->role !== 'panitia', 404);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $panitia->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $panitia->update([
            'name' => $request->name,
            'email' => $request->email,
            ...($request->filled('password') ? ['password' => Hash::make($request->password)] : []),
        ]);

        return redirect()->route('admin.panitia.index')->with('success', 'Data panitia berhasil diperbarui.');
    }

    public function destroy(User $panitia)
    {
        abort_if($panitia->role !== 'panitia', 404);
        $panitia->delete();
        return back()->with('success', 'Akun panitia berhasil dihapus.');
    }

    public function exportPdf()
    {
        $panitias = User::where('role', 'panitia')->with('events')->latest()->get();
        $pdf = Pdf::loadView('admin.panitia.pdf', compact('panitias'))
            ->setPaper('a4', 'portrait');
        return $pdf->download('daftar-panitia-' . now()->format('Ymd') . '.pdf');
    }
}
