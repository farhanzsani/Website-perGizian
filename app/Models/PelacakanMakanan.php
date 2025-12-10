<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelacakanMakanan extends Model
{
    protected $table = 'pelacakan_makanan';
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_konsumsi' => 'date',
        // 'waktu_konsumsi' => 'datetime'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function detail()
    {
        return $this->hasMany(DetailPelacakanMakan::class, 'pelacakan_makanan_id');
    }
}
