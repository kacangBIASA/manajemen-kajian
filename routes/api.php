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
    Route::get('/events/{id}/peserta', [AdminApiController::class, 'peserta']);
    Route::get('/events/{id}/infaq', [AdminApiController::class, 'infaq']);
    Route::post('/panitia', [AdminApiController::class, 'createPanitia']);
    Route::post('/events/{id}/assign-panitia', [AdminApiController::class, 'assignPanitia']);
});
