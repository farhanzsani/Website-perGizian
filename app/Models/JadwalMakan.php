<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalMakan extends Model
{
    protected $table = 'jadwal_makan';
    protected $guarded = ['id'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
