# Sprint 2 — Role System & Dashboard Panitia

## Konteks
Sprint 1 selesai dengan sistem pendaftaran publik, QR tiket, dan scan presensi oleh admin.
Sprint 2 memperkenalkan **role panitia** sebagai peran terpisah dari admin, dengan akses terbatas dan dashboard sendiri.

---

## Role yang Ada

| Role | Akses |
|------|-------|
| `admin` | Full access: kelola event, kelola panitia, lihat semua data |
| `panitia` | Terbatas: hanya event yang ditugaskan, scan presensi, catat infaq di lokasi |

---

## Perubahan Database

### 1. Tambah kolom `role` ke tabel `users`
```sql
ALTER TABLE users ADD COLUMN role ENUM('admin', 'panitia') DEFAULT 'admin';
```

### 2. Buat tabel `event_panitia` (pivot)
```sql
CREATE TABLE event_panitia (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    event_id BIGINT REFERENCES events(id),
    user_id  BIGINT REFERENCES users(id),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### 3. Tambah kolom ke tabel `pendaftarans`
```sql
ALTER TABLE pendaftarans
  ADD COLUMN scanned_by BIGINT NULL REFERENCES users(id),
  ADD COLUMN scanned_at TIMESTAMP NULL;
```

### 4. Buat tabel `infaq_records` (opsional — jika infaq dicatat terpisah oleh panitia)
```sql
CREATE TABLE infaq_records (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    event_id   BIGINT REFERENCES events(id),
    panitia_id BIGINT REFERENCES users(id),
    nominal    INTEGER NOT NULL,
    catatan    TEXT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## Flow Lengkap

### Admin
1. Login → redirect ke `/admin/dashboard`
2. Buat event kajian
3. Buat akun panitia (nama, email, password)
4. Assign panitia ke event (bisa lebih dari 1 panitia per event)
5. Lihat detail event: daftar peserta, total hadir, total infaq (gabungan semua panitia)

### Panitia
1. Login → redirect ke `/panitia/dashboard`
2. Dashboard menampilkan daftar event yang ditugaskan (event hari ini di-highlight)
3. Masuk ke event → bisa:
   - **Scan QR** peserta → otomatis tandai hadir + catat `scanned_by` & `scanned_at`
   - **Lihat peserta** event: filter hadir / belum hadir
   - **Catat infaq** yang diterima langsung di lokasi (nominal + catatan)

---

## Routes yang Direncanakan

```php
// Middleware: auth + role:admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', ...)->name('admin.dashboard');
    Route::resource('panitia', PanitiaController::class);
    Route::post('/event/{event}/assign-panitia', ...)->name('event.assign.panitia');
});

// Middleware: auth + role:panitia
Route::prefix('panitia')->middleware(['auth', 'role:panitia'])->group(function () {
    Route::get('/dashboard', ...)->name('panitia.dashboard');
    Route::get('/event/{event}', ...)->name('panitia.event.show');
    Route::get('/event/{event}/scan', ...)->name('panitia.scan');
    Route::post('/event/{event}/infaq', ...)->name('panitia.infaq.store');
});
```

---

## Middleware Role

Buat `app/Http/Middleware/CheckRole.php`:
```php
public function handle($request, Closure $next, $role)
{
    if (auth()->user()->role !== $role) {
        abort(403);
    }
    return $next($request);
}
```

Register di `app/Http/Kernel.php`:
```php
'role' => \App\Http\Middleware\CheckRole::class,
```

---

## Redirect Login Berdasarkan Role

Di `app/Http/Controllers/Auth/AuthenticatedSessionController.php`, setelah login:
```php
$role = auth()->user()->role;
return redirect($role === 'admin' ? '/admin/dashboard' : '/panitia/dashboard');
```

---

## UI: Dashboard Panitia

```
┌─────────────────────────────────────┐
│ Tadzkirah          [Nama Panitia]   │
├─────────────────────────────────────┤
│ Event Kajian Hari Ini               │
│ ┌─────────────────────────────────┐ │
│ │ 🟢 Kajian Zaidul Akbar [HARI INI]│ │
│ │    📍 Masjid Al-Ikhlas          │ │
│ │    🕐 09:00 WIB                  │ │
│ │    [Scan QR] [Peserta]          │ │
│ └─────────────────────────────────┘ │
│                                     │
│ Event Mendatang                     │
│ ┌─────────────────────────────────┐ │
│ │   Kajian Fiqh - 25 Jun 2026     │ │
│ │   📍 Online Zoom                │ │
│ └─────────────────────────────────┘ │
└─────────────────────────────────────┘
```

---

## Catatan Implementasi

- **Panitia tidak bisa lihat event lain** selain yang di-assign admin
- **Scan oleh panitia A ≠ scan oleh panitia B** — keduanya tersimpan di `scanned_by`
- **Admin lihat semua** scan dari semua panitia di detail event
- Data infaq dari panitia dikumpulkan di `infaq_records`, berbeda dengan infaq yang diisi peserta saat daftar (`infaq_nominal` di pendaftarans)
- Prioritas: selesaikan milestone Sprint 1 QA dulu sebelum mulai Sprint 2
