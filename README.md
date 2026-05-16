# 🕋 Sistem Manajemen Kajian

Sistem Manajemen Kajian adalah sebuah platform berbasis web yang dirancang untuk mempermudah pengelolaan acara kajian, mulai dari publikasi, pendaftaran peserta (gratis maupun berbayar), hingga proses *check-in* kehadiran menggunakan fitur *QR Code Scanner*.

## 🌟 Fitur Utama

- **Manajemen Event/Kajian**: Admin dapat membuat, mengedit, dan menghapus jadwal kajian. Kajian dapat diatur bersifat gratis maupun berbayar (dengan harga tiket).
- **Pendaftaran Publik (Landing Page)**: Halaman khusus bagi masyarakat umum untuk melihat daftar kajian dan melakukan pendaftaran secara mandiri.
- **Upload Bukti Pembayaran**: Sistem mendukung kewajiban unggah file bukti transfer bagi peserta yang mendaftar pada kajian berbayar.
- **Tiket QR Code Otomatis**: Setiap peserta yang berhasil mendaftar akan langsung mendapatkan tiket elektronik berupa *QR Code* unik.
- **Scan Kehadiran (Check-in)**: Fitur *Scanner* bagi panitia untuk melakukan absensi dengan memindai QR Code peserta di lokasi kajian secara *real-time*. Dilengkapi sistem *Anti-Spam* (*Rate Limiting*) untuk mengamankan *endpoint*.
- **Dashboard Admin yang Aman**: Semua sistem pengelolaan dan fitur *scanner* dilindungi oleh autentikasi yang aman.

## 🛠️ Teknologi yang Digunakan

- **Backend Framework:** [Laravel 10](https://laravel.com) (PHP 8.1+)
- **Frontend & Styling:** Laravel Blade & [Tailwind CSS](https://tailwindcss.com/)
- **Database:** MySQL / MariaDB
- **Pembuatan QR Code:** `milon/barcode`

## ⚙️ Persyaratan Sistem (Prerequisites)

Sebelum menjalankan proyek ini di *local environment*, pastikan Anda telah menginstal:
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL atau MariaDB (via XAMPP/Laragon/DB murni)

## 🚀 Langkah Instalasi

1. **Clone Repository**
   Silakan *clone repository* ini dan masuk ke dalam direktorinya.
   ```bash
   git clone <url-repo-anda>
   cd manajemen-kajian
   ```

2. **Install Dependensi (PHP & Javascript)**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment File**
   Buat file konfigurasi environment dari template yang sudah disediakan.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   **Penting:** Buka file `.env` yang baru saja dibuat, lalu sesuaikan koneksi database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Jalankan Migrasi & Database Seeder**
   Pastikan Anda sudah membuat *database* kosong sesuai nama di file `.env`, lalu jalankan:
   ```bash
   php artisan migrate --seed
   ```
   *Catatan: Perintah `--seed` digunakan agar akun admin default dibuat secara otomatis oleh `DatabaseSeeder`.*

5. **Symlink Storage (Penting)**
   Karena sistem menyimpan file unggahan bukti pembayaran, Anda harus membuat jembatan akses foldernya:
   ```bash
   php artisan storage:link
   ```

6. **Jalankan Aplikasi**
   Untuk melihat hasilnya, jalankan *local server* Laravel dan *asset bundler* Vite:
   ```bash
   # Terminal 1 (Untuk menjalankan PHP Server)
   php artisan serve

   # Terminal 2 (Untuk meng-compile TailwindCSS / Javascript)
   npm run dev
   ```
   Aplikasi kini dapat diakses melalui browser pada `http://localhost:8000`.

## 👨‍💻 Kontribusi
Jika ingin berkontribusi, silakan buat *Pull Request* baru atau diskusikan pada *tab Issues*.

## 📝 Lisensi
Proyek ini dikembangkan di bawah lisensi *open-source* [MIT license](https://opensource.org/licenses/MIT).
