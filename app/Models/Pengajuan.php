<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $table = 'pengajuan';
    protected $guarded = ['id'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
