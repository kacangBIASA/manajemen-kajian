<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfaqRecord extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'panitia_id', 'nominal', 'catatan'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function panitia()
    {
        return $this->belongsTo(User::class, 'panitia_id');
    }
}
