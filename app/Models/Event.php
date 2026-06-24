<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama', 'pemateri', 'moderator', 'tanggal', 'waktu',
        'tempat', 'tipe', 'link_online', 'deskripsi',
        'metode_pembayaran', 'harga', 'flyer',
        'qris_image', 'nama_bank', 'no_rekening', 'nama_rekening',
    ];

    public function pendaftarans()
    {
        return $this->hasMany(\App\Models\Pendaftaran::class);
    }

    public function panitias()
    {
        return $this->belongsToMany(\App\Models\User::class, 'event_panitia');
    }

    public function infaqRecords()
    {
        return $this->hasMany(\App\Models\InfaqRecord::class);
    }

    public function isOnline(): bool
    {
        return $this->tipe === 'online';
    }
}
