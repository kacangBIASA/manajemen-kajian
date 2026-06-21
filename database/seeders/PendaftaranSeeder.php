<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pendaftaran;
use Illuminate\Support\Str;

class PendaftaranSeeder extends Seeder
{
    public function run(): void
    {
        $peserta = [
            [
                'event_id' => 1,
                'nama' => 'Budi Santoso',
                'alamat' => 'Jl. Melati No. 5, Yogyakarta',
                'no_hp' => '081234567890',
                'email' => 'budi.santoso@gmail.com',
                'kode_qr' => Str::upper(Str::random(10)),
                'bukti_pembayaran' => '',
                'status' => 'Hadir',
            ],
            [
                'event_id' => 1,
                'nama' => 'Siti Rahayu',
                'alamat' => 'Jl. Mawar No. 12, Yogyakarta',
                'no_hp' => '082345678901',
                'email' => 'siti.rahayu@gmail.com',
                'kode_qr' => Str::upper(Str::random(10)),
                'bukti_pembayaran' => '',
                'status' => 'Belum Hadir',
            ],
            [
                'event_id' => 2,
                'nama' => 'Ahmad Firdaus',
                'alamat' => 'Jl. Kenanga No. 8, Sleman',
                'no_hp' => '083456789012',
                'email' => 'ahmad.firdaus@gmail.com',
                'kode_qr' => Str::upper(Str::random(10)),
                'bukti_pembayaran' => 'bukti_pembayaran/contoh_bukti.jpg',
                'status' => 'Hadir',
            ],
            [
                'event_id' => 2,
                'nama' => 'Nur Hidayah',
                'alamat' => 'Jl. Anggrek No. 3, Bantul',
                'no_hp' => '084567890123',
                'email' => 'nur.hidayah@gmail.com',
                'kode_qr' => Str::upper(Str::random(10)),
                'bukti_pembayaran' => 'bukti_pembayaran/contoh_bukti2.jpg',
                'status' => 'Belum Hadir',
            ],
            [
                'event_id' => 3,
                'nama' => 'Rizky Pratama',
                'alamat' => 'Jl. Cempaka No. 15, Kulon Progo',
                'no_hp' => '085678901234',
                'email' => 'rizky.pratama@gmail.com',
                'kode_qr' => Str::upper(Str::random(10)),
                'bukti_pembayaran' => '',
                'status' => 'Belum Hadir',
            ],
        ];

        foreach ($peserta as $data) {
            Pendaftaran::create($data);
        }
    }
}
