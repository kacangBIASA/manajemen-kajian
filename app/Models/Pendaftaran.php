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
        'email',
        'kode_qr',
        'bukti_pembayaran',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
