<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $table = 'artikel';
    protected $guarded = ['id'];

    public function kategori()
    {
        // withTimestamps() wajib karena di migration pivot kita pakai $table->timestamps()
        return $this->belongsToMany(KategoriArtikel::class, 'detail_artikel', 'artikel_id', 'kategori_artikel_id')
                    ->withTimestamps();
    }
}
