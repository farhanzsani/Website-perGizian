<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    protected $table = 'makanan';
    protected $guarded = ['id'];

    public function kategori()
    {
        return $this->belongsTo(KategoriMakanan::class, 'kategori_makanan_id');
    }
}
