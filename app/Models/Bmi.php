<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bmi extends Model
{
    protected $table = 'bmi';

    // Kita pakai $guarded agar praktis (semua boleh diisi kecuali id)
    protected $guarded = ['id'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
