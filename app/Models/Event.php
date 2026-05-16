<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public const METODE_GRATIS = 'Gratis';
    public const METODE_BERBAYAR = 'Berbayar';

    protected $fillable = ['nama', 'tanggal', 'waktu', 'tempat', 'deskripsi', 'metode_pembayaran', 'harga'];

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
