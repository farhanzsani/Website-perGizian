<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ahligizi extends Model
{
    use HasFactory;

    // Definisikan nama tabel secara eksplisit
    protected $table = 'ahligizi';

    protected $fillable = [
        'nama',
        'foto',
        'nomor_hp',
        'spesialis',
        'alamat',
        'deskripsi',
        'tanggal_lahir',
    ];
}
