<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KebutuhanKalori extends Model
{
    protected $table = 'kebutuhan_kalori';
    protected $guarded = ['id'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
