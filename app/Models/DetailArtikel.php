<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailArtikel extends Model
{
    protected $table = 'detail_artikel';
    protected $guarded = ['id'];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'artikel_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriArtikel::class, 'kategori_artikel_id');
    }
}
