<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/panitia/export-pdf', [\App\Http\Controllers\PanitiaController::class, 'exportPdf'])->name('admin.panitia.export-pdf');
    Route::resource('admin/panitia', \App\Http\Controllers\PanitiaController::class)
        ->names('admin.panitia')
        ->parameters(['panitia' => 'panitia']);

    Route::post('/event/{event}/assign-panitia', [\App\Http\Controllers\EventController::class, 'assignPanitia'])->name('event.assign.panitia');
    Route::delete('/event/{event}/remove-panitia/{panitia}', [\App\Http\Controllers\EventController::class, 'removePanitia'])->name('event.remove.panitia');
    Route::post('/event/{event}/clear-peserta', [\App\Http\Controllers\EventController::class, 'clearPeserta'])->name('event.clear.peserta');
    Route::get('/event/{event}/export-peserta-pdf', [\App\Http\Controllers\EventController::class, 'exportPesertaPdf'])->name('event.export.peserta.pdf');
});

// MVP 3 — Panitia portal
Route::middleware(['auth', 'role:panitia'])->group(function () {
    Route::get('/panitia/dashboard', [\App\Http\Controllers\PanitiaDashboardController::class, 'dashboard'])->name('panitia.dashboard');
    Route::get('/panitia/event/{id}', [\App\Http\Controllers\PanitiaDashboardController::class, 'detail'])->name('panitia.event.detail');
    Route::get('/panitia/event/{id}/scan', [\App\Http\Controllers\PanitiaDashboardController::class, 'scan'])->name('panitia.event.scan');
    Route::post('/panitia/scan/check', [\App\Http\Controllers\PanitiaDashboardController::class, 'checkScan'])->name('panitia.scan.check');
    Route::get('/panitia/event/{id}/registrasi-offline', [\App\Http\Controllers\PanitiaDashboardController::class, 'registrasiOffline'])->name('panitia.event.registrasi-offline');
    Route::post('/panitia/event/{id}/registrasi-offline', [\App\Http\Controllers\PanitiaDashboardController::class, 'storeRegistrasiOffline'])->name('panitia.event.registrasi-offline.store');
    Route::get('/panitia/event/{id}/infaq', [\App\Http\Controllers\PanitiaDashboardController::class, 'infaqForm'])->name('panitia.event.infaq');
    Route::post('/panitia/event/{id}/infaq', [\App\Http\Controllers\PanitiaDashboardController::class, 'storeInfaq'])->name('panitia.event.infaq.store');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('event', EventController::class)->except(['show']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/event-manage', [EventController::class, 'manage'])->name('event.manage');
    Route::get('/event/{id}/detail', [EventController::class, 'detail'])->name('event.detail');
});

Route::get('/', [EventController::class, 'publicIndex'])->name('dashboard.kajian');
Route::get('/kajian/{id}/daftar', [EventController::class, 'showForm'])->name('pendaftaran.form');
Route::post('/kajian/{id}/daftar', [EventController::class, 'submitForm'])->name('pendaftaran.submit');
Route::get('/tiket/{kode}', [EventController::class, 'showTicket'])->name('tiket.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/scan', [App\Http\Controllers\ScanController::class, 'index'])->name('event.scan');
    Route::post('/scan/check', [App\Http\Controllers\ScanController::class, 'check'])->name('event.scan.check');
});
