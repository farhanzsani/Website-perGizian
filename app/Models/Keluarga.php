<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    protected $table = 'keluarga';
    protected $guarded = ['id'];

    // Kepala Keluarga
    public function kepalaKeluarga()
    {
        return $this->belongsTo(Pengguna::class, 'kepala_keluarga_id');
    }

    // Anggota Keluarga
    public function anggota()
    {
        return $this->hasMany(Pengguna::class, 'keluarga_id');
    }
}
