<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'pemateri', 'moderator', 'tanggal', 'waktu', 'tempat', 'deskripsi', 'metode_pembayaran', 'harga', 'flyer'];

    public function pendaftarans()
    {
        return $this->hasMany(\App\Models\Pendaftaran::class);
    }
}
