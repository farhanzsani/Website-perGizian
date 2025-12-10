<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPelacakanMakan extends Model
{
    protected $table = 'detail_pelacakan_makan';
    protected $guarded = ['id'];

    public function pelacakan()
    {
        return $this->belongsTo(PelacakanMakanan::class, 'pelacakan_makanan_id');
    }

    public function makanan()
    {
        return $this->belongsTo(Makanan::class, 'makanan_id');
    }
}
