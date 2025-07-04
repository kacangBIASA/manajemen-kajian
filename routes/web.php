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

    Route::middleware(['auth'])->group(function () {
        Route::get('/admin', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });

    Route::middleware(['auth'])->group(function () {
        Route::resource('event', EventController::class)->except(['show']);
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/event-manage', [EventController::class, 'manage'])->name('event.manage');
    });

    Route::get('/', [EventController::class, 'publicIndex'])->name('dashboard.kajian');
    Route::get('/kajian/{id}/daftar', [EventController::class, 'showForm'])->name('pendaftaran.form');
    Route::post('/kajian/{id}/daftar', [EventController::class, 'submitForm'])->name('pendaftaran.submit');