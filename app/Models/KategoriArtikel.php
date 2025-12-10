<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriArtikel extends Model
{
    protected $table = 'kategori_artikel';
    protected $guarded = ['id'];

    public function artikel()
    {
        return $this->belongsToMany(Artikel::class, 'detail_artikel', 'kategori_artikel_id', 'artikel_id')
                    ->withTimestamps();
    }
}
