<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PublicController;
use App\Http\Controllers\Api\PanitiaApiController;
use App\Http\Controllers\Api\AdminApiController;

/*
|--------------------------------------------------------------------------
| API Routes — Tadzkirah
|--------------------------------------------------------------------------
|
| Format response:
| { "status": "success|error|info", "message": "...", "data": {...}|null }
|
| HTTP Status Codes:
| 200 OK          — GET, PUT, PATCH, DELETE berhasil
| 201 Created     — POST berhasil membuat resource
| 401 Unauthorized— tidak terautentikasi
| 403 Forbidden   — tidak punya izin
| 404 Not Found   — resource tidak ditemukan
| 409 Conflict    — duplikat data
| 422 Unprocessable — validasi gagal
|
*/

// ── Auth ──────────────────────────────────────────────────────────────────
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

// ── Public ────────────────────────────────────────────────────────────────
Route::get('/events', [PublicController::class, 'events']);
Route::get('/events/{id}', [PublicController::class, 'eventDetail']);
Route::post('/events/{id}/daftar', [PublicController::class, 'daftar']);
Route::get('/tiket/{kode}', [PublicController::class, 'tiket']);

// ── Panitia ───────────────────────────────────────────────────────────────
Route::middleware(['auth:sanctum', 'role.api:panitia'])->prefix('panitia')->group(function () {
    Route::get('/events', [PanitiaApiController::class, 'events']);
    Route::get('/events/{id}/peserta', [PanitiaApiController::class, 'peserta']);
    Route::post('/scan', [PanitiaApiController::class, 'scan']);
    Route::post('/events/{id}/infaq', [PanitiaApiController::class, 'storeInfaq']);
});

// ── Admin ─────────────────────────────────────────────────────────────────
Route::middleware(['auth:sanctum', 'role.api:admin'])->prefix('admin')->group(function () {

    // Events CRUD
    Route::get('/events', [AdminApiController::class, 'events']);
    Route::post('/events', [AdminApiController::class, 'createEvent']);
    Route::put('/events/{id}', [AdminApiController::class, 'updateEvent']);
    Route::patch('/events/{id}', [AdminApiController::class, 'updateEvent']);
    Route::delete('/events/{id}', [AdminApiController::class, 'deleteEvent']);

    // Peserta & Infaq (read-only)
    Route::get('/events/{id}/peserta', [AdminApiController::class, 'peserta']);
    Route::get('/events/{id}/infaq', [AdminApiController::class, 'infaq']);

    // Assign / Remove Panitia ke Event
    Route::post('/events/{id}/panitia', [AdminApiController::class, 'assignPanitia']);
    Route::delete('/events/{eventId}/panitia/{panitiaId}', [AdminApiController::class, 'removePanitia']);

    // Panitia CRUD
    Route::get('/panitia', [AdminApiController::class, 'listPanitia']);
    Route::post('/panitia', [AdminApiController::class, 'createPanitia']);
    Route::get('/panitia/{id}', [AdminApiController::class, 'showPanitia']);
    Route::put('/panitia/{id}', [AdminApiController::class, 'updatePanitia']);
    Route::patch('/panitia/{id}', [AdminApiController::class, 'updatePanitia']);
    Route::delete('/panitia/{id}', [AdminApiController::class, 'deletePanitia']);
});
