# Tadzkirah — User Guide

> **تذكرة** (Tadzkirah) = Pengingat. Aplikasi manajemen kajian Islam berbasis web.
> Stack: Laravel 10, Blade, Tailwind CSS, Alpine.js

---

## Daftar Isi

1. [Peran Pengguna](#1-peran-pengguna)
2. [Akses & Login](#2-akses--login)
3. [Publik — Daftar & Tiket Kajian](#3-publik--daftar--tiket-kajian)
4. [Admin — Kelola Event](#4-admin--kelola-event)
5. [Admin — Kelola Panitia](#5-admin--kelola-panitia)
6. [Admin — Detail Event & Rekap](#6-admin--detail-event--rekap)
7. [Admin — Scan QR](#7-admin--scan-qr)
8. [Panitia — Dashboard](#8-panitia--dashboard)
9. [Panitia — Detail Event](#9-panitia--detail-event)
10. [Panitia — Scan QR Absensi](#10-panitia--scan-qr-absensi)
11. [Panitia — Catat Infaq](#11-panitia--catat-infaq)

---

## 1. Peran Pengguna

| Peran | Akses |
|---|---|
| **Publik** (tanpa login) | Lihat jadwal kajian, daftar peserta, download tiket QR |
| **Admin** | Kelola event, kelola akun panitia, lihat rekap absensi & infaq, scan QR |
| **Panitia** | Lihat event yang ditugaskan, scan QR absensi, catat infaq di lokasi |

> Akun **admin** dan **panitia** hanya bisa dibuat oleh admin melalui aplikasi (tidak ada self-register untuk staf).

---

## 2. Akses & Login

| URL | Keterangan |
|---|---|
| `/` | Halaman publik — daftar kajian |
| `/login` | Login untuk admin & panitia |
| `/admin` | Dashboard admin (redirect otomatis setelah login admin) |
| `/panitia/dashboard` | Dashboard panitia (redirect otomatis setelah login panitia) |

### Kredensial default (seeder)

| Akun | Email | Password |
|---|---|---|
| Admin | `admin@tadzkirah.id` | `admin123` |
| Panitia 1 | `fauzi@tadzkirah.id` | `panitia123` |
| Panitia 2 | `rahma@tadzkirah.id` | `panitia123` |
| Panitia 3 | `rizky@tadzkirah.id` | `panitia123` |

---

## 3. Publik — Daftar & Tiket Kajian

Tidak perlu login. Alur lengkap:

```
/ (daftar kajian)
  → /kajian/{id}/daftar  (isi form pendaftaran)
    → /tiket/{kode_qr}   (tiket QR — bisa download)
```

### Langkah daftar peserta

1. Buka `/` — tampil kartu-kartu kajian yang tersedia.
2. Klik **Daftar Sekarang** pada kajian yang diminati.
3. Isi form:
   - Nama lengkap
   - Alamat
   - No. HP *(dipakai sebagai kunci unik — satu no. HP per kajian)*
   - Infaq sukarela & bukti transfer *(opsional)*
   - Motivasi kajian *(opsional)*
   - Bukti pembayaran *(wajib jika kajian berbayar)*
4. Klik **Kirim Pendaftaran**.
5. Sistem redirect ke halaman **Tiket QR**.

### Tiket QR

- Menampilkan nama peserta, nama kajian, pemateri, tanggal/waktu/tempat, dan QR code.
- Tombol **Download Tiket** menyimpan tiket sebagai gambar.
- Kajian online menampilkan tombol **Bergabung Sekarang** (link platform).

### Proteksi duplikat

Jika no. HP sudah terdaftar di kajian yang sama, sistem menampilkan pesan error dan **tidak** membuat data ganda. Peserta bisa kembali ke tiket lama melalui link yang dikirimkan atau meminta panitia menampilkan QR.

---

## 4. Admin — Kelola Event

> Akses: Login sebagai **admin**

### Buat event baru

1. Klik **Tambah Event** di navbar atau dashboard.
2. Isi form:
   - **Nama kajian**, pemateri, moderator *(opsional)*
   - **Tanggal** & waktu (gunakan date/time picker)
   - **Tipe kajian**:
     - `Offline` — isi kolom *Tempat*
     - `Online` — isi kolom *Nama Platform* + *Link Online* (wajib)
   - Deskripsi, metode pembayaran (Gratis / Berbayar), harga, flyer *(opsional)*
3. Klik **Simpan**.

### Edit / Hapus event

- Dari halaman **Kelola** (`/event-manage`), klik ikon pensil (edit) atau tempat sampah (hapus).
- Edit flyer: upload file baru akan otomatis mengganti yang lama.

---

## 5. Admin — Kelola Panitia

> Akses: **Admin** → menu **Panitia** di navbar

### Tambah akun panitia

1. Klik **Tambah Panitia**.
2. Isi nama, email, password.
3. Klik **Simpan** — akun panitia langsung aktif.

### Edit / Hapus akun panitia

- Klik **Edit** untuk ubah nama, email, atau reset password.
- Kosongkan field password jika tidak ingin mengubah.
- Klik **Hapus** untuk menghapus akun (akan otomatis melepas semua penugasan event).

---

## 6. Admin — Detail Event & Rekap

> Akses: **Kelola** → klik nama event → **Detail**

Halaman ini menampilkan:

### Statistik ringkas
- Total peserta, hadir, belum hadir
- Total infaq (peserta + panitia di lokasi)

### Panitia yang Ditugaskan
- Daftar panitia aktif di event ini (chip dengan tombol ×)
- **Assign panitia baru**: pilih dari dropdown → klik **Tugaskan**
- **Lepas panitia**: klik × pada chip nama panitia

### Daftar Peserta
Tabel berisi: nama, no. HP, status, discan oleh siapa & waktu scan, link tiket, bukti infaq.

- Kolom **Status**: `Hadir` (hijau) / `Belum Hadir` (amber)
- Kolom **Discan Oleh**: nama panitia + jam scan (jika sudah hadir)
- Kolom **Tiket**: link ke `/tiket/{kode_qr}` — berguna jika peserta lupa bawa tiket
- Kolom **Bukti Infaq**: klik untuk preview gambar/PDF di modal

### Rekap Infaq
- Total infaq peserta (dari form pendaftaran online)
- Total infaq panitia (dari catatan di lokasi)
- Breakdown per panitia

---

## 7. Admin — Scan QR

> Akses: menu **Scan** di navbar → `/scan`

1. Klik **Aktifkan Kamera**.
2. Izinkan akses kamera di browser.
3. Arahkan ke QR Code pada tiket peserta.
4. Sistem otomatis menandai peserta sebagai **Hadir** + mencatat waktu & akun yang scan.
5. Notifikasi SweetAlert muncul:
   - ✅ Hijau: absensi berhasil
   - ℹ️ Biru: peserta sudah absen sebelumnya
   - ❌ Merah: QR tidak ditemukan

> Scan di halaman admin **tidak** dibatasi per event — bisa scan peserta dari event mana pun.

---

## 8. Panitia — Dashboard

> Akses: Login sebagai **panitia** → otomatis redirect ke `/panitia/dashboard`

Menampilkan kartu-kartu event yang ditugaskan admin kepada panitia tersebut.

- **Badge "Hari Ini!"** (berkedip, teal) muncul jika event berlangsung hari ini
- Event masa lalu ditandai "Selesai"
- Tipe ditampilkan: 🌐 Online / 📍 Offline

Setiap kartu punya 3 tombol cepat:

| Tombol | Fungsi |
|---|---|
| **Detail** | Lihat peserta, rekap absensi & infaq |
| **Scan QR** | Buka kamera scan absensi untuk event ini |
| **Catat Infaq** | Form catat infaq yang dikumpulkan di lokasi |

---

## 9. Panitia — Detail Event

> `/panitia/event/{id}`

- **Stat cards**: total peserta, hadir, belum hadir, total infaq
- **Tombol aksi**: Scan QR Absensi dan Catat Infaq
- **Tabel Peserta** dengan tab filter:
  - `Semua` — seluruh peserta
  - `Hadir` — sudah scan
  - `Belum Hadir` — belum scan
- **Riwayat Infaq Saya** — daftar catatan infaq yang panitia ini sendiri input, beserta totalnya

---

## 10. Panitia — Scan QR Absensi

> `/panitia/event/{id}/scan`

Sama seperti scan admin, **namun**:
- Hanya bisa scan peserta yang terdaftar di **event ini** (scoped)
- Sistem memvalidasi bahwa panitia memang ditugaskan ke event tersebut
- QR dari event lain akan ditolak dengan pesan "QR Code tidak ditemukan untuk event ini"

**Alur:**
1. Klik **Aktifkan Kamera**
2. Scan QR tiket peserta
3. Sistem catat: `status = Hadir`, `scanned_by = panitia_id`, `scanned_at = timestamp`

---

## 11. Panitia — Catat Infaq

> `/panitia/event/{id}/infaq`

Digunakan untuk mencatat uang infaq yang dikumpulkan secara fisik di lokasi kajian.

**Form:**
- **Nominal** (wajib) — dalam Rupiah
- **Catatan** (opsional) — contoh: "Infaq dari jamaah baris belakang"

Setiap entri tersimpan ke tabel `infaq_records` dengan referensi ke `event_id` dan `panitia_id`.

Halaman juga menampilkan **riwayat catatan infaq saya** untuk event ini beserta total kumulatif, sehingga panitia bisa input bertahap sepanjang acara.

---

## Ringkasan Alur Hari-H Kajian

```
Admin assign panitia ke event
    ↓
Panitia login → Dashboard → pilih event
    ↓
[Di pintu masuk]
Panitia buka Scan QR → aktifkan kamera → scan tiket peserta
    ↓ (sistem catat Hadir + timestamp + nama panitia)
[Selama acara berlangsung]
Panitia buka Catat Infaq → input nominal → simpan
    (bisa berkali-kali, misal per gelombang kumpulkan)
    ↓
[Setelah acara]
Admin buka Detail Event → lihat rekap absensi + total infaq
```

---

## Catatan Teknis

| Hal | Detail |
|---|---|
| Framework | Laravel 10 + Breeze |
| Frontend | Blade + Tailwind CSS (CDN) + Alpine.js (CDN) |
| QR Generation | DNS2D (server-side) |
| QR Scan | html5-qrcode (client-side) |
| Notifikasi scan | SweetAlert2 |
| Download tiket | html2canvas |
| Kode QR tiket | Deterministik: `md5(no_hp + event_id)` — tidak duplikat meski daftar ulang |
| Dark mode | `localStorage.theme` — persists across reload |
