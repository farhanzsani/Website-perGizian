<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = 'pengguna';
    protected $guarded = ['id'];

    // Relasi ke Akun Login
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi Keluarga
    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'keluarga_id');
    }

    // Relasi Data Kesehatan
    public function bmi()
    {
        return $this->hasMany(Bmi::class, 'pengguna_id');
    }

    public function kebutuhanKalori()
    {
        return $this->hasMany(KebutuhanKalori::class, 'pengguna_id');
    }

    public function pelacakanMakanan()
    {
        return $this->hasMany(PelacakanMakanan::class, 'pengguna_id');
    }

    public function jadwalMakan()
    {
        return $this->hasMany(JadwalMakan::class, 'pengguna_id');
    }
}
