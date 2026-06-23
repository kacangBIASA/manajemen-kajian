# Sprint 2 — Role System, Tipe Kajian & Dashboard Panitia

## Konteks
Sprint 1 selesai dengan sistem pendaftaran publik, QR tiket, dan scan presensi oleh admin.
Sprint 2 memperkenalkan **role panitia**, **tipe kajian (online/offline)**, dan **RESTful API** berbasis Sanctum.

---

## Struktur MVP

| MVP | Fokus | Status |
|-----|-------|--------|
| MVP 1 | Database, Models, Auth & Middleware | Planned |
| MVP 2 | Tipe Kajian + Fitur Admin | Planned |
| MVP 3 | Dashboard & Fitur Panitia | Planned |
| MVP 4 | RESTful API (Sanctum) | Planned |

---

## Role yang Ada

| Role | Akses |
|------|-------|
| `admin` | Full access: kelola event, kelola panitia, lihat semua data |
| `panitia` | Terbatas: hanya event yang ditugaskan, scan presensi, catat infaq di lokasi |

---

## Tipe Kajian

| Tipe | Keterangan |
|------|------------|
| `offline` | Hadir fisik di lokasi — tampilkan nama tempat |
| `online` | Virtual via Zoom/Meet/dll — tampilkan link bergabung |

Kolom yang ditambahkan ke tabel `events`:
- `tipe` — ENUM `offline` / `online`, default `offline`
- `link_online` — VARCHAR nullable (hanya diisi jika tipe = online)

Di tiket peserta: jika online → tampilkan link bergabung; jika offline → tampilkan nama tempat.

---

## Perubahan Database

### 0. Tambah kolom `tipe` + `link_online` ke tabel `events`
```sql
ALTER TABLE events
  ADD COLUMN tipe ENUM('offline','online') DEFAULT 'offline' AFTER tempat,
  ADD COLUMN link_online VARCHAR(500) NULL AFTER tipe;
```

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

### Tipe Kajian di Form Daftar & Tiket
- **Offline**: tampilkan nama tempat + peta (opsional)
- **Online**: tampilkan link bergabung sebagai tombol hijau di form daftar & tiket QR
- Tiket peserta online mencantumkan link agar bisa langsung bergabung tanpa perlu cari info lagi

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

## RESTful API

Sprint 2 juga memperkenalkan API layer agar aplikasi bisa dikonsumsi oleh klien lain (mobile app, integrasi pihak ketiga, atau PWA di masa depan).

### Autentikasi API
Menggunakan **Laravel Sanctum** (sudah tersedia di Laravel 10 Breeze).
- Panitia & admin login via `/api/login` → dapat token
- Token dikirim di header: `Authorization: Bearer {token}`
- Token bisa di-revoke via `/api/logout`

### Endpoint yang Direncanakan

#### Auth
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `POST` | `/api/login` | Login, return token |
| `POST` | `/api/logout` | Revoke token |
| `GET`  | `/api/me` | Info user yang sedang login |

#### Events (Public)
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `GET`  | `/api/events` | Daftar semua event aktif |
| `GET`  | `/api/events/{id}` | Detail event |
| `POST` | `/api/events/{id}/daftar` | Daftar peserta (public, no auth) |
| `GET`  | `/api/tiket/{kode}` | Info tiket berdasarkan kode QR |

#### Panitia (auth + role:panitia)
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `GET`  | `/api/panitia/events` | Event yang di-assign ke panitia ini |
| `GET`  | `/api/panitia/events/{id}/peserta` | Daftar peserta event |
| `POST` | `/api/panitia/scan` | Scan QR → presensi peserta |
| `POST` | `/api/panitia/events/{id}/infaq` | Catat infaq di lokasi |

#### Admin (auth + role:admin)
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `GET`  | `/api/admin/events/{id}/peserta` | Semua peserta + scan log |
| `GET`  | `/api/admin/events/{id}/infaq` | Rekap infaq per panitia |
| `POST` | `/api/admin/panitia` | Buat akun panitia |
| `POST` | `/api/admin/events/{id}/assign` | Assign panitia ke event |

### Struktur Response Standar

```json
{
  "status": "success",
  "data": { ... },
  "message": "Presensi berhasil dicatat"
}
```

Error response:
```json
{
  "status": "error",
  "message": "QR Code tidak ditemukan",
  "code": 404
}
```

### File yang Perlu Dibuat

```
app/Http/Controllers/Api/
├── AuthController.php        ← login, logout, me
├── EventController.php       ← public events + daftar
├── PanitiaController.php     ← scan, peserta, infaq
└── AdminController.php       ← kelola panitia, assign, rekap
routes/api.php                ← semua route API
```

### Middleware API
```php
// routes/api.php
Route::post('/login', [AuthController::class, 'login']);
Route::post('/events/{id}/daftar', [EventController::class, 'daftar']);
Route::get('/tiket/{kode}', [EventController::class, 'tiket']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::middleware('role:panitia')->prefix('panitia')->group(...);
    Route::middleware('role:admin')->prefix('admin')->group(...);
});
```

---

## Catatan Implementasi

- **Panitia tidak bisa lihat event lain** selain yang di-assign admin
- **Scan oleh panitia A ≠ scan oleh panitia B** — keduanya tersimpan di `scanned_by`
- **Admin lihat semua** scan dari semua panitia di detail event
- Data infaq dari panitia dikumpulkan di `infaq_records`, berbeda dengan infaq yang diisi peserta saat daftar (`infaq_nominal` di pendaftarans)
- Prioritas: selesaikan milestone Sprint 1 QA dulu sebelum mulai Sprint 2
