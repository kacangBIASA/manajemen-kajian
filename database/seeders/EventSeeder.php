<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'nama' => 'Kajian Tafsir Al-Quran Juz 30',
                'tanggal' => '2026-07-05',
                'waktu' => '08:00:00',
                'tempat' => 'Masjid Al-Ikhlas, Jl. Merdeka No. 1',
                'deskripsi' => 'Kajian rutin tafsir Al-Quran Juz 30 bersama Ustadz Ahmad Fauzi. Terbuka untuk umum.',
                'metode_pembayaran' => 'Gratis',
                'harga' => null,
            ],
            [
                'nama' => 'Seminar Parenting Islami',
                'tanggal' => '2026-07-12',
                'waktu' => '09:00:00',
                'tempat' => 'Aula Islamic Center, Jl. Sudirman No. 45',
                'deskripsi' => 'Seminar cara mendidik anak sesuai tuntunan Islam bersama pakar parenting Islami.',
                'metode_pembayaran' => 'Berbayar',
                'harga' => 50000,
            ],
            [
                'nama' => 'Kajian Fiqih Muamalah',
                'tanggal' => '2026-07-19',
                'waktu' => '13:00:00',
                'tempat' => 'Masjid Baitul Hikmah, Jl. Ahmad Yani No. 10',
                'deskripsi' => 'Kajian fiqih muamalah modern mencakup transaksi digital, investasi halal, dan zakat kontemporer.',
                'metode_pembayaran' => 'Gratis',
                'harga' => null,
            ],
            [
                'nama' => 'Workshop Tahsin Al-Quran',
                'tanggal' => '2026-07-26',
                'waktu' => '08:30:00',
                'tempat' => 'Pesantren Darussalam, Jl. Pesantren No. 7',
                'deskripsi' => 'Workshop intensif perbaikan bacaan Al-Quran selama satu hari penuh bersama Qori nasional.',
                'metode_pembayaran' => 'Berbayar',
                'harga' => 75000,
            ],
            [
                'nama' => 'Kajian Sirah Nabawiyah',
                'tanggal' => '2026-08-02',
                'waktu' => '10:00:00',
                'tempat' => 'Masjid Al-Falah, Jl. Diponegoro No. 22',
                'deskripsi' => 'Menelusuri perjalanan hidup Rasulullah SAW dan teladan beliau untuk kehidupan modern.',
                'metode_pembayaran' => 'Gratis',
                'harga' => null,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
