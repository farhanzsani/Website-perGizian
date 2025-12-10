<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriMakanan extends Model
{
    protected $table = 'kategori_makanan';
    protected $guarded = ['id'];

    public function makanan()
    {
        return $this->hasMany(Makanan::class, 'kategori_makanan_id');
    }
}
