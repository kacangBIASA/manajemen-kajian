<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'nama',
        'alamat',
        'no_hp',
        'kode_qr',
        'bukti_pembayaran',
        'infaq_nominal',
        'bukti_infaq',
        'motivasi_kajian',
        'jenis_registrasi',
        'status',
        'scanned_by',
        'scanned_at',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function scanner()
    {
        return $this->belongsTo(\App\Models\User::class, 'scanned_by');
    }
}
