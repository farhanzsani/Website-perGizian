<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelacakanMakanan extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'pelacakan_makanan';

    // Kolom yang tidak boleh diisi manual (hanya ID).
    // Sisanya (makanan_id, jumlah_porsi, satuan, total_kalori, dll) BOLEH diisi massal.
    protected $guarded = ['id'];

    // Casting tipe data agar mudah diolah di View
    protected $casts = [
        'tanggal_konsumsi' => 'date',
        // 'waktu_konsumsi' biarkan string agar format H:i tetap terjaga
    ];

    /**
     * Relasi ke Model Pengguna (User)
     * Satu catatan pelacakan dimiliki oleh satu pengguna.
     */
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    /**
     * Relasi ke Model Makanan
     * Satu catatan pelacakan merujuk pada satu jenis makanan.
     */
    public function makanan()
    {
        return $this->belongsTo(Makanan::class, 'makanan_id');
    }
}
