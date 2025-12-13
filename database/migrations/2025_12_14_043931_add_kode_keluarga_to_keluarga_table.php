<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('keluarga', function (Blueprint $table) {
        $table->string('kode_keluarga', 6)->unique()->after('nama_keluarga')->nullable();
        // Nullable dulu jika ada data lama, nanti diisi.
        // Kalau db baru, bisa langsung unique()
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keluarga', function (Blueprint $table) {
            //
        });
    }
};
