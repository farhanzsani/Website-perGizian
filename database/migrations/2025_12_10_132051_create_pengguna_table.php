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
        Schema::disableForeignKeyConstraints();

        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_kelamin');
            $table->decimal('berat_badan');
            $table->decimal('tinggi_badan');
            $table->date('tanggal_lahir');
            $table->string('aktivitas_fisik');
            $table->unsignedBigInteger('keluarga_id');
            $table->foreign('keluarga_id')->references('id')->on('Keluarga');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
