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
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
